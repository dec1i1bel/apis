<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;
use App\Models\CityCurrentWeather;
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
                // ->where('wikidata_city_id', '=', $this->cityId)
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

    public function createJsonFile()
    {
        header('Content-type: application/json');
        $data = file_get_contents('php://input');

        $now = new \DateTime();
        $now->format('Y-m-d H:i:s');    // MySQL datetime format
        $jsuffix = $now->getTimestamp();

        $file = 'json/result_'.$jsuffix.'.json';

        $fp = fopen('../public/storage/'.$file, 'a');
        fwrite($fp, $data);
        fclose($fp);

        echo '/storage/'.$file;
    }
}