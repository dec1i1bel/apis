<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiWikidataCitiesController;

Route::get('cities', [ApiWikidataCitiesController::class, 'getCities']);
Route::get('city/{wikidata_city_id}/weather', [ApiWikidataCitiesController::class, 'getCityWeather']);
Route::post('json', [ApiWikidataCitiesController::class, 'createJsonFile']);