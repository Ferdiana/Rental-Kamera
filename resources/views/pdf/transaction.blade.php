<div class="container" style="margin-top: 1rem;">

    <h1>Transaction Details</h1>

    <p>Name: {{ $details['name'] }}</p>
    <p>Phone Number: {{ $details['phone Number'] }}</p>
    <p>Start Date: {{ $details['start Date'] }}</p>
    <p>End Date: {{ $details['end Date'] }}</p>
    <img src="{{ public_path('storage/transaction_images/' . $details['image']) }}" alt="Transaction Image" style="max-width: 300px;">

    <!-- Additional content as needed -->


</div>
