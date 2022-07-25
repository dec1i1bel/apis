<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\ExternalAPIManager;
use App\Lib\Helpers;
use App\Models\WikidataCities;
use Illuminate\Support\Facades\DB;

class GetGeoDBcities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:basic';

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
     * @return int
     */
    public function handle()
    {
        $api = new ExternalAPIManager('https://wft-geo-db.p.rapidapi.com/v1/geo/cities?minPopulation=10000000');

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
    
                    $dbCities = Helpers::getDatabaseCities();

                    if (!empty($dbCities)) {
                        /**
                         * Сompare arrays of cities from API and DB,
                         * and put missing cities to DB.
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
