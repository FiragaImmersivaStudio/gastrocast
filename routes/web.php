<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Api\RestaurantApiController;
use App\Http\Controllers\Api\ForecastApiController;
use App\Http\Controllers\Api\MetricsApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::middleware(['web'])->group(function () {
    // Welcome page
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    });

    // Authentication routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password reset routes would go here...
    
    // Protected web routes
    Route::middleware(['auth', 'tenant.scope', 'email.verif.toggle'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Restaurant management
        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
        Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
        Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
        Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
        
        // Dataset management
        Route::get('/datasets', function () { return view('datasets.index'); })->name('datasets.index');
        
        // Forecast & Insights
        Route::get('/forecast', function () { return view('forecast.index'); })->name('forecast.index');
        
        // What-If Lab
        Route::get('/whatif', function () { return view('whatif.index'); })->name('whatif.index');
        
        // Staffing Planner
        Route::get('/staffing', function () { return view('staffing.index'); })->name('staffing.index');
        
        // Inventory & Waste
        Route::get('/inventory', function () { return view('inventory.index'); })->name('inventory.index');
        
        // Menu Engineering
        Route::get('/menu-engineering', function () { return view('menu-engineering.index'); })->name('menu-engineering.index');
        
        // Promotions
        Route::get('/promotions', function () { return view('promotions.index'); })->name('promotions.index');
        
        // Operations Monitor
        Route::get('/operations', function () { return view('operations.index'); })->name('operations.index');
        
        // Reports & Export
        Route::get('/reports', function () { return view('reports.index'); })->name('reports.index');
        
        // Settings
        Route::get('/settings', function () { return view('settings.index'); })->name('settings.index');
    });

    // API-like endpoints (AJAX) - staying in web.php as requested
    Route::prefix('api')->middleware(['web', 'auth:sanctum', 'tenant.scope'])->group(function () {
        // Restaurant API
        Route::get('/restaurants', [RestaurantApiController::class, 'index']);
        Route::post('/restaurants', [RestaurantApiController::class, 'store']);
        Route::put('/restaurants/{restaurant}', [RestaurantApiController::class, 'update']);
        Route::delete('/restaurants/{restaurant}', [RestaurantApiController::class, 'destroy']);
        Route::post('/restaurants/{restaurant}/select', [RestaurantApiController::class, 'select']);
        
        // Forecast API
        Route::post('/forecast/run', [ForecastApiController::class, 'run']);
        Route::get('/forecast/summary', [ForecastApiController::class, 'summary']);
        Route::get('/forecast/{forecast}', [ForecastApiController::class, 'show']);
        
        // Metrics API
        Route::get('/metrics/overview', [MetricsApiController::class, 'overview']);
        Route::get('/metrics/trends', [MetricsApiController::class, 'trends']);
        Route::get('/metrics/heatmap', [MetricsApiController::class, 'heatmap']);
        
        // What-If API
        Route::get('/whatif/scenarios', function () { return response()->json(['message' => 'What-If scenarios endpoint']); });
        Route::post('/whatif/scenarios', function () { return response()->json(['message' => 'Create What-If scenario']); });
        Route::post('/whatif/run/{scenario}', function () { return response()->json(['message' => 'Run What-If scenario']); });
        
        // Reports API
        Route::get('/reports/export', function () { return response()->json(['message' => 'Export report']); });
        Route::post('/reports/schedule', function () { return response()->json(['message' => 'Schedule report']); });
        
        // Data Import API
        Route::post('/datasets/import', function () { return response()->json(['message' => 'Import dataset']); });
        Route::get('/datasets/status/{import}', function () { return response()->json(['message' => 'Import status']); });
        
        // LLM Summary API
        Route::post('/llm/summary', function () { return response()->json(['message' => 'Generate LLM summary']); });
    });
});
