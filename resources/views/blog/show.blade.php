@php
$meta_title = $blog->meta_title ?: $blog->title;
$meta_desc = $blog->meta_description ?: Str::limit(strip_tags($blog->content), 150);
$meta_keywords = $blog->meta_keywords ?: '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $meta_title }}</title>
    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}">
    <meta property="og:title" content="{{ $meta_title }}">
    <meta property="og:description" content="{{ $meta_desc }}">
    <meta property="og:type" content="article">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .blog-img { width: 100%; max-height: 350px; object-fit: cover; border-radius: 1rem; margin-bottom: 2rem; }
        .blog-content { font-size: 1.1rem; line-height: 1.7; }
    </style>
</head>
<body>
@include('dashboard.layout.header')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm p-4">
                @if($blog->image)
                    <img src="{{ asset($blog->image) }}" class="blog-img" alt="{{ $blog->title }}">
                @endif
                <h1 class="fw-bold mb-3">{{ $blog->title }}</h1>
                <div class="blog-content">{!! $blog->content !!}</div>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary mt-4"><i class="fas fa-arrow-left me-1"></i> Back to Blog</a>
            </div>
        </div>
    </div>
</div>
@include('dashboard.layout.footer')
</body>
</html>