<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\ProductionLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\InventoryReportExport;
use App\Exports\ProductionReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function index(Request $request) {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Get sales data filtered by date range
        $totalRevenue = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->sum('total_amount');
        $totalOrders = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->count();
        
        // Today's data (always shows today regardless of filter)
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
        
        // Top selling products (filtered by date range)
        $topProducts = OrderItems::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as revenue'))
            ->whereHas('order', function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->with('product')
            ->get();
        
        // Sales by order type (filtered by date range)
        $salesByType = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select('order_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('order_type')
            ->get();
        
        // Inventory data
        $ingredients = \App\Models\Ingredients::orderBy('name', 'asc')->get();
        $products = \App\Models\Products::orderBy('name', 'asc')->get();
        
        // Low stock items
        $lowStockIngredients = \App\Models\Ingredients::where('status', 'low_stock')
            ->orWhere('status', 'out_of_stock')
            ->orderBy('quantity', 'asc')
            ->get();
        
        $lowStockProducts = \App\Models\Products::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->get();
        
        // Production data
        $totalProduction = ProductionLog::where('status', 'completed')
            ->whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
            ->sum('quantity_produced');
        
        $totalBatches = ProductionLog::whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
            ->count();
        
        $successRate = $totalBatches > 0 
            ? round((ProductionLog::where('status', 'completed')
                ->whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
                ->count() / $totalBatches) * 100, 2)
            : 0;
        
        $todayProduction = ProductionLog::where('status', 'completed')
            ->whereDate('produced_at', Carbon::today())
            ->sum('quantity_produced');
        
        // Production by product (filtered by date range)
        $productionByProduct = ProductionLog::where('status', 'completed')
            ->whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
            ->select('product_id', DB::raw('SUM(quantity_produced) as total_produced'), DB::raw('COUNT(*) as batches'))
            ->groupBy('product_id')
            ->orderBy('total_produced', 'desc')
            ->with('product')
            ->get();
        
        // Recent production logs (last 10)
        $recentProduction = ProductionLog::whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
            ->with(['product', 'producer'])
            ->orderBy('produced_at', 'desc')
            ->limit(10)
            ->get();
        
        // Production by status
        $productionByStatus = ProductionLog::whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        
        return view('reports', compact(
            'totalRevenue',
            'totalOrders',
            'todaySales',
            'todayOrders',
            'salesByDate',
            'topProducts',
            'salesByType',
            'startDate',
            'endDate',
            'ingredients',
            'products',
            'lowStockIngredients',
            'lowStockProducts',
            'totalProduction',
            'totalBatches',
            'successRate',
            'todayProduction',
            'productionByProduct',
            'recentProduction',
            'productionByStatus'
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

    // Export Sales Report
    public function exportSales(Request $request, $format = 'excel')
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $fileName = 'sales-report-' . $startDate . '-to-' . $endDate;

        if ($format === 'pdf') {
            $data = $this->getSalesReportData($startDate, $endDate);
            $pdf = Pdf::loadView('exports.sales-report-pdf', $data);
            return $pdf->download($fileName . '.pdf');
        }

        return Excel::download(new SalesReportExport($startDate, $endDate), $fileName . '.xlsx');
    }

    // Export Inventory Report
    public function exportInventory($format = 'excel')
    {
        $fileName = 'inventory-report-' . Carbon::now()->format('Y-m-d');

        if ($format === 'pdf') {
            $data = [
                'products' => Products::orderBy('name', 'asc')->get(),
                'ingredients' => \App\Models\Ingredients::orderBy('name', 'asc')->get(),
                'date' => Carbon::now()->format('F d, Y'),
            ];
            $pdf = Pdf::loadView('exports.inventory-report-pdf', $data);
            return $pdf->download($fileName . '.pdf');
        }

        return Excel::download(new InventoryReportExport(), $fileName . '.xlsx');
    }

    // Export Production Report
    public function exportProduction(Request $request, $format = 'excel')
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $fileName = 'production-report-' . $startDate . '-to-' . $endDate;

        if ($format === 'pdf') {
            $data = $this->getProductionReportData($startDate, $endDate);
            $pdf = Pdf::loadView('exports.production-report-pdf', $data);
            return $pdf->download($fileName . '.pdf');
        }

        return Excel::download(new ProductionReportExport($startDate, $endDate), $fileName . '.xlsx');
    }

    // Helper method to get sales data for PDF
    private function getSalesReportData($startDate, $endDate)
    {
        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => Orders::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                ->sum('total_amount'),
            'totalOrders' => Orders::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                ->count(),
            'orders' => Orders::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                ->with('items.product')
                ->orderBy('created_at', 'desc')
                ->get(),
            'topProducts' => OrderItems::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as revenue'))
                ->whereHas('order', function($query) use ($startDate, $endDate) {
                    $query->where('status', 'completed')
                        ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                })
                ->groupBy('product_id')
                ->orderBy('total_sold', 'desc')
                ->limit(10)
                ->with('product')
                ->get(),
            'date' => Carbon::now()->format('F d, Y'),
        ];
    }

    // Helper method to get production data for PDF
    private function getProductionReportData($startDate, $endDate)
    {
        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalProduction' => ProductionLog::where('status', 'completed')
                ->whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
                ->sum('quantity_produced'),
            'totalBatches' => ProductionLog::whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
                ->count(),
            'productionLogs' => ProductionLog::whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
                ->with(['product', 'producer'])
                ->orderBy('produced_at', 'desc')
                ->get(),
            'productionByProduct' => ProductionLog::where('status', 'completed')
                ->whereBetween('produced_at', [$startDate, $endDate . ' 23:59:59'])
                ->select('product_id', DB::raw('SUM(quantity_produced) as total_produced'), DB::raw('COUNT(*) as batches'))
                ->groupBy('product_id')
                ->orderBy('total_produced', 'desc')
                ->with('product')
                ->get(),
            'date' => Carbon::now()->format('F d, Y'),
        ];
    }
}
