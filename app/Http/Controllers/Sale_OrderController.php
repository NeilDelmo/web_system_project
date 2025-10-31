<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Sale_OrderController extends Controller
{
    public function index() {
        $orders = Orders::with(['staff', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get all products, or filter by status if you have that column properly set
        $products = Products::orderBy('name', 'asc')->get();
        
        return view('sale_order', compact('orders', 'products'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'order_type' => 'required|in:walk-in,online,phone',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $product = Products::findOrFail($item['product_id']);
                
                // Check stock availability
                if ($product->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$product->name}. Available: {$product->stock_quantity}"
                    ], 422);
                }
                
                $totalAmount += $product->price * $item['quantity'];
            }

            // Create order
            $order = Orders::create([
                'order_type' => $validated['order_type'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $validated['notes'],
                'staff_id' => Auth::id(),
            ]);

            // Create order items and update product stock
            foreach ($validated['items'] as $item) {
                $product = Products::findOrFail($item['product_id']);
                
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                // Deduct from stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();

            $order->load(['staff', 'items.product']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Orders $order) {
        $order->load(['staff', 'items.product']);
        return response()->json($order);
    }

    public function update(Request $request, Orders $order) {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,canceled',
            'notes' => 'nullable|string',
        ]);

        try {
            // If canceling order, return stock
            if ($validated['status'] === 'canceled' && $order->status !== 'canceled') {
                foreach ($order->items as $item) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }

            $order->update($validated);
            $order->load(['staff', 'items.product']);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Orders $order) {
        try {
            // Return stock if order is not canceled
            if ($order->status !== 'canceled') {
                foreach ($order->items as $item) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }
}
