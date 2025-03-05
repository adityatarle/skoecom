@include('dashboard.layout.header')

<div class="container">
    <h1>Edit Subcategory</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Parent Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Parent Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($subcategory->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div>
                    <img src="{{ asset($subcategory->image) }}" alt="Subcategory Image" style="max-width: 200px;">
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Update Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Subcategory</button>
    </form>
</div>

@include('dashboard.layout.footer')
