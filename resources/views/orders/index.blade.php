@include('layout.header')

<style>
    .jewel-orders {
    padding: 50px 0;
    background-color: #f0ebe7;
}
.jewel-title {
    color: #333;
    letter-spacing: 2px;
    position: relative;
    margin-bottom: 40px;
}
.jewel-title::after {
    content: '';
    width: 50px;
    height: 2px;
    background: #b89f7e;
    position: absolute;
    bottom: -10px;
    left: 0;
}

/* Alert */
.jewel-alert {
    background: rgba(184, 159, 126, 0.1);
    border: 1px solid #b89f7e;
    color: #333;
    margin-bottom: 20px;
    border-radius: 5px;
}

/* Empty State */
.jewel-empty-text {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: #666;
    text-align: center;
    padding: 20px;
}

/* Table Wrapper */
.jewel-table-wrapper {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 20px;
}

/* Table */
.jewel-table {
    width: 100%;
    border-collapse: collapse;
}
.jewel-table th {
    font-family: 'Playfair Display', serif;
    color: #333;
    background: rgba(184, 159, 126, 0.1);
    border-bottom: 2px solid #b89f7e;
    padding: 15px;
    text-align: center;
}
.jewel-table td {
    padding: 15px;
    color: #666;
    text-align: center;
    vertical-align: middle;
    border: none; /* Remove default table borders */
}
.jewel-row {
    border-bottom: 1px solid #f0ebe7;
    transition: background 0.3s ease;
}
.jewel-row:hover {
    background: rgba(184, 159, 126, 0.05);
}

/* Badge */
.jewel-badge {
    background: #b89f7e;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-family: 'Lato', sans-serif;
    font-size: 0.9rem;
    text-transform: capitalize;
}

/* Button */
.jewel-btn {
    display: inline-block;
    padding: 8px 20px;
    background: #b89f7e;
    color: #fff;
    border-radius: 5px;
    text-transform: uppercase;
    font-size: 0.9rem;
    border: none;
    transition: all 0.3s ease;
}
.jewel-btn:hover {
    background: #9b8465;
    color: #fff;
    box-shadow: 0 2px 10px rgba(184, 159, 126, 0.3);
    text-decoration: none;
}
</style>


<!-- Orders Page Section -->
<div class="orders_section jewel-orders">
    <div class="container">
        <h2 class="jewel-title mb-4">My Orders</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show jewel-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($orders->isEmpty())
            <p class="jewel-empty-text">You have no orders yet.</p>
        @else
            <div class="table-responsive jewel-table-wrapper">
                <table class="table table-bordered jewel-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr class="jewel-row">
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>₹{{ number_format($order->total_price, 2) }}</td>
                            <td><span class="badge jewel-badge">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm jewel-btn">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@include('layout.footer')
