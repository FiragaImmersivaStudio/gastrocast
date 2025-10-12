<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:cleanup-deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete users who have been soft deleted for more than 31 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thirtyOneDaysAgo = Carbon::now()->subDays(31);
        
        // Find users who were deleted more than 31 days ago
        $usersToDelete = User::onlyTrashed()
            ->where('deletion_requested_at', '<=', $thirtyOneDaysAgo)
            ->get();
        
        $this->info("Found {$usersToDelete->count()} users to permanently delete.");
        
        foreach ($usersToDelete as $user) {
            $this->info("Permanently deleting user: {$user->email}");
            
            // Delete associated restaurants owned by this user
            $ownedRestaurants = Restaurant::where('owner_user_id', $user->id)->get();
            foreach ($ownedRestaurants as $restaurant) {
                $this->info("  - Deleting restaurant: {$restaurant->name}");
                // Delete associated data (orders, inventory, etc.)
                $restaurant->menuCategories()->delete();
                $restaurant->orders()->delete();
                $restaurant->inventoryItems()->delete();
                $restaurant->stockMovements()->delete();
                $restaurant->delete();
            }
            
            // Remove user from restaurant_user pivot table
            $user->restaurants()->detach();
            
            // Force delete the user
            $user->forceDelete();
        }
        
        $this->info("Cleanup completed. {$usersToDelete->count()} users permanently deleted.");
        
        return 0;
    }
}
