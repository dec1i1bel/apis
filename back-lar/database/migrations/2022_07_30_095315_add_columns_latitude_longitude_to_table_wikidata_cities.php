<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsLatitudeLongitudeToTableWikidataCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wikidata_cities', function (Blueprint $table) {
            $table->float('latitude', 13, 10);
            $table->float('longitude', 13, 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wikidata_cities', function (Blueprint $table) {
            $table->dropColumn([
                'latitude', 
                'longitude'
            ]);
        });
    }
}
