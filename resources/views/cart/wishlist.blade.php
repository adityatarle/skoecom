@include('layout.header')

<style>
    /* Breadcrumbs (Reused from Account Page) */
    .elegant-breadcrumbs {
        background: linear-gradient(135deg, #b89f7e 0%, #f0ebe7 100%);
        padding: 20px 0;
        border-bottom: 1px solid rgba(184, 159, 126, 0.2);
    }

    .jewel-title {
        font-size: 2.5rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .breadcrumb_content ul li {
        font-size: 0.9rem;
        color: #666;
    }

    .breadcrumb_content ul li a {
        text-decoration: none;
    }

    .breadcrumb_content ul li a:hover {
        text-decoration: underline;
    }

    /* Wishlist Area */
    .jewel-wishlist {
        padding: 50px 0;
        background-color: #f0ebe7;
    }

    .jewel-table-wrapper {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
    }

    /* Table */
    .jewel-table {
        width: 100%;
        border-collapse: collapse;
    }

    .jewel-table th {
        color: #333;
        background: rgba(184, 159, 126, 0.1);
        border-bottom: 2px solid #b89f7e;
        padding: 15px;
        text-align: center;
    }

    .jewel-table td {
        padding: 15px;
        color: #666;
        text-align: center;
        vertical-align: middle;
    }

    .jewel-row {
        border-bottom: 1px solid #f0ebe7;
    }

    .jewel-row:hover {
        background: rgba(184, 159, 126, 0.05);
    }

    /* Remove Button */
    .jewel-remove-btn {
        background: none;
        border: none;
        color: #b89f7e;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .jewel-remove-btn:hover {
        color: #9b8465;
    }

    /* Image */
    .jewel-img {
        max-width: 80px;
        border-radius: 5px;
        border: 1px solid #f0ebe7;
    }

    /* Product Link */
    .jewel-link {
        color: #b89f7e;
        text-decoration: none;
    }

    .jewel-link:hover {
        color: #9b8465;
        text-decoration: underline;
    }

    /* Stock Status */
    .jewel-stock {
        color: #b89f7e;
        font-weight: bold;
    }

    /* Add to Cart Button */
    .jewel-btn {
        display: inline-block;
        padding: 8px 20px;
        background: #b89f7e;
        color: #fff;
        border-radius: 5px;
        text-transform: uppercase;
        font-size: 0.9rem;
        border: none;
    }

    .jewel-btn:hover {
        background: #9b8465;
        color: #fff;
        box-shadow: 0 2px 10px rgba(184, 159, 126, 0.3);
    }

    /* Empty Wishlist */
    .jewel-empty {
        font-size: 1.5rem;
        color: #666;
        padding: 40px;
        text-align: center;
    }

    /* Share Section */
    .jewel-share {
        margin-top: 30px;
        text-align: center;
    }

    .jewel-heading {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        position: relative;
    }

    .jewel-heading::after {
        content: '';
        width: 50px;
        height: 2px;
        background: #b89f7e;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .jewel-share ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .jewel-share-icon {
        color: #b89f7e;
        font-size: 1.2rem;
    }

    .jewel-share-icon:hover {
        color: #9b8465;
    }
</style>


<!-- Breadcrumbs Area -->
<div class="breadcrumbs_area elegant-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3 class="jewel-title">Your Wishlist</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wishlist Area -->
<div class="wishlist_area jewel-wishlist">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table_desc modern-wishlist jewel-table-wrapper">
                    <div class="wishlist_page table-responsive">
                        <table class="jewelry-wishlist-table jewel-table">
                            <thead>
                                <tr>
                                    <th class="product_remove">Remove</th>
                                    <th class="product_thumb1">Preview</th>
                                    <th class="product_name">Jewelry</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Stock</th>
                                    <th class="product_total">Add to Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($wishlistItems))
                                    @if (Auth::check())
                                        @foreach($wishlistItems as $item)
                                            <tr class="wishlist-item-row jewel-row">
                                                <td class="product_remove">
                                                    <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="remove-btn jewel-remove-btn"><i class="fa fa-times"></i></button>
                                                    </form>
                                                </td>
                                                <td class="product_thumb1">
                                                    <a href="{{ route('product.details', $item->product->id) }}">
                                                        <img src="{{ $item->product->images->first() ? asset($item->product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $item->product->name }}" class="wishlist-img jewel-img">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="{{ route('product.details', $item->product->id) }}" class="product-link jewel-link">{{ $item->product->name }}</a>
                                                </td>
                                                <td class="product-price">₹{{ number_format($item->product->price, 2) }}</td>
                                                <td class="product_quantity stock-status jewel-stock">In Stock</td>
                                                <td class="product_total">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                        <button type="submit" class="btn subtle-btn add-to-cart-btn jewel-btn">Add to Cart</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach($wishlistItems as $key => $item)
                                            <tr class="wishlist-item-row jewel-row">
                                                <td class="product_remove">
                                                    <form action="{{ route('wishlist.remove', $key) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="remove-btn jewel-remove-btn"><i class="fa fa-times"></i></button>
                                                    </form>
                                                </td>
                                                <td class="product_thumb1">
                                                    <a href="{{ route('product.details', $key) }}">
                                                        <img src="{{ isset($item['image']) ? asset($item['image']) : asset('images/no-image.png') }}" alt="{{ $item['name'] ?? 'Product' }}" class="wishlist-img jewel-img">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="{{ route('product.details', $key) }}" class="product-link jewel-link">{{ $item['name'] ?? 'Unknown Product' }}</a>
                                                </td>
                                                <td class="product-price">₹{{ number_format($item['price'] ?? 0, 2) }}</td>
                                                <td class="product_quantity stock-status jewel-stock">In Stock</td>
                                                <td class="product_total">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $key }}">
                                                        <button type="submit" class="btn subtle-btn add-to-cart-btn jewel-btn">Add to Cart</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @else
                                    <tr>
                                        <td colspan="6" class="empty-wishlist jewel-empty">Your wishlist is longing for treasures.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist Share Section -->
        <div class="row">
            <div class="col-12">
                <div class="wishlist_share elegant-share jewel-share">
                    <h4 class="jewel-heading">Share Your Wishlist:</h4>
                    <ul>
                        <li><a href="#" class="share-icon jewel-share-icon"><i class="fa-brands fa-telegram"></i></a></li>
                        <li><a href="#" class="share-icon jewel-share-icon"><i class="fa-solid fa-envelope"></i></a></li>
                        <li><a href="#" class="share-icon jewel-share-icon"><i class="fa-brands fa-whatsapp"></i></a></li>
                        <li><a href="#" class="share-icon jewel-share-icon"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#" class="share-icon jewel-share-icon"><i class="fa-brands fa-facebook"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('submit', '.add-to-cart-form', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let addButton = form.find('.add-to-cart-btn');
            let originalButtonText = addButton.text();
            addButton.prop('disabled', true).text('Adding...');
            $.post(form.attr('action'), formData, function(response) {
                if (response.status === 'success') {
                    $('#cart_count').text(response.cart_count);
                    addButton.text('Added!');
                    setTimeout(function() {
                        addButton.prop('disabled', false).text(originalButtonText);
                    }, 1500);
                } else {
                    alert(response.message || 'Something went wrong!');
                    addButton.prop('disabled', false).text(originalButtonText);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                alert('Error adding item to cart. Please try again.');
                addButton.prop('disabled', false).text(originalButtonText);
            });
        });
    });
</script>

@include('layout.footer')