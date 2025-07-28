<footer class="footer_widgets">
    <div class="container">
        <div class="footer_top">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="widgets_container contact_us">
                        <h3>About SK</h3>
                        <div class="footer_contact">
                            <p>Address: Your address goes here.</p>
                            <p>Phone: <a href="tel:0123456789">0123456789</a></p>
                            <p>Email: demo@example.com</p>
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-4 col-6">
                    <div class="widgets_container widget_menu">
                        <h3>Information</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#sk-blog">Blog</a></li>
                                <li><a href="{{route('products')}}">Products</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-5 col-6">
                    <div class="widgets_container widget_menu">
                        <h3>My Account</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{route('profile.show')}}">My Account</a></li>
                                <li><a href="{{route('wishlist.index')}}">Wishlist</a></li>
                                <li><a href="{{route('checkout')}}">Checkout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="widgets_container product_widget">
                        <h3>Top Rated Products</h3>
                        <div class="simple_product">
                            <div class="simple_product_items">
                                <div class="simple_product_thumb">
                                    <a href="#"><img src="{{ asset('assets/img/s-product/product5.jpg') }}" alt=""></a>
                                </div>
                                <div class="simple_product_content">
                                    <div class="tag_cate">
                                        <a href="#">Rings,</a>
                                        <a href="#">Bracelet</a>
                                    </div>
                                    <div class="product_name">
                                        <h3><a href="#">Diamond Rings</a></h3>
                                    </div>
                                    <div class="product_price">
                                        <span class="old_price">$86.00</span>
                                        <span class="current_price">$70.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="simple_product_items">
                                <div class="simple_product_thumb">
                                    <a href="#"><img src="{{ asset('assets/img/s-product/24.jpeg') }}" alt=""></a>
                                </div>
                                <div class="simple_product_content">
                                    <div class="tag_cate">
                                        <a href="#">Bracelet</a>
                                    </div>
                                    <div class="product_name">
                                        <h3><a href="#">Diamond Bracelet</a></h3>
                                    </div>
                                    <div class="product_price">
                                        <span class="old_price">$74.00</span>
                                        <span class="current_price">$69.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_middel">
            <div class="row">
                <div class="col-12">
                    <div class="footer_middel_menu">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Online Store</a></li>
                            <li><a href="#">Promotion</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms Of Use</a></li>
                            <li><a href="#">Sitemap</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="row">
                <div class="col-12">
                    <div class="copyright_area">
                        <p>© Copyright <a href="#" class="text-uppercase">Heuristic Technopark</a>. All Rights Reserved</p>
                        <img src="{{ asset('assets/img/icon/papyel2.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product1.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product2.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product3.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product5.jpg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false"><img src="assets/img/product/product1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><img src="assets/img/product/product2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link button_three" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><img src="assets/img/product/product3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><img src="assets/img/product/product5.jpg" alt=""></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>Donec eu furniture</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="new_price">$64.99</span>
                                    <span class="old_price">$78.99</span>
                                </div>
                                <div class="see_all">
                                    <a href="product-details.html">See all features</a>
                                </div>
                                <div class="modal_add_to_cart mb-15">
                                    <form action="#">
                                        <input min="0" max="100" step="2" value="1" type="number">
                                        <button type="submit">add to cart</button>
                                    </form>
                                </div>
                                <div class="modal_description mb-15">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                </div>
                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal area start-->

</div>

<script>
    $(document).ready(function() {
        // Add to Cart
        $(".add_to_cart1").click(function(e) {
            e.preventDefault();
            var productId = $(this).data("id");

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}" // Ensure CSRF token is sent
                },
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        $("#cart_count").text(response.cart_count);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error adding to cart");
                }
            });
        });

        // Add to Wishlist
        $(".add_to_wishlist").click(function(e) {
            e.preventDefault();
            var productId = $(this).data("id");

            $.ajax({
                url: "{{ route('wishlist.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}" // Ensure CSRF token is included
                },
                success: function(response) {
                    if (response.status === "success" || response.status === "info") {
                        alert(response.message);
                        $("#wishlist_count").text(response.wishlist_count); // Update count
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error adding to wishlist");
                }
            });
        });
    });
</script>

<!-- JS
============================================ -->

<!-- Plugins JS -->
<script src="{{ asset('assets/js/vendor/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.main.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice.select.js') }}"></script>
<script src="{{ asset('assets/js/scrollup.js') }}"></script>
<script src="{{ asset('assets/js/ajax.chimp.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.js') }}"></script>
<script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
<script src="{{ asset('assets/js/isotope.main.js') }}"></script>
<script src="{{ asset('assets/js/jqquery.ripples.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/js/bpopup.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>



</body>


<!-- Mirrored from htmldemo.net/monsta/monsta/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Feb 2025 10:35:11 GMT -->

</html>