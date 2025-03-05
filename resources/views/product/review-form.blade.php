@include('layout.header')

<div class="container" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px;">
    <h2 style="font-size: 1.8rem; margin-bottom: 20px; color: #343a40; text-align: center;">Add a Review for {{ $product->name }}</h2>
    
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('product.review') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <div class="mb-3">
            <label class="form-label">Rating</label>
            <div class="d-flex align-items-center gap-2">
                <input type="hidden" id="rating" name="rating" value="{{ old('rating') }}">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            @error('rating')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="review_text" class="form-label">Your Review</label>
            <textarea class="form-control" id="review_text" name="review_text" rows="4" required>{{ old('review_text') }}</textarea>
            @error('review_text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        


        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        
        
        <div class="mb-3">
            <label for="image" class="form-label">Image Upload (optional)</label>
            <input type="file" class="form-control" id="image" name="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        
        <div class="mb-3">
            <button type="submit" class="btn btn-primary" style="border-radius: 4px; padding: 10px 20px; transition: background-color 0.3s ease;">Submit Review</button>
        </div>
    </form>
</div>

@include('layout.footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.dataset.value;
                ratingInput.value = rating;
                stars.forEach(s => s.style.color = s.dataset.value <= rating ? '#ffc107' : '#ddd');
            });
        });

        // Set initial state
        const savedRating = ratingInput.value || 0;
        stars.forEach(s => s.style.color = s.dataset.value <= savedRating ? '#ffc107' : '#ddd');
    });
</script>

<style>
    .star {
        font-size: 2rem;
        cursor: pointer;
        color: #ddd;
        transition: color 0.3s ease;
    }
    .star:hover {
        color: #ffc107;
    }
</style>
