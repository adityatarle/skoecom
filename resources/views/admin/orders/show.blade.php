@include('dashboard.layout.header')


<div class="container mt-4">
        <h1>Order #{{ $order->id }}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Order Details</h5>
                <p><strong>Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Address:</strong> {{ $order->street_address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }}</p>
                <p><strong>Total Price:</strong> {{ number_format($order->total_price, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p><strong>Razorpay Payment ID:</strong> {{ $order->razorpay_payment_id ?? 'N/A' }}</p>
                <p><strong>Razorpay Order ID:</strong> {{ $order->razorpay_order_id ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Placed At:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <ul>
                    @foreach (json_decode($order->products, true) as $product)
                        <li>{{ $product['name'] }} - {{ $product['quantity'] }} x {{ number_format($product['price'], 2) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Update Status</h5>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                </form>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>
    
@include('dashboard.layout.footer')