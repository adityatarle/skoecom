@include('dashboard.layout.header')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Site Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.settings.update') }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <h4 class="mb-3">Contact Information</h4>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Address</label>
                <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
            </div>
        </div>
        <h4 class="mb-3">Homepage SEO</h4>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Meta Title</label>
                <input type="text" name="seo_home_title" class="form-control" value="{{ $settings['seo_home_title'] ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Meta Description</label>
                <input type="text" name="seo_home_description" class="form-control" value="{{ $settings['seo_home_description'] ?? '' }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Meta Keywords</label>
                <input type="text" name="seo_home_keywords" class="form-control" value="{{ $settings['seo_home_keywords'] ?? '' }}">
            </div>
        </div>
        <h4 class="mb-3">Footer Links</h4>
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Home</label>
                <input type="text" name="footer_home" class="form-control" value="{{ $settings['footer_home'] ?? '/home' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Online Store</label>
                <input type="text" name="footer_store" class="form-control" value="{{ $settings['footer_store'] ?? '/products' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Promotion</label>
                <input type="text" name="footer_promotion" class="form-control" value="{{ $settings['footer_promotion'] ?? '/promotion' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Privacy Policy</label>
                <input type="text" name="footer_privacy" class="form-control" value="{{ $settings['footer_privacy'] ?? '/privacy-policy' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Terms Of Use</label>
                <input type="text" name="footer_terms" class="form-control" value="{{ $settings['footer_terms'] ?? '/terms-of-use' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Sitemap</label>
                <input type="text" name="footer_sitemap" class="form-control" value="{{ $settings['footer_sitemap'] ?? '/sitemap' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Support</label>
                <input type="text" name="footer_support" class="form-control" value="{{ $settings['footer_support'] ?? '/support' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Contacts</label>
                <input type="text" name="footer_contacts" class="form-control" value="{{ $settings['footer_contacts'] ?? '/contact' }}">
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <button class="btn btn-success">Save Settings</button>
        </div>
    </form>
</div>
@include('dashboard.layout.footer')