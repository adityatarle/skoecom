@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-warning text-white py-3">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Subcategory
                    </h3>
                </div>
                <div class="card-body p-4">
                    <!-- Show validation errors -->
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

                    <form action="{{ route('admin.subcategory.update', $subcategory) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-tag me-1"></i>Subcategory Name *
                            </label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg" 
                                   required value="{{ old('name', $subcategory->name) }}" placeholder="Enter subcategory name">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-bold">
                                <i class="fas fa-folder me-1"></i>Parent Category *
                            </label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                <option value="">Select Parent Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="parent_subcategory_id" class="form-label fw-bold">
                                <i class="fas fa-sitemap me-1"></i>Parent Subcategory (Optional)
                            </label>
                            <select name="parent_subcategory_id" id="parent_subcategory_id" class="form-select form-select-lg">
                                <option value="">None (Top Level Subcategory)</option>
                                @foreach($parentSubcategories as $parentSubcategory)
                                    <option value="{{ $parentSubcategory->id }}" {{ old('parent_subcategory_id', $subcategory->parent_subcategory_id) == $parentSubcategory->id ? 'selected' : '' }}>
                                        {{ $parentSubcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Leave empty to make this a top-level subcategory, or select a parent to nest it.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label fw-bold">
                                <i class="fas fa-image me-1"></i>Image
                            </label>
                            <input type="file" name="image" id="image" class="form-control form-control-lg" accept="image/*">
                            @if($subcategory->image)
                                <div class="mt-2">
                                    <small class="text-muted">Current image:</small><br>
                                    <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}" 
                                         class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB. Leave empty to keep current image.
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-warning btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Update Subcategory
                                </button>
                                <a href="{{ route('admin.subcategory.index') }}" class="btn btn-secondary btn-lg px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')
