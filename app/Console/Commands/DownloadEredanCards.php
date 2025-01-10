<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadEredanCards extends Command
{
    const EREDAN_URL = "http://static.eredan.com/cards/web_mid";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-eredan-cards';

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

        foreach($cardsJson as $cardJson) {
            $brCardUrl = self::EREDAN_URL . "/br/{$cardJson['filename']}.png";
            $usCardUrl = self::EREDAN_URL . "/us/{$cardJson['filename']}.png";

            $brCardName = $this->removeSpecialChars($cardJson["labels"]["pt_br"]["name"]) . ".png";
            $usCardName = $this->removeSpecialChars($cardJson["labels"]["en_us"]["name"]) . ".png";

            try {
                $brFileContent = false;
                if(!file_exists(base_path() . "/storage/app/public/" . $brCardName)) {
                    $brFileContent = file_get_contents($brCardUrl);
                }

                $usFileContent = false;
                if(!file_exists(base_path() . "/storage/app/public/" . $usCardName)) {
                    $usFileContent = file_get_contents($usCardUrl);
                }
            } catch (\Exception $exception) {
                file_put_contents(base_path() . "/cardsNotFound.txt", $exception->getMessage());
                continue;
            }

            if($brFileContent) {
                Storage::disk("public")->put($brCardName, $brFileContent);
            }

            if($usFileContent) {
                Storage::disk("public")->put($usCardName, $usFileContent);
            }

            sleep(0.5);
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
}
