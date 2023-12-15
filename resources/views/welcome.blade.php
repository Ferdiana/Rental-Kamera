<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Admin</title>

</head>
<body>
    <div class="d-flex">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Welcome, Admin</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="#" class="nav-link text-white active" onclick="loadContent('{{ route('admin.posts.transaction.show-all') }}', this)">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white" onclick="loadContent('{{ route('admin.posts.index') }}', this)">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                        Product
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white" onclick="loadContent('{{ route('admin.posts.create') }}', this)">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Add Product
                    </a>
                </li>
                <a href="{{ route('adminLogout') }}" class="btn btn-danger mb-3">Logout</a>      
            </ul>
        </div>
        
        <div class="flex-grow-1 d-flex flex-column p-3" id="dynamicContent">
            <script>
                window.onload = function () {
                    loadContent('{{ route('admin.posts.transaction.show-all') }}', document.querySelector('.nav-link.active'));
                };
            </script>
        </div>
    </div>

    <script>
        function loadContent(url, element) {
            axios.get(url)
                .then(function (response) {
                    document.getElementById('dynamicContent').innerHTML = response.data;

                    // Hapus kelas 'active' dari semua elemen nav-link
                    let navLinks = document.querySelectorAll('.nav-link');
                    navLinks.forEach(link => link.classList.remove('active'));

                    // Tambahkan kelas 'active' pada elemen yang diklik
                    element.classList.add('active');
                })
                .catch(function (error) {
                    console.error('Failed to load content:', error);
                });
        }
    </script>
</body>
</html>
