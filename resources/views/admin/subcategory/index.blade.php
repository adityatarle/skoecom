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
                                <i class="fas fa-sitemap me-2"></i>Subcategories Management
                            </h3>
                            <p class="mb-0 opacity-90">
                                Manage your product subcategories and nested subcategories
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-plus me-1"></i>Add Subcategory
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.subcategory.create') }}">
                                        <i class="fas fa-plus me-2 text-primary"></i>Add Main Subcategory
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.subcategory.create', ['parent_level' => true]) }}">
                                        <i class="fas fa-plus me-2 text-success"></i>Add Nested Subcategory
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-layer-group fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ $subcategories->where('parent_subcategory_id', null)->count() }}</h4>
                            <small>Main Subcategories</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-sitemap fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ $subcategories->where('parent_subcategory_id', '!=', null)->count() }}</h4>
                            <small>Nested Subcategories</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-tags fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ $subcategories->count() }}</h4>
                            <small>Total Subcategories</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ $subcategories->sum(function($sub) { return $sub->products->count(); }) }}</h4>
                            <small>Products Assigned</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subcategories Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-list me-2 text-primary"></i>
                            All Subcategories ({{ $subcategories->count() }})
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" class="form-control" placeholder="Search subcategories..." id="searchInput">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($subcategories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="subcategoriesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">Image</th>
                                        <th class="px-4 py-3">Name & Hierarchy</th>
                                        <th class="px-4 py-3">Category</th>
                                        <th class="px-4 py-3">Level</th>
                                        <th class="px-4 py-3">Products</th>
                                        <th class="px-4 py-3">Created</th>
                                        <th class="px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategories as $subcategory)
                                        <tr>
                                            <td class="px-4 py-3">
                                                @if($subcategory->image)
                                                    <img src="{{ asset($subcategory->image) }}" 
                                                         alt="{{ $subcategory->name }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 0.375rem;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($subcategory->parent_subcategory_id)
                                                        <span class="text-muted me-2">└──</span>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $subcategory->name }}</h6>
                                                        @if($subcategory->parentSubcategory)
                                                            <small class="text-muted">
                                                                Child of: {{ $subcategory->parentSubcategory->name }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-primary">{{ $subcategory->category->name }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($subcategory->parent_subcategory_id)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-sitemap me-1"></i>Nested
                                                    </span>
                                                @else
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-layer-group me-1"></i>Main
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-warning text-dark">
                                                    {{ $subcategory->products->count() }} Products
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <small class="text-muted">{{ $subcategory->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.subcategory.show', $subcategory) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.subcategory.edit', $subcategory) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(!$subcategory->parent_subcategory_id)
                                                        <a href="{{ route('admin.subcategory.create', ['parent_id' => $subcategory->id]) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Add Child Subcategory">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('admin.subcategory.destroy', $subcategory) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Subcategories Found</h5>
                            <p class="text-muted">Create your first subcategory to get started.</p>
                            <div class="mt-3">
                                <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Subcategory
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#subcategoriesTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Auto-dismiss alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<style>
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 2px;
}

.table th {
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.img-thumbnail {
    border: 2px solid #e9ecef;
}
</style>

@include('dashboard.layout.footer')
