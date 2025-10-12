<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::firstOrCreate([
            'email' => 'demo@custicast.com'
        ], [
            'name' => 'Demo User',
            'password' => bcrypt('demo123'),
            'email_verified_at' => now(),
        ]);

        // Assign owner role to demo user
        $user->assignRole('owner');

        // demo2 user
        $user2 = \App\Models\User::firstOrCreate([
            'email' => 'demo2@custicast.com'
        ], [
            'name' => 'Demo User 2',
            'password' => bcrypt('demo123'),
            'email_verified_at' => now(),
        ]);

        // Assign user role to demo2 user
        $user2->assignRole('user');

        echo "Demo user created/updated successfully\n";
    }
}
