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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('menu_categories')->onDelete('set null');
            $table->string('sku')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('cogs', 10, 2)->default(0); // Cost of goods sold
            $table->decimal('price', 10, 2);
            $table->integer('prep_time_minutes')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('allergens')->nullable();
            $table->json('nutrition_info')->nullable();
            $table->timestamps();
            
            $table->unique(['restaurant_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
