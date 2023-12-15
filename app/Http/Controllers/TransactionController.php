<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TransactionController extends Controller
{
    public function create()
    {
        $cartItems = Auth::user()->cartItems;

        return view('transactions.create', compact('cartItems'));
    }

    public function show(Transaction $transaction)
    {
        // Retrieve cartItems associated with the transaction
        $transactionItems = $transaction->transactionItems;

    // Access product details for each transaction item
        foreach ($transactionItems as $transactionItem) {
        $productName = $transactionItem->product->nama;
        // Add more details as neededx     
        }   

        return view('transactions.show', compact('transaction', 'transactionItems'));
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
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); // Get the original image name
        $imagePath = $image->storeAs('public/transaction_images', $imageName); // Store with the original name


        // Create the transaction
        $transaction = Transaction::create([
            
            'name' => $request->name, 
            'phone_number' => $request->phone_number,
            'user_id' => $user->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image_path' => $imageName,

        ]);
        
        $cartItems = $user->cartItems;

        foreach ($cartItems as $cartItem) {
            $transactionItem = TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->harga, // Adjust this based on your actual product pricing
            ]);
        }

        $user->cartItems->each(function ($cartItem) use ($transaction) {
            $cartItem->update(['transaction_id' => $transaction->id]);
        });

        // Clear user's cart
        $user->cartItems()->delete();

        return redirect()->route('cart.index')->with('success', 'Transaction completed successfully.');
    }

    private function generateInvoiceNumber()
    {
        return 'INV-' . now()->format('YmdHis') . rand(1000, 9999);
    }

    public function download(Transaction $transaction)
    {
        // Prepare data for PDF
        $details = [
            'name' => $transaction->name,
            'phone Number' => $transaction->phone_number,
            'start Date' => $transaction->start_date,
            'end Date' => $transaction->end_date,
            'image' => $transaction->image_path,
        ];

        // Create a PDF instance
        $pdf = PDF::loadView('pdf.transaction', compact('details'));

        // Save the PDF file to storage
        $filePath = 'public/transaction_details/' . $transaction->id . '_details.pdf';
        Storage::put($filePath, $pdf->output());

        // Provide the download link
        return Response::download(storage_path('app/' . $filePath));
    }
}

