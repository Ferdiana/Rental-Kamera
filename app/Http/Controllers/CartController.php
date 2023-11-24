<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Get the current user's cart items
        $cartItems = Auth::user()->cartItems;

        return view('cart.index', compact('cartItems'));
    }

    public function add(Product $product, Request $request)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        Auth::user()->cartItems()->create([
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }
    

    public function update(CartItem $item, Request $request)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        // Update the quantity of the cart item
        $item->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        // Remove the cart item
        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
