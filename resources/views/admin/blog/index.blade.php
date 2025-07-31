@include('dashboard.layout.header')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Blog Posts</h2>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> Add Blog</a>
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
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>@if($blog->image)<img src="{{ asset($blog->image) }}" alt="Blog" style="width:100px;max-height:60px;object-fit:cover;">@endif</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->slug }}</td>
                            <td>
                                <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No blogs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $blogs->links() }}</div>
</div>
@include('dashboard.layout.footer')