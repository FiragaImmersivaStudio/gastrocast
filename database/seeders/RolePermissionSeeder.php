<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Restaurant management
            'view restaurants',
            'create restaurants',
            'edit restaurants',
            'delete restaurants',
            'select restaurants',
            
            // Data management
            'view datasets',
            'import datasets',
            'export datasets',
            
            // Analytics & Forecasting
            'view dashboard',
            'generate forecasts',
            'view analytics',
            
            // LLM & AI Features
            'use llm summary',
            'refresh llm summary',
            
            // Menu Engineering
            'view menu engineering',
            'edit menu items',
            
            // Staff Management
            'view staff',
            'manage staff',
            'view schedules',
            'edit schedules',
            
            // Inventory
            'view inventory',
            'manage inventory',
            
            // Operations
            'view operations',
            'monitor operations',
            
            // Promotions
            'view promotions',
            'create promotions',
            'edit promotions',
            
            // Reports
            'view reports',
            'export reports',
            
            // Settings
            'view settings',
            'edit settings',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $ownerRole = \Spatie\Permission\Models\Role::create(['name' => 'owner']);
        $managerRole = \Spatie\Permission\Models\Role::create(['name' => 'manager']);
        $staffRole = \Spatie\Permission\Models\Role::create(['name' => 'staff']);

        // Owner has all permissions
        $ownerRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // Manager has most permissions except user management and sensitive settings
        $managerPermissions = [
            'view restaurants', 'edit restaurants', 'select restaurants',
            'view datasets', 'import datasets', 'export datasets',
            'view dashboard', 'generate forecasts', 'view analytics',
            'use llm summary', 'refresh llm summary',
            'view menu engineering', 'edit menu items',
            'view staff', 'manage staff', 'view schedules', 'edit schedules',
            'view inventory', 'manage inventory',
            'view operations', 'monitor operations',
            'view promotions', 'create promotions', 'edit promotions',
            'view reports', 'export reports',
            'view settings',
        ];
        $managerRole->givePermissionTo($managerPermissions);

        // Staff has limited permissions
        $staffPermissions = [
            'view restaurants', 'select restaurants',
            'view datasets',
            'view dashboard', 'view analytics',
            'view menu engineering',
            'view staff', 'view schedules',
            'view inventory',
            'view operations',
            'view promotions',
            'view reports',
        ];
        $staffRole->givePermissionTo($staffPermissions);
    }
}
