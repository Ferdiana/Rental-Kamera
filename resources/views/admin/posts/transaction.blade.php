<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Transaction Details</h3>
                    <hr>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">GAMBAR</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">PHONE NUMBER</th>
                            <th scope="col">INVOICE</th>
                            <th scope="col">DATE</th>
                            <th scope="col">END DATE</th>
                            <th scope="col">PRODUCT</th>
                            <th scope="col">PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('/storage/transaction_images/' . $transaction->image_path) }}" class="rounded"
                                        style="width: 150px">
                                </td>
                                <td>{{ $transaction->name }}</td>
                                <td>{{ $transaction->phone_number }}</td>
                                <td>{{ $transaction->invoice_number }}</td>
                                <td>{{ $transaction->start_date }}</td>
                                <td>{{ $transaction->end_date }}</td>
                                <td>
                                    @foreach($transaction->transactionItems as $transactionItem)
                                        {{ $transactionItem->product->nama }}
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $totalHarga = 0;
                                    @endphp
                                
                                    @foreach($transaction->transactionItems as $transactionItem)
                                        @php
                                            $totalHarga += $transactionItem->quantity * $transactionItem->product->harga;
                                        @endphp
                                    @endforeach
                                
                                    {{ $totalHarga }}
                                </td>
                                
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Post belum Tersedia.
                            </div>
                        @endforelse
                    </tbody>
                </table>
         
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}', 'Success!');
        @elseif (session()->has('error'))
            toastr.error('{{ session('error') }}', 'Error!');
        @endif
    </script>

</body>

</html>
