@include('layout.header')

<style>
    /* Breadcrumbs */
    .elegant-breadcrumbs {
        background: linear-gradient(135deg, #b89f7e 0%, #f0ebe7 100%);
        /* padding: 20px 0;
        border-bottom: 1px solid rgba(184, 159, 126, 0.2); */
    }

    .jewel-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .breadcrumb_content ul li {
        font-size: 0.9rem;
        color: #666;
    }

    /* .breadcrumb_content ul li a {
        color: #b89f7e;
        text-decoration: none;
    } */

    .breadcrumb_content ul li a:hover {
        text-decoration: underline;
    }

    /* Account Section */
    .account-section {
        padding: 50px 0;
    }

    .jewel-dashboard {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
    }

    /* Tabs */
    .jewel-tabs .nav-link {
        font-family: 'Playfair Display', serif;
        color: #666;
        padding: 15px 20px;
        border-bottom: 1px solid #f0ebe7;
        transition: all 0.3s ease;
    }

    .jewel-tabs .nav-link:hover,
    .jewel-tabs .nav-link.active {
        color: #b89f7e;
        background: rgba(184, 159, 126, 0.1);
        border-left: 3px solid #b89f7e;
    }

    /* Content */
    .jewel-content {
        padding: 20px;
    }

    .jewel-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        position: relative;
    }

    .jewel-heading::after {
        content: '';
        width: 50px;
        height: 2px;
        background: #b89f7e;
        position: absolute;
        bottom: -10px;
        left: 0;
    }

    .jewel-content p,
    .jewel-content a {
        font-size: 1rem;
        color: #666;
    }

    .jewel-content a {
        color: #b89f7e;
        text-decoration: none;
    }

    .jewel-content a:hover {
        text-decoration: underline;
    }

    /* Tables */
    .jewel-table table {
        border: none;
    }

    .jewel-table th {
        font-family: 'Playfair Display', serif;
        color: #333;
        background: rgba(184, 159, 126, 0.1);
        border-bottom: 2px solid #b89f7e;
    }

    .jewel-table td {
        color: #666;
        vertical-align: middle;
    }

    .jewel-table .success {
        color: #28a745;
    }

    .jewel-table .processing {
        color: #b89f7e;
    }

    .jewel-table .danger {
        color: #dc3545;
    }

    /* Buttons */
    .jewel-btn {
        display: inline-block;
        padding: 8px 20px;
        background: #b89f7e;
        color: #fff;
        border-radius: 5px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .jewel-btn:hover {
        background: #9b8465;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(184, 159, 126, 0.3);
    }

    /* Form */
    .jewel-form .form-label {
        color: #333;
    }

    .jewel-input {
        border: 1px solid #f0ebe7;
        border-radius: 5px;
        padding: 10px;
        transition: border-color 0.3s ease;
    }

    .jewel-input:focus {
        border-color: #b89f7e;
        box-shadow: 0 0 5px rgba(184, 159, 126, 0.3);
    }

    /* Alert */
    .jewel-alert {
        background: rgba(184, 159, 126, 0.1);
        border: 1px solid #b89f7e;
        color: #333;
    }
</style>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area elegant-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3 class="jewel-title">My Account</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- my account start  -->
<section class="main_content_area account-section">
    <div class="container">
        <div class="account_dashboard jewel-dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button jewel-tabs">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <!-- <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Dashboard</a></li> -->
                            <li><a href="#account-details" data-bs-toggle="tab" class="nav-link active">Hello, <b>{{ old('name', $user->name) }}</b></a></li>
                            <li><a href="#orders" data-bs-toggle="tab" class="nav-link">Orders</a></li>
                            <li><a href="#downloads" data-bs-toggle="tab" class="nav-link">Downloads</a></li>
                            <li><a href="#address" data-bs-toggle="tab" class="nav-link">Addresses</a></li>
                            <li>
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content jewel-content">
                        @if (session('success'))
                        <div class="alert alert-success jewel-alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <!-- <div class="tab-pane fade show active" id="dashboard">
                            <h3 class="jewel-heading">Dashboard</h3>
                            <p>Explore your account dashboard to effortlessly review your <a href="#">recent orders</a>, update your <a href="#">shipping and billing addresses</a>, or <a href="{{ route('profile.edit') }}">refine your password and account details</a>.</p>
                        </div> -->
                        <div class="tab-pane fade show active" id="account-details">
                            <h3 class="jewel-heading">Account Details</h3>
                            <div class="login jewel-form">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="{{ route('profile.update') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control jewel-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control jewel-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control jewel-input @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                                                @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control jewel-input @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="save_button primary_btn default_button">
                                                <button type="submit" class="btn jewel-btn">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <h3 class="jewel-heading">Orders</h3>
                            <div class="table-responsive jewel-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Delivery Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders && count($orders) > 0)
                                        @foreach($orders as $order)
                                        <tr>
                                            <!-- <td>{{ $order->id }}</td> -->
                                            <td class="w-25"><img src="assets/img/blog/12.jpg" alt="Order Image" class="w-50"></td>
                                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                                            <td><span class="{{ $order->status == 'completed' ? 'success' : 'processing' }}">{{ ucfirst($order->status) }}</span></td>
                                            <td>${{ $order->total }} for {{ $order->items()->count() }} item(s)</td>
                                            <td><a href="{{ route('orders.show', $order->id) }}" class="view jewel-btn text-white">View</a></td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5">No orders found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="downloads">
                            <h3 class="jewel-heading">Downloads</h3>
                            <div class="table-responsive jewel-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Downloads</th>
                                            <th>Expires</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Shopnovilla - Free Real Estate PSD Template</td>
                                            <td>May 10, 2018</td>
                                            <td><span class="danger">Expired</span></td>
                                            <td><a href="#" class="view jewel-btn text-white">Download</a></td>
                                        </tr>
                                        <tr>
                                            <td>Organic - ecommerce html template</td>
                                            <td>Sep 11, 2018</td>
                                            <td>Never</td>
                                            <td><a href="#" class="view jewel-btn text-white">Download</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address">
                            <h3 class="jewel-heading">Addresses</h3>
                            <p>The following addresses will be used on the checkout page by default.</p>
                            <h4 class="billing-address">Billing Address</h4>
                            <a href="#" class="view jewel-btn text-white">Edit</a>
                            <p><strong>{{ $user->name }}</strong></p>
                            <address>
                                <span><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</span>,
                                <br>
                                <span><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</span>,
                                <br>
                                <span><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</span>
                            </address>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->

@include('layout.footer')