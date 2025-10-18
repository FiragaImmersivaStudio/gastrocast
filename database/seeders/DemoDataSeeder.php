<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\SystemParameter;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed options: set to true to seed the corresponding table, false to skip
        $seedOptions = [
            'system_parameters' => true,
            'users' => true,
            'restaurants' => true,
            'menu_data' => false,
            'orders' => false,
        ];

        // Create system parameters
        if ($seedOptions['system_parameters']) {
            $this->createSystemParameters();
        }

        // Create demo user
        $user = null;
        if ($seedOptions['users']) {
            $user = User::create([
                'name' => 'Demo Owner',
                'email' => 'demo@custicast.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]);

            // demo2
            $user2 = User::create([
                'name' => 'Demo User 2',
                'email' => 'demo2@custicast.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]);

            // demo3
            $user3 = User::create([
                'name' => 'Demo User 3',
                'email' => 'demo3@custicast.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]);
        }

        // Create demo restaurants
        $restaurant1 = null;
        $restaurant2 = null;
        if ($seedOptions['restaurants'] && $user) {
            $restaurant1 = Restaurant::create([
                'owner_user_id' => $user->id,
                'name' => 'The Gourmet Burger',
                'category' => 'Fast Casual',
                'address' => '123 Main Street, Downtown City',
                'phone' => '+1-555-0123',
                'email' => 'info@gourmetburger.com',
                'timezone' => 'America/New_York',
                'operating_hours' => [
                    'monday' => ['open' => '11:00', 'close' => '22:00'],
                    'tuesday' => ['open' => '11:00', 'close' => '22:00'],
                    'wednesday' => ['open' => '11:00', 'close' => '22:00'],
                    'thursday' => ['open' => '11:00', 'close' => '22:00'],
                    'friday' => ['open' => '11:00', 'close' => '23:00'],
                    'saturday' => ['open' => '10:00', 'close' => '23:00'],
                    'sunday' => ['open' => '10:00', 'close' => '21:00'],
                ],
            ]);

            $restaurant2 = Restaurant::create([
                'owner_user_id' => $user->id,
                'name' => 'Pasta Paradise',
                'category' => 'Italian',
                'address' => '456 Oak Avenue, Uptown City',
                'phone' => '+1-555-0456',
                'email' => 'hello@pastaparadise.com',
                'timezone' => 'America/New_York',
                'operating_hours' => [
                    'monday' => ['open' => '12:00', 'close' => '21:00'],
                    'tuesday' => ['open' => '12:00', 'close' => '21:00'],
                    'wednesday' => ['open' => '12:00', 'close' => '21:00'],
                    'thursday' => ['open' => '12:00', 'close' => '21:00'],
                    'friday' => ['open' => '12:00', 'close' => '22:00'],
                    'saturday' => ['open' => '11:00', 'close' => '22:00'],
                    'sunday' => ['open' => '11:00', 'close' => '20:00'],
                ],
            ]);

            // Add user to restaurant pivot table
            $restaurant1->users()->attach($user->id, ['role' => 'owner', 'joined_at' => now()]);
            $restaurant2->users()->attach($user->id, ['role' => 'owner', 'joined_at' => now()]);
        }

        // Create menu categories and items for restaurant 1
        if ($seedOptions['menu_data'] && $restaurant1 && $restaurant2) {
            $this->createMenuData($restaurant1, 'burger');
            $this->createMenuData($restaurant2, 'italian');
        }

        // Create sample orders
        if ($seedOptions['orders'] && $restaurant1 && $restaurant2) {
            $this->createSampleOrders($restaurant1);
            $this->createSampleOrders($restaurant2);
        }

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Email: demo@custicast.com');
        $this->command->info('Password: demo123');
    }

    private function createSystemParameters()
    {
        $parameters = [
            ['key' => 'email_verification_enabled', 'value' => 'false', 'type' => 'boolean', 'description' => 'Enable email verification for new users'],
            ['key' => 'llm_provider', 'value' => 'groq', 'type' => 'string', 'description' => 'LLM provider (groq or router)'],
            ['key' => 'chart_ci_level', 'value' => '95', 'type' => 'integer', 'description' => 'Confidence interval level for charts'],
            ['key' => 'theme_primary', 'value' => '#7A001F', 'type' => 'string', 'description' => 'Primary theme color'],
            ['key' => 'theme_accent', 'value' => '#FFC107', 'type' => 'string', 'description' => 'Accent theme color'],
            ['key' => 'whatif_enabled', 'value' => 'true', 'type' => 'boolean', 'description' => 'Enable What-If Laboratory feature'],
            ['key' => 'dark_mode_enabled', 'value' => 'true', 'type' => 'boolean', 'description' => 'Enable dark mode toggle'],
        ];

        foreach ($parameters as $param) {
            SystemParameter::updateOrCreate(
                ['key' => $param['key']],
                $param
            );
        }
    }

    private function createMenuData($restaurant, $type)
    {
        if ($type === 'burger') {
            $categories = [
                ['name' => 'Burgers', 'description' => 'Our signature burger creations'],
                ['name' => 'Sides', 'description' => 'Perfect accompaniments'],
                ['name' => 'Beverages', 'description' => 'Refreshing drinks'],
                ['name' => 'Desserts', 'description' => 'Sweet endings'],
            ];

            foreach ($categories as $catData) {
                $category = MenuCategory::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $catData['name'],
                    'description' => $catData['description'],
                    'sort_order' => array_search($catData, $categories),
                ]);

                // Create menu items for each category
                if ($category->name === 'Burgers') {
                    $items = [
                        ['sku' => 'BURGER-001', 'name' => 'Classic Beef Burger', 'cogs' => 8.50, 'price' => 15.95],
                        ['sku' => 'BURGER-002', 'name' => 'Cheese Deluxe', 'cogs' => 9.25, 'price' => 17.95],
                        ['sku' => 'BURGER-003', 'name' => 'Veggie Burger', 'cogs' => 7.50, 'price' => 14.95],
                        ['sku' => 'BURGER-004', 'name' => 'BBQ Bacon Burger', 'cogs' => 10.75, 'price' => 19.95],
                    ];
                } elseif ($category->name === 'Sides') {
                    $items = [
                        ['sku' => 'SIDE-001', 'name' => 'French Fries', 'cogs' => 2.50, 'price' => 5.95],
                        ['sku' => 'SIDE-002', 'name' => 'Onion Rings', 'cogs' => 3.25, 'price' => 6.95],
                        ['sku' => 'SIDE-003', 'name' => 'Sweet Potato Fries', 'cogs' => 3.50, 'price' => 7.95],
                    ];
                } elseif ($category->name === 'Beverages') {
                    $items = [
                        ['sku' => 'BEV-001', 'name' => 'Soft Drink', 'cogs' => 0.75, 'price' => 2.95],
                        ['sku' => 'BEV-002', 'name' => 'Craft Beer', 'cogs' => 2.50, 'price' => 5.95],
                        ['sku' => 'BEV-003', 'name' => 'Fresh Juice', 'cogs' => 1.25, 'price' => 3.95],
                    ];
                } else { // Desserts
                    $items = [
                        ['sku' => 'DESS-001', 'name' => 'Chocolate Brownie', 'cogs' => 2.25, 'price' => 6.95],
                        ['sku' => 'DESS-002', 'name' => 'Ice Cream Sundae', 'cogs' => 1.75, 'price' => 5.95],
                    ];
                }

                foreach ($items as $itemData) {
                    MenuItem::create([
                        'restaurant_id' => $restaurant->id,
                        'category_id' => $category->id,
                        'sku' => $itemData['sku'],
                        'name' => $itemData['name'],
                        'cogs' => $itemData['cogs'],
                        'price' => $itemData['price'],
                        'prep_time_minutes' => rand(5, 15),
                        'is_active' => true,
                    ]);
                }
            }
        } else { // Italian
            // Similar structure for Italian restaurant...
            $category = MenuCategory::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Pasta',
                'description' => 'Fresh homemade pasta dishes',
                'sort_order' => 0,
            ]);

            $items = [
                ['sku' => 'PASTA-001', 'name' => 'Spaghetti Carbonara', 'cogs' => 6.50, 'price' => 18.95],
                ['sku' => 'PASTA-002', 'name' => 'Fettuccine Alfredo', 'cogs' => 5.75, 'price' => 16.95],
                ['sku' => 'PASTA-003', 'name' => 'Penne Arrabbiata', 'cogs' => 5.25, 'price' => 15.95],
            ];

            foreach ($items as $itemData) {
                MenuItem::create([
                    'restaurant_id' => $restaurant->id,
                    'category_id' => $category->id,
                    'sku' => $itemData['sku'],
                    'name' => $itemData['name'],
                    'cogs' => $itemData['cogs'],
                    'price' => $itemData['price'],
                    'prep_time_minutes' => rand(10, 20),
                    'is_active' => true,
                ]);
            }
        }
    }

    private function createSampleOrders($restaurant)
    {
        $menuItems = $restaurant->menuItems;
        $startDate = now()->subDays(90); // 3 months of data

        for ($i = 0; $i < 150; $i++) { // Create 150 orders per restaurant
            $orderDate = $startDate->copy()->addDays(rand(0, 90))->addHours(rand(11, 21))->addMinutes(rand(0, 59));
            
            $grossAmount = rand(1500, 8500) / 100; // $15-85
            $taxAmount = $grossAmount * 0.08; // 8% tax
            $netAmount = $grossAmount - $taxAmount;

            $order = Order::create([
                'restaurant_id' => $restaurant->id,
                'order_no' => 'ORD-' . $restaurant->id . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'order_dt' => $orderDate,
                'channel' => collect(['dine_in', 'takeaway', 'delivery'])->random(),
                'status' => 'completed',
                'gross_amount' => $grossAmount,
                'net_amount' => $netAmount,
                'tax_amount' => $taxAmount,
                'waiting_time_sec' => rand(300, 1800), // 5-30 minutes
                'party_size' => rand(1, 6),
                'customer_name' => 'Customer ' . ($i + 1),
            ]);

            // Create 1-4 order items per order
            $itemCount = min(rand(1, 4), $menuItems->count());
            $selectedItems = $menuItems->random($itemCount);

            foreach ($selectedItems as $menuItem) {
                $qty = rand(1, 3);
                $unitPrice = $menuItem->price;
                $lineTotal = $qty * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ]);
            }
        }
    }
}
