<?php

namespace App\Http\Controllers;

use \GuzzleHttp\Client;
use \App\Lib\ThirdPartyApiManager;

class DemoController extends Controller
{
    public function index()
    {
        $data = ThirdPartyApiManager::receiveData();

        return view('index', [
            'data' => $data['body']
        ]);
    }
}
