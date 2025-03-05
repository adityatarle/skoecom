
<div class="container">
    <h2>Your Order Details</h2>
    <p>Order ID: {{ $order->id }}</p>
    <p>Status: {{ $order->status }}</p>
    <h3>Products:</h3>
    <ul>
        @foreach(json_decode($order->products, true) as $product)
            <li>{{ $product['name'] }} - ${{ $product['price'] }}</li>
        @endforeach
    </ul>
    <p><strong>Total Price: ${{ $order->total_price }}</strong></p>
</div>

