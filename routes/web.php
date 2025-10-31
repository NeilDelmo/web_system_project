<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\Sale_OrderController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// All authenticated routes with back history prevention
Route::middleware(['auth', 'preventBackHistory'])->group(function () {
    
    // Dashboard - accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products route - accessible by all authenticated users
    Route::get('products', [ProductManageController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductManageController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}', [ProductManageController::class, 'show'])->name('products.show');
    Route::put('/products/{product}', [ProductManageController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductManageController::class, 'destroy'])->name('products.destroy');
    Route::post('/categories/store', [ProductManageController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}', [ProductManageController::class, 'showCategory'])->name('categories.show');
    Route::put('/categories/{category}', [ProductManageController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [ProductManageController::class, 'destroyCategory'])->name('categories.destroy');
    Route::post('/ingredients/store', [ProductManageController::class, 'storeIngredient'])->name('ingredients.store');
    Route::post('/pricing-rules/store', [ProductManageController::class, 'storePricingRule'])->name('pricing.store');
    Route::post('/recipes/store', [ProductManageController::class, 'storeRecipe'])->name('recipes.store');

    // Inventory route - requires 'manage_inventory' permission
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->middleware('permission:manage_inventory')
        ->name('inventory');

    // Sales and order routes - requires 'manage_orders' permission
    Route::get('/sale_and_orders', [Sale_OrderController::class, 'index'])
        ->middleware('permission:manage_orders')
        ->name('sale_and_orders');
    Route::get('/sales', [Sale_OrderController::class, 'index'])
        ->middleware('permission:manage_orders')
        ->name('sales'); // Alias route

    // Production routes - accessible by all authenticated users
    Route::get('/production', [ProductionController::class, 'index'])->name('production');
    Route::get('/production/recipe-requirements/{product}', [ProductionController::class, 'getRecipeRequirements'])->name('production.requirements');
    Route::post('/production/produce', [ProductionController::class, 'produce'])->name('production.produce');

    // Reports route - requires 'view_reports' permission
    Route::get('/reports', function () {
        return view('reports');
    })->middleware('permission:view_reports')->name('reports');
    
});

// ========================================
// TEST ROUTES FOR ERROR PAGES
// Remove these routes in production!
// ========================================
Route::prefix('test-errors')->group(function () {
    
    // Test 401 - Unauthorized (must be logged out to see this)
    Route::get('/401', function () {
        abort(401);
    })->name('test.401');
    
    // Test 403 - Forbidden (must be logged in but lack permission)
    Route::get('/403', function () {
        abort(403);
    })->middleware('auth')->name('test.403');
    
    // Test 404 - Not Found
    Route::get('/404', function () {
        abort(404);
    })->name('test.404');
    
    // Test 500 - Server Error
    Route::get('/500', function () {
        abort(500);
    })->name('test.500');
    
    // Test 503 - Service Unavailable
    Route::get('/503', function () {
        abort(503);
    })->name('test.503');
    
});
