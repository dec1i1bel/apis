<?php

namespace App\Http\Controllers;

use \App\Lib\GeoDBCitiesApiManager;
use \Illuminate\Http\Request;
use \App\Models\WikidataCities;

class WikidataCitiesController extends Controller
{
    public function getCities()
    {
        $res = WikidataCities::all();

        return view('index', [
            'data' => $res
        ]);
    }

    public function getCityDetails(Request $request)
    {
        $apiManager = new GeoDBCitiesApiManager($request['wikidataCityId']);
        $data = $apiManager->receiveData();

        return view('index', [
            'data' => $data['body']
        ]);
    }
}
