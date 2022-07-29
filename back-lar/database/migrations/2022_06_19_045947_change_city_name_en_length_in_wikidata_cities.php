<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCityNameEnLengthInWikidataCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wikidata_cities', function (Blueprint $table) {
            $table->string('city_name_en', 50)->change();
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
            $table->string('city_name_en', 20)->change();
        });
    }
}
