<?php

namespace App\Lib;

use \GuzzleHttp\Client;

class GeoDBCitiesApiManager
{
    private $url;
    private $wikidataCityId;
    private $headers;

    public function __construct($wikidataCityId)
    {
        $this->wikidataCityId = $wikidataCityId;
        $this->url = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities/'.$this->wikidataCityId;
        $this->headers = [
            'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com',
            'X-RapidAPI-Key' => '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
        ];
    }
    
    public function receiveData()
    {
        $client = new Client;

        $response = $client->get($this->url, ['headers' => $this->headers]);
        $statusCode = $response->getStatusCode();

        $res['body'] = ($statusCode == 200) ? $response->getBody() : 'error getting data';

        return $res;
    }
}