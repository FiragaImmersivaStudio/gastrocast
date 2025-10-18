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
        Schema::table('forecasts', function (Blueprint $table) {
            $table->datetime('start_date')->nullable()->after('forecast_date');
            $table->datetime('end_date')->nullable()->after('start_date');
            $table->text('summary_text')->nullable()->after('mape');
            $table->string('model_used', 100)->nullable()->after('summary_text');
            $table->integer('tokens_used')->nullable()->after('model_used');
            $table->integer('processing_time_ms')->nullable()->after('tokens_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forecasts', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'summary_text', 'model_used', 'tokens_used', 'processing_time_ms']);
        });
    }
};
