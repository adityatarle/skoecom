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
                <a href="" class="logo">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Jaipur Gems" class="logo">
                </a>

                <a href="#" class="mobile-logo">
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
                    <a href="#">
                        <i class="fas fa-search d-none d-lg-block"></i>
                    </a>
                    <a href="#">
                        <i class="fa-regular fa-heart">
                            <span class="badge">0</span>
                        </i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-cart-shopping">
                            <span class="badge">0</span>
                        </i>
                    </a>
                    <a href="#">
                        <i class="fas fa-user d-none d-lg-block"></i>
                    </a>
                </div>
            </div>

            <nav class="navbar">
                <div class="navbar-links">
                    <div class="dropdown">
                        <a href="#">All Jewellery <span class="dropdown-arrow">▾</span></a>
                        <div class="dropdown-content">
                            <a href="#">Gold Jewellery</a>
                            <a href="#">Temple Gold Jewellery</a>
                            <a href="#">Diamond Jewellery</a>
                            <a href="#">Nuvo Polki / Jadau Jewellery</a>
                            <a href="#">Silver Jewellery</a>
                            <a href="#">Desert Rose</a>
                            <a href="#">Available In Store</a>
                            <a href="#">Best Sellers</a>
                        </div>
                    </div>
                    <a href="#">New Arrivals</a>

                    <div class="dropdown">
                        <a href="#">Choker / Necklace <span class="dropdown-arrow">▾</span></a>
                        <div class="dropdown-content">
                            <a href="#">Choker</a>
                            <a href="#">Necklace / Long Necklace</a>
                            <a href="#">Earrings / Chandbali / Jhumka</a>
                            <a href="#">Bangles / Bracelets</a>
                            <a href="#">Necklace And Earring Set</a>
                            <a href="#">Rings</a>
                            <a href="#">Maang Tikka</a>
                            <a href="#">Pendants</a>
                            <a href="#">Hand Phool</a>
                            <a href="#">Anklet</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#">Earrings <span class="dropdown-arrow">▾</span></a>
                        <div class="dropdown-content">
                            <a href="#">Stud Earrings</a>
                            <a href="#">Drop Earrings</a>
                            <a href="#">Hoop Earrings</a>
                            <a href="#">Jhumkas</a>
                            <a href="#">Chandbali Earrings</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#">Bangles <span class="dropdown-arrow">▾</span></a>
                        <div class="dropdown-content">
                            <a href="#">Gold Bangles</a>
                            <a href="#">Silver Bangles</a>
                            <a href="#">Diamond Bangles</a>
                            <a href="#">Kada Bangles</a>
                            <a href="#">Enamel Bangles</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#">Rings <span class="dropdown-arrow">▾</span></a>
                        <div class="dropdown-content">
                            <a href="#">Engagement Rings</a>
                            <a href="#">Wedding Bands</a>
                            <a href="#">Fashion Rings</a>
                            <a href="#">Statement Rings</a>
                            <a href="#">Cocktail Rings</a>
                        </div>
                    </div>

                    <a href="#">High Jewellery</a>
                </div>
            </nav>



            <script>
                const navbarToggle = document.querySelector('.navbar-toggle');
                const navbarLinks = document.querySelector('.navbar-links');

                navbarToggle.addEventListener('click', () => {
                    navbarLinks.classList.toggle('show');
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