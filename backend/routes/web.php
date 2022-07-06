<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WikidataCitiesController;

Route::get('/', [
    WikidataCitiesController::class,
    'getCities'
])->name('index');