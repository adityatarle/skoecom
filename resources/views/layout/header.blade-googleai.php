<!doctype html>
<html class="no-js" lang="en">
<!-- Mirrored from htmldemo.net/monsta/monsta/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Feb 2025 10:34:51 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sk Ornaments - Jewelry eCommerce Bootstrap 5 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">

    <!-- CSS
    ========================= -->

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!--modernizr min js here-->
    <script src="{{ asset('assets/js/vendor/modernizr-3.7.1.min.js') }}"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

    <script>
        $(function() {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [0, 1000],
                slide: function(event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
        });
    </script>

</head>


<body>
    <!--header sidebar area start-->
    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay">

    </div>


    <!-- Main Wrapper Start -->

    <div class="home_three_body_wrapper">
        <!--header area start-->
        <!-- Header Section -->
        <header class="header_area header_three">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between py-3 py-sm-0">
                    <!-- Hamburger Menu -->
                    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Logo -->
                    <!-- <a href="{{route('home')}}" class="logo">
                        <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="Jaipur Gems" class="logo-img img-fluid pt-3">
                    </a> -->
                    <!-- Desktop logo (lg and up) -->
                    <a href="{{ route('home') }}" class="logo d-none d-lg-block">
                        <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments" class="logo-img img-fluid pt-0 pt-lg-3">
                    </a>

                    <!-- Tablet view (md to lg) -->
                    <div class="d-none d-md-flex d-lg-none align-items-center justify-content-between w-100">
                        <!-- Tablet logo -->
                        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                            <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments" class="img-fluid py-3">
                        </a>

                        <!-- Search bar -->
                        <div class="search-bar d-flex align-items-center ms-3">
                            <input type="text" class="form-control" placeholder="Search for jewelry...">
                            <button type="submit" class="btn ms-2"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <!-- Tablet view end -->



                    <!-- Mobile logo (sm and below) -->
                    <a href="{{ route('home') }}" class="logo d-flex d-md-none align-items-center w-100">
                        <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments" class="logo-img img-fluid">
                        <p class="ms-2 fw-bold fs-6 mb-0">SK Ornaments</p>
                    </a>




                    <!-- Desktop Search -->
                    <div class="search-bar d-none d-lg-flex">
                        <input type="text" class="form-control" placeholder="Search for jewelry...">
                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                    </div>

                    <!-- Header Icons -->
                    <div class="header-icons">
                        <a href="#">
                            <i class="fas fa-headphones d-none d-lg-block"></i>
                        </a>
                        <a href="{{ route('wishlist.index') }}">
                            <i class="fa-regular fa-heart">
                                <span class="badge" id="wishlist_count">
                                    @auth
                                    {{ \App\Models\Wishlist::where('user_id', Auth::id())->count() }}
                                    @else
                                    {{ count(session('wishlist', [])) }}
                                    @endauth
                                </span>
                            </i>
                        </a>
                        <a href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping">
                                <span class="badge" id="cart_count">{{ count(session('cart', [])) }}</span>
                            </i>
                        </a>
                        <a href="{{ route('profile.show') }}">
                            <i class="fas fa-user d-none d-lg-block"></i>
                        </a>
                    </div>
                </div>

                <!-- Mobile Search Bar (Visible only on mobile) -->

                <!-- Mobile Search Start-->
                <div class="mobile-search-bar d-lg-none d-md-none">
                    <form action="#" method="get" class="d-flex">
                        <input type="text" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                    </form>

                    <!-- <a href="{{ route('wishlist.index') }}" class="d-block d-lg-none">
                        <i class="fa-regular fa-heart">
                            <span class="badge" id="wishlist_count">
                                @auth
                                {{ \App\Models\Wishlist::where('user_id', Auth::id())->count() }}
                                @else
                                {{ count(session('wishlist', [])) }}
                                @endauth
                            </span>
                        </i>
                    </a>
                    <a href="{{ route('cart.index') }}" class="d-block d-lg-none">
                        <i class="fa-solid fa-cart-shopping">
                            <span class="badge" id="cart_count">{{ count(session('cart', [])) }}</span>
                        </i>
                    </a> -->
                </div>
                <!-- Mobile Search End -->

                <!-- Navigation -->
                <!-- Navigation -->
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                        <ul class="navbar-nav navbar-links">
                            @foreach($categories as $category)
                            {{-- Make sure the LI has the 'dropdown' class --}}
                            <li class="nav-item dropdown">
                                {{--
                    THIS IS THE KEY CHANGE:
                    - Add class="dropdown-toggle" to the link.
                    - Add data-bs-toggle="dropdown" attribute.
                    - Add role="button" for accessibility.
                    - Add aria-expanded="false" for accessibility.
                    - Use href="#" if the main category itself isn't a page link.
                    - Bootstrap's dropdown-toggle class adds an arrow automatically,
                      so your custom span can likely be removed.
                --}}
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                    {{-- Removed custom arrow: <span class="dropdown-arrow d-lg-none"><i class="fas fa-chevron-down"></i></span> --}}
                                </a>

                                @if($category->subcategories->count() > 0)
                                {{--
                    THIS IS THE OTHER KEY CHANGE:
                    - Use a UL element for the dropdown content.
                    - Give it the class="dropdown-menu".
                --}}
                                <ul class="dropdown-menu">
                                    @foreach($category->subcategories as $subcategory)
                                    {{-- Wrap the link in an LI and add class="dropdown-item" to the A tag --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products', ['subcategory' => $subcategory->name]) }}">
                                            {{ $subcategory->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>

        </header>

        <!--header area end-->

        @yield('content')
    </div> <!-- Closing home_three_body_wrapper -->

    <!-- Scripts -->
    <!-- 1. jQuery Core -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 2. jQuery UI (if needed for slider etc.) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <!-- 3. Bootstrap Bundle (Includes Popper) -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> <!-- Use bundle! -->

    <!-- 4. Theme Plugins -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- 5. Theme Mail Script (if needed) -->
    <script src="{{ asset('assets/js/ajax-mail.js') }}"></script>

    <!-- 6. Theme Main Script -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- 7. Theme Header Script (if applicable) -->
    <script src="{{ asset('assets/js/header-script.js') }}"></script>

</body>

</html>