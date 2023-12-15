<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        .card-img-top {
          height: 300px;
          width: 300px;
          object-fit: cover;
        }        
    </style>
      
    <title> Cart </title>
  </head>
  <body>
    @if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    @endif
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-3 mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Rental Kamera</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/product">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">You Logged In As {{Auth::user()->email }}</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="col">
                    <div class="header" style="padding-left: 1rem">
                        <h4>Your Cart</h4>
                    </div>
                    <div class="body">
                        <div class="list-group" style="padding-left: 1rem">
                            @if($cartItems->isEmpty())
                                <p>Your cart is empty.</p>
                            @else
                                <div class="row">
                                    <div class="col">
                                    </div>
                                    <div class="col">
                                        Name
                                    </div>
                                    <div class="col">
                                        Quantity
                                    </div>  
                                    <div class="col">
                                        Price /day
                                    </div>
                                    <hr>
                                </div>
                                @php
                                    $totalPrice = 0; // Initialize the total price variable
                                @endphp
                                @foreach($cartItems as $cartItem)
                                        <div class="row">
                                            <div class="col">
                                                <img src="{{ Storage::url('public/products/'.$cartItem->product->image) }}" class="card-img-top" alt="img">
                                            </div>
                                            <div class="col">
                                                {{ $cartItem->product->nama }} 
                                            </div>
                                            <div class="col">
                                                <form action="{{ route('cart.update', ['item' => $cartItem]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="div">
                                                            <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" required>
                                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col">
                                                {{ $cartItem->product->harga }}
                                            </div>
                                            
                                            <div class="a" style="padding-bottom: 2rem; padding-top : 1rem;">
        
                                                

                                                <form action="{{ route('cart.remove', ['item' => $cartItem]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                </form>
                                            </div>
                                    
                                        </div>
                                        @php
                                            // Calculate and update the total price for each item
                                            $totalPrice += $cartItem->product->harga * $cartItem->quantity;
                                        @endphp
                                @endforeach
                                    
                                <div class="div" style="padding-bottom: 1rem">
                                    <p>Total : {{ $totalPrice }}</p>
                                    <a href="{{ route('transactions.create') }}" class="btn btn-success">Proceed to Transaction</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
</body>
</html>