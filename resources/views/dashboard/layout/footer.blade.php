@php
use App\Models\Setting;
$footerLinks = [
    'Home' => Setting::get('footer_home', '/'),
    'Online Store' => Setting::get('footer_store', '/products'),
    'Promotion' => Setting::get('footer_promotion', '/promotion'),
    'Privacy Policy' => Setting::get('footer_privacy', '/privacy-policy'),
    'Terms Of Use' => Setting::get('footer_terms', '/terms-of-use'),
    'Sitemap' => Setting::get('footer_sitemap', '/sitemap'),
    'Support' => Setting::get('footer_support', '/support'),
    'Contacts' => Setting::get('footer_contacts', '/contact'),
];
$contact_address = Setting::get('contact_address');
$contact_phone = Setting::get('contact_phone');
$contact_email = Setting::get('contact_email');
@endphp
</div>
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <span class="fw-bold">&copy; {{ date('Y') }} {{ config('app.name') }}</span>
                <span class="ms-2">Developed by Blaze Fusion Technologies</span>
            </div>
            <div class="col-md-6 text-md-end">
                @foreach($footerLinks as $label => $url)
                    <a href="{{ $url }}" class="text-light text-decoration-none mx-2">{{ $label }}</a>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4 small"><i class="fas fa-map-marker-alt me-1"></i> {{ $contact_address }}</div>
            <div class="col-md-4 small"><i class="fas fa-phone me-1"></i> {{ $contact_phone }}</div>
            <div class="col-md-4 small"><i class="fas fa-envelope me-1"></i> {{ $contact_email }}</div>
        </div>
    </div>
</footer>
<!--end::Footer-->
<!--end:::Main-->
</div>
<!--end::Wrapper-->
<!--end::Page-->
</div>
<!--end::App-->
<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>
<script src="{{ asset('admin/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/utilities/modals/new-target.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/utilities/modals/users-search.js') }}"></script>
</body>
<!--end::Body-->
</html>
