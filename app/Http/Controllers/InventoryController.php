<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $ingredients = Ingredients::all();
        
        return view('inventory', compact('ingredients'));
    }
}
