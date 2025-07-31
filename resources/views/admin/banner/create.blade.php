@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Add Homepage Banner</h2>
    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Banner Image *</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Title *</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Subtitle</label>
            <input type="text" name="subtitle" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Button Text</label>
            <input type="text" name="button_text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Button URL</label>
            <input type="text" name="button_url" class="form-control">
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-success">Save Banner</button>
        </div>
    </form>
</div>
@include('dashboard.layout.footer')