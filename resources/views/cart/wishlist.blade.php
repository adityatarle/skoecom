@include('layout.header')

<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3>Wishlist</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">home</a></li>
                        <li>></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--wishlist area start -->
<div class="wishlist_area">
    <div class="container">
        <form action="#">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc wishlist">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Stock Status</th>
                                        <th class="product_total">Add To Cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($wishlistItems) > 0)
                                    @if (Auth::check())
                                    @foreach($wishlistItems as $item)
                                    <tr>
                                        <td class="product_remove">
                                            <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">X</button>
                                            </form>
                                        </td>
                                        <td class="product_thumb">
                                            <a href="{{ route('product.details', $item->product->id) }}">
                                                <img src="{{ $item->product->images->first() ? asset($item->product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $item->product->name }}">
                                            </a>
                                        </td>
                                        <td class="product_name"><a href="{{ route('product.details', $item->product->id) }}">{{ $item->product->name }}</a></td>
                                        <td class="product-price">₹{{ number_format($item->product->price, 2) }}</td>
                                        <td class="product_quantity">In Stock</td>
                                        <td class="product_total"><a href="{{ route('cart.add', $item->product->id) }}">Add To Cart</a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    @foreach($wishlistItems as $key => $item)
                                    <tr>
                                        <td class="product_remove">
                                            <form action="{{ route('wishlist.remove', $key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">X</button>
                                            </form>
                                        </td>
                                        <td class="product_thumb">
                                            <a href="#">
                                                <img src="{{ isset($item['image']) ? asset($item['image']) : asset('images/no-image.png') }}" alt="{{ $item['name'] }}">
                                            </a>
                                        </td>
                                        <td class="product_name"><a href="#">{{ $item['name'] }}</a></td>
                                        <td class="product-price">₹{{ number_format($item['price'], 2) }}</td>
                                        <td class="product_quantity">In Stock</td>
                                        <td class="product_total"><a href="#">Add To Cart</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @else
                                    <tr>
                                        <td colspan="6">Your wishlist is empty.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col-12">
                <div class="wishlist_share">
                    <h4>Share on:</h4>
                    <ul>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                        <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>


@include('layout.footer')