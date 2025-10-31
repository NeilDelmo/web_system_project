<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
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
        
        // Get purchase requests with ingredient, supplier and user relationships
        $purchaseRequests = PurchaseRequest::with(['ingredient', 'supplier', 'requestedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get all suppliers
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        
        return view('inventory', compact('ingredients', 'lowStockIngredients', 'purchaseRequests', 'suppliers'));
    }

    public function storePurchaseRequest(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'requested_quantity' => 'required|numeric|min:0.01',
            'date_needed' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $ingredient = Ingredients::findOrFail($validated['ingredient_id']);

        $purchaseRequest = PurchaseRequest::create([
            'ingredient_id' => $validated['ingredient_id'],
            'supplier_id' => $validated['supplier_id'],
            'requested_quantity' => $validated['requested_quantity'],
            'unit' => $ingredient->unit,
            'status' => 'requested',
            'notes' => $validated['notes'] ?? null,
            'requested_by' => Auth::id(),
            'date_needed' => $validated['date_needed'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase request created successfully',
            'data' => $purchaseRequest->load(['ingredient', 'supplier', 'requestedBy'])
        ]);
    }

    public function updatePurchaseRequest(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:requested,received,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $purchaseRequest->status;
        $newStatus = $validated['status'];

        // If status is changed to "received", update ingredient stock
        if ($oldStatus !== 'received' && $newStatus === 'received') {
            $ingredient = $purchaseRequest->ingredient;
            $newQuantity = $ingredient->quantity + $purchaseRequest->requested_quantity;
            
            $ingredient->quantity = $newQuantity;
            
            // Update status based on new quantity
            if ($newQuantity <= 0) {
                $ingredient->status = 'out_of_stock';
            } elseif ($newQuantity <= $ingredient->reorder_level) {
                $ingredient->status = 'low_stock';
            } else {
                $ingredient->status = 'in_stock';
            }
            
            $ingredient->save();
        }

        $purchaseRequest->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Purchase request updated successfully',
            'data' => $purchaseRequest->load(['ingredient', 'supplier', 'requestedBy'])
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

    // Supplier CRUD operations
    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'ingredient_ids' => 'nullable|array',
            'ingredient_ids.*' => 'exists:ingredients,id',
        ]);

        $supplier = Supplier::create($validated);

        // Attach ingredients if provided
        if (!empty($validated['ingredient_ids'])) {
            $supplier->ingredients()->attach($validated['ingredient_ids']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Supplier created successfully',
            'data' => $supplier->load('ingredients')
        ]);
    }

    public function showSupplier(Supplier $supplier)
    {
        return response()->json($supplier->load('ingredients'));
    }

    public function updateSupplier(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'ingredient_ids' => 'nullable|array',
            'ingredient_ids.*' => 'exists:ingredients,id',
        ]);

        $supplier->update($validated);

        // Sync ingredients
        if (isset($validated['ingredient_ids'])) {
            $supplier->ingredients()->sync($validated['ingredient_ids']);
        } else {
            $supplier->ingredients()->detach();
        }

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully',
            'data' => $supplier->load('ingredients')
        ]);
    }

    public function destroySupplier(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }

    public function getSuppliersForIngredient($ingredientId)
    {
        $ingredient = Ingredients::with('suppliers')->findOrFail($ingredientId);
        
        return response()->json([
            'success' => true,
            'data' => $ingredient->suppliers,
            'ingredient_unit' => $ingredient->unit
        ]);
    }
}
