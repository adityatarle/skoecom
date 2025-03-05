@include('layout.header')

<div class="container product-details-container" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div class="row">
        <!-- Existing Product Details (your code) -->
        <div class="col-md-6">
            <div class="product-image-container" style="display: flex; flex-direction: column; align-items: center; border: 1px solid #ddd; border-radius: 8px; padding: 10px; margin-bottom: 20px;">
                <div id="main-image-container" style="width: 100%; margin-bottom: 10px;">
                    @if($product->images->first())
                    <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="product-image" style="max-width: 100%; height: auto; display: block; border-radius: 8px; cursor:zoom-in;" id="main-image">
                    @else
                    <p>No image</p>
                    @endif
                </div>
                <div class="image-thumbnails" style="display: flex; flex-wrap: wrap; justify-content: center;">
                    @foreach ($product->images as $image)
                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="thumbnail" data-image="{{ asset($image->image_path) }}" style="width: 70px; height: 70px; object-fit: cover; margin: 5px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 product-info" style="padding: 20px; overflow-y: auto; max-height: 600px;">
            <h1 class="product-title" style="font-size: 2.5rem; margin-bottom: 10px; font-weight: 500; color: #343a40;">{{ $product->name }}</h1>
            <div class="product-meta" style="margin-bottom: 15px; ">
                <p class="product-category" style="font-style: italic; color: #777; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; max-width:100%;">
                    Category: {{ $product->category->name ?? 'N/A' }}
                </p>
                @if($reviews->count() > 0)
                <div class="average-rating" style="font-size: 1rem;">
                    @php
                    $averageRating = $reviews->avg('rating');
                    @endphp
                    <span style="vertical-align: middle;">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <=$averageRating)
                            <svg width="20" height="20" class="text-primary" style="vertical-align: middle; margin-right:2px;">
                            <use xlink:href="#star-solid"></use>
                            </svg>
                            @else
                            <svg width="16" height="16" class="text-secondary" style="vertical-align: middle; margin-right:2px;">
                                <use xlink:href="#star"></use>
                            </svg>
                            @endif
                            @endfor
                    </span>

                </div>
                @endif
            </div>
            <p class="product-price" style="font-size: 2rem; font-weight: bold; color: #28a745; margin-bottom: 20px;">
            ₹{{ $product->price }}
            </p>
            <div class="product-actions" style="margin-top: 25px;">
                <button class="btn btn-success checkout-btn" style="border-radius: 4px; padding: 10px 20px; white-space: nowrap; transition: background-color 0.3s ease; background-color: #28a745; border-color: #28a745;" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    Checkout
                </button>
                 <a href="{{ route('product.review.create', $product->id) }}" class="btn btn-outline-secondary" style="margin-left:10px">Write a Review</a>
                 <button class="btn btn-outline-primary share-btn" style="margin-left:10px">Share Product</button>
            </div>
            <div class="product-description" style="line-height: 1.7; margin-bottom: 25px; color: #444;  overflow-wrap: break-word;">
                {!! $product->description !!}
            </div>
        </div>
    </div>
    <a href="/" class="btn btn-secondary back-button" style="margin-top: 30px;">Back to Products</a>

     <!-- Added Benefits Section -->
     <div class="container-fluid" style="margin-top:50px;">
        <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
            <div class="col">
                <div class="card mb-3 border-0">
                    <div class="row">
                        <div class="col-md-2 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z" />
                            </svg>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body p-0">
                                <h5>Free Shipping on Orders Over $50</h5>
                                <p class="card-text">Enjoy complimentary delivery on orders that meet a minimum of $50.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border-0">
                    <div class="row">
                        <div class="col-md-2 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                            </svg>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body p-0">
                                <h5>Secure Online Payments</h5>
                                <p class="card-text">Shop with confidence using our secure payment gateway, ensuring your transactions are protected.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border-0">
                    <div class="row">
                        <div class="col-md-2 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                            </svg>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body p-0">
                                <h5>Authenticity Guaranteed</h5>
                                <p class="card-text">We stand by the quality of our saffron, ensuring you receive 100% genuine and pure product.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border-0">
                    <div class="row">
                        <div class="col-md-2 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                            </svg>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body p-0">
                                <h5>Save with Special Offers</h5>
                                <p class="card-text">Take advantage of exclusive discounts and promotions on our range of saffron products.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border-0">
                    <div class="row">
                        <div class="col-md-2 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                            </svg>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body p-0">
                                <h5>Hand-Picked Freshness</h5>
                                <p class="card-text">We provide the freshest handpicked saffron, ensuring each strand meets our stringent quality standards.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <!-- Related Products Section -->
    @if ($relatedProducts->count() > 0)
    <div style="margin-top: 50px;">
        
        <div id="related-products-carousel" class="carousel slide" data-bs-ride="carousel">
        <h2 style="font-size: 1.8rem; margin-bottom: 20px; color: #343a40; text-align:center;">Related Products</h2>
            <div class="carousel-inner">
                @foreach ($relatedProducts->chunk(3) as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center">
                        @foreach ($chunk as $relatedProduct)
                        <div class="card mx-2" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; width: 30%; transition: transform 0.3s ease;">
                            <a href="{{ route('product.details', $relatedProduct->id) }}" style="text-decoration:none; color:inherit;">
                                @if($relatedProduct->images->first())
                                <img src="{{ asset($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}" class="card-img-top" style="height:200px; object-fit:cover; cursor:pointer;">
                                @else
                                <img src="{{ asset('no-image.jpg') }}" alt="No image" class="card-img-top" style="height:200px; object-fit:cover; cursor:pointer;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 1.2rem; margin-bottom: 8px; color: #343a40; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $relatedProduct->name }}
                                    </h5>
                                    <p class="card-text" style="font-weight:bold; color: #28a745;">${{ $relatedProduct->price }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#related-products-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#related-products-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    @endif
    <!-- Reviews Section -->
    <div class="reviews-section" style="margin-top: 50px; padding: 20px;">
        <h2 style="font-size: 1.8rem; margin-bottom: 20px; color: #343a40; text-align:center;">Customer Reviews</h2>
        @if($reviews->count() > 0)
        <ul class="list-unstyled">
            @foreach($reviews as $review)
            <li class="review-item" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                <div class="review-header d-flex justify-content-between align-items-center">
                    <div class="review-name-email">
                        <h6 style="font-weight: bold; margin-bottom: 5px;">{{ $review->name }}</h6>
                        
                    </div>
                    <div class="rating">
                        @for($i=0;$i<$review->rating; $i++)
                            <svg width="24" height="24" class="text-primary">
                                <use xlink:href="#star-solid"></use>
                            </svg>
                            @endfor
                    </div>
                </div>
                @if($review->image_path)
                <div class="review-image mt-2">
                    <img src="{{ asset($review->image_path) }}" alt="Review Image" style="max-width: 150px; max-height:150px; margin-bottom: 10px;">
                </div>
                @endif
                <p class="review-text" style="line-height: 1.6; color: #444;">{{ $review->review_text }}</p>
            </li>
            @endforeach
        </ul>
        @else
        <p style="text-align: center;">No reviews yet.</p>
        @endif
    </div>

</div>
<!-- Existing Modal (your code) -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Product Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productInquiryForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <!-- <div class="mb-3">
                     <label for="email" class="form-label">Email</label>
                     <input type="email" class="form-control" id="email" name="email" required>
                 </div> -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
                <div id="formResponse" style="display: none; margin-top: 10px;" class="alert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitInquiry">Submit Inquiry</button>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')

<script>
   // Share product functionality
     document.querySelector('.share-btn').addEventListener('click', async () => {
         const shareData = {
           title: document.querySelector('.product-title').innerText,
           url: window.location.href,
         };
         try {
           await navigator.share(shareData);
            console.log('Shared successfully');
         } catch (err) {
            console.error('Error sharing:', err);
            alert('There was a problem sharing this product.');
         }
       });

  document.getElementById('submitInquiry').addEventListener('click', function() {
      const form = document.getElementById('productInquiryForm');
      const formData = new FormData(form);
      const formResponseDiv = document.getElementById('formResponse');

      fetch('{{ route('product.inquiry') }}', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: formData,
      })
          .then(response => {
              if (response.ok) {
                  return response.json();
              }
              throw new Error('Network response was not ok.');
          })
          .then(data => {
              formResponseDiv.textContent = data.message;
              formResponseDiv.classList.add('alert-success');
              formResponseDiv.style.display = 'block';
              form.reset()
           
              setTimeout(() => {
                    window.location.reload(); // Refresh the page
                }, 1000); // Adjust the delay as needed (optional delay)
          })
          .catch(error => {
              formResponseDiv.textContent = 'There was a problem submitting the form: ' + error.message;
              formResponseDiv.classList.add('alert-danger');
              formResponseDiv.style.display = 'block';
          });
  });

  document.querySelectorAll('.thumbnail').forEach(thumbnail => {
      thumbnail.addEventListener('click', function() {
          const mainImage = document.getElementById('main-image');
          const newImageSrc = this.getAttribute('data-image');
          mainImage.src = newImageSrc;
      });
  });
 </script>