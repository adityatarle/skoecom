@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-info text-white py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-sitemap me-2"></i>Subcategories Management
                    </h3>
                    <a href="{{ route('admin.subcategory.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>Add New Subcategory
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-hashtag me-1"></i>ID
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-image me-1"></i>Image
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-tag me-1"></i>Name
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-folder me-1"></i>Category
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-sitemap me-1"></i>Parent Subcategory
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-layer-group me-1"></i>Level
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-cogs me-1"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subcategories as $subcategory)
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $subcategory->id }}</td>
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
                                            @if($subcategory->parent_subcategory_id)
                                                <span class="text-muted me-2">└─</span>
                                            @endif
                                            <span class="fw-semibold">{{ $subcategory->name }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">{{ $subcategory->category->name }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($subcategory->parentSubcategory)
                                                <span class="badge bg-secondary">{{ $subcategory->parentSubcategory->name }}</span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>Top Level
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($subcategory->parent_subcategory_id)
                                                <span class="badge bg-info">Level 2</span>
                                            @else
                                                <span class="badge bg-success">Level 1</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.subcategory.edit', $subcategory) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-5 text-center text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted opacity-50"></i>
                                            <h5>No subcategories found</h5>
                                            <p class="mb-0">Get started by creating your first subcategory.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')
