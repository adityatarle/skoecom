@include('dashboard.layout.header')

<div class="container" style="margin-top: 30px;">
    <h2 style="font-size: 1.8rem; margin-bottom: 20px; color: #fff; text-align:center;">Edit Review</h2>
   <div style="display:flex; align-items:center; justify-content:center;">
         <div style="width: 600px; max-width: 100%; padding: 20px; border: 1px solid #555; border-radius: 8px; background-color: #333;">
             <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}">
                  @csrf
                    @method('PUT')
                  <div class="mb-3">
                     <label for="name" class="form-label" style="color: #ddd;">Name</label>
                      <input type="text" class="form-control" value="{{ $review->name }}" readonly style="background-color: #444; color: #ddd; border-color: #555;">
                  </div>
                   <div class="mb-3">
                       <label for="email" class="form-label" style="color: #ddd;">Email</label>
                       <input type="text" class="form-control" value="{{ $review->email }}" readonly style="background-color: #444; color: #ddd; border-color: #555;">
                   </div>
                  <div class="mb-3">
                       <label for="review_text" class="form-label" style="color: #ddd;">Review</label>
                    <textarea class="form-control" rows="4" readonly style="background-color: #444; color: #ddd; border-color: #555;">{{$review->review_text}}</textarea>
                </div>
                 <div class="mb-3">
                     <label for="rating" class="form-label" style="color: #ddd;">Rating</label>
                     <input type="number" class="form-control"  value="{{ $review->rating }}" readonly style="background-color: #444; color: #ddd; border-color: #555;">
                </div>
                  <div class="mb-3">
                      <label for="is_approved" class="form-label" style="color: #ddd;">Status</label>
                     <select class="form-control" id="is_approved" name="is_approved" required style="background-color: #444; color: #ddd; border-color: #555;">
                         <option value="1" {{ $review->is_approved ? 'selected' : '' }}>Approve</option>
                         <option value="0" {{ !$review->is_approved ? 'selected' : '' }}>Decline</option>
                     </select>
                  </div>
                 <button type="submit" class="btn btn-primary" style="border-radius: 4px; padding: 10px 20px; transition: background-color 0.3s ease; background-color:#555; color: #ddd; border-color:#777;">Update Status</button>
             </form>
           </div>
   </div>
</div>
@include('dashboard.layout.footer')