<?php

namespace App\Lib;

use \GuzzleHttp\Client;

class ExternalAPIManager
{
    private $url;
    private $headers;

    public function __construct($url)
    {
        $apiHost = explode('//', $url);
        $apiHost = array_pop($apiHost);
        $this->url = $url;
        $this->headers = [
            'X-RapidAPI-Host' => $apiHost,
            'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
        ];
    }
    
    /**
     * @return array
     */
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