<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\GeoDBCitiesApiManager as GeoDB;
use App\Models\WikidataCities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class GetGeoDBcities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geodb:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get basic information (name, coordinates, etc.) about cities in the world with population more than 1000000 people from GeoDB Cities API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new GeoDB('https://wft-geo-db.p.rapidapi.com/v1/geo/cities?minPopulation=10000000');

        $get = $api->getData();

        if ($get == 'error') {
            $data = $get;
        } else {
            $data = json_decode($get)->data;

            if (!empty($data)) {
                foreach ($data as $item) {
                    $dataCities[$item->wikiDataId] = $item->name;
                }

                if (isset($dataCities)) {
                    $dataCities = collect($dataCities)->toArray();
    
                    $databaseCities = DB::table('wikidata_cities')->select('wikidata_id', 'city_name_en')->get();
                    foreach ($databaseCities as $city) {
                        $dbCities[$city->wikidata_id] = $city->city_name_en;
                    }

                    if (isset($dbCities)) {
                        /**
                         * теперь имеем массивы городов из БД и из API.
                         * сравниваем их и в БД вписываем недостающие
                         */
                        $diffCities = array_diff(
                            array_keys($dataCities),
                            array_keys($dbCities)
                        );
                        foreach ($diffCities as $dCityWikiId) {

                            if (isset($dataCities[$dCityWikiId])) {
                                $city = $dataCities[$dCityWikiId];
                            } elseif (isset($dbCities[dCityWikiId])) {
                                $city = $dataCities[$dCityWikiId];
                            }
                            if (isset($city)) {
                                $citiesToWrite[$dCityWikiId] = $city;
                            }
                        }

                        if (isset($citiesToWrite)) {
                            foreach ($citiesToWrite as $wikiId => $cityName) {
                                WikidataCities::create([
                                    'wikidata_id' => $wikiId,
                                    'city_name_en' => $cityName
                                ]);
                            }
                        }

                    }
                }
            }
        }

        return $data;
    }
}
