@include('dashboard.layout.header')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Homepage Banners</h2>
        <a href="{{ route('admin.banner.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> Add Banner</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Button</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td><img src="{{ asset($banner->image) }}" alt="Banner" style="width:120px;max-height:60px;object-fit:cover;"></td>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $banner->subtitle }}</td>
                            <td>{{ $banner->button_text }}</td>
                            <td>
                                <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.banner.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No banners found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('dashboard.layout.footer')