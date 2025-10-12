<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if ($user) {
            // Create some sample invoices
            Invoice::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . date('Y') . '-001',
                'amount' => 1000000,
                'currency' => 'IDR',
                'status' => 'paid',
                'due_date' => Carbon::now()->subDays(30),
                'paid_at' => Carbon::now()->subDays(28),
                'payment_method' => 'Credit Card (**** 4242)',
                'description' => 'Basic Plan - Monthly Subscription',
                'billing_details' => [
                    'plan' => 'Basic',
                    'period' => 'monthly',
                    'billing_period' => Carbon::now()->subDays(30)->format('Y-m') . ' - ' . Carbon::now()->format('Y-m')
                ]
            ]);

            Invoice::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . date('Y') . '-002',
                'amount' => 1000000,
                'currency' => 'IDR',
                'status' => 'paid',
                'due_date' => Carbon::now()->subDays(60),
                'paid_at' => Carbon::now()->subDays(58),
                'payment_method' => 'Credit Card (**** 4242)',
                'description' => 'Basic Plan - Monthly Subscription',
                'billing_details' => [
                    'plan' => 'Basic',
                    'period' => 'monthly',
                    'billing_period' => Carbon::now()->subDays(60)->format('Y-m') . ' - ' . Carbon::now()->subDays(30)->format('Y-m')
                ]
            ]);

            Invoice::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . date('Y') . '-003',
                'amount' => 1000000,
                'currency' => 'IDR',
                'status' => 'pending',
                'due_date' => Carbon::now()->addDays(5),
                'payment_method' => 'Credit Card (**** 4242)',
                'description' => 'Basic Plan - Monthly Subscription',
                'billing_details' => [
                    'plan' => 'Basic',
                    'period' => 'monthly',
                    'billing_period' => Carbon::now()->format('Y-m') . ' - ' . Carbon::now()->addMonth()->format('Y-m')
                ]
            ]);
        }
    }
}
