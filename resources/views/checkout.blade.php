@include('layout.header')

<!--Checkout page section-->
<div class="Checkout_section" id="accordion">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Returning Customer Section -->
                <div class="user-actions">
                    <h3 class="mb-0">
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
                    <h3 class="mb-0">
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
        <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST">
            @csrf
            <div class="checkout_form">
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-6 col-md-6">
                        <h3>Billing Details</h3>
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

                        <div class="row">
                            <div class="mb-20 col-lg-6">

                                <label>First Name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ auth()->check() ? auth()->user()->first_name : old('first_name') }}" required>
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-lg-6">
                                <label>Last Name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ auth()->check() ? auth()->user()->last_name : old('last_name') }}" required>
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-12">
                                <label>Street address <span>*</span></label>
                                <input placeholder="House number and street name" type="text" name="street_address" value="{{ old('street_address') }}" required>
                                @error('street_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-12">
                                <label>Town / City <span>*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-12">
                                <label>State <span>*</span></label>
                                <input type="text" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-12">
                                <label>Country <span>*</span></label>
                                <select name="country" id="country" required>
                                    <option value="">Select Country</option>
                                    <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>USA</option>
                                    <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                </select>
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-lg-6">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone" value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-lg-6">
                                <label>Email Address <span>*</span></label>
                                <input type="email" name="email" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                    @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                    <tr>
                                        <td>{{ $details['name'] }} <strong>× {{ $details['quantity'] }}</strong></td>
                                        <td>₹{{ number_format($details['quantity'] * $details['price'], 2) }}</td>
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
                                        <td>₹{{ number_format($cartTotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>₹0.00</strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>₹{{ number_format($cartTotal, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Payment Method -->
                        <div class="payment_method">
                            <h3>Select Payment Method</h3>
                            <label>
                                <input id="payment_cash" name="payment_method" type="radio" value="cash_on_delivery" required style="width: 5%;"> Cash on Delivery
                            </label>
                            <label>
                                <input id="payment_razorpay" name="payment_method" type="radio" value="razorpay" style="width: 5%;"> Razorpay
                            </label>

                            <!-- Hidden fields for Razorpay -->
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrder['id'] }}">
                            <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                            <div class="order_button">
                                <button type="submit" id="place-order-btn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--Checkout page section end-->

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const placeOrderBtn = document.getElementById('place-order-btn');
    const checkoutForm = document.getElementById('checkout-form');
    
    // Form validation
    function validateForm() {
        const requiredFields = checkoutForm.querySelectorAll('input[required], select[required]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(field => {
            const value = field.value.trim();
            if (!value) {
                field.style.borderColor = '#dc3545';
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });

        // Email validation
        const emailField = checkoutForm.querySelector('input[type="email"]');
        if (emailField && emailField.value) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailField.value)) {
                emailField.style.borderColor = '#dc3545';
                if (!firstInvalidField) {
                    firstInvalidField = emailField;
                }
                isValid = false;
            }
        }

        if (!isValid && firstInvalidField) {
            firstInvalidField.focus();
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return isValid;
    }

    // Payment method validation
    function validatePaymentMethod() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
        if (!paymentMethod) {
            alert('Please select a payment method.');
            return false;
        }
        return paymentMethod;
    }

    // Place order button click handler
    placeOrderBtn.onclick = function(e) {
        e.preventDefault();
        
        // Disable button to prevent double submission
        placeOrderBtn.disabled = true;
        const originalText = placeOrderBtn.textContent;
        placeOrderBtn.textContent = 'Processing...';

        // Validate form
        if (!validateForm()) {
            placeOrderBtn.disabled = false;
            placeOrderBtn.textContent = originalText;
            return;
        }

        // Validate payment method
        const paymentMethod = validatePaymentMethod();
        if (!paymentMethod) {
            placeOrderBtn.disabled = false;
            placeOrderBtn.textContent = originalText;
            return;
        }

        if (paymentMethod === 'razorpay') {
            // Initialize Razorpay
            const options = {
                "key": "{{ env('RAZORPAY_KEY') }}",
                "amount": "{{ $razorpayOrder['amount'] }}",
                "currency": "INR",
                "name": "Ecommerce Store",
                "description": "Order Payment",
                "image": "{{ asset('images/logo.png') }}",
                "order_id": "{{ $razorpayOrder['id'] }}",
                "handler": function(response) {
                    console.log('Razorpay Payment Success:', response);
                    
                    // Set Razorpay response values
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    
                    // Submit the form
                    console.log('Submitting form after successful payment');
                    checkoutForm.submit();
                },
                "prefill": {
                    "name": "{{ old('first_name', auth()->check() ? auth()->user()->first_name : '') }} {{ old('last_name', auth()->check() ? auth()->user()->last_name : '') }}",
                    "email": "{{ old('email', auth()->check() ? auth()->user()->email : '') }}",
                    "contact": "{{ old('phone', auth()->check() ? auth()->user()->phone : '') }}"
                },
                "theme": {
                    "color": "#b89f7e"
                },
                "modal": {
                    "ondismiss": function() {
                        console.log('Razorpay modal dismissed');
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.textContent = originalText;
                    }
                }
            };

            try {
                const rzp = new Razorpay(options);
                
                rzp.on('payment.failed', function(response) {
                    console.log('Razorpay Payment Failed:', response);
                    alert('Payment failed: ' + (response.error.description || 'Please try again'));
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.textContent = originalText;
                });

                rzp.open();
                console.log('Razorpay modal opened');
                
            } catch (error) {
                console.error('Razorpay initialization failed:', error);
                alert('Failed to initialize payment gateway. Please try again.');
                placeOrderBtn.disabled = false;
                placeOrderBtn.textContent = originalText;
            }
        } else {
            // Cash on delivery - submit form directly
            console.log('Submitting form for Cash on Delivery');
            checkoutForm.submit();
        }
    };

    // Real-time validation feedback
    const inputs = checkoutForm.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '';
            }
        });

        input.addEventListener('input', function() {
            if (this.style.borderColor === 'rgb(220, 53, 69)') {
                this.style.borderColor = '';
            }
        });
    });
});
</script>

@include('layout.footer')