<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>All Transactions</h1>

        <ul>
            @foreach($transactions as $transaction)
                <li>
                    <a href="{{ route('transactions.show', $transaction) }}">
                        Transaction {{ $transaction->id }} - {{ $transaction->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>