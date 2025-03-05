@include('dashboard.layout.header')

<div class="container">
    <h1>Add New Product Item</h1>
    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <!-- Category Dropdown -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="labour_charges" class="form-label">Labour Charges</label>
            <input type="number" name="labour_charges" id="labour_charges" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="gst_percentage" class="form-label">GST Percentage (%)</label>
            <input type="number" name="gst_percentage" id="gst_percentage" class="form-control" step="0.01">
        </div>


        <div class="mb-3">
            <label class="form-label">Product Break Up Price</label>
            <div id="pricing-container">
                <div class="mb-2 row pricing-item">
                    <div class="col-md-3">
                        <input type="text" name="components[0][name]" class="form-control" placeholder="Component (e.g., Gold 22KT)" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="components[0][weight]" class="form-control" placeholder="Weight (g)">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="components[0][rate]" class="form-control" placeholder="Rate (₹)">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="components[0][total_value]" class="form-control" placeholder="Total Value (₹)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-pricing">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-pricing">Add More</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Images</label>
            <div id="image-container">
                <div class="mb-3 input-group image-input">
                    <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                    <button type="button" class="btn btn-danger remove-image">Remove</button>
                    <div class="image-preview-container" style="display: none;">
                        <img src="" class="image-preview" />
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-image">Add Image</button>
        </div>

        <button type="submit" class="btn btn-primary">Add Product Item</button>
    </form>
</div>

<!-- Crop Image Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="text-center modal-body">
                <div id="modal-crop-container">
                    <img id="modal-image-preview" src="" alt="Image preview" style="max-width: 100%;" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-crop-button">Crop & Save</button>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.js"></script>

<!-- JavaScript for Category-Subcategory Filtering -->
<script>
    $(document).ready(function () {
        $('#description').summernote({
            height: 300,
        });

        let imageCount = 1;
        $('#add-image').click(function () {
            if (imageCount < 5) {
                $('#image-container').append(`
                    <div class="mb-3 input-group image-input">
                        <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                        <button type="button" class="btn btn-danger remove-image">Remove</button>
                        <div class="image-preview-container" style="display: none;">
                            <img src="" class="image-preview" />
                        </div>
                    </div>
                `);
                imageCount++;
            }

            if (imageCount >= 5) {
                $('#add-image').hide();
            }
        });

        $('#image-container').on('click', '.remove-image', function () {
            $(this).closest('.image-input').remove();
            imageCount--;

            if (imageCount < 5) {
                $('#add-image').show();
            }
        });

        let cropper = null;

        $('#image-container').on('change', '.image-upload', function (e) {
            let currentInput = $(this);
            let currentPreview = $(this).siblings('.image-preview-container').find('.image-preview');
            let file = e.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $('#modal-image-preview').attr('src', event.target.result);
                    $('#cropModal').modal('show');
                };
                reader.readAsDataURL(file);

                $('#cropModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    let modalImage = $('#modal-image-preview');

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(modalImage[0], {
                        aspectRatio: 1,
                        viewMode: 1,
                        crop(event) {},
                    });
                });

                $('#cropModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                });

                $('#modal-crop-button').off('click').on('click', function () {
                    let croppedCanvas = cropper.getCroppedCanvas({
                        width: 200,
                        height: 200,
                    });

                    croppedCanvas.toBlob(function (blob) {
                        let file = new File([blob], "cropped_image.jpg", { type: "image/jpeg" });
                        let container = new DataTransfer();
                        container.items.add(file);
                        currentInput[0].files = container.files;

                        let previewReader = new FileReader();
                        previewReader.onload = function (event) {
                            currentPreview.attr('src', event.target.result).parent().show();
                            $('#cropModal').modal('hide');
                        };
                        previewReader.readAsDataURL(file);
                    });
                });
            }
        });

        // Fetch subcategories when category is selected
        $('#category_id').change(function () {
            let categoryId = $(this).val();
            $('#sub_category_id').html('<option value="">Select Subcategory</option>'); // Reset subcategory

            if (categoryId) {
                $.ajax({
                    url: '{{ route("admin.subcategory.getByCategory") }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#sub_category_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        let pricingIndex = 1;

        $('#add-pricing').click(function () {
            $('#pricing-container').append(`
                <div class="mb-2 row pricing-item">
                    <div class="col-md-3">
                        <input type="text" name="components[${pricingIndex}][name]" class="form-control" placeholder="Component (e.g., Gold 22KT)" required>
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
    });
</script>
