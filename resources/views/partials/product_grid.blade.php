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