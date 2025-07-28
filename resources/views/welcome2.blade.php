
@include('layout.header')

<!--slider area start-->
<div class="slider_area home_slider_three owl-carousel">
        <div class="single_slider" style="background-image: url('assets/img/slider/banner.jpg');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="slider_content">
                            <p>exclusive offer -10% off this week</p>
                            <h1>Rings For Women</h1>
                            <p class="slider_price">starting at <span>$2,199.00</span></p>
                            <a class="button" href="shop.html">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider" style="background-image: url('assets/img/slider/slider5.jpg');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="slider_content">
                            <p>exclusive offer -10% off this week</p>
                            <h1>Rings For Women</h1>
                            <p class="slider_price">starting at <span>$2,199.00</span></p>
                            <a class="button" href="shop.html">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--slider area end-->

<!--shipping area start-->
<div class="shipping_area shipping_two">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="single-shipping">
                    <div class="shipping_icone icone_1">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="shipping_content">
                        <h3>Free Shipping</h3>
                        <p>Free shipping on all orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-shipping">
                    <div class="shipping_icone icone_2">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="shipping_content">
                        <h3>Money Return</h3>
                        <p>Back guarantee under 7 days</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-shipping">
                    <div class="shipping_icone icone_3">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="shipping_content">
                        <h3>Member Discount</h3>
                        <p>On every order over $120.00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-shipping">
                    <div class="shipping_icone icone_4">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="shipping_content">
                        <h3>Online Support</h3>
                        <p>Support online 24 hours a day</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--shipping area end-->

<!--product section area start-->
<section class="py-5" id="products-section" style="background-color: white; color: black;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs">
                    <div class="d-flex justify-content-center border-bottom my-5"> <!-- Centering the tab buttons -->
                        <!--Product Tab Buttons-->
                        <div class="product_tab_button">
                            <ul class="nav" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ request('category') == null || request('category') == 'all' ? 'active' : '' }}" data-bs-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="{{ request('category') == null || request('category') == 'all' ? 'true' : 'false' }}">All</a>
                                </li>
                                @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link {{ request('category') == $category->name ? 'active' : '' }}" data-bs-toggle="tab" href="#nav-{{ Str::slug($category->name) }}" role="tab" aria-controls="nav-{{ Str::slug($category->name) }}" aria-selected="{{ request('category') == $category->name ? 'true' : 'false' }}">{{ $category->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Product Tab Buttons -->
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show {{ request('category') == null || request('category') == 'all' ? 'active' : '' }}" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @foreach ($productsByCategory['All'] as $product)
                                <div class="col"> <!-- product_column3 grid system use -->
                                    <div class="single_product">
                                        <div class="product_thumb">
                                            <a class="primary_img" href="{{ route('product.details', $product->id) }}"><img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt=""></a>
                                            <a class="secondary_img" href="{{ route('product.details', $product->id) }}"><img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt=""></a>
                                            <div class="quick_button">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box" data-placement="top" data-original-title="quick view"> quick view</a>
                                            </div>
                                        </div>
                                        <div class="product_content">
                                            <div class="tag_cate">
                                                <a href="#">Clothing,</a>
                                                <a href="#">Potato chips</a>
                                            </div>
                                            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
                                            <div class="price_box">
                                                @if($product->old_price)
                                                <span class="old_price">${{ $product->old_price }}</span>
                                                @endif
                                                <span class="current_price">${{ $product->price }}</span>
                                            </div>
                                            <div class="product_hover">
                                                <div class="product_ratings">
                                                    <ul>
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                    </ul>
                                                </div>
                                                <!-- <div class="product_desc">
                                                <p>{!! $product->description !!}</p>

                                                </div> -->
                                                <div class="action_links">
                                                    <ul>
                                                        <li>
                                                            <a href="#" class="add_to_wishlist" data-id="{{ $product->id }}" title="Add to Wishlist">
                                                                ❤️
                                                            </a>
                                                        </li>
                                                        <li class="add_to_cart"><a href="#" class="add_to_cart1" data-id="{{ $product->id }}" title="add to cart">add to cart</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- product_column3 grid system use -->
                                @endforeach
                            </div>
                        </div>
                        @foreach ($categories as $category)
                        <div class="tab-pane fade {{ request('category') == $category->name ? 'show active' : '' }}" id="nav-{{ Str::slug($category->name) }}" role="tabpanel" aria-labelledby="nav-{{ Str::slug($category->name) }}-tab">
                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @if (isset($productsByCategory[$category->name]))
                                @foreach ($productsByCategory[$category->name] as $product)
                                <div class="col"> <!-- product_column3 grid system use -->
                                    <div class="single_product">
                                        <div class="product_thumb">
                                            <a class="primary_img" href="{{ route('product.details', $product->id) }}"><img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $product->name }}"></a>
                                            <a class="secondary_img" href="{{ route('product.details', $product->id) }}"><img src="{{ $product->images->count() > 1 ? asset($product->images[1]->image_path) : asset($product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png')) }}" alt="{{ $product->name }}"></a>
                                            <div class="quick_button">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box" data-placement="top" data-original-title="quick view"> quick view</a>
                                            </div>
                                        </div>
                                        <div class="product_content">
                                            <div class="tag_cate">
                                                @if ($product->category)
                                                <a href="#">{{ $product->category->name }}</a>
                                                @endif
                                            </div>
                                            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
                                            <div class="price_box">
                                                @if ($product->old_price)
                                                <span class="old_price">₹{{ number_format($product->old_price, 2) }}</span>
                                                @endif
                                                <span class="current_price">₹{{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <div class="product_hover">
                                                <div class="product_ratings">
                                                    {{-- Implement your rating display logic here --}}
                                                </div>
                                                <div class="product_desc">
                                                    <p>{{ $product->description }}</p>
                                                </div>
                                                <div class="action_links">
                                                    <ul>
                                                        <li>
                                                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" data-placement="top" title="Add to Wishlist" data-bs-toggle="tooltip">
                                                                    <span class="icon icon-Heart"></span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li class="add_to_cart"><a href="{{ route('cart.add', $product->id) }}" title="add to cart">add to cart</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- product_column3 grid system use -->
                                @endforeach
                                @else
                                <p>No Products for this category</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--product section area end-->

<!--banner fullwidth start-->
<section class="banner_fullwidth position-relative overflow-hidden mb-5 mb-md-5">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="banner_text text-center mx-auto rounded-3 shadow-sm">
                    <p class="text-uppercase mb-2 fw-light ls-2 text-dusty-rose">Sale Off 20% All Products</p>
                    <h2 class="display-4 text-capitalize mb-3 fw-bold text-deep-brown">New Trending Collection</h2>
                    <span class="d-block mb-4 fst-italic text-warm-gray">We Believe That Good Design is Always in Season</span>
                    <a href="shop.html" class="btn btn-outline-soft-gold text-uppercase fw-medium px-5 py-2 rounded-1 mt-4">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--banner area end-->

<!--blog section area start-->
<section class="blog_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Lorem Ipsum</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="blog_wrapper blog_column3 owl-carousel">
                <div class="col-lg-4">
                    <div class="single_blog">
                        <div class="blog_thumb">
                            <a href="blog-details.html"><img src="assets/img/blog/blog1.jpg" alt="Blog image post"></a>
                        </div>
                        <div class="blog_content">
                            <h3><a href="blog-details.html">Blog Image Post</a></h3>
                            <div class="author_name">
                                <p>
                                    <span>by</span>
                                    <span class="themes">admin</span>
                                    / 30 Oct 2018
                                </p>
                            </div>
                            <div class="post_desc">
                                <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.</p>
                            </div>
                            <div class="read_more">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_blog">
                        <div class="blog_thumb">
                            <a href="blog-details.html"><img src="assets/img/blog/blog2.jpg" alt="Post with Gallery"></a>
                        </div>
                        <div class="blog_content">
                            <h3><a href="blog-details.html">Post with Gallery</a></h3>
                            <div class="author_name">
                                <p>
                                    <span>by</span>
                                    <span class="themes">admin</span>
                                    / 30 Oct 2018
                                </p>
                            </div>
                            <div class="post_desc">
                                <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.</p>
                            </div>
                            <div class="read_more">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_blog">
                        <div class="blog_thumb">
                            <a href="blog-details.html"><img src="assets/img/blog/blog3.jpg" alt="Post with Video"></a>
                        </div>
                        <div class="blog_content">
                            <h3><a href="blog-details.html">Post with Video</a></h3>
                            <div class="author_name">
                                <p>
                                    <span>by</span>
                                    <span class="themes">admin</span>
                                    / 30 Oct 2018
                                </p>
                            </div>
                            <div class="post_desc">
                                <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.</p>
                            </div>
                            <div class="read_more">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_blog">
                        <div class="blog_thumb">
                            <a href="blog-details.html"><img src="assets/img/blog/blog2.jpg" alt="Maecenas ultricies"></a>
                        </div>
                        <div class="blog_content">
                            <h3><a href="blog-details.html">Maecenas ultricies</a></h3>
                            <div class="author_name">
                                <p>
                                    <span>by</span>
                                    <span class="themes">admin</span>
                                    / 30 Oct 2018
                                </p>
                            </div>
                            <div class="post_desc">
                                <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.</p>
                            </div>
                            <div class="read_more">
                                <a href="blog-details.html">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--blog section area end-->

<!--Newsletter area start-->
<div class="newsletter_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="newsletter_content">
                    <h2>Our Newsletter</h2>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <div class="subscribe_form">
                        <form id="mc-form" class="mc-form footer-newsletter">
                            <input id="mc-email" type="email" autocomplete="off" placeholder="Email address..." />
                            <button id="mc-submit" type="submit">Subscribe</button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts text-center">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                        </div><!-- mailchimp-alerts end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Newsletter area start-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>






@include('layout.footer')
apps-fileview.texmex_20250313.01_p0
welcome.blade.php
Displaying welcome.blade.php.