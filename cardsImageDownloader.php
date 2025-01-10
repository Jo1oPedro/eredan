<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Storage;

require_once __DIR__ . "/vendor/autoload.php";

define("erendaUrl", "http://static.eredan.com/cards/web_mid/");

$cardsJson = file_get_contents(__DIR__ . "/resources/assets/json/cards.json");
$cardsJson = json_decode($cardsJson, true);

foreach($cardsJson as $cardJson) {
    $brCardFileName = erendaUrl . "/br/{$cardJson['filename']}.png";
    $usCardFileName = erendaUrl . "/us/{$cardJson['filename']}.png";
    $brCardName = removeSpecialChars($cardJson["labels"]["pt_br"]["name"]);
    $usCardName = removeSpecialChars($cardJson["labels"]["en_us"]["name"]);

    if($cardJson["prerequis"]) {
        dd($cardJson);
    }
}

function removeSpecialChars($string) {
    $string = str_replace(" ", "-", $string);

    $unwantedArray = ['Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'];

    $string = strtr($string,$unwantedArray);

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

dd($cardsJson[0]);
