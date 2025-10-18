<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('weather_temp', 5, 2)->nullable()->after('dataset_id')->comment('Temperature in Kelvin');
            $table->string('weather_condition')->nullable()->after('weather_temp')->comment('Main weather condition (e.g., Rain, Clear)');
            $table->string('weather_description')->nullable()->after('weather_condition')->comment('Detailed weather description');
            $table->integer('weather_humidity')->nullable()->after('weather_description')->comment('Humidity percentage');
            $table->integer('weather_pressure')->nullable()->after('weather_humidity')->comment('Atmospheric pressure in hPa');
            $table->decimal('weather_wind_speed', 5, 2)->nullable()->after('weather_pressure')->comment('Wind speed in m/s');
            $table->timestamp('weather_fetched_at')->nullable()->after('weather_wind_speed')->comment('When weather data was fetched');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'weather_temp',
                'weather_condition',
                'weather_description',
                'weather_humidity',
                'weather_pressure',
                'weather_wind_speed',
                'weather_fetched_at',
            ]);
        });
    }
};
