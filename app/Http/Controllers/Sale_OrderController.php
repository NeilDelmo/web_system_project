<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Sale_OrderController extends Controller
{
    public function index() {
        return view('sale_order');
    }
}
