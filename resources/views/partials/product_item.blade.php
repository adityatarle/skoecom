<div class="custom-col-5">
    <div class="single_product">
        <div class="product_thumb">
            <a class="primary_img" href="{{ route('product.details', $product->id) }}">
                <img src="{{ asset('uploads/' . $product->image_path) }}" alt="{{ $product->name }}">
            </a>
            <div class="quick_button">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box">Quick View</a>
            </div>
        </div>
        <div class="product_content">
            <div class="tag_cate">
                <a href="#">{{ $product->category->name ?? 'Uncategorized' }}</a>
            </div>
            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
            <div class="price_box">
                <span class="current_price">${{ number_format($product->price, 2) }}</span>
            </div>
            <div class="product_hover">
                <div class="product_ratings">
                    <ul>
                        @php
                        $averageRating = isset($reviews[$product->id]) ? (int) $reviews[$product->id]->avg('rating') : 0;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                        <li>
                            <a href="#">
                                <i class="ion-ios-star{{ $i <= $averageRating ? '' : '-outline' }}"></i>
                            </a>
                        </li>
                        @endfor
                    </ul>
                </div>
                <div class="product_desc">
                    <p>{{ Str::limit($product->short_description, 100) }}</p>
                </div>
                <div class="action_links">
                    <ul>
                        <li><a href="#" title="Add to Wishlist"><span class="icon icon-Heart"></span></a></li>
                        <li class="add_to_cart"><a href="cart.html" title="Add to Cart">Add to Cart</a></li>
                        <li><a href="compare.html" title="Compare"><i class="ion-ios-settings-strong"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
