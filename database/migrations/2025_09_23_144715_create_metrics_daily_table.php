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
        Schema::create('metrics_daily', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('traffic')->default(0);
            $table->integer('conversions')->default(0);
            $table->integer('transactions')->default(0);
            $table->decimal('gmv', 12, 2)->default(0);
            $table->decimal('aov', 10, 2)->default(0);
            $table->decimal('conversion_rate', 5, 4)->default(0);
            $table->integer('avg_waiting_time_sec')->default(0);
            $table->decimal('avg_party_size', 3, 1)->default(1);
            $table->timestamps();
            
            $table->unique(['restaurant_id', 'date']);
            $table->index(['restaurant_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metrics_daily');
    }
};
