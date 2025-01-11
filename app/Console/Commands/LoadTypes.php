<?php

namespace App\Console\Commands;

use App\Models\Type;
use Illuminate\Console\Command;

class LoadTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-types';

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
        $typesJson = file_get_contents(base_path() . "/resources/assets/json/types.json");
        $typesJson = json_decode($typesJson, true);

        foreach($typesJson as $key => $typeJson) {
            Type::create([
                "eredan_type_id" => $typeJson["id"],
                "script_slug" => $typeJson["script_slug"],
                "perso" => $typeJson["perso"],
                "persistant" => $typeJson["persistant"],
                "cadre_type" => $typeJson["cadre_type"],
                "can_be_foil" => $typeJson["can_be_foil"],
                "use_in_game" => $typeJson["use_in_game"],
                "with_xp" => $typeJson["with_xp"],
                "fond_type"=> $typeJson["fond_type"],
                "id_parent" => $typeJson["id_parent"],
            ]);

            $firstRow = false;
            if($key === 0) {
                $firstRow = true;
            }

            $englishName = $typeJson["labels"]["en_us"]["name"];
            unset($typeJson["labels"]["en_us"]);

            foreach($typeJson["labels"] as $locale => $label) {
                $this->writeTranslation($englishName, $label["name"], $locale, $firstRow);
            }
        }

    }

    private function writeTranslation(string $original, string $translation, string $locale, bool $firstRow = false)
    {
        if(strpos($original, "\r") !== false || strpos($translation, "\r") !== false) {
            $original = str_replace(["\r", '"'], ["\\r", "'"], $original);
            $translation = str_replace(["\r", '"'], ["\\r", "'"], $translation);
        }

        if(strpos($original, "\n") !== false || strpos($translation, "\n") !== false) {
            $original = str_replace(["\n", '"'], ["\\n", "'"], $original);
            $translation = str_replace(["\n", '"'], ["\\n", "'"], $translation);
        }

        $originalAndTranslation = "    \"$original\":\"$translation\"," . PHP_EOL;

        $locale = match($locale) {
            "pt_br" => "pt_br",
            "es_es" => "es",
            "fr_fr" => "fr"
        };

        if($firstRow) {
            $this->writeRow("{" . PHP_EOL, $locale);
        }

        $this->writeRow($originalAndTranslation, $locale, FILE_APPEND);
    }

    private function writeRow(string $string, string $locale, int $flag = 0) {
        file_put_contents(base_path() . "/resources/lang/{$locale}.json", $string, $flag);
    }
}
