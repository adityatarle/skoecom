@include('layout.header')

<style>
    .product_details {
        padding: 2rem 0;
    }

    .product-details-tab {
        background: #ffffff;
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid #dee2e6;
    }

    .product_d_right {
        background: #ffffff;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        height: 100%;
    }

    .product_d_right h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 0.5rem;
    }

    .product_d_right p {
        font-size: 0.95rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .product_price {
        margin: 1rem 0;
    }

    .current_price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #000000;
    }

    .accordion-item {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .accordion-button {
        background: linear-gradient(125deg, #b89f7e 10%, #f0ebe7 100%);
        font-weight: 500;
        color: #ffffff;
        border-radius: 4px;
        padding: 1rem;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(125deg, #f0ebe7 10%, #b89f7e 100%);
        color: #000000;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    .accordion-body {
        background: #f8f9fa;
        border-radius: 4px;
        padding: 1rem;
    }

    .table {
        font-size: 0.9rem;
        color: #000000;
    }

    .table th,
    .table td {
        padding: 0.5rem;
        vertical-align: middle;
    }
</style>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area product_bread bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{route('home')}}">home</a></li>
                        <li>></li>
                        <li>product details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- Product Details Start -->
<div class="product_details mt-4">
    <div class="container">
        <div class="row">
            <!-- Product Image Section -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="product-details-tab">
                    <div class="single-zoom">
                        @if($product->images->isNotEmpty())
                        <img id="main-image"
                            src="{{ asset($product->images->first()->image_path) }}"
                            alt="{{ $product->name }}"
                            style="width: 100%; height: auto; display: block;">
                        @else
                        <p>No image available</p>
                        @endif
                    </div>

                    <!-- Thumbnail Carousel -->
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            @foreach ($product->images as $image)
                            <li>
                                <img class="product-thumbnail"
                                    src="{{ asset($image->image_path) }}"
                                    data-image="{{ asset($image->image_path) }}"
                                    alt="{{ $product->name }}" />
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6 col-md-6">
                <div class="product_d_right">
                    <form action="#">
                        <h1>{{ $product->name }}</h1>
                        <p><strong>Product Code:</strong> {{ $product->sku }}</p>
                        <p><strong>Available in:</strong> {{ $product->location }}</p>

                        <div class="product_price">
                            <span class="current_price">₹{{ number_format($pricingBreakup['grand_total'], 2) }}</span>
                            <p>(Inclusive of all taxes)</p>
                        </div>

                        <div class="pb-3">
                            <p class="fw-bold mb-0">Product Description:</p>
                            <p>{!! $product->description !!}</p>
                        </div>

                        <!-- Bootstrap Accordion -->
                        <div class="accordion" id="productDetailsAccordion">
                            <!-- Product Break Up Price -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Product Break Up Price
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#productDetailsAccordion">
                                    <div class="accordion-body bg-light">
                                        <p class="fw-bold">Ocean’s Whisper Diamond Bangle is crafted in 18KT White Gold and is studded with Diamonds and Pearls.</p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Component</th>
                                                    <th>Weight (g)</th>
                                                    <th>Rate</th>
                                                    <th>Total Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pricingBreakup['components'] as $component)
                                                <tr>
                                                    <td>{{ $component->component }}</td>
                                                    <td>{{ $component->weight ?? '-' }}</td>
                                                    <td>{{ $component->rate ? '₹' . number_format($component->rate, 2) : '-' }}</td>
                                                    <td>₹{{ number_format($component->total_value, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td>Subtotal</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>₹{{ number_format($pricingBreakup['subtotal'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Labour Charges</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>₹{{ number_format($pricingBreakup['labour_charges'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>GST ({{ $pricingBreakup['gst_percentage'] }}%)</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>₹{{ number_format($pricingBreakup['gst_amount'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Grand Total</strong></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><strong>₹{{ number_format($pricingBreakup['grand_total'], 2) }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-3 d-flex gap-2 align-items-center">
                            <button class="btn btn-dark add_to_cart1" data-id="{{ $product->id }}">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline-secondary add_to_wishlist" data-id="{{ $product->id }}" title="Add to Wishlist">
                                <i class="fa fa-heart-o"></i> Add to Wishlist
                            </button>
                            <button class="btn btn-success" onclick="buyNow({{ $product->id }})">
                                <i class="fa fa-bolt"></i> Buy Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Details End -->

<!-- Thumbnail Image Switcher Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainImage = document.getElementById("main-image");
        const thumbnails = document.querySelectorAll(".product-thumbnail");

        if (!mainImage || thumbnails.length === 0) {
            console.error("Main image or thumbnails not found!");
            return;
        }

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener("click", function() {
                let newImageSrc = this.getAttribute("data-image");
                if (newImageSrc) {
                    mainImage.src = newImageSrc;
                }
            });

            thumbnail.addEventListener("mouseover", function() {
                let newImageSrc = this.getAttribute("data-image");
                if (newImageSrc) {
                    mainImage.src = newImageSrc;
                }
            });
        });
    });

    // Buy Now functionality
    function buyNow(productId) {
        // First add to cart
        $.ajax({
            url: "{{ route('cart.add') }}",
            type: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === "success") {
                    // Redirect to checkout immediately
                    window.location.href = "{{ route('checkout') }}";
                } else {
                    alert(response.message || 'Error adding product to cart');
                }
            },
            error: function(xhr, status, error) {
                console.error('Buy Now Error:', xhr.responseText);
                alert("Error processing buy now request");
            }
        });
    }
</script>

@include('layout.footer')