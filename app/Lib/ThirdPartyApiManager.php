<?php

namespace App\Lib;

use \GuzzleHttp\Client;

class ThirdPartyApiManager
{
    public static function receiveData()
    {
        $client = new Client;

        $url = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities/Q60?languageCode=ru';
        $headers = [
            'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com',
            'X-RapidAPI-Key' => '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
        ];

        $response = $client->get($url, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();

        $res['body'] = ($statusCode == 200) ? $response->getBody() : 'error getting response from API';

        return $res;
    }
}