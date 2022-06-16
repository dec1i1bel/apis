<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WikidataCities;
use App\Lib\GeoDBCitiesApiManager as GeoDB;
use App\Models\WikidataCities;

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
    
            foreach ($data as $item) {
                $wikiDataId = $item->wikiDataId;
                $city = $item->city;
                // ... getting other fields from result ...
                // save fields to database
            }
        }

        return $data;
    }
}
