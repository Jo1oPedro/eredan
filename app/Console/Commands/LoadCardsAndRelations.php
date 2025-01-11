<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\Label;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LoadCardsAndRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-cards-and-relations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cardsJson = file_get_contents(base_path() . "/resources/assets/json/cards.json");
        $cardsJson = json_decode($cardsJson, true);

        foreach($cardsJson as $key => $cardJson) {
            try {
                $card = Card::create([
                    "name" => $cardJson["labels"]["en_us"]["name"],
                    "description" => str_replace('"', "'", $cardJson["labels"]["en_us"]["description"]),
                    "level" => $cardJson["level"],
                    "serie_id" => $cardJson["serie_id"],
                    "type_id" => $cardJson["type_id"],
                    "rare_id" => $cardJson["rare_id"],
                    "evolution" => $cardJson["evolution"],
                    "duree" => $cardJson["duree"],
                    "properties" => $cardJson["properties"],
                    "script_slug" => $cardJson["script_slug"],
                    "dern_modification" => $cardJson["dern_modification"],
                    "filename" => $cardJson["filename"],
                    "date_sortie" => $cardJson["date_sortie"],
                    "model_id" => $cardJson["model_id"],
                    "sex" => $cardJson["sex"],
                    "life" => $cardJson["life"],
                    "base_attack" => $cardJson["base_attack"],
                    "high_attack" => $cardJson["high_attack"],
                    "defense" => $cardJson["defense"],
                    "spirit" => $cardJson["spirit"],
                    "all_classes" => $cardJson["all_classes"],
                    "max_runes" => $cardJson["max_runes"] ?? 0,
                    "personal" => $cardJson["personal"],
                    "persistant" => $cardJson["persistant"],
                    "nb_slot" => $cardJson["nb_slot"],
                    "id_reedition" => $cardJson["id_reedition"],
                    "illustration" => $cardJson["illustration"],
                    "illustration_illustrator" => $cardJson["illustration_illustrator"],
                    "background" => $cardJson["background"],
                    "background_illustrator" => $cardJson["background_illustrator"],
                    "frame_type" => $cardJson["frame_type"],
                    "background_type" => $cardJson["background_type"],
                    "hasNextEvo" => $cardJson["hasNextEvo"],
                ]);
            } catch (\Exception $exception) {
                dd($exception->getMessage(), $cardJson);
            }

            $englishName = $cardJson["labels"]["en_us"]["name"];
            $englishDescription = $cardJson["labels"]["en_us"]["description"];
            unset($cardJson["labels"]["en_us"]);

            $lastRow = false;

            if($key === count($cardsJson) - 1) {
                $lastRow = true;
            }

            foreach($cardJson["labels"] as $locale => $label) {
                $this->writeTranslation($englishName, $label["name"], $locale);
                $this->writeTranslation($englishDescription, $label["description"], $locale, $lastRow);
            }
        }
    }

    private function removeSpecialChars($string): string
    {
        $string = str_replace(" ", "-", $string);

        $unwantedArray = ['Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'];

        $string = strtr($string,$unwantedArray);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    private function writeTranslation(string $original, string $translation, string $locale, bool $lastRow = false)
    {
        if(strpos($original, "\r") !== false || strpos($translation, "\r") !== false) {
            $original = str_replace(["\r", '"'], ["\\r", "'"], $original);
            $translation = str_replace(["\r", '"'], ["\\r", "'"], $translation);
        }

        if(strpos($original, "\n") !== false || strpos($translation, "\n") !== false) {
            $original = str_replace(["\n", '"'], ["\\n", "'"], $original);
            $translation = str_replace(["\n", '"'], ["\\n", "'"], $translation);
        }

        $originalAndTranslation = "    \"$original\":\"$translation\"";

        if(!$lastRow) {
            $originalAndTranslation .= ",";
        }

        $originalAndTranslation .=  PHP_EOL;

        $locale = match($locale) {
            "pt_br" => "pt_br",
            "es_es" => "es",
            "fr_fr" => "fr"
        };

        $this->writeRow($originalAndTranslation, $locale, FILE_APPEND);

        if($lastRow) {

            $this->writeRow("}", $locale, FILE_APPEND);
        }
    }

    private function writeRow(string $string, string $locale, int $flag = 0) {
        file_put_contents(base_path() . "/resources/lang/{$locale}.json", $string, $flag);
    }
}
