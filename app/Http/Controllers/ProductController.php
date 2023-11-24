<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product()
    {
    $products = Product::latest()->get();
    return view('product', compact('products'));
    }
}
