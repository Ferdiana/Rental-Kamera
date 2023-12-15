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

        // Check if the requested quantity is available in stock
        if ($product->stock < $request->quantity) {
            return redirect()->route('product')->with('error', 'Stock Habis');
        }

        // Check if the product is already in the user's cart
        $existingCartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $newQuantity = $existingCartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return redirect()->route('product')->with('error', 'Stock habis.');
            }

            $existingCartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // If the product is not in the cart, create a new cart item
            Auth::user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        // Decrement the stock
        $product->decrement('stock', $request->quantity);

        return redirect()->route('product')->with('success', 'Product added to cart.');
    }
    

    public function update(CartItem $item, Request $request)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        // Retrieve the product associated with the cart item
        $product = $item->product;

        // Calculate the difference between the current quantity and the updated quantity
        $quantityDifference = $request->quantity - $item->quantity;

        // Check if the updated quantity is valid based on the available stock
        if ($product->stock < $quantityDifference) {
            return redirect()->route('cart.index')->with('error', 'Insufficient stock for the requested quantity.');
        }

        // Update the quantity of the cart item
        $item->update([
            'quantity' => $request->quantity,
        ]);

        // Update the stock accordingly (increment or decrement based on the quantity difference)
        $product->decrement('stock', $quantityDifference);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        // Retrieve the product associated with the cart item
        $product = $item->product;

        // Remove the cart item
        $item->delete();

        // Increment the stock
        $product->increment('stock', $item->quantity);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
