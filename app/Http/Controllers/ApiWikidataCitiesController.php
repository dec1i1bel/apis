<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;

class ApiWikidataCitiesController extends Controller
{
    public function getCities()
    {
        return WikidataCities::all()->toJson(JSON_UNESCAPED_UNICODE);
    }
}