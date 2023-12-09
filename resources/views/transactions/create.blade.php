<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <title>Transaction</title>

    <style>
        .form-group {
          padding-bottom: 1rem;
        }        
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        
            <div class="col-md-8">

                <h1>Transaction Form</h1>
                <p>Name: {{ $cartItems }}</p>
                
                <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
        
                    <!-- Add other fields for the transaction form -->
                    <div class="form-group" style="padding-bottom: 1rem">
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
            </div>
        
    </div>
    
</body>
</html>

