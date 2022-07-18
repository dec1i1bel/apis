<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;
use Illuminate\Support\Facades\Storage;

class ApiWikidataCitiesController extends Controller
{
    public function getCities()
    {
        $json = WikidataCities::all()->toJson(JSON_UNESCAPED_UNICODE);
        $fp = fopen('../storage/app/public/json/cities.json', 'w');
        fwrite($fp, $json);
        fclose($fp);

        return $json;
    }

    public function generateResult()
    {
        header('Content-type: application/json');
        $data = file_get_contents('php://input');

        $now = new \DateTime();
        $now->format('Y-m-d H:i:s');    // MySQL datetime format
        $jsuffix = $now->getTimestamp();

        $file = 'json/result_'.$jsuffix.'.json';

        $fp = fopen('../public/storage/'.$file, 'a');
        fwrite($fp, $data);
        fclose($fp);

        echo '/storage/'.$file;
    }
}