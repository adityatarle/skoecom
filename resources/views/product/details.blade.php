@include('layout.header')

<!--breadcrumbs area start-->
<div class="breadcrumbs_area product_bread bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>></li>
                        <li><a href="shop.html">shop</a></li>
                        <li>></li>
                        <li><a href="shop.html">Clothing</a></li>
                        <li>></li>
                        <li>product details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
<div class="product_details">
    <div class="container">
        <div class="row">
            <!-- Product Image Section -->
            <div class="mb-4 col-lg-6 col-md-6 mb-md-0">
                <div class="product-details-tab">
                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            @if($product->images->isNotEmpty())
                            <img id="zoom1"
                                src="{{ asset($product->images->first()->image_path) }}"
                                data-zoom-image="{{ asset($product->images->first()->image_path) }}"
                                alt="{{ $product->name }}"
                                style="width: 100%; height: auto; display: block;">
                            @else
                            <p>No image available</p>
                            @endif
                        </a>
                    </div>

                    <!-- Thumbnail Carousel -->
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            @foreach ($product->images as $image)
                            <li>
                                <a href="#" class="elevatezoom-gallery"
                                    data-image="{{ asset($image->image_path) }}"
                                    data-zoom-image="{{ asset($image->image_path) }}">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" />
                                </a>
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

                        <div class="pb-4">
                            <p class="fw-bold mb-0">Product Description:</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse aut blanditiis quidem voluptatem aperiam nesciunt, sapiente iste mollitia sequi sunt quisquam omnis praesentium ab deleniti, repellat ratione nobis laboriosam modi molestias ex assumenda. Quia harum voluptatem vel mollitia. A vitae, corrupti quas fugit illum quibusdam reprehenderit qui inventore reiciendis minus!</p>
                        </div>

                        <!-- Bootstrap Accordion -->
                        <div class="accordion" id="productDetailsAccordion">

                            <!-- Product Details -->
                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Product Details
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#productDetailsAccordion">
                                    <div class="accordion-body">
                                        <p>{!! $product->description !!}</p>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Product Break Up Price -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Product Break Up Price
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#productDetailsAccordion">
                                    <div class="accordion-body bg-light m-4">
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

                            <!-- Shipping Status -->
                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Shipping Status
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#productDetailsAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Free Shipping In India.</strong></p>
                                        <p>We will ship the product in <strong>7 to 10 days</strong>.</p>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <button class="btn btn-dark">Add to Cart</button>
                            <button class="btn btn-outline-dark">Buy Now</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product details end-->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@include('layout.footer')