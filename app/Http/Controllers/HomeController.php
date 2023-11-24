<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // public function index()
    // {
    // $posts = Post::where('user_id', Auth::id())->latest()->get();
    // return view('home', compact('posts'));
    // }

    public function home()
    {
    $products = Product::latest()->get();
    return view('home', compact('products'));
    }

}
