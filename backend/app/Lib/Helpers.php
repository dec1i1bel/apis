<?php

namespace App\Lib;

use Illuminate\Support\Facades\DB;

class Helpers
{
    /**
     * @return array [<city wikidata id> => <city name>]
     */
    public static function getDatabaseCities()
    {
        $dbCities = [];

        $databaseCities = DB::table('wikidata_cities')
                        ->select('id', 'city_name_en')
                        ->get();

        foreach ($databaseCities as $city) {
            $dbCities[$city->id] = $city->city_name_en;
        }

        return $dbCities;
    }
}