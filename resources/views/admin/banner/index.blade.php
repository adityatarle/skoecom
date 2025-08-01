@extends('dashboard.layout.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Banner Management</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Banner
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Button</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                            <tr>
                                <td>
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" 
                                         style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td>
                                    <span class="badge bg-{{ $banner->type == 'slider' ? 'primary' : ($banner->type == 'fullwidth' ? 'success' : 'info') }}">
                                        {{ ucfirst($banner->type) }}
                                    </span>
                                </td>
                                <td>{{ $banner->title ?? 'N/A' }}</td>
                                <td>{{ $banner->subtitle ?? 'N/A' }}</td>
                                <td>
                                    @if($banner->button_text)
                                        <span class="badge bg-secondary">{{ $banner->button_text }}</span>
                                    @else
                                        <span class="text-muted">No button</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.banner.toggle-status', $banner) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $banner->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $banner->sort_order }}</td>
                                <td>
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
@endsection