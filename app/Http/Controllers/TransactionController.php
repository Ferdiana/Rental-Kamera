<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function create()
    {
        $cartItems = Auth::user()->cartItems;

        return view('transactions.create', compact('cartItems'));
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function index()
    {
        $transactions = Transaction::all();

        return view('transactions.index', compact('transactions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            // Add validation rules for other fields in the transaction form
            'name' => 'required',
            'phone_number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user = Auth::user();

        // Store the image
        $imagePath = $request->file('image')->store('public/transaction_images');

        // Create the transaction
        $transaction = Transaction::create([
            
            'name' => $request->name, 
            'phone_number' => $request->phone_number,
            'user_id' => $user->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image_path' => $imagePath,
        ]);

        // Associate cart items with the transaction
        $user->cartItems->each(function ($cartItem) use ($transaction) {
            $cartItem->update(['transaction_id' => $transaction->id]);
        });

        // Clear user's cart
        $user->cartItems()->delete();

        return redirect()->route('cart.index')->with('success', 'Transaction completed successfully.');
    }

    // You can customize the invoice number generation logic based on your requirements
    private function generateInvoiceNumber()
    {
        return 'INV-' . now()->format('YmdHis') . rand(1000, 9999);
    }

    public function download(Transaction $transaction)
{
    // Get transaction details
    $details = [
        'name' => $transaction->name,
        'phone Number' => $transaction->phone_number,
        'start Date' => $transaction->start_date,
        'end Date' => $transaction->end_date,
        'image' => $transaction->image_path
        // Add more details based on your transaction model
    ];

    // Create a CSV file
    $csv = Writer::createFromString('');
    $csv->insertOne(array_keys($details));
    $csv->insertOne(array_values($details));

    // Save the CSV file to storage
    $filePath = 'public/transaction_details/' . $transaction->id . '_details.csv';
    Storage::put($filePath, $csv->getContent());

    // Provide the download link
    return Response::download(storage_path('app/' . $filePath));
}
}

