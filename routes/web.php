<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\Sale_OrderController;
use App\Http\Controllers\ReportsController;
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
    Route::get('/ingredients/{ingredient}', [ProductManageController::class, 'showIngredient'])->name('ingredients.show');
    Route::put('/ingredients/{ingredient}', [ProductManageController::class, 'updateIngredient'])->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}', [ProductManageController::class, 'destroyIngredient'])->name('ingredients.destroy');
    Route::post('/pricing-rules/store', [ProductManageController::class, 'storePricingRule'])->name('pricing.store');
    Route::get('/pricing-rules/{pricingRule}', [ProductManageController::class, 'showPricingRule'])->name('pricing.show');
    Route::put('/pricing-rules/{pricingRule}', [ProductManageController::class, 'updatePricingRule'])->name('pricing.update');
    Route::delete('/pricing-rules/{pricingRule}', [ProductManageController::class, 'destroyPricingRule'])->name('pricing.destroy');
    Route::post('/recipes/store', [ProductManageController::class, 'storeRecipe'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [ProductManageController::class, 'showRecipe'])->name('recipes.show');
    Route::put('/recipes/{recipe}', [ProductManageController::class, 'updateRecipe'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [ProductManageController::class, 'destroyRecipe'])->name('recipes.destroy');

    // Inventory route - requires 'manage_inventory' permission
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->middleware('permission:manage_inventory')
        ->name('inventory');
    
    // Purchase Request routes - restricted to admin role only
    Route::post('/purchase-requests/store', [InventoryController::class, 'storePurchaseRequest'])
        ->middleware(['permission:manage_inventory', 'role:admin'])
        ->name('purchase-requests.store');
    Route::put('/purchase-requests/{purchaseRequest}', [InventoryController::class, 'updatePurchaseRequest'])
        ->middleware(['permission:manage_inventory', 'role:admin'])
        ->name('purchase-requests.update');
    Route::delete('/purchase-requests/{purchaseRequest}', [InventoryController::class, 'destroyPurchaseRequest'])
        ->middleware(['permission:manage_inventory', 'role:admin'])
        ->name('purchase-requests.destroy');

    // Supplier routes
    Route::post('/suppliers/store', [InventoryController::class, 'storeSupplier'])
        ->middleware('permission:manage_inventory')
        ->name('suppliers.store');
    Route::get('/suppliers/{supplier}', [InventoryController::class, 'showSupplier'])
        ->middleware('permission:manage_inventory')
        ->name('suppliers.show');
    Route::put('/suppliers/{supplier}', [InventoryController::class, 'updateSupplier'])
        ->middleware('permission:manage_inventory')
        ->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [InventoryController::class, 'destroySupplier'])
        ->middleware('permission:manage_inventory')
        ->name('suppliers.destroy');
    
    // Get suppliers for a specific ingredient
    Route::get('/ingredients/{ingredient}/suppliers', [InventoryController::class, 'getSuppliersForIngredient'])
        ->middleware('permission:manage_inventory')
        ->name('ingredients.suppliers');
    
    // Adjust stock manually
    Route::post('/ingredients/{ingredient}/adjust-stock', [InventoryController::class, 'adjustStock'])
        ->middleware('permission:manage_inventory')
        ->name('ingredients.adjustStock');

    // Sales and order routes - requires 'manage_orders' permission
    Route::get('/sale_and_orders', [Sale_OrderController::class, 'index'])
        ->middleware('permission:manage_orders')
        ->name('sale_and_orders');
    Route::get('/sales', [Sale_OrderController::class, 'index'])
        ->middleware('permission:manage_orders')
        ->name('sales'); // Alias route
    
    // Order CRUD routes
    Route::post('/orders', [Sale_OrderController::class, 'store'])
        ->middleware('permission:manage_orders')
        ->name('orders.store');
    Route::get('/orders/{order}', [Sale_OrderController::class, 'show'])
        ->middleware('permission:manage_orders')
        ->name('orders.show');
    Route::put('/orders/{order}', [Sale_OrderController::class, 'update'])
        ->middleware('permission:manage_orders')
        ->name('orders.update');
    Route::delete('/orders/{order}', [Sale_OrderController::class, 'destroy'])
        ->middleware('permission:manage_orders')
        ->name('orders.destroy');

    // Production routes - accessible by all authenticated users
    Route::get('/production', [ProductionController::class, 'index'])->name('production');
    Route::get('/production/recipe-requirements/{product}', [ProductionController::class, 'getRecipeRequirements'])->name('production.requirements');
    Route::post('/production/produce', [ProductionController::class, 'produce'])->name('production.produce');

    // Reports routes - requires 'view_reports' permission
    Route::get('/reports', [ReportsController::class, 'index'])
        ->middleware('permission:view_reports')
        ->name('reports');
    Route::get('/reports/sales-data', [ReportsController::class, 'getSalesData'])
        ->middleware('permission:view_reports')
        ->name('reports.salesData');
    
    // Export routes
    Route::get('/reports/export/sales/{format}', [ReportsController::class, 'exportSales'])
        ->middleware('permission:view_reports')
        ->name('reports.export.sales');
    Route::get('/reports/export/inventory/{format}', [ReportsController::class, 'exportInventory'])
        ->middleware('permission:view_reports')
        ->name('reports.export.inventory');
    Route::get('/reports/export/production/{format}', [ReportsController::class, 'exportProduction'])
        ->middleware('permission:view_reports')
        ->name('reports.export.production');
    
    // Settings routes - requires admin role
    Route::middleware('role:admin')->prefix('settings')->group(function () {
        Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        
        // User Management
        Route::get('/users', [\App\Http\Controllers\SettingsController::class, 'users'])->name('settings.users');
        Route::post('/users', [\App\Http\Controllers\SettingsController::class, 'storeUser'])->name('settings.users.store');
        Route::put('/users/{id}', [\App\Http\Controllers\SettingsController::class, 'updateUser'])->name('settings.users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyUser'])->name('settings.users.destroy');
        
        // System Settings
        Route::get('/system', [\App\Http\Controllers\SettingsController::class, 'systemSettings'])->name('settings.system');
        Route::post('/system/bakery-info', [\App\Http\Controllers\SettingsController::class, 'updateBakeryInfo'])->name('settings.bakery-info.update');
        Route::post('/system/notifications', [\App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
        Route::post('/system/email', [\App\Http\Controllers\SettingsController::class, 'updateEmailSettings'])->name('settings.email.update');

        // Audit Logs
        Route::get('/audit-logs', [\App\Http\Controllers\SettingsController::class, 'auditLogs'])->name('settings.audit-logs');
    });
    
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


//test email
Route::post('/system/test-email', [\App\Http\Controllers\SettingsController::class, 'testEmail'])->name('settings.test-email');