@include('layout.header')

<!--Checkout page section-->
<div class="Checkout_section" id="accordion">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Returning Customer Section -->
                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Returning customer?
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_login">Click here to login</a>
                    </h3>
                    <div id="checkout_login" class="collapse">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details below.</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form_group">
                                    <label>Email <span>*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="form_group">
                                    <label>Password <span>*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="form_group group_3">
                                    <button type="submit">Login</button>
                                    <label for="remember_box">
                                        <input id="remember_box" type="checkbox" name="remember">
                                        <span> Remember me </span>
                                    </label>
                                </div>
                                <a href="#">Lost your password?</a>
                            </form>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Coupon Section -->
                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Have a coupon?
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_coupon">Click here to enter your code</a>
                    </h3>
                    <div id="checkout_coupon" class="collapse">
                        <div class="checkout_info">
                            <form method="POST" action="{{ route('apply.coupon') }}">
                                @csrf
                                <input placeholder="Coupon code" type="text" name="coupon_code">
                                <button type="submit">Apply coupon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="checkout_form">
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-6 col-md-6">
                        <h3>Billing Details</h3>
                        <div class="row">
                            <div class="mb-20 col-lg-6">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <label>First Name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ auth()->check() ? auth()->user()->first_name : '' }}" required>
                            </div>
                            <div class="mb-20 col-lg-6">
                                <label>Last Name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ auth()->check() ? auth()->user()->last_name : '' }}" required>
                            </div>
                            <div class="mb-20 col-12">
                                <label>Street address <span>*</span></label>
                                <input placeholder="House number and street name" type="text" name="street_address" required>
                            </div>
                            <div class="mb-20 col-12">
                                <label>Town / City <span>*</span></label>
                                <input type="text" name="city" required>
                            </div>
                            <div class="mb-20 col-12">
                                <label>State<span>*</span></label>
                                <input type="text" name="state" required>
                            </div>
                            <div class="mb-20 col-12">
                                <label>Country<span>*</span></label>
                                <select name="country" id="country" required>
                                    <option value="">Select Country</option>
                                    <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>USA</option>
                                    <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                </select>
                            </div>

                            <div class="mb-20 col-lg-6">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required>
                            </div>
                            <div class="mb-20 col-lg-6">
                                <label>Email Address <span>*</span></label>
                                <input type="email" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-6 col-md-6">
                        <h3>Your Order</h3>
                        <div class="order_table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                    @php
                                    $subtotal = $details['quantity'] * $details['price'];
                                    $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $details['name'] }} <strong>× {{ $details['quantity'] }}</strong></td>
                                        <td>₹{{ $subtotal }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2">Your cart is empty.</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td>₹{{ $total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>₹0.00</strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>₹{{ $total }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Payment Method -->
                        <div class="payment_method">
                            <h3>Select Payment Method</h3>
                            <label>
                                <input id="payment_cash" name="payment_method" type="radio" value="cash_on_delivery" required> Cash on Delivery
                            </label>
                            <label>
                                <input id="payment_paypal" name="payment_method" type="radio" value="paypal"> PayPal
                            </label>
                            <div class="order_button">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--Checkout page section end-->

@include('layout.footer')
