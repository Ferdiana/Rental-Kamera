<!DOCTYPE html>
<html>
<head>
    <title>Admin Auth Laravel 8 </title>
</head>
<body>
  
<div class="container">
    Welcome, Admin
    <a href="{{ route('adminLogout') }}" class="btn btn-danger">Logout</a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-danger">Tambah Data</a>
</div>
</div>
   
</body>
</html>