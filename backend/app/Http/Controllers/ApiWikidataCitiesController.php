<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;
use Illuminate\Support\Facades\Storage;

class ApiWikidataCitiesController extends Controller
{
    public function getCities()
    {
        $json = WikidataCities::all()->toJson(JSON_UNESCAPED_UNICODE);
        $fp = fopen('../storage/app/public/jsons/cities.json', 'w');
        fwrite($fp, $json);
        fclose($fp);

        return $json;
    }

    public function generateResult()
    {
        header('Content-type: application/json');
        $data = file_get_contents('php://input');

        $fp = fopen('../storage/app/public/jsons/front_result.json', 'w');
        fwrite($fp, $data);
        fclose($fp);

        echo 'data received';
    }
}