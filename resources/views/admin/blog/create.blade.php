@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Add Blog Post</h2>
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Blog Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Title *</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Content *</label>
            <textarea name="content" class="form-control" rows="7" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Title</label>
            <input type="text" name="meta_title" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Description</label>
            <input type="text" name="meta_description" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control">
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-success">Save Blog</button>
        </div>
    </form>
</div>
@include('dashboard.layout.footer')