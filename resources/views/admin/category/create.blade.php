@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-success text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="card-title mb-1">
                                <i class="fas fa-plus-circle me-2"></i>Create New Category
                            </h3>
                            <p class="mb-0 opacity-90">
                                @switch($level)
                                    @case(1)
                                        Creating a Top Level Category
                                        @break
                                    @case(2)
                                        Creating a Parent Category
                                        @break
                                    @case(3)
                                        Creating a Child Category
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            @switch($level)
                                @case(1)
                                    <span class="badge bg-light text-dark fs-6">Level 1</span>
                                    @break
                                @case(2)
                                    <span class="badge bg-light text-dark fs-6">Level 2</span>
                                    @break
                                @case(3)
                                    <span class="badge bg-light text-dark fs-6">Level 3</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="level" value="{{ $level }}">

                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-header bg-transparent border-0 pb-0">
                                        <h5 class="card-title text-primary">
                                            <i class="fas fa-info-circle me-2"></i>Basic Information
                                        </h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label for="name" class="form-label fw-bold">
                                                    <i class="fas fa-tag me-1"></i>Category Name *
                                                </label>
                                                <input type="text" 
                                                       name="name" 
                                                       id="name" 
                                                       class="form-control form-control-lg" 
                                                       required 
                                                       value="{{ old('name') }}" 
                                                       placeholder="Enter category name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sort_order" class="form-label fw-bold">
                                                    <i class="fas fa-sort me-1"></i>Sort Order
                                                </label>
                                                <input type="number" 
                                                       name="sort_order" 
                                                       id="sort_order" 
                                                       class="form-control form-control-lg" 
                                                       value="{{ old('sort_order', 0) }}" 
                                                       min="0"
                                                       placeholder="0">
                                            </div>
                                            <div class="col-12">
                                                <label for="description" class="form-label fw-bold">
                                                    <i class="fas fa-align-left me-1"></i>Description
                                                </label>
                                                <textarea name="description" 
                                                          id="description" 
                                                          class="form-control" 
                                                          rows="3" 
                                                          placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hierarchy -->
                            @if($level > 1)
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-header bg-transparent border-0 pb-0">
                                            <h5 class="card-title text-warning">
                                                <i class="fas fa-sitemap me-2"></i>Category Hierarchy
                                            </h5>
                                        </div>
                                        <div class="card-body pt-2">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="parent_id" class="form-label fw-bold">
                                                        <i class="fas fa-arrow-up me-1"></i>
                                                        @if($level == 2)
                                                            Parent Category (Top Level) *
                                                        @else
                                                            Parent Category *
                                                        @endif
                                                    </label>
                                                    <select name="parent_id" id="parent_id" class="form-select form-select-lg" required>
                                                        <option value="">Select Parent Category</option>
                                                        @foreach($parentCategories as $parent)
                                                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                                {{ $parent->name }}
                                                                @if($parent->description)
                                                                    - {{ Str::limit($parent->description, 50) }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        @if($level == 2)
                                                            This category will be a child of the selected top-level category.
                                                        @else
                                                            This category will be a child of the selected parent category.
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Image & Settings -->
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-header bg-transparent border-0 pb-0">
                                        <h5 class="card-title text-info">
                                            <i class="fas fa-cog me-2"></i>Image & Settings
                                        </h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label for="image" class="form-label fw-bold">
                                                    <i class="fas fa-image me-1"></i>Category Image
                                                </label>
                                                <input type="file" 
                                                       name="image" 
                                                       id="image" 
                                                       class="form-control form-control-lg" 
                                                       accept="image/*"
                                                       onchange="previewImage(this)">
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Supported formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB
                                                </div>
                                                <div id="image-preview" class="mt-3" style="display: none;">
                                                    <img id="preview-img" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-toggle-on me-1"></i>Status
                                                </label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           name="is_active" 
                                                           id="is_active" 
                                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active Category
                                                    </label>
                                                </div>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Inactive categories won't be displayed on the website
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary btn-lg px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg px-4">
                                        <i class="fas fa-save me-2"></i>Create Category
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Auto-generate slug from name (for future use)
document.getElementById('name').addEventListener('input', function() {
    // This could be used to show a preview of the slug
    const name = this.value;
    const slug = name.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
    // Could display slug preview here
});
</script>

@include('dashboard.layout.footer')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.js"></script>

