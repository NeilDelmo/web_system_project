<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request) {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Get sales data
        $totalRevenue = Orders::where('status', 'completed')->sum('total_amount');
        $totalOrders = Orders::where('status', 'completed')->count();
        $todaySales = Orders::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');
        $todayOrders = Orders::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->count();
        
        // Get sales by date (filtered by date range)
        $salesByDate = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Top selling products
        $topProducts = OrderItems::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as revenue'))
            ->whereHas('order', function($query) {
                $query->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->with('product')
            ->get();
        
        // Sales by order type
        $salesByType = Orders::where('status', 'completed')
            ->select('order_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('order_type')
            ->get();
        
        return view('reports', compact(
            'totalRevenue',
            'totalOrders',
            'todaySales',
            'todayOrders',
            'salesByDate',
            'topProducts',
            'salesByType'
        ));
    }

    public function getSalesData(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30));
        $endDate = $request->input('end_date', Carbon::now());

        $salesData = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($salesData);
    }
}
