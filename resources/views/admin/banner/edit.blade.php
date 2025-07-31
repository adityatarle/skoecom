@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Edit Homepage Banner</h2>
    <form action="{{ route('admin.banner.update', $banner) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-bold">Banner Image</label><br>
            <img src="{{ asset($banner->image) }}" alt="Banner" style="width:180px;max-height:80px;object-fit:cover;" class="mb-2">
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Leave blank to keep current image.</small>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Title *</label>
            <input type="text" name="title" class="form-control" value="{{ $banner->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ $banner->subtitle }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Button Text</label>
            <input type="text" name="button_text" class="form-control" value="{{ $banner->button_text }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Button URL</label>
            <input type="text" name="button_url" class="form-control" value="{{ $banner->button_url }}">
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-success">Update Banner</button>
        </div>
    </form>
</div>
@include('dashboard.layout.footer')