<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\WikidataCities;

class CityCurrentWeather extends Model
{
    use HasFactory;

    protected $fillable = [
        'wikidata_city_id',
        'icon_file',
        'temp_c',
        'humidity_p',
        'is_day',
        'wind_dir',
        'wind_kph',
        'cloud_p',
    ];

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wikidataCity(): BelongsTo
    {
        return $this->belongsTo(WikidataCities::class);
    }
}
