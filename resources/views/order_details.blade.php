@include('layout.header')

<style>
    .order-details {
        padding: 2rem 0;
        background-color: #f8f9fa;
    }
    
    .order-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .order-header {
        border-bottom: 2px solid #b89f7e;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .order-title {
        color: #333;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .order-meta {
        color: #666;
        font-size: 0.9rem;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-paid {
        background: #d4edda;
        color: #155724;
    }
    
    .status-processing {
        background: #cce5ff;
        color: #004085;
    }
    
    .status-shipped {
        background: #e2e3e5;
        color: #383d41;
    }
    
    .status-completed {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .order-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #b89f7e;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 1rem;
        background: #fafafa;
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }
    
    .product-details {
        flex: 1;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .product-price {
        color: #b89f7e;
        font-weight: 600;
    }
    
    .order-summary {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #b89f7e;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        color: #666;
    }
    
    .summary-total {
        border-top: 2px solid #b89f7e;
        padding-top: 1rem;
        margin-top: 1rem;
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }
    
    .address-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .address-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .breadcrumbs_area {
        background: linear-gradient(135deg, #b89f7e 0%, #f0ebe7 100%);
        padding: 20px 0;
    }
    
    .jewel-title {
        font-size: 2rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .back-button {
        background: #b89f7e;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 2rem;
        transition: background 0.3s ease;
    }
    
    .back-button:hover {
        background: #9b8465;
        color: white;
        text-decoration: none;
    }
</style>

<!-- Breadcrumbs Area -->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3 class="jewel-title">Order Details</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>></li>
                        <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li>></li>
                        <li>Order #{{ $order->id }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details -->
<div class="order-details">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <a href="{{ route('orders.index') }}" class="back-button">
            <i class="fa fa-arrow-left"></i> Back to My Orders
        </a>

        <div class="order-card">
            <div class="order-header">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="order-title">Order #{{ $order->id }}</h1>
                        <div class="order-meta">
                            <p class="mb-1">Order Date: <strong>{{ $order->created_at->format('F j, Y g:i A') }}</strong></p>
                            <p class="mb-1">Payment Method: <strong>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</strong></p>
                            @if($order->razorpay_payment_id)
                                <p class="mb-0">Payment ID: <strong>{{ $order->razorpay_payment_id }}</strong></p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div class="order-section">
                        <h3 class="section-title">Order Items</h3>
                        @if(is_array($order->products))
                            @foreach($order->products as $id => $product)
                                <div class="product-item">
                                    @if(isset($product['image']))
                                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image">
                                    @else
                                        <div style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: #999;">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="product-details">
                                        <div class="product-name">{{ $product['name'] ?? 'Unknown Product' }}</div>
                                        <div>Quantity: <strong>{{ $product['quantity'] ?? 0 }}</strong></div>
                                        <div class="product-price">₹{{ number_format(($product['price'] ?? 0), 2) }} each</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="product-price">
                                            <strong>₹{{ number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No items found in this order.</p>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="order-section">
                        <h3 class="section-title">Order Summary</h3>
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span>₹{{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total:</span>
                                <span>₹{{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="order-section">
                        <h3 class="section-title">Shipping Address</h3>
                        <div class="address-section">
                            <div class="address-title">{{ $order->first_name }} {{ $order->last_name }}</div>
                            <p class="mb-1">{{ $order->street_address }}</p>
                            <p class="mb-1">{{ $order->city }}, {{ $order->state }}</p>
                            <p class="mb-1">{{ $order->country }}</p>
                            <p class="mb-1">Phone: {{ $order->phone }}</p>
                            <p class="mb-0">Email: {{ $order->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')