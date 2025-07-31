@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Edit Blog Post</h2>
    <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-bold">Blog Image</label><br>
            @if($blog->image)
                <img src="{{ asset($blog->image) }}" alt="Blog" style="width:140px;max-height:80px;object-fit:cover;" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Leave blank to keep current image.</small>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Title *</label>
            <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Content *</label>
            <textarea name="content" class="form-control" rows="7" required>{{ $blog->content }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ $blog->meta_title }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Description</label>
            <input type="text" name="meta_description" class="form-control" value="{{ $blog->meta_description }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control" value="{{ $blog->meta_keywords }}">
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-success">Update Blog</button>
        </div>
    </form>
</div>
@include('dashboard.layout.footer')