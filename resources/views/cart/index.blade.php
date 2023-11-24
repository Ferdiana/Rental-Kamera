<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
      
    <title> Cart </title>
  </head>
  <body>

    <h1>Your Cart</h1>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <ul>
            @foreach($cartItems as $cartItem)
                <li>
                    {{ $cartItem->product->nama }} - Quantity: {{ $cartItem->quantity }}
                    <!-- Add more details or actions as needed -->

                    <form action="{{ route('cart.remove', ['item' => $cartItem]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>

                    <!-- Edit Quantity Form -->
                    <form action="{{ route('cart.update', ['item' => $cartItem]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <label for="quantity">Edit Quantity:</label>
                        <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" required>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
    

    <a href="{{ route('transactions.create') }}" class="btn btn-success">Proceed to Transaction</a>
    <!-- Add any additional content or functionality as needed -->

</body>
</html>