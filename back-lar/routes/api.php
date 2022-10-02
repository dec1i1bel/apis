<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWikidataCitiesController;
use App\Http\Controllers\ApiPlacesController;

Route::get('cities', [ApiWikidataCitiesController::class, 'getCities']);
Route::get('city/{wikidata_city_id}/weather', [ApiWikidataCitiesController::class, 'getCityWeather']);
Route::get('city/{wikidata_city_id}/json', [ApiWikidataCitiesController::class, 'createJsonFile']);
Route::get('place/{place_name}/photos', [ApiPlacesController::class, 'getPlacePhotos']);
