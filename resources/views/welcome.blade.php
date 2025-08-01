@include('layout.header')

@php
use App\Models\Banner;
use App\Models\Setting;
use App\Models\Blog;

// Get banners by type
$sliderBanners = Banner::active()->slider()->orderBy('sort_order')->get();
$fullwidthBanner = Banner::active()->fullwidth()->first();
$newsletterSettings = [
    'title' => Setting::get('newsletter_title', 'Our Newsletter'),
    'description' => Setting::get('newsletter_description', 'Get E-mail updates about our latest shop and special offers.'),
    'placeholder' => Setting::get('newsletter_placeholder', 'Email address...'),
    'button_text' => Setting::get('newsletter_button_text', 'Subscribe')
];

// Get latest blogs for the commented section
$latestBlogs = Blog::latest()->take(4)->get();
@endphp

<style>
    @keyframes moveRight {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(5px);
        }

        100% {
            transform: translateX(0);
        }
    }

    .arrow-animate {
        display: inline-block;
        animation: moveRight 1s infinite;
    }

    /* 11/4/25 start */
    /* Mobile view */
    @media (max-width: 768px) {
        .jewelry-nav {
            justify-content: center;
            gap: 5px;
        }

        .jewelry-nav .nav-link {
            padding: 6px 12px !important;
            font-size: 14px;
        }
    }

    /* Extra small screens */
    @media (max-width: 480px) {
        .jewelry-nav {
            flex-direction: column;
            align-items: center;
        }

        .jewelry-nav .nav-link {
            width: 100%;
            text-align: center;
        }
    }

    /* 11/4/25 end */
    @media (max-width: 479px) {
        .tab-nav {
            background: url('assets/img/bg/bg2-2.png') center center no-repeat;
            object-fit: cover;
        }
    }
</style>

<!--slider area start-->
@if($sliderBanners->count() > 0)
<div class="slider_area home_slider_three owl-carousel">
    @foreach($sliderBanners as $banner)
    <div class="single_slider" style="background-image: url('{{ asset($banner->image) }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="slider_content">
                        @if($banner->subtitle)
                            <p>{{ $banner->subtitle }}</p>
                        @endif
                        @if($banner->title)
                            <h1>{{ $banner->title }}</h1>
                        @endif
                        @if($banner->price_text)
                            <p class="slider_price">{{ $banner->price_text }}</p>
                        @endif
                        @if($banner->button_text && $banner->button_url)
                            <a class="button" href="{{ $banner->button_url }}">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<!-- Default slider if no banners -->
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
</div>
@endif
<!--slider area end-->

<!-- Benefits Section Start -->
<section class="benefits-section">
    <div class="container">
        <div class="row g-0 g-lg-4">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="benefit-card">
                    <i class="fas fa-truck"></i>
                    <h6>Free Shipping</h6>
                    <p>Free shipping on all orders</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="benefit-card">
                    <i class="fas fa-undo"></i>
                    <h6>Money Return</h6>
                    <p>Back guarantee under 7 days</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="benefit-card">
                    <i class="fas fa-tag"></i>
                    <h6>Member Discount</h6>
                    <p>On every order over $120.00</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="benefit-card">
                    <i class="fas fa-headset"></i>
                    <h6>Online Support</h6>
                    <p>Support online 24 hours a day</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Benefits Section End -->

<!--product section area start-->
<section class="py-md-5 py-4 overflow-hidden" id="products-section" style="background: linear-gradient(135deg, #f8f1e9 0%, #e8e2d9 100%); color: #333;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="jewelry-tabs product-tabs">
                    <!-- Dropdown for Mobile View -->

                    <!-- Tab Navigation -->
                    <div class="tab-nav d-flex justify-content-center mb-lg-5 mb-0 p-5 p-lg-0">
                        <ul class="nav jewelry-nav flex-wrap justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request('category') == null || request('category') == 'all' ? 'active' : '' }}" data-bs-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="{{ request('category') == null || request('category') == 'all' ? 'true' : 'false' }}">All</a>
                            </li>
                            @foreach ($categories->take(3) as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ request('category') == $category->name ? 'active' : '' }}" data-bs-toggle="tab" href="#nav-{{ Str::slug($category->name) }}" role="tab" aria-controls="nav-{{ Str::slug($category->name) }}" aria-selected="{{ request('category') == $category->name ? 'true' : 'false' }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                            <li class="nav-item d-flex align-items-center">
                                <a href="{{ route('products') }}" class="nav-link active">
                                    <i class="fas fa-arrow-right arrow-animate"></i>
                                </a>
                            </li>
                        </ul>
                    </div>


                    <!-- Tab Content -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- All Products Tab -->
                        <div class="tab-pane fade {{ request('category') == null || request('category') == 'all' ? 'show active' : '' }}" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                            <div class="jewelry-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 px-3">
                                @foreach ($productsByCategory['All']->take(8) as $product)
                                <div class="col">
                                    <div class="jewelry-product">
                                        <div class="product-thumb">
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $product->name }}" class="primary-img img-fluid">
                                                <img src="{{ $product->images->count() > 1 ? asset($product->images[1]->image_path) : ($product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png')) }}" alt="{{ $product->name }}" class="hover-img img-fluid">
                                            </a>
                                            <div class="quick-view">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box">Quick View</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <p><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></p>
                                            <div class="price-box">
                                                @if($product->old_price)
                                                <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                                @endif
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <div class="action-links">
                                                <a href="{{ route('wishlist.add', $product->id) }}" class="add_to_wishlist" data-id="{{ $product->id }}" title="Add to Wishlist"><i class="icon ion-ios-heart-outline"></i></a>
                                                <a href="{{ route('cart.add', $product->id) }}" class="add_to_cart1" data-id="{{ $product->id }}" title="add to cart"><i class="icon ion-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>

                        <!-- Category-Specific Tabs -->
                        @foreach ($categories as $category)
                        <div class="tab-pane fade {{ request('category') == $category->name ? 'show active' : '' }}" id="nav-{{ Str::slug($category->name) }}" role="tabpanel" aria-labelledby="nav-{{ Str::slug($category->name) }}-tab">
                            <div class="jewelry-grid row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3 px-3">
                                @if (isset($productsByCategory[$category->name]))
                                @foreach ($productsByCategory[$category->name]->take(8) as $product)
                                <div class="col">
                                    <div class="jewelry-product">
                                        <div class="product-thumb">
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $product->name }}" class="primary-img img-fluid">
                                                <img src="{{ $product->images->count() > 1 ? asset($product->images[1]->image_path) : ($product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png')) }}" alt="{{ $product->name }}" class="hover-img img-fluid">
                                            </a>
                                            <div class="quick-view">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box">Quick View</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <p><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></p>
                                            <div class="price-box">
                                                @if($product->old_price)
                                                <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                                @endif
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <div class="action-links">
                                                <a href="{{ route('wishlist.add', $product->id) }}" class="add_to_wishlist" data-id="{{ $product->id }}" title="Add to Wishlist"><i class="icon ion-ios-heart-outline"></i></a>
                                                <a href="{{ route('cart.add', $product->id) }}" class="add_to_cart1" data-id="{{ $product->id }}" title="add to cart"><i class="icon ion-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-center py-5">No products available in this category.</p>
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
@if($fullwidthBanner)
<section class="banner_fullwidth position-relative overflow-hidden mb-5 mb-md-5">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="banner_text text-center mx-auto rounded-3 shadow-sm">
                    @if($fullwidthBanner->subtitle)
                        <p class="text-uppercase mb-2 fw-light ls-2 text-dusty-rose">{{ $fullwidthBanner->subtitle }}</p>
                    @endif
                    @if($fullwidthBanner->title)
                        <h2 class="display-4 text-capitalize mb-3 fw-bold text-deep-brown">{{ $fullwidthBanner->title }}</h2>
                    @endif
                    @if($fullwidthBanner->description)
                        <span class="d-block mb-4 fst-italic text-warm-gray">{{ $fullwidthBanner->description }}</span>
                    @endif
                    @if($fullwidthBanner->button_text && $fullwidthBanner->button_url)
                        <a href="{{ $fullwidthBanner->button_url }}" class="btn btn-outline-soft-gold text-uppercase fw-medium px-5 py-2 rounded-1 mt-4">{{ $fullwidthBanner->button_text }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@else
<!-- Default fullwidth banner if none exists -->
<section class="banner_fullwidth position-relative overflow-hidden mb-5 mb-md-5">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="banner_text text-center mx-auto rounded-3 shadow-sm">
                    <p class="text-uppercase mb-2 fw-light ls-2 text-dusty-rose">Sale Off 20% All Products</p>
                    <h2 class="display-4 text-capitalize mb-3 fw-bold text-deep-brown">New Trending Collection</h2>
                    <span class="d-block mb-4 fst-italic text-warm-gray">We Believe That Good Design is Always in Season</span>
                    <a href="{{route('products')}}" class="btn btn-outline-soft-gold text-uppercase fw-medium px-5 py-2 rounded-1 mt-4">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!--banner area end-->

<!--blog section area start-->
@if($latestBlogs->count() > 0)
<section class="blog_section" id="sk-blog">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Latest Blog Posts</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="blog_wrapper blog_column3 owl-carousel">
                @foreach($latestBlogs as $blog)
                <div class="col-lg-4">
                    <div class="single_blog">
                        <div class="blog_thumb">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}">
                                @else
                                    <img src="assets/img/blog/12.jpg" alt="{{ $blog->title }}">
                                @endif
                            </a>
                        </div>
                        <div class="blog_content">
                            <h3><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h3>
                            <div class="author_name">
                                <p>
                                    <span>by</span>
                                    <span class="themes">admin</span>
                                    / {{ $blog->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="post_desc">
                                <p>{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                            </div>
                            <div class="read_more">
                                <a href="{{ route('blog.show', $blog->slug) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!--blog section area end-->

<!--Newsletter area start-->
<div class="newsletter_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="newsletter_content">
                    <h2>{{ $newsletterSettings['title'] }}</h2>
                    <p>{{ $newsletterSettings['description'] }}</p>
                    <div class="subscribe_form">
                        <form id="mc-form" class="mc-form footer-newsletter">
                            <input id="mc-email" type="email" autocomplete="off" placeholder="{{ $newsletterSettings['placeholder'] }}" />
                            <button id="mc-submit" type="submit">{{ $newsletterSettings['button_text'] }}</button>
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