@include('layout.header')

<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3>Shopping Cart</h3>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>></li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!--shopping cart area start -->
<div class="shopping_cart_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(!empty($cart) && count($cart) > 0)
                <form action="#" method="post">
                    @csrf
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb1">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cart as $id => $details)
                                    @php $subtotal = $details['quantity'] * $details['price']; $total += $subtotal; @endphp
                                    <tr>
                                        <td class="product_remove">
                                            <a href="{{ route('cart.remove', $id) }}"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                        <td class="product_thumb1">
                                            <a href="{{ route('product.details', $id) }}">
                                                @if(isset($details['image']))
                                                <!-- DEBUGGING:  Check the generated URL -->
                                                @php $imagePath = asset('/' . $details['image']); @endphp
                                                <img src="{{ $imagePath }}" alt="{{ $details['name'] }}">

                                                @else
                                                No Image
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product_name"><a href="{{ route('product.details', $id) }}">{{ $details['name'] }}</a></td>
                                        <td class="product-price">₹{{ $details['price'] }}</td>
                                        <td class="product_quantity">
                                            <label>Quantity</label>
                                            <div class=" align-items-center">
                                                <a href="{{ route('cart.decrease', $id) }}" class="cart-qty-btn">-</a>
                                                <input min="1" max="100" value="{{ $details['quantity'] }}" type="number" class="cart-qty-input" data-id="{{ $id }}">
                                                <a href="{{ route('cart.increase', $id) }}" class="cart-qty-btn">+</a>
                                            </div>
                                        </td>
                                        <td class="product_total">₹{{ $subtotal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cart_submit">
                            <a href="{{route('products')}}" class="btn-primary">Add more</a>
                            <button type="submit">update cart</button>
                        </div>
                    </div>
            </div>
            <!--coupon code area start-->
            <div class="coupon_area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left">
                            <h3>Coupon</h3>
                            <div class="coupon_inner">
                                <p>Enter your coupon code if you have one.</p>
                                <input placeholder="Coupon code" type="text">
                                <button type="submit">Apply coupon</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                                <div class="cart_subtotal">
                                    <p>Subtotal</p>
                                    <p class="cart_amount">₹{{ $total }}</p>
                                </div>
                                <div class="cart_subtotal ">
                                    <p>Shipping</p>
                                    <p class="cart_amount"><span>Flat Rate:</span>₹0.00</p>
                                </div>
                                <a href="#">Calculate shipping</a>

                                <div class="cart_subtotal">
                                    <p>Total</p>
                                    <p class="cart_amount">₹{{ $total }}</p>
                                </div>
                                <div class="checkout_btn">
                                    <a href="{{route('checkout')}}">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area end-->
        </div>

        @else
        <p>Your cart is empty.</p>
        <a href="{{ route('products') }}" class="btn btn-primary">Continue Shopping</a>
        @endif
        </form>
    </div>
</div>
<!--shopping cart area end -->

@include('layout.footer')