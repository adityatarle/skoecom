@include('dashboard.layout.header')

<div class="container" style="background-color: white; color: black;">
    <h1>Product Category Items</h1>
    <a href="{{ route('admin.category.create') }}" class="btn btn-primary mb-3">Add New Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($categories->isEmpty())
        <p>No product categories found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->image)
                                 <img src="{{ asset($category->image) }}" alt="Category Image" style="max-width: 100px; max-height: 100px;">
                            @else
                                  <img src="{{ asset('images/no-image.jpg') }}" alt="Default Category Image" style="max-width: 100px; max-height: 100px;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@include('dashboard.layout.footer')