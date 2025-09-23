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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('sku')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('uom'); // Unit of measure (kg, pcs, liter, etc.)
            $table->decimal('current_stock', 10, 3)->default(0);
            $table->decimal('safety_stock', 10, 3)->default(0);
            $table->decimal('reorder_point', 10, 3)->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->integer('lead_time_days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['restaurant_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
