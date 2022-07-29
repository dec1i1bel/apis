<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CityCurrentWeather;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WikidataCities extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'wikidata_id',
        'city_name_en',
    ];

    /**
     * @return use Illuminate\Database\Eloquent\Relations\HasOne;
     */
    public function currentWeather(): HasOne
    {
        return $this->hasOne(CityCurrentWeather::class);
    }
}
