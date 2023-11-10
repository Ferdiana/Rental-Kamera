<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
    $posts = Post::all();
    return view('index', compact('posts'));
    }

}
