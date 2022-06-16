<?php

namespace App\Lib;

use \GuzzleHttp\Client;

class GeoDBCitiesApiManager
{
    private $url;
    private $headers;

    public function __construct($url)
    {
        $this->url = $url;
        $this->headers = [
            'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com',
            'X-RapidAPI-Key' => '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
        ];
    }
    
    public function getData()
    {
        $client = new Client;

        $response = $client->get($this->url, [
            'headers' => $this->headers
        ]);
        
        $statusCode = $response->getStatusCode();

        if ($statusCode = 200) {
            $body = $response->getBody();
            $res = $body->getContents();
        } else {
            $res = 'error';
        }

        return $res;
    }
}