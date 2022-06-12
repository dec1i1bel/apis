<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikidataCities extends Model
{
    use HasFactory;

    protected $fillable = [
        'wikidata_id',
        'city_name_en',
    ];
}
