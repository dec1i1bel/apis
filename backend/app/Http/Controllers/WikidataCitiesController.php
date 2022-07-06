<?php

namespace App\Http\Controllers;

use \App\Lib\GeoDBCitiesApiManager;
use \Illuminate\Http\Request;
use \App\Models\WikidataCities;
use App\Lib\GeoDBCitiesApiManager as GeoDB;

class WikidataCitiesController extends Controller
{
    public function getCities()
    {
        $api = new GeoDB('https://wft-geo-db.p.rapidapi.com/v1/geo/cities?minPopulation=10000000');

        $data = $api->getData();

        return view('index', [
            'data' => $data
        ]);
    }
}
