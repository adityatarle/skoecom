@include('layout.header')

<section class="py-3" id="home" style="background-image: url('images/background-pattern.jpg');background-repeat: no-repeat;background-size: cover;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="banner-blocks">

                    <div class="banner-ad large bg-info block-1">

                        <div class="swiper main-swiper">
                            <div class="swiper-wrapper">

                                <div class="swiper-slide">
                                    <div class="row banner-content p-5">
                                        <div class="content-wrapper col-md-7">
                                            <div class="categories my-3">Premium Grade</div>
                                            <h3 class="display-4">Finest Saffron Threads</h3>
                                            <p>Experience the rich aroma and exquisite flavor of our hand-picked saffron.</p>
                                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Shop Now</a>
                                        </div>
                                        <div class="img-wrapper col-md-5">
                                            <img src="images/product-thumb-1.png" class="img-fluid">
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="row banner-content p-5">
                                        <div class="content-wrapper col-md-7">
                                            <div class="categories mb-3 pb-3">100% Pure</div>
                                            <h3 class="banner-title">Saffron for Culinary Use</h3>
                                            <p>Enhance your dishes with our top-quality saffron threads. Perfect for all your culinary needs.</p>
                                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Shop Collection</a>
                                        </div>
                                        <div class="img-wrapper col-md-5">
                                            <img src="images/product-thumb-1.png" class="img-fluid">
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="row banner-content p-5">
                                        <div class="content-wrapper col-md-7">
                                            <div class="categories mb-3 pb-3">Luxury Spices</div>
                                            <h3 class="banner-title">Saffron Infused Products</h3>
                                            <p>Discover the luxury of saffron in our range of infused oils, teas and more.</p>
                                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Explore Products</a>
                                        </div>
                                        <div class="img-wrapper col-md-5">
                                            <img src="images/product-thumb-2.png" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-pagination"></div>

                        </div>
                    </div>

                    <div class="banner-ad bg-success-subtle block-2" style="background:url('images/ad-image-1.png') no-repeat;background-position: right bottom">
                        <div class="row banner-content p-5">

                            <div class="content-wrapper col-md-7">
                                <div class="categories sale mb-3 pb-3">Limited Time Offer</div>
                                <h3 class="banner-title">Saffron Gift Sets</h3>
                                <a href="#" class="d-flex align-items-center nav-link">Explore Gift Sets <svg width="24" height="24">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></a>
                            </div>

                        </div>
                    </div>

                    <div class="banner-ad bg-danger block-3" style="background:url('images/ad-image-2.png') no-repeat;background-position: right bottom">
                        <div class="row banner-content p-5">

                            <div class="content-wrapper col-md-7">
                                <div class="categories sale mb-3 pb-3">Special Deal</div>
                                <h3 class="item-title">Saffron Bundles</h3>
                                <a href="#" class="d-flex align-items-center nav-link">View Bundles <svg width="24" height="24">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></a>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- / Banner Blocks -->

            </div>
        </div>
    </div>
</section>

<section class="about-us-section py-5" id="about" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-5" style="font-size: 2.5rem; font-weight: 700; color: #212529; text-transform: capitalize;">About Us</h2>
        <div class="row align-items-center">
            <div class="col-md-6 about-us-image-container position-relative">
                <div class="about-us-image-wrapper">
                    <img src="{{ asset('images/about.jpg') }}" alt="About Us" class="about-us-image img-fluid rounded-4">
                    <div class="about-us-image-overlay"></div>
                </div>
                <div class="about-us-shape"></div>
                <div class="about-us-shape-2"></div>
            </div>
            <div class="col-md-6 about-us-content-container">
                <div class="about-us-content p-5">
                    <h2 class="about-us-title display-4 mb-4 position-relative">Our Passion</h2>
                    <p class="about-us-text mb-4 position-relative">
                        At Preona, we're driven by a passion for quality and authenticity. Our commitment goes beyond sourcing just the best saffron and other natural ingredients; we also strive to create a brand that inspires and captivates.
                    </p>
                    <div class="about-us-mission mt-4 mb-4 position-relative">
                        <h4 class="about-us-mission-title">Our Mission</h4>
                        <p class="about-us-mission-text">To bring the most authentic and high quality saffron to every household, and to empower individuals to enhance their health and beauty in natural, ethical ways.
                        </p>
                    </div>
                    <div class="about-us-values mt-4 mb-4 position-relative">
                        <h4 class="about-us-value-title">Core Values</h4>
                        <ul class="list-unstyled">
                            <li class="about-us-value-item">Ethical Sourcing</li>
                            <li class="about-us-value-item">Quality and Purity</li>
                            <li class="about-us-value-item">Sustainability</li>
                            <li class="about-us-value-item">Customer Satisfaction</li>
                        </ul>
                    </div>
                    <a href="{{route('products')}}" class="btn btn-primary btn-lg mt-4 about-us-button position-relative">Explore Our Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 overflow-hidden" id="categories-section" style="background-color: white; color: black;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                    <h2 class="section-title">Categories</h2>

                    <div class="d-flex align-items-center">
                        <a href="#products-section" class="btn-link text-decoration-none" aria-label="View all categories">View All Categories →</a>
                        <div class="swiper-buttons">
                            <button class="swiper-prev category-carousel-prev btn btn-yellow" aria-label="Previous category">❮</button>
                            <button class="swiper-next category-carousel-next btn btn-yellow" aria-label="Next category">❯</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="category-carousel swiper">
                    <div class="swiper-wrapper">
                        @foreach($categories as $category)
                        <div class="swiper-slide">
                            <a href="{{route('products',['category'=>$category->name])}}" class="nav-link category-item" aria-label="View {{ $category->name }} category">
                                <div class="category-image-container">
                                    @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }} category image" class="category-image">
                                    @else
                                    <img src="{{ asset('images/no-image.jpg') }}" alt="Default category thumbnail" class="category-image">
                                    @endif
                                </div>
                                <h3 class="category-title">{{$category->name}}</h3>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="py-5 overflow-hidden" id="latest-product" style="background-color: white; color: black;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">
                    <h2 class="section-title">Latest Products</h2>
                    <div class="d-flex align-items-center">
                        <a href="#products-section" class="btn-link text-decoration-none">View All Products →</a>
                        <div class="swiper-buttons">
                            <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                            <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="brand-carousel swiper">
                    <div class="swiper-wrapper">
                        @if($latestProducts->isEmpty())
                        <p>No products have been added yet.</p>
                        @else
                        @foreach($latestProducts as $product)
                        <div class="swiper-slide">
                            <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="image-container">
                                            @if($product->images->first())
                                            <img src="{{ asset($product->images->first()->image_path) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                            @else
                                            <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body py-0">
                                            <a href="{{ route('product.details', $product->id) }}" class="product-link">
                                                @if($product->category)
                                                <p class="text-muted mb-0">{{ $product->category->name }}</p>
                                                @endif
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-5" id="products-section" style="background-color: white; color: black;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                        <h3>Products</h3>
                        <div class="d-flex align-items-center">
                            <!-- Dropdown for Mobile -->
                            <div class="d-md-none">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Category
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                        <li><a class="dropdown-item text-uppercase fs-6 {{request('category') == null || request('category') == 'all' ? 'active' : ''}}" href="{{route('main.page',['category'=>'all'])}}">All</a></li>
                                        @foreach($categories as $category)
                                        <li><a class="dropdown-item text-uppercase fs-6 {{request('category') == $category->name ? 'active' : ''}}" href="{{route('main.page',['category'=>$category->name])}}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- Nav Tabs for Desktop -->
                            <nav class="d-none d-md-block">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a href="{{route('main.page',['category'=>'all'])}}" class="nav-link text-uppercase fs-6 {{request('category') == null || request('category') == 'all' ? 'active' : ''}}" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                                    @foreach($categories as $category)
                                    <a href="{{route('main.page',['category'=>$category->name])}}" class="nav-link text-uppercase fs-6 {{request('category') == $category->name ? 'active' : ''}}" id="nav-{{ Str::slug($category->name) }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ Str::slug($category->name) }}">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show {{request('category') == null || request('category') == 'all' ? 'active' : ''}}" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @foreach($productsByCategory['All'] as $product)
                                <div class="col">
                                    <div class="product-item">
                                        @if($product->discount > 0)
                                        <span class="badge bg-success position-absolute m-3">-{{ $product->discount }}%</span>
                                        @endif
                                        <a href="#" class="btn-wishlist"><svg width="24" height="24">
                                                <use xlink:href="#heart"></use>
                                            </svg></a>
                                        <figure class="product-image-container">
                                            @if($product->images->first())
                                            <a href="{{ route('product.details', $product->id) }}" class="glightbox">
                                                <img src="{{ asset($product->images->first()->image_path) }}" class="product-img" alt="{{ $product->name }}">
                                            </a>
                                            @else
                                            <img src="{{ asset('images/no-image.png') }}" class="product-img" alt="No Image">
                                            @endif
                                        </figure>
                                        <a href="{{ route('product.details', $product->id) }}" class="product-link">
                                            @if($product->category)
                                            <p class="text-muted mb-0">{{ $product->category->name }}</p>
                                            @endif
                                            <h3>{{ $product->name }}</h3>
                                        </a>

                                        <a href="{{ route('product.details', $product->id) }}" class="product-link" style="display: inline-block; margin-bottom: 5px;">
                                            <span class="rating-display" style="vertical-align: middle;">
                                                @php
                                                $defaultRating = 4;
                                                $averageRating = isset($reviews[$product->id]) ? $reviews[$product->id]->avg('rating') : $defaultRating;
                                                @endphp
                                                @for($i=1; $i<=5; $i++)
                                                    @if ($i <=$averageRating)
                                                    <svg width="20" height="20" class="text-primary star-icon" style="vertical-align: middle; margin-right:2px;">
                                                    <use xlink:href="#star-solid"></use>
                                                    </svg>
                                                    @else
                                                    <svg width="16" height="16" class="text-secondary star-icon" style="vertical-align: middle; margin-right:2px;">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                    @endif
                                                    @endfor

                                            </span>
                                        </a>

                                        <span class="price">₹{{ $product->price }}</span>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route('cart.add', $product->id) }}" class="nav-link add-to-cart-btn" data-id="{{ $product->id }}">
                                                Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach($categories as $category)
                        <div class="tab-pane fade {{request('category') == $category->name ? 'show active' : ''}}" id="nav-{{ Str::slug($category->name) }}" role="tabpanel" aria-labelledby="nav-{{ Str::slug($category->name) }}-tab">
                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @if(isset($productsByCategory[$category->name]))
                                @foreach($productsByCategory[$category->name] as $product)
                                <div class="col">
                                    <div class="product-item">
                                        @if($product->discount > 0)
                                        <span class="badge bg-success position-absolute m-3">-{{ $product->discount }}%</span>
                                        @endif
                                        <a href="#" class="btn-wishlist"><svg width="24" height="24">
                                                <use xlink:href="#heart"></use>
                                            </svg></a>
                                        <figure class="product-image-container">
                                            @if($product->images->first())
                                            <a href="{{ route('product.details', $product->id) }}" title="{{ $product->name }}">
                                                <img src="{{ asset($product->images->first()->image_path) }}" class="product-img" alt="{{ $product->name }}">
                                            </a>
                                            @else
                                            <img src="{{ asset('images/no-image.png') }}" class="product-img" alt="No Image">
                                            @endif
                                        </figure>
                                        <a href="{{ route('product.details', $product->id) }}" class="product-link">
                                            @if($product->category)
                                            <p class="text-muted mb-0">{{ $product->category->name }}</p>
                                            @endif
                                            <h3>{{ $product->name }}</h3>
                                        </a>
                                        <a href="{{ route('product.details', $product->id) }}" class="product-link" style="display: inline-block; margin-bottom: 10px;">
                                            <span class="rating-display" style="vertical-align: middle;">
                                                @php
                                                $defaultRating = 4;
                                                $averageRating = isset($reviews[$product->id]) ? $reviews[$product->id]->avg('rating') : $defaultRating;
                                                @endphp
                                                @for($i=1; $i<=5; $i++)
                                                    @if ($i <=$averageRating)
                                                    <svg width="16" height="16" class="text-primary star-icon" style="vertical-align: middle; margin-right:2px;">
                                                    <use xlink:href="#star-solid"></use>
                                                    </svg>
                                                    @else
                                                    <svg width="16" height="16" class="text-secondary star-icon" style="vertical-align: middle; margin-right:2px;">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                    @endif
                                                    @endfor
                                                    ({{$averageRating}})
                                            </span>
                                        </a>
                                        <span class="price">₹{{ $product->price }}</span>
                                        <div class="d-flex align-items-center justify-content-between">

                                            <a href="javascript:void(0)" class="nav-link add-to-cart-btn" data-id="{{ $product->id }}">
                                                Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p> No Products for this category </p>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<section class="py-5">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="banner-ad bg-danger mb-3" style="background: url('images/ad-image-3.png'); background-repeat: no-repeat; background-position: right bottom; background-color: #f8f0e3; color: #4a2300;">
                    <div class="banner-content p-5">
                        <div class="categories text-primary fs-3 fw-bold">Premium Quality</div>
                        <h3 class="banner-title">Finest Saffron Strands</h3>
                        <p>Experience the richness of genuine saffron, carefully handpicked and naturally dried.</p>
                        <a href="{{ route('products') }}" class="btn btn-dark text-uppercase">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="banner-ad bg-info" style="background: url('images/ad-image-4.png'); background-repeat: no-repeat; background-position: right bottom; background-color: #e8f5e9; color: #003300;">
                    <div class="banner-content p-5">
                        <div class="categories text-primary fs-3 fw-bold">Enhance Your Cooking</div>
                        <h3 class="banner-title">Saffron Infusions</h3>
                        <p>Explore the many uses of saffron in culinary delights and traditional remedies.</p>
                        <a href="{{ route('products') }}" class="btn btn-dark text-uppercase">Learn More</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="py-5">
    <div class="container-fluid">

        <div class="bg-secondary py-5 my-5 rounded-5" style="background: url('images/bg-leaves-img-pattern.png') no-repeat;">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-6 p-5">
                        <div class="section-header">
                            <h2 class="section-title display-4">Discover the Magic of <span class="text-primary">Saffron</span> and get 25% Off</h2>
                        </div>
                        <p>Embark on a culinary adventure with our premium saffron. Handpicked and carefully processed, our saffron brings unparalleled flavor and vibrant color to your dishes. Subscribe now to receive 25% off your first purchase!</p>
                    </div>
                    <div class="col-md-6 p-5">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text"
                                    class="form-control form-control-lg" name="name" id="name" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Enter your email address">
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <label class="form-check-label" for="subscribe">
                                    <input class="form-check-input" type="checkbox" id="subscribe" value="subscribe">
                                    Receive exclusive offers and saffron recipes!</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-lg">Get Your Discount</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".add-to-cart-btn").forEach(function(button) {
            button.addEventListener("click", function() {
                let productId = this.getAttribute("data-id");

                fetch("/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            id: productId,
                            quantity: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Product added to cart!");
                        } else {
                            alert("Failed to add to cart");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });
</script>


@include('layout.footer')