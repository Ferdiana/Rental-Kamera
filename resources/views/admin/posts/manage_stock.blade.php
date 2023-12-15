<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock</title>
</head>
<body>
    <h1>Manage Stock</h1>

    <form method="POST" action="{{ route('admin.posts.update_stock', $product->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Stock</button>
    </form>
</body>
</html>