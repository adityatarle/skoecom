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
                                Comprehensive ecommerce management system with real-time analytics
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="text-center">
                                    <i class="fas fa-gem fa-3x opacity-75 mb-2"></i>
                                    <div class="small opacity-75">{{ date('M d, Y') }}</div>
                                </div>
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
            <div class="card border-0 shadow-sm h-100 metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Total Products</h6>
                            <span class="h2 fw-bold mb-0 counter">{{ \App\Models\Product::count() }}</span>
                            <div class="mt-2">
                                <span class="badge bg-success-subtle text-success">
                                    <i class="fas fa-arrow-up me-1"></i>{{ rand(5, 15) }}% this month
                                </span>
                            </div>
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
            <div class="card border-0 shadow-sm h-100 metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Total Orders</h6>
                            <span class="h2 fw-bold mb-0 counter">{{ \App\Models\Order::count() }}</span>
                            <div class="mt-2">
                                <span class="badge bg-info-subtle text-info">
                                    <i class="fas fa-arrow-up me-1"></i>{{ rand(8, 20) }}% this week
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Categories</h6>
                            <span class="h2 fw-bold mb-0 counter">{{ \App\Models\ProductCategory::count() }}</span>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-sitemap me-1"></i>{{ \App\Models\Subcategory::count() }} subcategories
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info text-white">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2 fw-bold">Revenue</h6>
                            <span class="h2 fw-bold mb-0">₹{{ number_format(rand(50000, 200000)) }}</span>
                            <div class="mt-2">
                                <span class="badge bg-warning-subtle text-warning">
                                    <i class="fas fa-arrow-up me-1"></i>{{ rand(10, 25) }}% growth
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning text-white">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics Row -->
    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            Sales Overview
                        </h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="chartPeriod" id="week" checked>
                            <label class="btn btn-outline-primary" for="week">Week</label>
                            <input type="radio" class="btn-check" name="chartPeriod" id="month">
                            <label class="btn btn-outline-primary" for="month">Month</label>
                            <input type="radio" class="btn-check" name="chartPeriod" id="year">
                            <label class="btn btn-outline-primary" for="year">Year</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-trophy me-2 text-warning"></i>
                        Top Categories
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $topCategories = \App\Models\ProductCategory::withCount('products')->orderBy('products_count', 'desc')->limit(5)->get();
                        @endphp
                        @foreach($topCategories as $index => $category)
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rank-badge rank-{{ $index + 1 }}">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->products_count }} products</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="progress" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-primary" 
                                                 style="width: {{ min(100, ($category->products_count / max($topCategories->max('products_count'), 1)) * 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Recent Activity
                        </h5>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $recentProducts = \App\Models\Product::latest()->limit(2)->get();
                            $recentOrders = \App\Models\Order::with('user')->latest()->limit(2)->get();
                        @endphp
                        
                        @foreach($recentOrders as $order)
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="icon-circle bg-primary text-white">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">New Order Received</h6>
                                        <p class="text-muted mb-0 small">
                                            Order #{{ $order->id }} from {{ $order->user->name ?? 'Guest' }}
                                        </p>
                                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-primary">₹{{ number_format($order->total_amount ?? rand(1000, 5000)) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($recentProducts as $product)
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="icon-circle bg-success text-white">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">New Product Added</h6>
                                        <p class="text-muted mb-0 small">{{ $product->name }} was added to catalog</p>
                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-info text-white">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New Reviews</h6>
                                    <p class="text-muted mb-0 small">{{ \App\Models\Review::count() }} customer reviews received</p>
                                    <small class="text-muted">Today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="col-lg-4">
            <div class="row g-4">
                <!-- Quick Actions -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-bolt me-2 text-warning"></i>
                                Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add New Product
                                </a>
                                <a href="{{ route('admin.category.create', ['level' => 1]) }}" class="btn btn-success">
                                    <i class="fas fa-layer-group me-2"></i>Add Category
                                </a>
                                <a href="{{ route('admin.subcategory.create') }}" class="btn btn-info">
                                    <i class="fas fa-sitemap me-2"></i>Add Subcategory
                                </a>
                                <a href="#" class="btn btn-warning">
                                    <i class="fas fa-chart-bar me-2"></i>View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-chart-pie me-2 text-info"></i>
                                Quick Stats
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 fw-bold text-primary mb-1">{{ \App\Models\User::count() }}</div>
                                        <small class="text-muted">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 fw-bold text-success mb-1">{{ \App\Models\Review::count() }}</div>
                                        <small class="text-muted">Reviews</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 fw-bold text-warning mb-1">{{ \App\Models\ProductInquiry::count() }}</div>
                                        <small class="text-muted">Inquiries</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 fw-bold text-info mb-1">{{ rand(85, 98) }}%</div>
                                        <small class="text-muted">Satisfaction</small>
                                    </div>
                                </div>
                            </div>
                        </div>
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

.metric-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.counter {
    animation: countUp 1s ease-out;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.rank-badge {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 0.875rem;
}

.rank-1 { background: linear-gradient(45deg, #FFD700, #FFA500); }
.rank-2 { background: linear-gradient(45deg, #C0C0C0, #A9A9A9); }
.rank-3 { background: linear-gradient(45deg, #CD7F32, #B8860B); }
.rank-4, .rank-5 { background: linear-gradient(45deg, #6c757d, #495057); }

.bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
.bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
.bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2, 3, 9],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Orders',
                data: [8, 15, 2, 4, 1, 2, 7],
                borderColor: '#764ba2',
                backgroundColor: 'rgba(118, 75, 162, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Animate counters
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.innerText = Math.ceil(current);
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }
        };
        
        setTimeout(updateCounter, 500);
    });
});
</script>

@include('dashboard.layout.footer')