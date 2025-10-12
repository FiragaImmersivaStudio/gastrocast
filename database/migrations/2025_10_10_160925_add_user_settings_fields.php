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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('timezone')->default('UTC')->after('phone');
            
            // Notification preferences
            $table->boolean('notification_forecast_ready')->default(true)->after('timezone');
            $table->boolean('notification_system_updates')->default(true)->after('notification_forecast_ready');
            $table->boolean('notification_forecast_next_month')->default(true)->after('notification_system_updates');
            
            // 2FA fields
            $table->text('two_factor_secret')->nullable()->after('notification_forecast_next_month');
            $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
            
            // Soft delete fields
            $table->timestamp('deleted_at')->nullable()->after('two_factor_enabled');
            $table->timestamp('deletion_requested_at')->nullable()->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name', 
                'phone',
                'timezone',
                'notification_forecast_ready',
                'notification_system_updates',
                'notification_forecast_next_month',
                'two_factor_secret',
                'two_factor_enabled',
                'deleted_at',
                'deletion_requested_at'
            ]);
        });
    }
};
