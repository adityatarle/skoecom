@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h3 mb-2 fw-bold">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Welcome to SK Ornaments Dashboard
                            </h1>
                            <p class="mb-0 opacity-90">
                                Manage your ecommerce store efficiently with our comprehensive admin panel
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <i class="fas fa-gem fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Total Products</h6>
                            <span class="h2 fw-bold mb-0">{{ \App\Models\Product::count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary text-white">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Categories</h6>
                            <span class="h2 fw-bold mb-0">{{ \App\Models\ProductCategory::count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success text-white">
                                <i class="fas fa-folder"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Subcategories</h6>
                            <span class="h2 fw-bold mb-0">{{ \App\Models\Subcategory::count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info text-white">
                                <i class="fas fa-sitemap"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Total Orders</h6>
                            <span class="h2 fw-bold mb-0">{{ \App\Models\Order::count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New Product Added</h6>
                                    <p class="text-muted mb-0 small">Latest jewelry item was added to the catalog</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-primary text-white">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New Order Received</h6>
                                    <p class="text-muted mb-0 small">Customer placed an order for gold necklace</p>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-info text-white">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New Review Posted</h6>
                                    <p class="text-muted mb-0 small">Customer left a 5-star review for silver earrings</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-warning text-white">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Product Inquiry</h6>
                                    <p class="text-muted mb-0 small">Customer inquired about custom jewelry design</p>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                        <a href="{{ route('admin.subcategory.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-sitemap me-2"></i>Add Subcategory
                        </a>
                        <a href="#" class="btn btn-info btn-lg">
                            <i class="fas fa-chart-bar me-2"></i>View Analytics
                        </a>
                        <a href="#" class="btn btn-warning btn-lg">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>

@include('dashboard.layout.footer')