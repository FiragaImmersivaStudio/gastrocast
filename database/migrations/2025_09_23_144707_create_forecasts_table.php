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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->integer('horizon_days');
            $table->enum('granularity', ['hour', 'day'])->default('day');
            $table->json('params_json'); // Forecasting parameters
            $table->json('result_json'); // Forecast results
            $table->json('ci_lower_json'); // Lower confidence interval
            $table->json('ci_upper_json'); // Upper confidence interval
            $table->decimal('mape', 5, 2)->nullable(); // Mean Absolute Percentage Error
            $table->datetime('forecast_date');
            $table->timestamps();
            
            $table->index(['restaurant_id', 'forecast_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
