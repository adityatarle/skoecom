@include('layout.header')

<style>
    #contact-page {
        background-color: #f9f5f3;
        color: #333;
    }

    .card {
        background-color: #eee9e5;
        border: none;
        border-radius: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .section-title {
        color: #b89f7e;
        font-size: 1.75rem;
        position: relative;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 2px;
        background-color: #b89f7e;
    }

    .form-control,
    .form-control:focus {
        border-radius: 0;
        border: 1px solid #b89f7e;
        background-color: #f9f5f3;
        font-size: 0.95rem;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(184, 159, 126, 0.25);
        border-color: #b89f7e;
    }

    .form-control::placeholder {
        color: #999;
        opacity: 0.8;
    }

    .btn-custom {
        background-color: #b89f7e;
        color: #fff;
        border-radius: 0;
        padding: 12px 30px;
        font-size: 1rem;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-custom:hover {
        background-color: #a38b6b;
        transform: scale(1.05);
    }

    .contact-info h5 {
        color: #b89f7e;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }

    .contact-info p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #555;
    }

    iframe {
        border-radius: 0;
        border: 1px solid #b89f7e;
    }
</style>

<!-- Main Content -->
<div class="container py-5" id="contact-page">
    <div class="row g-4">
        <!-- Left Column: Form and Map -->
        <div class="col-lg-7">
            <!-- Contact Form -->
            <div class="card p-4">
                <h2 class="section-title">Send Us a Message</h2>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                            @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Your Email" required>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Your Phone" required>
                        @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your Message" required>{{ old('message') }}</textarea>
                        @error('message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-custom text-white">Submit Inquiry</button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Column: Contact Info -->
        <div class="col-lg-5">
            <div class="card p-4 contact-info">
                <h2 class="section-title">Contact Information</h2>

                <div class="mb-4">
                    <h5 class="fw-medium">Store Location</h5>
                    <p>123 Jewel Street<br>Crystal City, Luxe State 12345</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-medium">Get in Touch</h5>
                    <p>Phone: (555) 123-4567<br>Email: info@luxejewels.com</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-medium">Business Hours</h5>
                    <p>Monday - Friday: 10:00 AM - 6:00 PM<br>Saturday: 11:00 AM - 4:00 PM<br>Sunday: Closed</p>
                </div>

            </div>
        </div>
    </div>

    <div class="row pt-4">
        <div class="col-12">
            <!-- Google Map -->
            <div class="card p-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019495614154!2d-122.41941568468101!3d37.77492977975932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808f8e2b6c1d%3A0x7b2e6f5e8d2f5e7b!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2sin!4v1634567890123"
                    width="100%"
                    height="300"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')