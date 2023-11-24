<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>transaction</title>
</head>
<body>
    <h1>Transaction Form</h1>

    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Add other fields for the transaction form -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary">Complete Transaction</button>
    </form>
</body>
</html>

