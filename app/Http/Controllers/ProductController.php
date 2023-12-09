<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product()
    {
        $products = Product::latest()->get();
        $categories = Category::all();

        return view('product', compact('products', 'categories'));
    }

    public function showByCategory($category = null)
    {
        if ($category == 'all') {
            $products = Product::latest()->get();
        } else {
            $products = Product::whereHas('categories', function ($query) use ($category) {
                $query->where('id', $category);
            })->latest()->get();
        }

        if (request()->ajax()) {
            $view = View::make('partials.product_cards', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        $categories = Category::all();

        return view('product', compact('products', 'categories'));
    }

}
