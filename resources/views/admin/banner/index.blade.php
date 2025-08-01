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
                                <i class="fas fa-image me-2"></i>Banner Management
                            </h3>
                            <small class="opacity-90">Manage homepage banners, sliders, and promotional content</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('admin.banner.create') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus me-1"></i>Add New Banner
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banners Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="px-4 py-3">Image</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Title</th>
                                    <th class="px-4 py-3">Subtitle</th>
                                    <th class="px-4 py-3">Button</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Order</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                <tr>
                                    <td class="px-4 py-3">
                                        <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" 
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-{{ $banner->type == 'slider' ? 'primary' : ($banner->type == 'fullwidth' ? 'success' : 'info') }}">
                                            {{ ucfirst($banner->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $banner->title ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $banner->subtitle ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($banner->button_text)
                                            <span class="badge bg-secondary">{{ $banner->button_text }}</span>
                                        @else
                                            <span class="text-muted">No button</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('admin.banner.toggle-status', $banner) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $banner->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3">{{ $banner->sort_order }}</td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.banner.edit', $banner) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.banner.destroy', $banner) }}" method="POST" 
                                                  style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>No banners found. Create your first banner!</p>
                                        </div>
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