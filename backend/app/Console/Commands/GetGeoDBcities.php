<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
            $wcities = WikidataCities::all()->get();

            foreach ($data as $item) {
                if (!$wcities->contains($wcities->where('wikidata_id'), $item->wikiDataId)) {
                    WikidataCities::create([
                        'wikidata_id' => $item->wikiDataId,
                        'city_name_en' => $item->city
                    ]);
                }
            }
        }

        return $data;
    }
}
