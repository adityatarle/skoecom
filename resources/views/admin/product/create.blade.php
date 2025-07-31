@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="card-title mb-1">
                                <i class="fas fa-plus me-2"></i>Add New Product
                            </h3>
                            <p class="mb-0 opacity-90">
                                Create a new product with detailed information and components
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-light text-dark fs-6">New Product</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="row g-4">
                                    <div class="col-md-8">
                                        <label for="name" class="form-label fw-bold">
                                            <i class="fas fa-tag me-1"></i>Product Name *
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               id="name" 
                                               class="form-control form-control-lg" 
                                               value="{{ old('name') }}"
                                               required 
                                               placeholder="Enter product name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="price" class="form-label fw-bold">
                                            <i class="fas fa-rupee-sign me-1"></i>Price *
                                        </label>
                                        <input type="number" 
                                               name="price" 
                                               id="price" 
                                               class="form-control form-control-lg" 
                                               value="{{ old('price') }}"
                                               step="0.01" 
                                               min="0"
                                               required 
                                               placeholder="0.00">
                                    </div>
                                    <div class="col-12">
                                        <label for="description" class="form-label fw-bold">
                                            <i class="fas fa-align-left me-1"></i>Description
                                        </label>
                                        <textarea name="description" 
                                                  id="description" 
                                                  class="form-control" 
                                                  rows="4" 
                                                  placeholder="Enter product description (supports text and numbers)">{{ old('description') }}</textarea>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            You can include text, numbers, and special characters in the description.
                                        </div>
                                    </div>
                                    <!-- Featured/Top Rated toggles -->
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mt-3">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_featured">
                                                <i class="fas fa-star me-1"></i> Featured Product
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mt-3">
                                            <input class="form-check-input" type="checkbox" name="is_top_rated" id="is_top_rated" value="1" {{ old('is_top_rated') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_top_rated">
                                                <i class="fas fa-trophy me-1"></i> Top Rated Product
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category & Pricing -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold text-warning">
                                    <i class="fas fa-folder me-2"></i>Category & Classification
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="category_id" class="form-label fw-bold">
                                            <i class="fas fa-list me-1"></i>Category *
                                        </label>
                                        <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="sub_category_id" class="form-label fw-bold">
                                            <i class="fas fa-sitemap me-1"></i>Subcategory
                                        </label>
                                        <select name="sub_category_id" id="sub_category_id" class="form-select form-select-lg">
                                            <option value="">Select Subcategory</option>
                                        </select>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            First select a category to load available subcategories.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold text-success">
                                    <i class="fas fa-calculator me-2"></i>Pricing Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="labour_charges" class="form-label fw-bold">
                                            <i class="fas fa-tools me-1"></i>Labour Charges
                                        </label>
                                        <input type="number" 
                                               name="labour_charges" 
                                               id="labour_charges" 
                                               class="form-control form-control-lg" 
                                               value="{{ old('labour_charges') }}"
                                               step="0.01" 
                                               min="0"
                                               placeholder="0.00">
                                    </div>
                                    <div class="col-12">
                                        <label for="gst_percentage" class="form-label fw-bold">
                                            <i class="fas fa-percentage me-1"></i>GST Percentage (%)
                                        </label>
                                        <input type="number" 
                                               name="gst_percentage" 
                                               id="gst_percentage" 
                                               class="form-control form-control-lg" 
                                               value="{{ old('gst_percentage') }}"
                                               step="0.01" 
                                               min="0" 
                                               max="100"
                                               placeholder="18.00">
                                    </div>
                                    <div class="col-12">
                                        <div class="bg-light p-3 rounded">
                                            <h6 class="mb-2">Price Calculation Preview</h6>
                                            <div class="small">
                                                <div>Base Price: ₹<span id="basePrice">0.00</span></div>
                                                <div>Labour Charges: ₹<span id="labourCharges">0.00</span></div>
                                                <div>GST (<span id="gstRate">0</span>%): ₹<span id="gstAmount">0.00</span></div>
                                                <hr class="my-2">
                                                <div class="fw-bold">Total: ₹<span id="totalPrice">0.00</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold text-info">
                                    <i class="fas fa-images me-2"></i>Product Images
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-camera me-1"></i>Upload Images
                                        </label>
                                        <div id="image-container">
                                            <div class="input-group mb-3 image-input">
                                                <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                                                <button type="button" class="btn btn-outline-success add-image-btn">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <div class="image-preview-container mt-2" style="display: none;">
                                                    <img src="" class="image-preview img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Supported formats: JPEG, PNG, JPG, GIF, SVG, WebP. Max size: 2MB per image.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Components -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 fw-bold text-danger">
                                        <i class="fas fa-cogs me-2"></i>Product Components
                                    </h5>
                                    <button type="button" class="btn btn-success btn-sm" id="add-component">
                                        <i class="fas fa-plus me-1"></i>Add Component
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="components-container">
                                    <div class="component-row border rounded p-3 mb-3">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Component Name *</label>
                                                <input type="text" name="components[0][name]" class="form-control" required placeholder="e.g., Gold, Silver, Diamond">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-bold">Weight</label>
                                                <input type="number" name="components[0][weight]" class="form-control component-weight" step="0.001" min="0" placeholder="0.000">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-bold">Rate</label>
                                                <input type="number" name="components[0][rate]" class="form-control component-rate" step="0.01" min="0" placeholder="0.00">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Total Value *</label>
                                                <input type="number" name="components[0][total_value]" class="form-control component-total" step="0.01" min="0" required placeholder="0.00">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm w-100 remove-component" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Total Components Value: ₹<span id="total-components-value">0.00</span></strong>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <small class="text-muted">Auto-calculated from component total values</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="d-flex gap-3 justify-content-center">
                                    <button type="submit" class="btn btn-success btn-lg px-5">
                                        <i class="fas fa-save me-2"></i>Create Product
                                    </button>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-lg px-5">
                                        <i class="fas fa-arrow-left me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let componentIndex = 1;

// Price calculation
function updatePriceCalculation() {
    const basePrice = parseFloat(document.getElementById('price').value) || 0;
    const labourCharges = parseFloat(document.getElementById('labour_charges').value) || 0;
    const gstPercentage = parseFloat(document.getElementById('gst_percentage').value) || 0;
    
    const subtotal = basePrice + labourCharges;
    const gstAmount = (subtotal * gstPercentage) / 100;
    const total = subtotal + gstAmount;
    
    document.getElementById('basePrice').textContent = basePrice.toFixed(2);
    document.getElementById('labourCharges').textContent = labourCharges.toFixed(2);
    document.getElementById('gstRate').textContent = gstPercentage.toFixed(1);
    document.getElementById('gstAmount').textContent = gstAmount.toFixed(2);
    document.getElementById('totalPrice').textContent = total.toFixed(2);
}

// Add event listeners for price calculation
document.getElementById('price').addEventListener('input', updatePriceCalculation);
document.getElementById('labour_charges').addEventListener('input', updatePriceCalculation);
document.getElementById('gst_percentage').addEventListener('input', updatePriceCalculation);

// Component management
document.getElementById('add-component').addEventListener('click', function() {
    const container = document.getElementById('components-container');
    const newComponent = document.createElement('div');
    newComponent.className = 'component-row border rounded p-3 mb-3';
    newComponent.innerHTML = `
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Component Name *</label>
                <input type="text" name="components[${componentIndex}][name]" class="form-control" required placeholder="e.g., Gold, Silver, Diamond">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Weight</label>
                <input type="number" name="components[${componentIndex}][weight]" class="form-control component-weight" step="0.001" min="0" placeholder="0.000">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Rate</label>
                <input type="number" name="components[${componentIndex}][rate]" class="form-control component-rate" step="0.01" min="0" placeholder="0.00">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Total Value *</label>
                <input type="number" name="components[${componentIndex}][total_value]" class="form-control component-total" step="0.01" min="0" required placeholder="0.00">
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm w-100 remove-component">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newComponent);
    componentIndex++;
    updateRemoveButtons();
    updateComponentsTotal();
});

// Remove component
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-component')) {
        e.target.closest('.component-row').remove();
        updateRemoveButtons();
        updateComponentsTotal();
    }
});

function updateRemoveButtons() {
    const components = document.querySelectorAll('.component-row');
    components.forEach((component, index) => {
        const removeBtn = component.querySelector('.remove-component');
        removeBtn.disabled = components.length === 1;
    });
}

// Calculate components total
function updateComponentsTotal() {
    const totals = document.querySelectorAll('.component-total');
    let sum = 0;
    totals.forEach(total => {
        sum += parseFloat(total.value) || 0;
    });
    document.getElementById('total-components-value').textContent = sum.toFixed(2);
}

// Add event listeners for component calculations
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('component-total')) {
        updateComponentsTotal();
    }
    if (e.target.classList.contains('component-weight') || e.target.classList.contains('component-rate')) {
        const row = e.target.closest('.component-row');
        const weight = parseFloat(row.querySelector('.component-weight').value) || 0;
        const rate = parseFloat(row.querySelector('.component-rate').value) || 0;
        const totalField = row.querySelector('.component-total');
        totalField.value = (weight * rate).toFixed(2);
        updateComponentsTotal();
    }
});

// Image management
let imageIndex = 1;

document.addEventListener('click', function(e) {
    if (e.target.closest('.add-image-btn')) {
        const container = document.getElementById('image-container');
        const newImageInput = document.createElement('div');
        newImageInput.className = 'input-group mb-3 image-input';
        newImageInput.innerHTML = `
            <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
            <button type="button" class="btn btn-outline-danger remove-image-btn">
                <i class="fas fa-trash"></i>
            </button>
            <div class="image-preview-container mt-2" style="display: none;">
                <img src="" class="image-preview img-thumbnail" style="max-width: 150px; max-height: 150px;">
            </div>
        `;
        container.appendChild(newImageInput);
        imageIndex++;
    }
    
    if (e.target.closest('.remove-image-btn')) {
        e.target.closest('.image-input').remove();
    }
});

// Image preview
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('image-upload')) {
        const file = e.target.files[0];
        const previewContainer = e.target.parentElement.querySelector('.image-preview-container');
        const previewImg = previewContainer.querySelector('.image-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
});

// Category-Subcategory relationship
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('sub_category_id');
    
    // Clear existing options
    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
    
    if (categoryId) {
        // Fetch subcategories for the selected category
        fetch(`/admin/subcategory/get-by-category?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subcategories:', error));
    }
});

// Initialize calculations
updatePriceCalculation();
updateComponentsTotal();
</script>

<style>
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}

.component-row {
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6 !important;
}

.component-row:hover {
    border-color: #007bff !important;
    background-color: #e3f2fd;
}

.image-input {
    border: 2px dashed #dee2e6;
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: #f8f9fa;
}

.image-input:hover {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 2px;
}
</style>

@include('dashboard.layout.footer')