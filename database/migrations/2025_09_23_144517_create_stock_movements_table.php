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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjust']);
            $table->decimal('qty', 10, 3);
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->string('ref')->nullable(); // Reference (PO number, order number, etc.)
            $table->text('note')->nullable();
            $table->datetime('moved_at');
            $table->timestamps();
            
            $table->index(['restaurant_id', 'moved_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
