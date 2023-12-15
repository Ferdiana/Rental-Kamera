<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Transaction Details</title>
</head>

<body>
    <div class="container" style="margin-top: 1rem;">

        <h1>Transaction Details</h1>

        <div class="row">
            <div class="col-md-6">
                <p>Name: {{ $transaction->name }}</p>
                <p>Phone Number: {{ $transaction->phone_number }}</p>
                <p>Start Date: {{ $transaction->start_date }}</p>
                <p>End Date: {{ $transaction->end_date }}</p>

                <h2>Your Items</h2>
                    <ul>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach($transactionItems as $transactionItem)
                        <li>
                            Product Name: {{ $transactionItem->product->nama }}<br>
                            Quantity: {{ $transactionItem->quantity }}<br>
                    
                            @if ($transaction->start_date && $transaction->end_date)
                                Start Date: {{ $transactionItem->start_date }}<br>
                                End Date: {{ $transactionItem->end_date }}<br>
                                
                                @php
                                    $duration = strtotime($transaction->end_date) - strtotime($transaction->start_date);
                                    $days = ceil($duration / (60 * 60 * 24));
                                    $subtotal = $transactionItem->quantity * $transactionItem->price * $days;
                                    $totalPrice += $subtotal;
                                @endphp
                    
                                Price/Day: {{ $transactionItem->price }}<br>
                                Duration: {{ $days }} days<br>
                                Subtotal: {{ $subtotal }}<br>
                            @else
                                Duration: N/A<br>
                                Subtotal: N/A<br>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                <p>Total Price: {{ $totalPrice }}</p>
                <p>Invoice: {{ $transactionItem->transaction->invoice_number }}</p>
                <a href="{{ route('transactions.download', $transaction) }}" class="btn btn-primary">Download Details</a>
                <a href="{{ route('transactions.index') }}">Back to Transactions</a>
            </div>

            <div class="col-md-6">
                <img src="{{ asset('/storage/transaction_images/' . $transaction->image_path) }}"
                    alt="Transaction Image" class="img-fluid" style="max-width: 300px;">
            </div>
        </div>

        
    </div>
</body>

</html>