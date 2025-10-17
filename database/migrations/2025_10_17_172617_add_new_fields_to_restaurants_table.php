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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('website')->nullable()->after('email');
            $table->text('description')->nullable()->after('website');
            $table->boolean('is_inside_mall')->default(false)->after('description');
            $table->string('mall_name')->nullable()->after('is_inside_mall');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'website', 'description', 'is_inside_mall', 'mall_name']);
        });
    }
};
