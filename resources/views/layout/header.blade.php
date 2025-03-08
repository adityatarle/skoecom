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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#slider-range").slider({
                range: true,
                min: 0, // Minimum price value
                max: 1000, // Maximum price value (adjust as needed)
                values: [0, 1000], // Initial values
                slide: function(event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
        });
    </script>

    <style>
        /* Mobile Styles */
        @media (max-width: 768px) {
            .navbar-links {
                flex-direction: column;
                /* Stack navigation items vertically */
                display: none;
                /* Hide by default */
                width: 100%;
                /* Make links full width */
            }

            .navbar-links.show {
                display: flex;
                /* Show when toggled */
            }

            .navbar-links a {
                padding: 10px;
                text-align: left;
                /* Ensure text is left-aligned */
                border-bottom: 1px solid #eee;
                /* Add a border between links */
            }

            .dropdown-content {
                position: static;
                /* Display dropdown inline */
                display: none;
                /* Hide by default */
                background-color: #f9f9f9;
                padding: 0;
                box-shadow: none;
                z-index: 1;
                width: 100%;
            }

            .dropdown-content a {
                padding: 10px;
                display: block;
                border-bottom: 1px solid #eee;
            }

            .dropdown-content.show {
                display: block;
                /* Show when toggled */
            }

            .dropdown-arrow {
                color: #000000;
            }
        }


        .navbar .navbar-links .dropdown>a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Distribute content evenly */
        }

        .navbar .navbar-links .dropdown .dropdown-arrow {
            margin-left: auto;
            /* Push arrow to the right */
            display: inline-block;
            /* Ensure the arrow is visible */
        }
    </style>
</head>


<body>
    <!--header sidebar area start-->
    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay">

    </div>





    <!-- Main Wrapper Start -->

    <div class="home_three_body_wrapper">
        <!--header area start-->
        <header class="header_area header_three sticky-top">
            <div class="header">
                <button class="navbar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Jaipur Gems" class="logo">
                </a>

                <a href="{{ route('home') }}" class="mobile-logo">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Jaipur Gems" class="mobile-logo">
                </a>

                <div class="search-bar-mobile">
                    <a href="#"><i class="fas fa-search"></i></a>
                </div>

                <div class="search-bar">
                    <input type="text" placeholder="Search for products, categories, ...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="header-icons">
                    <a href="#">
                        <i class="fas fa-headphones d-none d-lg-block"></i>
                    </a>

                    <a href="{{ route('wishlist.index') }}">
                        <i class="fa-regular fa-heart">
                            <span class="badge" id="wishlist_count">
                                <!-- {{Auth::id()}} -->
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
                    <a href="#">
                        <i class="fas fa-user d-none d-lg-block"></i>
                    </a>
                </div>
            </div>

            <nav class="navbar">
                <div class="navbar-links">
                    @foreach($categories as $category)
                    <div class="dropdown">
                        <a href="{{ route('products', ['category' => $category->name]) }}">
                            {{ $category->name }}
                            @if($category->subcategories->count() > 0)
                            <span class="dropdown-arrow">▾</span>
                            @endif
                        </a>

                        @if($category->subcategories->count() > 0)
                        <div class="dropdown-content">
                            @foreach($category->subcategories as $subcategory)
                            <a href="{{ route('products', ['subcategory' => $subcategory->name]) }}">{{ $subcategory->name }}</a> <br>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </nav>



            <script>
                $(document).ready(function() {
                    // Toggle main menu
                    $(".navbar-toggle").click(function() {
                        $(".navbar-links").toggleClass("show");
                    });

                    // Toggle dropdowns
                    $(".dropdown > a").click(function(e) {
                        e.preventDefault(); // Prevent default link behavior
                        $(this).parent().toggleClass("show"); // Toggle class on parent dropdown
                        $(this).next(".dropdown-content").slideToggle(); // Toggle dropdown content visibility
                    });

                    // Close dropdown when clicking outside
                    $(document).click(function(e) {
                        if (!$(e.target).closest('.dropdown').length) {
                            $(".dropdown").removeClass("show");
                            $(".dropdown-content").slideUp();
                        }
                    });
                });
            </script>
        </header>
        <!--header area end-->

        @yield('content')
        <!-- Use asset helper function to add js file  -->
        <script src="{{ asset('assets/js/vendor/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/ajax-mail.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>