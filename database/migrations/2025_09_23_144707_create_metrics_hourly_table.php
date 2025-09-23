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
        Schema::create('metrics_hourly', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->datetime('ts'); // Timestamp for the hour
            $table->integer('traffic')->default(0); // Number of visitors/customers
            $table->integer('conversions')->default(0); // Number of orders
            $table->integer('transactions')->default(0); // Number of completed transactions
            $table->decimal('gmv', 12, 2)->default(0); // Gross Merchandise Value
            $table->decimal('aov', 10, 2)->default(0); // Average Order Value
            $table->decimal('conversion_rate', 5, 4)->default(0); // conversions/traffic
            $table->timestamps();
            
            $table->unique(['restaurant_id', 'ts']);
            $table->index(['restaurant_id', 'ts']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metrics_hourly');
    }
};
