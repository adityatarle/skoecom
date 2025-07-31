@php
use App\Models\Setting;
$page_title = $title;
$page_content = Setting::get($setting_key, '');
$meta_title = $seo_title ?? $page_title;
$meta_desc = $seo_desc ?? Str::limit(strip_tags($page_content), 150);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $meta_title }}</title>
    <meta name="description" content="{{ $meta_desc }}">
    <meta property="og:title" content="{{ $meta_title }}">
    <meta property="og:description" content="{{ $meta_desc }}">
    <meta property="og:type" content="article">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .static-content { font-size: 1.1rem; line-height: 1.7; background: #fff; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 2rem; margin-top: 2rem; }
    </style>
</head>
<body>
@include('dashboard.layout.header')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="static-content">
                <h1 class="fw-bold mb-3">{{ $page_title }}</h1>
                {!! $page_content !!}
            </div>
        </div>
    </div>
</div>
@include('dashboard.layout.footer')
</body>
</html>