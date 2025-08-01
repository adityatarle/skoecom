@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-plus me-2"></i>Create New Banner
                            </h3>
                            <small class="opacity-90">Add a new banner for your homepage</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('admin.banner.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back to Banners
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label fw-bold">Banner Type *</label>
                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select Banner Type</option>
                                        <option value="slider" {{ old('type') == 'slider' ? 'selected' : '' }}>Slider Banner</option>
                                        <option value="fullwidth" {{ old('type') == 'fullwidth' ? 'selected' : '' }}>Full Width Banner</option>
                                        <option value="newsletter" {{ old('type') == 'newsletter' ? 'selected' : '' }}>Newsletter Banner</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Banner Image *</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*" required>
                            <div class="form-text">Recommended size: 1920x600px for slider, 1200x400px for fullwidth</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Title</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}" placeholder="Enter banner title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtitle" class="form-label fw-bold">Subtitle</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" 
                                           value="{{ old('subtitle') }}" placeholder="Enter banner subtitle">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Enter banner description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label fw-bold">Button Text</label>
                                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" 
                                           value="{{ old('button_text') }}" placeholder="e.g., Shop Now">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_url" class="form-label fw-bold">Button URL</label>
                                    <input type="url" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" 
                                           value="{{ old('button_url') }}" placeholder="https://example.com">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price_text" class="form-label fw-bold">Price Text (for slider)</label>
                                    <input type="text" name="price_text" id="price_text" class="form-control @error('price_text') is-invalid @enderror" 
                                           value="{{ old('price_text') }}" placeholder="e.g., starting at $2,199.00">
                                    @error('price_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active Banner
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')