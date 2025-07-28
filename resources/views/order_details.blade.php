<!-- Include Header -->
@include('layout.header')

<!-- Order Details Section -->
<section class="order-details-section py-5" style="background: linear-gradient(135deg, #f9f6f2 0%, #e8e4df 100%);">
    <div class="container">
        <!-- Title -->
        <div class="row text-center mb-4">
            <div class="col-12">
                <h2 class="order-title" style="color: #2b2b2b; font-size: 2.5rem; letter-spacing: 1px;">
                    Order Details
                </h2>
                <p class="fst-italic">
                    Thank you for your purchase! Below are the details of your exquisite order.
                </p>
            </div>
        </div>

        <!-- Order Overview -->
        <div class="row g-4">
            <!-- Billing Details -->
            <div class="col-lg-6 col-md-6">
                <div class="card shadow-sm" style="border: none; border-radius: 15px; background: #fff; padding: 20px;">
                    <h3 class="mb-3" style="color: #2b2b2b; font-size: 1.5rem;">
                        Billing Details
                    </h3>
                    <ul class="list-unstyled order-details-list" style="color: #555;">
                        <li><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</li>
                        <li><strong>Email:</strong> {{ $order->email }}</li>
                        <li><strong>Phone:</strong> {{ $order->phone }}</li>
                        <li><strong>Address:</strong> {{ $order->street_address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }}</li>
                        <li><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</li>
                        <li><strong>Order Status:</strong>
                            <span class="badge px-2 py-1" style="border-radius: 10px;
                                @if($order->status == 'pending') background: #f7c948; color: #fff;
                                @elseif($order->status == 'processing') background: #5a9bd4; color: #fff;
                                @elseif($order->status == 'completed') background: #6bb288; color: #fff;
                                @else background: #d3d3d3; color: #555;
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="col-lg-6 col-md-6">
                <div class="card shadow-sm" style="border: none; border-radius: 15px; background: #fff; padding: 20px;">
                    <h3 class="mb-3" style="color: #2b2b2b; font-size: 1.5rem;">
                        Shipping Details
                    </h3>
                    <ul class="list-unstyled order-details-list" style="color: #555;">
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
        </div>

        <!-- Order Summary -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4" style="color: #2b2b2b; font-size: 1.75rem;">
                    Your Order Summary
                </h3>
                <div class="table-responsive shadow-sm" style="background: #fff; border-radius: 15px; overflow: auto;">
                    <table class="table mb-0" style="font-family: 'Lora', serif;">
                        <thead style="background: #f5f1ed; color: #2b2b2b;">
                            <tr>
                                <th scope="col" style="padding: 15px;">Product</th>
                                <th scope="col" style="padding: 15px;">Quantity</th>
                                <th scope="col" style="padding: 15px;">Unit Price</th>
                                <th scope="col" style="padding: 15px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody style="color: #555;">
                            @php $total = 0; @endphp
                            @foreach($order->products as $product)
                                @php
                                    $subtotal = $product['quantity'] * $product['price'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td style="padding: 15px;">{{ $product['name'] }}</td>
                                    <td style="padding: 15px;">{{ $product['quantity'] }}</td>
                                    <td style="padding: 15px;">₹{{ number_format($product['price'], 2) }}</td>
                                    <td style="padding: 15px;">₹{{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #f9f6f2; color: #2b2b2b;">
                            <tr>
                                <th scope="row" colspan="3" style="padding: 15px;">Cart Subtotal</th>
                                <td style="padding: 15px;">₹{{ number_format($total, 2) }}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="3" style="padding: 15px;">Shipping</th>
                                <td style="padding: 15px;">₹0.00</td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <th scope="row" colspan="3" style="padding: 15px;">Order Total</th>
                                <td style="padding: 15px;">₹{{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back to Orders Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('orders.index') }}" class="btn" style="background: #b89f7e; color: #fff; padding: 10px 30px; border-radius: 25px; transition: all 0.3s ease;">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Include Footer -->
@include('layout.footer')

<!-- Bootstrap 5 CSS (Add to layout.header if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">