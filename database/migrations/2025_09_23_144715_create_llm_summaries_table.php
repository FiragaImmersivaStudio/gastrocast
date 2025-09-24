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
        Schema::create('llm_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->enum('context', ['overview', 'forecast', 'inventory', 'staffing', 'promo', 'whatif', 'menu']);
            $table->text('prompt');
            $table->text('response');
            $table->json('action_items')->nullable();
            $table->string('model_used')->default('groq');
            $table->integer('tokens_used')->default(0);
            $table->decimal('processing_time_ms', 8, 2)->default(0);
            $table->timestamps();
            
            $table->index(['restaurant_id', 'context', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llm_summaries');
    }
};
