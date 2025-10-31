<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Orders;
use App\Models\ProductionLog;
use App\Models\Ingredients;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalProducts = Products::count();
        $pendingOrders = Orders::where('status', 'pending')->count();
        $lowStockProducts = Products::where('stock_quantity', '<', 10)->count();
        $lowStockIngredients = Ingredients::whereIn('status', ['low_stock', 'out_of_stock'])->count();
        $totalLowStock = $lowStockProducts + $lowStockIngredients;
        
        // Today's sales
        $todaySales = Orders::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');
        $todayOrders = Orders::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->count();
        
        // Recent production (last 5)
        $recentProduction = ProductionLog::with(['product', 'producer'])
            ->orderBy('produced_at', 'desc')
            ->limit(5)
            ->get();
        
        // Low stock alerts
        $lowStockProductsList = Products::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->limit(5)
            ->get();
        
        $lowStockIngredientsList = Ingredients::whereIn('status', ['low_stock', 'out_of_stock'])
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get();
        
        // Sales chart data (last 7 days)
        $salesChartData = Orders::where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        return view('dashboard', compact(
            'totalProducts',
            'pendingOrders',
            'totalLowStock',
            'todaySales',
            'todayOrders',
            'recentProduction',
            'lowStockProductsList',
            'lowStockIngredientsList',
            'salesChartData'
        ));
    }
}
