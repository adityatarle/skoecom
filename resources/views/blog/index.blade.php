@php
use App\Models\Setting;
$seo_title = Setting::get('seo_blog_title', 'Blog - ' . config('app.name'));
$seo_desc = Setting::get('seo_blog_description', '');
$seo_keywords = Setting::get('seo_blog_keywords', '');
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
        .blog-card { border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: box-shadow 0.2s; }
        .blog-card:hover { box-shadow: 0 6px 24px rgba(102,126,234,0.12); }
        .blog-img { width: 100%; height: 180px; object-fit: cover; border-radius: 1rem 1rem 0 0; }
    </style>
</head>
<body>
@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center">Our Blog</h2>
    <div class="row g-4">
        @forelse($blogs as $blog)
            <div class="col-md-4">
                <div class="card blog-card h-100">
                    @if($blog->image)
                        <img src="{{ asset($blog->image) }}" class="blog-img" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <div class="mb-2 text-muted">{{ Str::limit(strip_tags($blog->content), 120) }}</div>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No blog posts yet.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $blogs->links() }}</div>
</div>
@include('dashboard.layout.footer')
</body>
</html>