@php
use App\Models\Banner;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Blog;
$banner = Banner::first();
$featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
$topRatedProducts = Product::where('is_top_rated', true)->latest()->take(8)->get();
$contact_address = Setting::get('contact_address');
$contact_phone = Setting::get('contact_phone');
$contact_email = Setting::get('contact_email');
$seo_title = Setting::get('seo_home_title', config('app.name'));
$seo_desc = Setting::get('seo_home_description', '');
$seo_keywords = Setting::get('seo_home_keywords', '');
$blogs = Blog::latest()->take(3)->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $seo_title }}</title>
    <meta name="description" content="{{ $seo_desc }}">
    <meta name="keywords" content="{{ $seo_keywords }}">
    <meta property="og:title" content="{{ $seo_title }}">
    <meta property="og:description" content="{{ $seo_desc }}">
    <meta property="og:type" content="website">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .banner-section { background: #f8f9fa; padding: 3rem 0; text-align: center; }
        .banner-section img { max-width: 100%; max-height: 350px; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .banner-title { font-size: 2.5rem; font-weight: 700; margin-top: 2rem; }
        .banner-subtitle { font-size: 1.25rem; color: #6c757d; margin-bottom: 1.5rem; }
        .section-title { font-size: 2rem; font-weight: 600; margin: 2.5rem 0 1.5rem; text-align: center; }
        .product-card { border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: box-shadow 0.2s; }
        .product-card:hover { box-shadow: 0 6px 24px rgba(102,126,234,0.12); }
        .product-img { width: 100%; height: 180px; object-fit: cover; border-radius: 1rem 1rem 0 0; }
        .blog-card { border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: box-shadow 0.2s; }
        .blog-card:hover { box-shadow: 0 6px 24px rgba(102,126,234,0.12); }
        .blog-img { width: 100%; height: 140px; object-fit: cover; border-radius: 1rem 1rem 0 0; }
        .contact-box { background: #f1f3f6; border-radius: 1rem; padding: 2rem; margin-top: 2rem; }
    </style>
</head>
<body>
@include('dashboard.layout.header')
<div class="banner-section">
    @if($banner)
        <img src="{{ asset($banner->image) }}" alt="Banner">
        <div class="banner-title">{{ $banner->title }}</div>
        @if($banner->subtitle)
            <div class="banner-subtitle">{{ $banner->subtitle }}</div>
        @endif
        @if($banner->button_text && $banner->button_url)
            <a href="{{ $banner->button_url }}" class="btn btn-primary btn-lg mt-2">{{ $banner->button_text }}</a>
        @endif
    @else
        <div class="banner-title">Welcome to {{ config('app.name') }}</div>
        <div class="banner-subtitle">Your one-stop shop for the best products!</div>
    @endif
</div>
<div class="container">
    <div class="section-title">Featured Products</div>
    <div class="row g-4">
        @forelse($featuredProducts as $product)
            <div class="col-md-3">
                <div class="card product-card h-100">
                    @if($product->images && count($product->images))
                        <img src="{{ asset($product->images[0]->image_path) }}" class="product-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x180?text=No+Image" class="product-img" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2 text-primary fw-bold">₹{{ number_format($product->price,2) }}</div>
                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-outline-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No featured products yet.</div>
        @endforelse
    </div>
    <div class="section-title">Top Rated Items</div>
    <div class="row g-4">
        @forelse($topRatedProducts as $product)
            <div class="col-md-3">
                <div class="card product-card h-100">
                    @if($product->images && count($product->images))
                        <img src="{{ asset($product->images[0]->image_path) }}" class="product-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x180?text=No+Image" class="product-img" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2 text-primary fw-bold">₹{{ number_format($product->price,2) }}</div>
                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-outline-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No top rated products yet.</div>
        @endforelse
    </div>
    <div class="section-title">Latest Blogs</div>
    <div class="row g-4">
        @forelse($blogs as $blog)
            <div class="col-md-4">
                <div class="card blog-card h-100">
                    @if($blog->image)
                        <img src="{{ asset($blog->image) }}" class="blog-img" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <div class="mb-2 text-muted">{{ Str::limit(strip_tags($blog->content), 100) }}</div>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No blog posts yet.</div>
        @endforelse
    </div>
    <div class="section-title">Contact Us</div>
    <div class="contact-box">
        <div class="row">
            <div class="col-md-4 mb-2"><i class="fas fa-map-marker-alt me-2"></i> <strong>Address:</strong> {{ $contact_address ?: 'Not set' }}</div>
            <div class="col-md-4 mb-2"><i class="fas fa-phone me-2"></i> <strong>Phone:</strong> {{ $contact_phone ?: 'Not set' }}</div>
            <div class="col-md-4 mb-2"><i class="fas fa-envelope me-2"></i> <strong>Email:</strong> {{ $contact_email ?: 'Not set' }}</div>
        </div>
    </div>
</div>
@include('dashboard.layout.footer')
</body>
</html>