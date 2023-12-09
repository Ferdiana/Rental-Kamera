<!DOCTYPE html>
  <html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Add this to the head of your HTML document -->
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

      <style>
        .card-img-top {
          height: 300px;
          object-fit: cover;
        }
        .list-group-item {
        border: none !important; /* Menghapus border */
        background-color: transparent !important;
        }
        .list-group-item.active {
        color: #0008ff !important; /* Mengubah warna teks saat aktif menjadi merah */
        }
        
        </style>

      <title>List Product</title>
  </head>
  <body>
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
            <div class="col-md-4">
                <div class="col">
                    <div class="header" style="padding-left: 1rem">
                        <h4>Categories</h4>
                    </div>
                    <div class="body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action category-link" data-category-id="all">
                                All Categories
                            </a>
                            @foreach ($categories as $category)
                                <a href="#" class="list-group-item list-group-item-action category-link" data-category-id="{{ $category->id }}">
                                    {{ $category->nama_kategori }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-fixed bottom-0 start-0 p-3" style="z-index: 1030; width: 20%;">
                <div class="card">
                    <div class="button-add">
                        <a href="/cart" class="btn btn-light">Cart</a>
                    </div>
                    <div class="button-add">
                        <a href="/transactions" class="btn btn-light">Transaction Detail</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row" id="product-container">
                    @foreach ($products as $product)
                        <div class="col-md-6 product" data-category="{{ $product->kategori_id }}">
                            <div class="card mb-4">
                                <img src="{{ Storage::url('public/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->nama }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->nama }}</h5>
                                    <p class="card-text">{!! $product->deskripsi !!}</p>

                                    <!-- Add to Cart Button -->
                                    <form action="{{ route('cart.add', $product->id) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                  
                    <div class="col-md-12" id="no-products-message" style="display: none;">
                      <p>No products available in this category.</p>
                    </div>
                  
                </div>
            </div>
        </div>
      </div>

    <script>
        // Add click event to category links
        document.querySelectorAll('.category-link').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                filterProducts(link.getAttribute('data-category-id'));
            });
        });

        // Function to filter products based on category
        function filterProducts(categoryId) {
            let products = document.querySelectorAll('.product');
            let noProductsMessage = document.getElementById('no-products-message');

            let hasProducts = false;

            products.forEach(function (product) {
                if (categoryId === 'all' || product.getAttribute('data-category') === categoryId) {
                    product.style.display = 'block';
                    hasProducts = true;
                } else {
                    product.style.display = 'none';
                }
            });

            if (hasProducts) {
                noProductsMessage.style.display = 'none';
            } else {
                noProductsMessage.style.display = 'block';
            }
        }
    </script>
  </body>
</html>
