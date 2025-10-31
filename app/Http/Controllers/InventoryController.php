<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name-asc');
        
        // Parse sort parameter
        [$column, $direction] = explode('-', $sort);
        
        // Validate column and direction
        $allowedColumns = ['name', 'category', 'quantity', 'status'];
        $allowedDirections = ['asc', 'desc'];
        
        if (!in_array($column, $allowedColumns)) {
            $column = 'name';
        }
        
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
        
        // Get sorted ingredients
        $ingredients = Ingredients::orderBy($column, $direction)->get();
        
        // Get low stock ingredients (quantity <= reorder_level)
        $lowStockIngredients = Ingredients::whereColumn('quantity', '<=', 'reorder_level')
            ->orderByRaw("CASE 
                WHEN status = 'out_of_stock' THEN 1 
                WHEN status = 'low_stock' THEN 2 
                ELSE 3 
            END")
            ->orderBy('quantity', 'asc')
            ->get();
        
        // Get purchase requests with ingredient and user relationships
        $purchaseRequests = PurchaseRequest::with(['ingredient', 'requestedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('inventory', compact('ingredients', 'lowStockIngredients', 'purchaseRequests'));
    }

    public function storePurchaseRequest(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'requested_quantity' => 'required|numeric|min:0.01',
            'date_needed' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $ingredient = Ingredients::findOrFail($validated['ingredient_id']);

        $purchaseRequest = PurchaseRequest::create([
            'ingredient_id' => $validated['ingredient_id'],
            'requested_quantity' => $validated['requested_quantity'],
            'unit' => $ingredient->unit,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'requested_by' => Auth::id(),
            'date_needed' => $validated['date_needed'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase request created successfully',
            'data' => $purchaseRequest->load(['ingredient', 'requestedBy'])
        ]);
    }

    public function updatePurchaseRequest(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,ordered,received,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $purchaseRequest->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Purchase request updated successfully',
            'data' => $purchaseRequest->load(['ingredient', 'requestedBy'])
        ]);
    }

    public function destroyPurchaseRequest(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase request deleted successfully'
        ]);
    }
}
