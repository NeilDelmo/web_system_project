<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Recipe;
use App\Models\Ingredients;
use App\Models\PricingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductManageController extends Controller
{
    public function index()
    {

        // Load products with categories
        $products = Products::with('category')->get();
// Load all categories and ingredients
        $categories = Categories::all();
        $ingredients = Ingredients::all();
// Load recipes with ingredients
        $recipes = Recipe::with('ingredients')->get();
        $pricingRules = PricingRule::with('product')->get();
// Return to view with data
        return view('productmanage', compact (
            'products',
            'categories',
            'ingredients',
            'recipes',
            'pricingRules'
        ));
    }


    // Store new product
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        //image upload
        if($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;

        }
        // Default status to 'active' if not provided

        $validated['status']= $validated['status'] ?? 'active';

        // Create product
        Products::create($validated);

        // Clear the product cache

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function storeCategory(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Create category
        Categories::create($validated);

        // Clear the category cache

        // Return to category index with success message
        return redirect()->route('products.index', ['tab' => 'categories'])->with('success', 'Category created successfully.');
    }

    public function storePricingRule(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'min_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);


    $validated['status'] = $validated['status'] ?? 'active';
        // Create pricing rule
        PricingRule::create($validated);


        // Return to pricing rule index with success message
        return redirect()->route('products.index', ['tab' => 'pricing'])->with('success', 'Pricing rule created successfully.');
    }

    public function storeIngredient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
        ]);

        // Automatically determine status based on quantity
        if ($validated['quantity'] == 0) {
            $validated['status'] = 'out_of_stock';
        } elseif ($validated['quantity'] <= $validated['reorder_level']) {
            $validated['status'] = 'low_stock';
        } else {
            $validated['status'] = 'in_stock';
        }

        // Create ingredient
        Ingredients::create($validated);

        return redirect()->route('inventory')->with('success', 'Ingredient added successfully.');
    }

    public function storeRecipe(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'instructions' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'ingredient' => 'required|array|min:1',
            'ingredient.*' => 'required|exists:ingredients,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:0',
            'unit' => 'required|array|min:1',
            'unit.*' => 'required|string|max:50',
        ]);

        // Create recipe
        $recipe = Recipe::create([
            'name' => $validated['name'],
            'product_id' => $validated['product_id'],
            'instructions' => $validated['instructions'],
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        // Attach ingredients with quantities and units
        foreach ($validated['ingredient'] as $index => $ingredientId) {
            $recipe->ingredients()->attach($ingredientId, [
                'quantity' => $validated['quantity'][$index],
                'unit' => $validated['unit'][$index],
            ]);
        }

        return redirect()->route('products.index', ['tab' => 'recipes'])->with('success', 'Recipe created successfully.');
    }

    public function show(Products $product){
        return response()->json($product->load('category'));
    }

    public function update(Request $request, Products $product){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if($request->hasFile('image')) {
            // Delete old image if exists
            if($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            // Keep existing image
            $validated['image'] = $product->image;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Products $product){
       If($product->image){
        Storage::disk('public')->delete($product->image);
       }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    //categories methods

    public function showCategory(Categories $category)
{
    $category->load('products');
    $category->products_count = $category->products->count();
    return response()->json($category);
}

// Update category
public function updateCategory(Request $request, Categories $category)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:active,inactive',
    ]);

    $category->update($validated);

    return redirect()->route('products.index', ['tab' => 'categories'])->with('success', 'Category updated successfully.');
}

// Delete category
public function destroyCategory(Categories $category)
{
    // Check if category has products
    if ($category->products()->count() > 0) {
        return redirect()->route('products.index', ['tab' => 'categories'])->with('error', 'Cannot delete category that has products. Please reassign or delete the products first.');
    }

    $category->delete();

    return redirect()->route('products.index', ['tab' => 'categories'])->with('success', 'Category deleted successfully.');
}

// Show recipe (for view modal)
public function showRecipe(Recipe $recipe)
{
    $recipe->load(['product', 'ingredients']);
    return response()->json($recipe);
}

// Update recipe
public function updateRecipe(Request $request, Recipe $recipe)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
        'instructions' => 'required|string',
        'notes' => 'nullable|string',
        'status' => 'required|in:active,inactive',
        'ingredient' => 'required|array|min:1',
        'ingredient.*' => 'required|exists:ingredients,id',
        'quantity' => 'required|array|min:1',
        'quantity.*' => 'required|numeric|min:0',
        'unit' => 'required|array|min:1',
        'unit.*' => 'required|string|max:50',
    ]);

    // Update recipe basic info
    $recipe->update([
        'name' => $validated['name'],
        'product_id' => $validated['product_id'],
        'instructions' => $validated['instructions'],
        'notes' => $validated['notes'] ?? null,
        'status' => $validated['status'],
    ]);

    // Detach all existing ingredients
    $recipe->ingredients()->detach();

    // Attach updated ingredients with quantities and units
    foreach ($validated['ingredient'] as $index => $ingredientId) {
        $recipe->ingredients()->attach($ingredientId, [
            'quantity' => $validated['quantity'][$index],
            'unit' => $validated['unit'][$index],
        ]);
    }

    return redirect()->route('products.index', ['tab' => 'recipes'])->with('success', 'Recipe updated successfully.');
}

// Delete recipe
public function destroyRecipe(Recipe $recipe)
{
    // Delete the recipe (ingredients will be detached automatically due to cascade)
    $recipe->delete();

    return redirect()->route('products.index', ['tab' => 'recipes'])->with('success', 'Recipe deleted successfully.');
}

// Show pricing rule (for view modal)
public function showPricingRule(PricingRule $pricingRule)
{
    $pricingRule->load('product');
    return response()->json($pricingRule);
}

// Update pricing rule
public function updatePricingRule(Request $request, PricingRule $pricingRule)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'min_quantity' => 'required|integer|min:1',
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
        'status' => 'required|in:active,inactive',
    ]);

    $pricingRule->update($validated);

    return redirect()->route('products.index', ['tab' => 'pricing'])->with('success', 'Pricing rule updated successfully.');
}

// Delete pricing rule
public function destroyPricingRule(PricingRule $pricingRule)
{
    $pricingRule->delete();

    return redirect()->route('products.index', ['tab' => 'pricing'])->with('success', 'Pricing rule deleted successfully.');
}

// Show ingredient (for view modal)
public function showIngredient(Ingredients $ingredient)
{
    return response()->json($ingredient);
}

// Update ingredient
public function updateIngredient(Request $request, Ingredients $ingredient)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'unit' => 'required|string|max:50',
        'quantity' => 'required|numeric|min:0',
        'reorder_level' => 'required|numeric|min:0',
    ]);

    // Update ingredient
    $ingredient->update($validated);

    // Update status based on quantity
    if ($ingredient->quantity == 0) {
        $ingredient->status = 'out_of_stock';
    } elseif ($ingredient->quantity <= $ingredient->reorder_level) {
        $ingredient->status = 'low_stock';
    } else {
        $ingredient->status = 'in_stock';
    }
    $ingredient->save();

    return redirect()->route('inventory')->with('success', 'Ingredient updated successfully.');
}

// Delete ingredient
public function destroyIngredient(Ingredients $ingredient)
{
    // Check if ingredient is used in any recipes
    if ($ingredient->recipes()->count() > 0) {
        return redirect()->route('inventory')->with('error', 'Cannot delete ingredient that is used in recipes. Please remove it from recipes first.');
    }

    $ingredient->delete();

    return redirect()->route('inventory')->with('success', 'Ingredient deleted successfully.');
}
}
