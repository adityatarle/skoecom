@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-1">
                                <i class="fas fa-eye me-2"></i>Category Details
                            </h3>
                            <p class="mb-0 opacity-90">
                                Detailed view of {{ $category->name }} category
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Category Information -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Category Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="fw-bold text-muted small">Category Name</label>
                                        <h4 class="mb-0">{{ $category->name }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="fw-bold text-muted small">Level</label>
                                        <div>
                                            @switch($category->level)
                                                @case(1)
                                                    <span class="badge bg-primary fs-6">Top Level</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge bg-success fs-6">Parent Category</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge bg-info fs-6">Child Category</span>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                                
                                @if($category->parent)
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <label class="fw-bold text-muted small">Parent Category</label>
                                            <div>
                                                <a href="{{ route('admin.category.show', $category->parent) }}" class="text-decoration-none">
                                                    <i class="fas fa-arrow-up me-1"></i>{{ $category->parent->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="fw-bold text-muted small">Status</label>
                                        <div>
                                            @if($category->is_active)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-pause me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($category->slug)
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <label class="fw-bold text-muted small">URL Slug</label>
                                            <div class="font-monospace text-muted">{{ $category->slug }}</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="fw-bold text-muted small">Sort Order</label>
                                        <div>{{ $category->sort_order }}</div>
                                    </div>
                                </div>

                                @if($category->description)
                                    <div class="col-12">
                                        <div class="info-item">
                                            <label class="fw-bold text-muted small">Description</label>
                                            <p class="mb-0">{{ $category->description }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($category->image)
                                    <div class="col-12">
                                        <div class="info-item">
                                            <label class="fw-bold text-muted small">Category Image</label>
                                            <div class="mt-2">
                                                <img src="{{ asset($category->image) }}" 
                                                     alt="{{ $category->name }}" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 300px; max-height: 300px;">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="col-lg-4">
                    <div class="row g-4">
                        <!-- Quick Stats -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-chart-bar me-2 text-success"></i>
                                        Statistics
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="h3 fw-bold text-primary mb-1">{{ $stats['direct_products'] }}</div>
                                                <small class="text-muted">Direct Products</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="h3 fw-bold text-success mb-1">{{ $stats['total_products'] }}</div>
                                                <small class="text-muted">Total Products</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="h3 fw-bold text-info mb-1">{{ $stats['child_categories'] }}</div>
                                                <small class="text-muted">Child Categories</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="h3 fw-bold text-warning mb-1">{{ $stats['total_descendants'] }}</div>
                                                <small class="text-muted">All Descendants</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Tree -->
                        @if($category->children->count() > 0)
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-bottom-0 py-3">
                                        <h5 class="card-title mb-0 fw-bold">
                                            <i class="fas fa-sitemap me-2 text-warning"></i>
                                            Child Categories
                                        </h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach($category->children as $child)
                                                <div class="list-group-item border-0 py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <a href="{{ route('admin.category.show', $child) }}" class="text-decoration-none fw-semibold">
                                                                {{ $child->name }}
                                                            </a>
                                                            <div class="small text-muted">
                                                                {{ $child->products->count() }} products
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if($child->is_active)
                                                                <span class="badge bg-success-subtle text-success">Active</span>
                                                            @else
                                                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-bolt me-2 text-primary"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Edit Category
                                        </a>
                                        @if($category->level < 3)
                                            <a href="{{ route('admin.category.create', ['level' => $category->level + 1, 'parent_id' => $category->id]) }}" class="btn btn-success">
                                                <i class="fas fa-plus me-2"></i>Add Child Category
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                            <i class="fas fa-box me-2"></i>Add Product
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Products in this Category -->
            @if($category->products->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-box me-2 text-success"></i>
                                        Products in this Category ({{ $category->products->count() }})
                                    </h5>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i>View All
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="px-4 py-3">Product</th>
                                                <th class="px-4 py-3">Price</th>
                                                <th class="px-4 py-3">Created</th>
                                                <th class="px-4 py-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->products->take(5) as $product)
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            @if($product->image_path)
                                                                <img src="{{ asset($product->image_path) }}" 
                                                                     alt="{{ $product->name }}" 
                                                                     class="me-3 img-thumbnail" 
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="me-3 bg-light d-flex align-items-center justify-content-center" 
                                                                     style="width: 50px; height: 50px; border-radius: 0.375rem;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                                @if($product->description)
                                                                    <small class="text-muted">{{ Str::limit(strip_tags($product->description), 50) }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    display: block;
    margin-bottom: 0.25rem;
}

.bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
.bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
</style>

@include('dashboard.layout.footer')