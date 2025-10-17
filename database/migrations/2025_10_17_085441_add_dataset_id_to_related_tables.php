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
        // Add dataset_id to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('dataset_id')->nullable()->constrained()->onDelete('set null');
        });

        // Add dataset_id to menu_items table
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreignId('dataset_id')->nullable()->constrained()->onDelete('set null');
        });

        // Add dataset_id to inventory_items table
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->foreignId('dataset_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['dataset_id']);
            $table->dropColumn('dataset_id');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign(['dataset_id']);
            $table->dropColumn('dataset_id');
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropForeign(['dataset_id']);
            $table->dropColumn('dataset_id');
        });
    }
};
