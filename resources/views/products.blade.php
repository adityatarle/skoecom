@include('layout.header')

<style>
    /* Basic styling for the filter widget */
    .widget_filter {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .widget_filter h2 {
        font-size: 1.2em;
        margin-bottom: 10px;
    }

    /* Styling for the slider range container */
    #slider-range {
        margin-bottom: 15px;
    }

    /* Styling for the price amount display */
    #amount {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Styling for the filter button */
    .widget_filter button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .widget_filter button:hover {
        background-color: #0056b3;
    }
</style>
<!--shop  area start-->
<div class="shop_area shop_reverse">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                <div class="sidebar_widget">
                    <div class="widget_list widget_categories">
                        <h2>Categories</h2>
                        <ul>
                            @foreach($categories as $category)
                            <li><a href="{{ route('products', ['category' => $category->name]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget_list widget_filter">
                        <h2>Filter by price</h2>
                        <form action="{{ route('products') }}" method="GET">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <div id="slider-range"></div>
                            <input type="text" name="amount" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            <input type="hidden" id="min_price" name="min_price" value="">
                            <input type="hidden" id="max_price" name="max_price" value="">
                            <button type="submit">Filter</button>
                        </form>
                    </div>


                    <div class="widget_list widget_color">
                        <h2>Color</h2>
                        <ul>
                            <li><a href="#">Gold </a> <span>(4)</span></li>
                            <li><a href="#"> Green </a> <span>(6)</span></li>
                            <li><a href="#">White </a> <span>(10)</span></li>
                        </ul>
                    </div>
                    <div class="widget_list tag-cloud">
                        <h2>Tags</h2>
                        <div class="tag_widget">
                            <ul>
                                <li><a href="#">asian</a></li>
                                <li><a href="#">brown</a></li>
                                <li><a href="#">euro</a></li>
                                <li><a href="#">fashion</a></li>
                                <li><a href="#">france</a></li>
                                <li><a href="#">hat</a></li>
                                <li><a href="#">t-shirt</a></li>
                                <li><a href="#">travel</a></li>
                                <li><a href="#">white</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="widget_list Featured_p">
                        <h2>Featured Products</h2>
                        <div class="Featured_item">
                            <div class="Featured_img">
                                <a href="#"><img src="assets/img/s-product/product5.jpg" alt=""></a>
                            </div>
                            <div class="Featured_info">
                                <h3><a href="#">Letraset animal</a></h3>
                                <div class="product_ratings">
                                    <ul>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                    </ul>
                                </div>
                                <div class="price_box">
                                    <span class="old_price">$65.00</span>
                                    <span class="current_price">$60.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="Featured_item">
                            <div class="Featured_img">
                                <a href="#"><img src="assets/img/s-product/product6.jpg" alt=""></a>
                            </div>
                            <div class="Featured_info">
                                <h3><a href="#">Donec eu furniture</a></h3>
                                <div class="product_ratings">
                                    <ul>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                    </ul>
                                </div>
                                <div class="price_box">
                                    <span class="old_price">$65.00</span>
                                    <span class="current_price">$60.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="Featured_item bottom">
                            <div class="Featured_img">
                                <a href="#"><img src="assets/img/s-product/product2.jpg" alt=""></a>
                            </div>
                            <div class="Featured_info">
                                <h3><a href="#">Letraset animal</a></h3>
                                <div class="product_ratings">
                                    <ul>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                    </ul>
                                </div>
                                <div class="price_box">
                                    <span class="old_price">$65.00</span>
                                    <span class="current_price">$60.00</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!--sidebar widget end-->
            </div>
            <div class="col-lg-9 col-md-12">
                <!--shop wrapper start-->
                <!--shop toolbar start-->
                <div class="shop_toolbar">
                    <div class="list_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-bs-toggle="tab" href="#large" role="tab" aria-controls="large" aria-selected="true"><i class="ion-grid"></i></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><i class="ion-ios-list-outline"></i> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="orderby_wrapper">
                        <h3>Sort By : </h3>
                        <div class=" niceselect_option">

                            <form class="select_option" action="#">

                                <select name="orderby" id="short">
                                    <option selected value="1">Sort by popularity</option>
                                    <option value="2">Sort by popularity</option>
                                    <option value="3">Sort by newness</option>
                                    <option value="4">Sort by price: low to high</option>
                                    <option value="5">Sort by price: high to low</option>
                                    <option value="6">Product Name: Z</option>
                                </select>
                            </form>


                        </div>
                        <div class="page_amount">
                            <p>Showing 1–9 of 21 results</p>
                        </div>
                    </div>
                </div>
                <!--shop toolbar end-->

                <!--shop tab product start-->
                  <!--shop tab product start-->

                  <div class="tab-content">
                    <div class="tab-pane grid_view fade show active" id="large" role="tabpanel">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6">
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
                                            @if ($product->category)
                                            <a href="{{ route('products', ['category' => $product->category->name]) }}">{{ $product->category->name }}</a>
                                            @endif
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
                                                    <li><a href="wishlist.html" data-placement="top" title="Add to Wishlist" data-bs-toggle="tooltip"><span class="icon icon-Heart"></span></a></li>
                                                    <li class="add_to_cart"><a href="cart.html" title="add to cart">add to cart</a></li>
                                                    <li><a href="compare.html" title="compare"><i class="ion-ios-settings-strong"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    <!--shop tab product end-->

                <!--shop wrapper end-->



            </div>
        </div>
    </div>
</div>
<!--shop  area end-->

<script>
    $(function() {
        // 1. Try to get the values from Local Storage
        var category = localStorage.getItem("category");
        var minPrice = localStorage.getItem("min_price");
        var maxPrice = localStorage.getItem("max_price");

        // 2. Get min/max from URL if set: Overwrites whatever is set!
        const urlParams = new URLSearchParams(window.location.search);
        const urlMinPrice = urlParams.get('min_price');
        const urlMaxPrice = urlParams.get('max_price');
        const urlCategory = urlParams.get('category');
        if (urlMinPrice) minPrice = urlMinPrice;
        if (urlMaxPrice) maxPrice = urlMaxPrice;
        if (urlCategory) category = urlCategory;
        // 3. Persist settings with Local Storage.
        if (urlMinPrice || urlMaxPrice || urlCategory) {
            localStorage.setItem("min_price", minPrice);
            localStorage.setItem("max_price", maxPrice);
            localStorage.setItem("category", category);
        }
        // Parse local storage values or default
        var minPriceNum = parseInt(minPrice) || 0;
        var maxPriceNum = parseInt(maxPrice) || 10000;

        // Set value to the dropdown - we don't use Local Storage by default.
        if (category) {
            $('select[name="category"]').val(category);
        }

        // Set the slider values
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [minPriceNum, maxPriceNum],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            },
            stop: function(event, ui) {
                // Trigger form submission on slider stop (mouseup)
                $(this).closest("form").submit();
            }
        });

        // Set default value on load
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));
    });
</script>


@include('layout.footer')