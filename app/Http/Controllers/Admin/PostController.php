<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index(): View
    {
        $products  = Product::paginate(10);
        return view('admin.posts.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all(); // Fetch all categories
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'       => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama'        => 'required|min:5',
            'deskripsi'   => 'required|min:10',
            'harga'       => 'required|numeric',
            'kategori_id' => 'required|exists:categories,id',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create post
        Product::create([
            'image'       => $image->hashName(),
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'kategori_id' => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('adminDashboard')->with(['success' => 'Data Berhasil Disimpan!']);
    }

   
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);

        return view('admin.posts.show', compact('product'));
    }

    public function edit(string $id): View
    {
        //get post by ID
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Fetch all categories
        return view('admin.posts.edit', compact('product','categories'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama'      => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'kategori_id' => 'required|exists:categories,id', // Add this line to validate category ID
        ]);

        // Pastikan post yang akan diperbarui milik pengguna yang sedang login
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/'.$product->image);

            //update post with new image and category ID
            $product->update([
                'image'       => $image->hashName(),
                'nama'        => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'kategori_id' => $request->kategori_id, // Add this line to update category ID
            ]);

        } else {

            //update post without image and update category ID
            $product->update([
                'nama'        => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'kategori_id' => $request->kategori_id, // Add this line to update category ID
            ]);
        }

        //redirect to index
        return redirect()->route('adminDashboard')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        // Pastikan post yang akan dihapus milik pengguna yang sedang login
        $product = Product::findOrFail($id);

        //delete image
        Storage::delete('public/products/'. $product->image);

        //delete post
        $product->delete();

        //redirect to index
        return redirect()->route('adminDashboard')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function showAllTransactions(): View
    {
        $transactions = Transaction::all();

        return view('admin.posts.transaction', compact('transactions'));
    }

    public function manageStock($id): View
    {
        $product = Product::findOrFail($id);

        return view('admin.posts.manage_stock', compact('product'));
    }

    public function updateStock(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'stock' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('adminDashboard', $id)->with(['success' => 'Stock updated successfully']);
    }
}

