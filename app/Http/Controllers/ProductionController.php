<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Recipe;
use App\Models\Ingredients;
use App\Models\ProductionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function index()
    {
        // Load products that have recipes
        $products = Products::whereHas('recipes')->with('recipes.ingredients')->get();
        $productionLogs = ProductionLog::with('product')->latest()->take(20)->get();
        
        return view('production', compact('products', 'productionLogs'));
    }

    // Get recipe details and calculate required ingredients
    public function getRecipeRequirements(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        
        $product = Products::with('recipes.ingredients')->findOrFail($productId);
        
        if (!$product->recipes || $product->recipes->isEmpty()) {
            return response()->json(['error' => 'No recipe found for this product'], 404);
        }

        // Get the first active recipe (you could enhance this to select specific recipes)
        $recipe = $product->recipes->where('status', 'active')->first();
        
        if (!$recipe) {
            return response()->json(['error' => 'No active recipe found'], 404);
        }

        $requirements = [];
        $canProduce = true;
        
        foreach ($recipe->ingredients as $ingredient) {
            $requiredQty = $ingredient->pivot->quantity * $quantity;
            $available = $ingredient->quantity;
            $sufficient = $available >= $requiredQty;
            
            if (!$sufficient) {
                $canProduce = false;
            }
            
            $requirements[] = [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'required' => $requiredQty,
                'available' => $available,
                'unit' => $ingredient->pivot->unit,
                'sufficient' => $sufficient,
            ];
        }

        return response()->json([
            'recipe' => $recipe->name,
            'requirements' => $requirements,
            'canProduce' => $canProduce,
        ]);
    }

    // Process production
    public function produce(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            $product = Products::with('recipes.ingredients')->findOrFail($validated['product_id']);
            
            // Get active recipe
            $recipe = $product->recipes->where('status', 'active')->first();
            
            if (!$recipe) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'No active recipe found for this product.'
                    ], 400);
                }
                return redirect()->route('production')->with('error', 'No active recipe found for this product.');
            }

            $ingredientsUsed = [];
            
            // Check and reduce ingredient stock
            foreach ($recipe->ingredients as $ingredient) {
                $requiredQty = $ingredient->pivot->quantity * $validated['quantity'];
                
                if ($ingredient->quantity < $requiredQty) {
                    DB::rollBack();
                    
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'error' => "Insufficient {$ingredient->name}. Required: {$requiredQty}, Available: {$ingredient->quantity}"
                        ], 400);
                    }
                    
                    return redirect()->route('production')->with('error', "Insufficient {$ingredient->name}. Required: {$requiredQty}, Available: {$ingredient->quantity}");
                }
                
                // Reduce ingredient stock
                $ingredient->quantity -= $requiredQty;
                
                // Update status based on new quantity
                if ($ingredient->quantity == 0) {
                    $ingredient->status = 'out_of_stock';
                } elseif ($ingredient->quantity <= $ingredient->reorder_level) {
                    $ingredient->status = 'low_stock';
                } else {
                    $ingredient->status = 'in_stock';
                }
                
                $ingredient->save();
                
                $ingredientsUsed[] = [
                    'ingredient_id' => $ingredient->id,
                    'ingredient_name' => $ingredient->name,
                    'quantity' => $requiredQty,
                    'unit' => $ingredient->pivot->unit,
                ];
            }

            // Increase product stock
            $product->stock_quantity += $validated['quantity'];
            $product->save();

            // Create production log
            ProductionLog::create([
                'product_id' => $product->id,
                'quantity_produced' => $validated['quantity'],
                'ingredients_used' => $ingredientsUsed,
                'status' => 'completed',
                'notes' => $validated['notes'],
                'produced_by' => Auth::id(),
                'produced_at' => now(),
            ]);

            DB::commit();

            // Check if request expects JSON (AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully produced {$validated['quantity']} {$product->name}. Product stock updated."
                ]);
            }

            return redirect()->route('production')->with('success', "Successfully produced {$validated['quantity']} {$product->name}. Product stock updated.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if request expects JSON (AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Production failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('production')->with('error', 'Production failed: ' . $e->getMessage());
        }
    }
}
