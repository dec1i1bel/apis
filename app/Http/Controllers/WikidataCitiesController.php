<?php

namespace App\Http\Controllers;

use \GuzzleHttp\Client;
use \App\Lib\GeoDBCitiesApiManager;
use \Illuminate\HttpRequest;
use \App\Models\WikidataCities;

class WikidataCitiesController extends Controller
{
    public function index()
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
