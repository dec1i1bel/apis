<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCityWeather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_current_weather', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wikidata_city_id');
            $table->foreign('wikidata_city_id')
                ->references('id')
                ->on('wikidata_cities');
            $table->string('icon_file', 100);
            $table->tinyinteger('temp_c');
            $table->tinyinteger('humidity_p');
            $table->tinyinteger('is_day');
            $table->string('wind_dir', 10);
            $table->tinyinteger('wind_kph');
            $table->tinyinteger('cloud_p');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_current_weather');
    }
}
