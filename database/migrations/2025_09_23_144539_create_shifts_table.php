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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_member_id')->constrained()->onDelete('cascade');
            $table->datetime('start_dt');
            $table->datetime('end_dt');
            $table->enum('planned_role', ['cashier', 'cook', 'server', 'manager', 'cleaner'])->default('server');
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['restaurant_id', 'start_dt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
