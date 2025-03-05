@include('layout.header')

<!-- Order Details Section -->
<div class="order_details_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="order_title">Order Details</h2>
                <p>Thank you for your purchase! Your order details are listed below.</p>
            </div>
        </div>

        <!-- Order Overview -->
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h3>Billing Details</h3>
                <ul class="order_details_list">
                    <li><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</li>
                    <li><strong>Email:</strong> {{ $order->email }}</li>
                    <li><strong>Phone:</strong> {{ $order->phone }}</li>
                    <li><strong>Address:</strong> {{ $order->street_address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }}</li>
                    <li><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</li>
                    <li><strong>Order Status:</strong>
                        <span class="badge
                            @if($order->status == 'pending') badge-warning
                            @elseif($order->status == 'processing') badge-primary
                            @elseif($order->status == 'completed') badge-success
                            @else badge-secondary
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6 col-md-6">
                <h3>Shipping Details</h3>
                <ul class="order_details_list">
                    <li><strong>Address:</strong> {{ auth()->user()->street_address }}, {{ auth()->user()->city }}, {{ auth()->user()->state }}</li>
                    <li><strong>Country:</strong> {{ auth()->user()->country }}</li>
                    <li><strong>Payment Method:</strong>
                        @if($order->payment_method == 'paypal')
                            PayPal
                        @elseif($order->payment_method == 'cash_on_delivery')
                            Cash on Delivery
                        @else
                            Other
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mt-4 row">
            <div class="col-12">
                <h3>Your Order Summary</h3>
                <div class="order_table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach(json_decode($order->products, true) as $product)
                                @php
                                    $subtotal = $product['quantity'] * $product['price'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>₹{{ number_format($product['price'], 2) }}</td>
                                    <td>₹{{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Cart Subtotal</th>
                                <td>₹{{ number_format($total, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3">Shipping</th>
                                <td>₹0.00</td>
                            </tr>
                            <tr class="order_total">
                                <th colspan="3">Order Total</th>
                                <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back to Orders Button -->
        <div class="mt-4 row">
            <div class="text-center col-12">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to Orders</a>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
