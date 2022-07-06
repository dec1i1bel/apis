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
}