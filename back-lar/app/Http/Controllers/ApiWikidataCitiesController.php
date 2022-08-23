<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;
use App\Models\CityCurrentWeather;
use App\Models\CityPlaces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiWikidataCitiesController extends Controller
{
    private $cityId;

    public function getCities()
    {
        return WikidataCities::all()->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param int $cityId
     * @return string
     */
    public function getCityWeather(int $cityId)
    {
        $this->cityId = $cityId;
        $city = WikidataCities::find($this->cityId)->city_name_en;
        $cityWeather = DB::table('city_current_weather')
                ->join('wikidata_cities', function($join) {
                    $join->on('city_current_weather.wikidata_city_id', '=', 'wikidata_cities.id')
                        ->where('city_current_weather.wikidata_city_id', '=', $this->cityId);
                })
                ->select(
                    'wikidata_cities.city_name_en',
                    'city_current_weather.wikidata_city_id',
                    'city_current_weather.icon_file',
                    'city_current_weather.temp_c',
                    'city_current_weather.humidity_p',
                    'city_current_weather.is_day',
                    'city_current_weather.wind_dir',
                    'city_current_weather.wind_kph',
                    'city_current_weather.cloud_p',
                    'city_current_weather.updated_at',
                )
                ->first();

        return $cityWeather;
    }

    public function createJsonFile(int $cityId)
    {
        $this->cityId = $cityId;

        $data = json_encode($this->getDataForJson());

        $now = new \DateTime();
        $now->format('Y-m-d H:i:s');
        $jsuffix = $now->getTimestamp();

        $file = 'json/result_'.$jsuffix.'.json';

        $fp = fopen('../public/storage/'.$file, 'a');
        fwrite($fp, $data);
        fclose($fp);

        $json = json_encode(['link' => '/storage/'.$file]);

        return $json;
    }

    private function getDataForJson()
    {
        $data = [];
        $cityCurrentWeather = CityCurrentWeather::where('wikidata_city_id', '=', $this->cityId)
            ->select(
                'icon_file',
                'temp_c',
                'humidity_p',
                'is_day',
                'wind_dir',
                'wind_kph',
                'cloud_p',
                'created_at',
                'updated_at'
            )
            ->first();

        $dbCityPlaces = CityPlaces::where('city_id_id', '=', $this->cityId)
            ->select(
                'name',
                'latitude',
                'longitude',
                'distance',
            )
            ->get();

        $cityPlaces = [];
        foreach ($dbCityPlaces as $place) {
            $cityPlaces[$place->name] = [
                'latitude' => $place->latitude,
                'longitude' => $place->longitude,
                'distance' => $place->distance,
            ];
        }

        $data['city'] = [
            'id' => $this->cityId,
            'current_weather' => $cityCurrentWeather,
            'places' => $cityPlaces,
        ];

        return $data;
    }
}
