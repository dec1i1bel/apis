<?php

namespace App\Http\Controllers;

use \GuzzleHttp\Client;

class DemoController extends Controller
{
    public function index()
    {
        $data = $this->GetDataFromE3rdPartyApi();

        return view('index', [
            'data' => $data['body']
        ]);
    }

    /**
     * 'RapidApi settings for url:
     * - Q60 - New-York id from Wikidata
     * - languageCode=ru - [optional] language of the data received. Default - en
     */
    private function GetDataFromE3rdPartyApi()
    {
        $client = new Client;

        $url = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities/Q60?languageCode=ru';
        $headers = [
            'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com',
            'X-RapidAPI-Key' => '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
        ];

        $response = $client->get($url, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();

        $res['body'] = ($statusCode == 200) ? $response->getBody() : 'error getting response from API'

        return $res;
    }
}
