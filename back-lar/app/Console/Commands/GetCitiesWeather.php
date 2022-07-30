<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\ExternalAPIManager;
use App\Lib\Helpers;
use App\Models\WikidataCities;
use App\Models\CityCurrentWeather;
use Illuminate\Support\Facades\DB;

class GetCitiesWeather extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cities:weather';

    /**
     * @var string
     */
    protected $description = 'Get weather from external API for cities in the database and save it to the database';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $dbCities = Helpers::getDatabaseCities();
        foreach ($dbCities as $cityId => $city) {
            $dbCitiesIdsNames[$cityId] = $city['name_en'];
        }

        if (isset($dbCitiesIdsNames)) {
            foreach ($dbCitiesIdsNames as $cityId => $cityName) {
                /**
                 * для каждого города - запрос текущей погоды к внешнему api:
                 */
                $cityName = str_replace(' ', '%20', $cityName);
                $cityWeatherApi = new ExternalAPIManager('https://weatherapi-com.p.rapidapi.com/current.json?q=' . $cityName);
    
                $cityData = $cityWeatherApi->getData();
    
                if ($cityData != 'error') {
                    $cityData = json_decode($cityData)->current;
                    CityCurrentWeather::updateOrCreate(
                        [
                            'wikidata_city_id' => $cityId,
                        ],
                        [
                            'wikidata_city_id' => $cityId,
                            'icon_file' => $cityData->condition->icon,
                            'temp_c' => $cityData->temp_c,
                            'humidity_p' => $cityData->humidity,
                            'is_day' => $cityData->is_day,
                            'wind_dir' => $cityData->wind_dir,
                            'wind_kph' => $cityData->wind_kph,
                            'cloud_p' => $cityData->cloud,
                        ]
                    );
                }
            }
        }
    }
}
