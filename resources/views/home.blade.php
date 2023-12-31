<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
      
    <title>Home</title>
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
              <a class="nav-link active" aria-current="page" href="#">Home</a>
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
      <div class="row d-flex justify-content-around">
    
        <div class="col-md-6">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              @foreach ($products as $product)
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $loop->index + 1 }}"></button>
              @endforeach
            </div>
            <div class="carousel-inner">
              @foreach ($products as $product)
              <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ Storage::url('public/products/'.$product->image) }}" class="d-block w-100" alt="{{ $product->name }}" style="height: 500px; object-fit: cover;">
              </div>
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        <div class="col-md-4 d-flex flex-column justify-content-center">
          <div class="h1 mb-4">Camera</div>
          <div class="p mb-4">Cameras that you can rent to capture your precious moments. The camera brings the beauty of photography to your fingertips with advanced technology and incredible performance.</div>
          <div class="div">
            <button class="btn-primary p-2" onclick="redirectToProduct()">Book Now</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      function redirectToProduct() {
          window.location.href = "/product";
      }
    </script>
  </body>
</html>