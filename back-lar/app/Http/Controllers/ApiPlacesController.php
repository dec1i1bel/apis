<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ApiPlacesController extends Controller
{
    public function getPlacePhotos(string $placeName)
    {
        $url = 'https://yandex.ru/images/search?from=tabbar&text='.$placeName;

        $httpClient = new Client();
        $response = $httpClient->request('GET', $url);
        $respImgs = $response->evaluate('//img[@class="serp-item__thumb justifier__thumb"]');
        $imgs = [];
        foreach ($respImgs as $k => $img) {
            $imgs[] = 'https:'.$img->getAttribute('src');
        }

        $imgs = json_encode($imgs);

        return $imgs;
    }
}
