@include('dashboard.layout.header')

<div class="container">
    <h1>Subcategories</h1>
    <a href="{{ route('admin.subcategory.create') }}" class="mb-3 btn btn-primary">Add New Subcategory</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($subcategories->isEmpty())
        <p>No subcategories found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Parent Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name ?? 'N/A' }}</td>
                        <td>
                            @if($subcategory->image)
                                <img src="{{ asset($subcategory->image) }}" alt="Subcategory Image" style="max-width: 100px;">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" alt="Default Image" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.subcategory.edit', $subcategory->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.subcategory.destroy', $subcategory->id) }}" method="POST" class="d-inline">
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
