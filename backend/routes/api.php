<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiWikidataCitiesController;

Route::get('cities', [ApiWikidataCitiesController::class, 'getCities']);
Route::post('result', [ApiWikidataCitiesController::class, 'generateResult']);