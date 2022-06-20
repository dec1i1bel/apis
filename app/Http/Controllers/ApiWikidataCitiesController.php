<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;

class ApiWikidataCitiesController extends Controller
{
    public function getCities()
    {
        $json = WikidataCities::all()->toJson(JSON_UNESCAPED_UNICODE);
        $fp = fopen('results.json', 'w');
        fwrite($fp, $json);
        fclose($fp);

        return $json;
    }
}