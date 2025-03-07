@include('dashboard.layout.header')

<div class="container">
    <h1>Edit Product Item</h1>
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="removed_images" id="removed_images" value=""/>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <!-- Category Dropdown -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subcategory Dropdown -->
        <div class="mb-3">
            <label for="sub_category_id" class="form-label">Subcategory</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                <option value="">Select Subcategory</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label for="labour_charges" class="form-label">Labour Charges</label>
            <input type="number" name="labour_charges" id="labour_charges" class="form-control" step="0.01" value="{{ $product->labour_charges }}">
        </div>

        <div class="mb-3">
            <label for="gst_percentage" class="form-label">GST Percentage (%)</label>
            <input type="number" name="gst_percentage" id="gst_percentage" class="form-control" step="0.01" value="{{ $product->gst_percentage }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Product Break Up Price</label>
            <div id="pricing-container">
                @foreach ($product->pricingDetails as $index => $component)
                    <div class="mb-2 row pricing-item">
                        <div class="col-md-3">
                            <input type="text" name="components[{{ $index }}][name]" class="form-control" value="{{ $component->component }}" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="components[{{ $index }}][weight]" class="form-control" value="{{ $component->weight }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="components[{{ $index }}][rate]" class="form-control" value="{{ $component->rate }}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="components[{{ $index }}][total_value]" class="form-control" value="{{ $component->total_value }}" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-pricing">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" id="add-pricing">Add More</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Images</label>
            <div id="image-container">
                @foreach ($product->images as $image)
                    <div class="mb-3 input-group image-input" data-image-id="{{ $image->id }}">
                        <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                        <button type="button" class="btn btn-danger remove-image" data-image-id="{{ $image->id }}">Remove</button>
                        <div class="image-preview-container">
                            <img src="{{ asset($image->image_path) }}" class="image-preview" style="max-width: 100px;">
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" id="add-image">Add Image</button>
        </div>

        <button type="submit" class="btn btn-primary">Update Product Item</button>
    </form>
</div>

@include('dashboard.layout.footer')

<script>
    $(document).ready(function () {
        // Populate subcategories on edit
        function loadSubcategories(categoryId, selectedSubcategory) {
            $('#sub_category_id').html('<option value="">Select Subcategory</option>');
            if (categoryId) {
                $.ajax({
                    url: '{{ route("admin.subcategory.getByCategory") }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            let selected = (value.id == selectedSubcategory) ? 'selected' : '';
                            $('#sub_category_id').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                    }
                });
            }
        }

        let selectedCategory = $('#category_id').val();
        let selectedSubcategory = '{{ $product->sub_category_id }}';
        if (selectedCategory) {
            loadSubcategories(selectedCategory, selectedSubcategory);
        }

        $('#category_id').change(function () {
            let categoryId = $(this).val();
            loadSubcategories(categoryId, null);
        });

        // Pricing Section
        let pricingIndex = {{ count($product->pricingDetails) }};
        $('#add-pricing').click(function () {
            $('#pricing-container').append(`
                <div class="mb-2 row pricing-item">
                    <div class="col-md-3">
                        <input type="text" name="components[${pricingIndex}][name]" class="form-control" placeholder="Component" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="components[${pricingIndex}][weight]" class="form-control" placeholder="Weight (g)">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="components[${pricingIndex}][rate]" class="form-control" placeholder="Rate (₹)">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="components[${pricingIndex}][total_value]" class="form-control" placeholder="Total Value (₹)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-pricing">Remove</button>
                    </div>
                </div>
            `);
            pricingIndex++;
        });

        $(document).on('click', '.remove-pricing', function () {
            $(this).closest('.pricing-item').remove();
        });

        // Image Removal
        let removedImages = [];
        $('#image-container').on('click', '.remove-image', function () {
            let imageId = $(this).data('image-id');
            if (imageId) {
                removedImages.push(imageId);
                $('#removed_images').val(JSON.stringify(removedImages));
            }
            $(this).closest('.image-input').remove();
        });
    });
</script>
