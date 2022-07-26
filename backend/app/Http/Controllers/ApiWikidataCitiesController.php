<?php

namespace App\Http\Controllers;

use App\Models\WikidataCities;
use Illuminate\Support\Facades\Storage;
use App\Models\CityCurrentWeather;

class ApiWikidataCitiesController extends Controller
{
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
        return CityCurrentWeather::where('wikidata_city_id', '=', $cityId)
                ->get()
                ->toJson(JSON_UNESCAPED_UNICODE);
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