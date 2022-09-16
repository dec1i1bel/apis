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
    protected $description = 'Get basic information (name, coordinates, etc.) about cities from GeoDB Cities API';

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
        $api = new ExternalAPIManager('https://wft-geo-db.p.rapidapi.com/v1/geo/cities?minPopulation=2000000&maxPopulatin=10000000');

        $get = $api->getData();

        if ($get == 'error') {
            $data = $get;
        } else {
            $data = json_decode($get)->data;

            if (!empty($data)) {
                foreach ($data as $item) {
                    WikidataCities::updateOrCreate(
                        [
                            'wikidata_id' => $item->wikiDataId
                        ],
                        [
                            'wikidata_id' => $item->wikiDataId,
                            'city_name_en' => $item->name,
                            'latitude' => $item->latitude,
                            'longitude' => $item->longitude,
                        ]
                    );
                }
            }
        }

        return $data;
    }
}
