@extends('dashboard.layout.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Site Settings</h2>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Contact Information -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-address-book me-2"></i>Contact Information
                        </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label fw-bold">Address</label>
                                    <input type="text" name="contact_address" id="contact_address" 
                                           class="form-control @error('contact_address') is-invalid @enderror" 
                                           value="{{ old('contact_address', $settings['contact_address']) }}">
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label fw-bold">Phone</label>
                                    <input type="text" name="contact_phone" id="contact_phone" 
                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                           value="{{ old('contact_phone', $settings['contact_phone']) }}">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="contact_email" id="contact_email" 
                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                           value="{{ old('contact_email', $settings['contact_email']) }}">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Settings -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3 text-success">
                            <i class="fas fa-envelope me-2"></i>Newsletter Settings
                        </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="newsletter_title" class="form-label fw-bold">Newsletter Title</label>
                                    <input type="text" name="newsletter_title" id="newsletter_title" 
                                           class="form-control @error('newsletter_title') is-invalid @enderror" 
                                           value="{{ old('newsletter_title', $settings['newsletter_title']) }}">
                                    @error('newsletter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="newsletter_button_text" class="form-label fw-bold">Button Text</label>
                                    <input type="text" name="newsletter_button_text" id="newsletter_button_text" 
                                           class="form-control @error('newsletter_button_text') is-invalid @enderror" 
                                           value="{{ old('newsletter_button_text', $settings['newsletter_button_text']) }}">
                                    @error('newsletter_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="newsletter_description" class="form-label fw-bold">Description</label>
                                    <textarea name="newsletter_description" id="newsletter_description" rows="2" 
                                              class="form-control @error('newsletter_description') is-invalid @enderror">{{ old('newsletter_description', $settings['newsletter_description']) }}</textarea>
                                    @error('newsletter_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="newsletter_placeholder" class="form-label fw-bold">Email Placeholder</label>
                                    <input type="text" name="newsletter_placeholder" id="newsletter_placeholder" 
                                           class="form-control @error('newsletter_placeholder') is-invalid @enderror" 
                                           value="{{ old('newsletter_placeholder', $settings['newsletter_placeholder']) }}">
                                    @error('newsletter_placeholder')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Homepage SEO -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3 text-info">
                            <i class="fas fa-search me-2"></i>Homepage SEO
                        </h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="seo_home_title" class="form-label fw-bold">Page Title</label>
                                    <input type="text" name="seo_home_title" id="seo_home_title" 
                                           class="form-control @error('seo_home_title') is-invalid @enderror" 
                                           value="{{ old('seo_home_title', $settings['seo_home_title']) }}">
                                    <div class="form-text">Recommended: 50-60 characters</div>
                                    @error('seo_home_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="seo_home_description" class="form-label fw-bold">Meta Description</label>
                                    <textarea name="seo_home_description" id="seo_home_description" rows="2" 
                                              class="form-control @error('seo_home_description') is-invalid @enderror">{{ old('seo_home_description', $settings['seo_home_description']) }}</textarea>
                                    <div class="form-text">Recommended: 150-160 characters</div>
                                    @error('seo_home_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="seo_home_keywords" class="form-label fw-bold">Meta Keywords</label>
                                    <input type="text" name="seo_home_keywords" id="seo_home_keywords" 
                                           class="form-control @error('seo_home_keywords') is-invalid @enderror" 
                                           value="{{ old('seo_home_keywords', $settings['seo_home_keywords']) }}">
                                    <div class="form-text">Comma separated keywords</div>
                                    @error('seo_home_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Links -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3 text-warning">
                            <i class="fas fa-link me-2"></i>Footer Links
                        </h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_home" class="form-label fw-bold">Home</label>
                                    <input type="text" name="footer_home" id="footer_home" 
                                           class="form-control @error('footer_home') is-invalid @enderror" 
                                           value="{{ old('footer_home', $settings['footer_home']) }}">
                                    @error('footer_home')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_store" class="form-label fw-bold">Online Store</label>
                                    <input type="text" name="footer_store" id="footer_store" 
                                           class="form-control @error('footer_store') is-invalid @enderror" 
                                           value="{{ old('footer_store', $settings['footer_store']) }}">
                                    @error('footer_store')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_promotion" class="form-label fw-bold">Promotion</label>
                                    <input type="text" name="footer_promotion" id="footer_promotion" 
                                           class="form-control @error('footer_promotion') is-invalid @enderror" 
                                           value="{{ old('footer_promotion', $settings['footer_promotion']) }}">
                                    @error('footer_promotion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_contacts" class="form-label fw-bold">Contacts</label>
                                    <input type="text" name="footer_contacts" id="footer_contacts" 
                                           class="form-control @error('footer_contacts') is-invalid @enderror" 
                                           value="{{ old('footer_contacts', $settings['footer_contacts']) }}">
                                    @error('footer_contacts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_privacy" class="form-label fw-bold">Privacy Policy</label>
                                    <input type="text" name="footer_privacy" id="footer_privacy" 
                                           class="form-control @error('footer_privacy') is-invalid @enderror" 
                                           value="{{ old('footer_privacy', $settings['footer_privacy']) }}">
                                    @error('footer_privacy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_terms" class="form-label fw-bold">Terms Of Use</label>
                                    <input type="text" name="footer_terms" id="footer_terms" 
                                           class="form-control @error('footer_terms') is-invalid @enderror" 
                                           value="{{ old('footer_terms', $settings['footer_terms']) }}">
                                    @error('footer_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_sitemap" class="form-label fw-bold">Sitemap</label>
                                    <input type="text" name="footer_sitemap" id="footer_sitemap" 
                                           class="form-control @error('footer_sitemap') is-invalid @enderror" 
                                           value="{{ old('footer_sitemap', $settings['footer_sitemap']) }}">
                                    @error('footer_sitemap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="footer_support" class="form-label fw-bold">Support</label>
                                    <input type="text" name="footer_support" id="footer_support" 
                                           class="form-control @error('footer_support') is-invalid @enderror" 
                                           value="{{ old('footer_support', $settings['footer_support']) }}">
                                    @error('footer_support')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection