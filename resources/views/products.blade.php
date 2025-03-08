@include('layout.header')

<style>
    /* Basic styling for the filter widget */
    .widget_filter {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .widget_filter h2 {
        font-size: 1.2em;
        margin-bottom: 10px;
    }

    /* Styling for the slider range container */
    #slider-range {
        margin-bottom: 15px;
    }

    /* Styling for the price amount display */
    #amount {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Styling for the filter button */
    .widget_filter button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .widget_filter button:hover {
        background-color: #0056b3;
    }
</style>
<!--shop  area start-->
<div class="shop_area shop_reverse">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!-- sidebar widget start -->
                <div class="sidebar_widget">
                    <div class="widget_list widget_categories">
                        <h2>Categories</h2>
                        <ul>
                            @foreach($categories as $category)
                            <li><a href="#" data-category="{{ $category->name }}" class="category-filter">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget_list widget_filter">
                        <h2>Filter by price</h2>
                        <form id="price-filter-form" action="{{ route('products') }}" method="GET">
                            <input type="hidden" name="category" id="filter-category" value="{{ request('category') }}">
                            <div id="slider-range"></div>
                            <input type="text" name="amount" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            <input type="hidden" id="min_price" name="min_price" value="">
                            <input type="hidden" id="max_price" name="max_price" value="">
                            <button type="submit">Filter</button>
                        </form>
                    </div>
                    <!-- ... rest of your sidebar widgets ... -->
                </div>
                <!-- sidebar widget end -->
            </div>
            <div class="col-lg-9 col-md-12">
                <!-- shop wrapper start -->
                <!-- shop toolbar start -->
                <div class="shop_toolbar">
                    <!-- ... your toolbar ... -->
                </div>
                <!-- shop toolbar end -->

                <!-- shop tab product start -->
                <div class="tab-content">
                    <div class="tab-pane grid_view fade show active" id="large" role="tabpanel">
                        <div id="product-grid-container">
                            @include('partials.product_grid')
                        </div>
                    </div>
                    <!-- shop tab product end -->
                </div>
                <!-- shop wrapper end -->
            </div>
        </div>
    </div>
</div>
<!-- shop area end -->

<script>
    $(function() {

        // Category filter click handler
        $('.category-filter').on('click', function(e) {
            e.preventDefault();  // Prevent the link from navigating
            var category = $(this).data('category');
            $('#filter-category').val(category); // Set category to hidden form field for price filter
            updateProducts(category, $('#min_price').val(), $('#max_price').val());
        });

        // Price slider
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [0, 10000],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            },
            stop: function(event, ui) {
                // Call function on slider stop
                updateProducts($('#filter-category').val(), ui.values[0], ui.values[1]);
            }
        });

        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));

        // Prevent the price filter form from submitting normally
        $('#price-filter-form').on('submit', function(e) {
            e.preventDefault();
            updateProducts($('#filter-category').val(), $('#min_price').val(), $('#max_price').val());
        });


        // Function to update product list via AJAX
        function updateProducts(category, min_price, max_price) {
            $.ajax({
                url: "{{ route('products') }}",
                type: "GET",
                data: {
                    category: category,
                    min_price: min_price,
                    max_price: max_price
                },
                success: function(data) {
                    $("#product-grid-container").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", status, error);
                    // Optionally display an error message to the user
                }
            });
        }
    });
</script>

@include('layout.footer')