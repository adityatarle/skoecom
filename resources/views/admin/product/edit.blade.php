@include('dashboard.layout.header')

<div class="container">
    <h1 style="color: black;">Edit Product Item</h1>
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
         <input type="hidden" name="removed_images" id="removed_images" value=""/>
        <div class="mb-3">
            <label for="name" class="form-label" style="color: black;">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required style="background-color: white; color: black;">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label" style="color: black;">Description</label>
            <textarea name="description" id="description" class="form-control" style="background-color: white; color: black;">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label" style="color: black;">Category</label>
            <select name="category_id" id="category_id" class="form-control" style="background-color: white; color: black;">
                <option value="" style="color: black;">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }} style="color: black;">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label" style="color: black;">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $product->price }}" required style="background-color: white; color: black;">
        </div>

         <div class="mb-3">
            <label class="form-label" style="color: black;">Images</label>
              <div id="image-container">
               @if($product->images)
                 @foreach($product->images as $image)
                    <div class="input-group mb-3 image-input"  data-image-id="{{ $image->id }}">
                        <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                        <button type="button" class="btn btn-danger remove-image" data-image-id="{{$image->id}}">Remove</button>
                         <div class="image-preview-container" style="display: block;">
                             <img src="{{ asset($image->image_path) }}" class="image-preview"  style="max-width: 100px;"/>
                         </div>
                    </div>
                  @endforeach
                @endif
                <div class="input-group mb-3 image-input">
                    <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                     <button type="button" class="btn btn-danger remove-image">Remove</button>
                     <div class="image-preview-container" style="display: none;">
                          <img src="" class="image-preview"  />
                     </div>
                 </div>
              </div>
                <button type="button" class="btn btn-secondary" id="add-image">Add Image</button>
        </div>


        <button type="submit" class="btn btn-primary">Update Product Item</button>
    </form>
</div>

<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="modal-crop-container">
              <img id="modal-image-preview" src="" alt="Image preview" style="max-width: 100%;" />
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="modal-crop-button">Crop & Save</button>
      </div>
    </div>
  </div>
</div>
@include('dashboard.layout.footer')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css" rel="stylesheet"/>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.js"></script>

<script>
    $(document).ready(function() {
        $('#description').summernote({
            height: 300,
        });

        let imageCount = {{ $product->images->count() > 0 ? $product->images->count() : 1 }};
         let removedImages = [];
        $('#add-image').click(function(){
            if (imageCount < 5){
                 $('#image-container').append( `
                       <div class="input-group mb-3 image-input">
                            <input type="file" name="images[]" class="form-control image-upload" accept="image/*">
                             <button type="button" class="btn btn-danger remove-image">Remove</button>
                             <div class="image-preview-container" style="display: none;">
                                  <img src="" class="image-preview"  />
                            </div>
                         </div>
                      `);
                  imageCount++;
            }
             if (imageCount >= 5){
                $('#add-image').hide()
            }
        });

        $('#image-container').on('click', '.remove-image', function(){
           let imageId = $(this).data('image-id')
            if(imageId){
                removedImages.push(imageId)
                 $('#removed_images').val(JSON.stringify(removedImages));
            }

               $(this).closest('.image-input').remove();
                imageCount--;
                if (imageCount < 5) {
                    $('#add-image').show();
                }

        });
      let cropper = null;

        $('#image-container').on('change', '.image-upload', function(e){
            let currentInput = $(this); // Capture the input element
            let currentPreview = $(this).siblings('.image-preview-container').find('.image-preview'); // Capture the preview element
             let file = e.target.files[0];
            
            if (file){
                let reader = new FileReader()
                reader.onload = function(event){
                    let modalImage = $('#modal-image-preview');
                    modalImage.attr('src',event.target.result)
                    $('#cropModal').modal('show')
                }
            reader.readAsDataURL(file);
            
            $('#cropModal').off('shown.bs.modal').on('shown.bs.modal', function (e) {
                let modalImage = $('#modal-image-preview');
                if (cropper){
                        cropper.destroy();
                    }
                    cropper = new Cropper(modalImage[0],{
                        aspectRatio: 1,
                        viewMode: 1,
                        crop: function (event) {}
                    });
             });

             $('#cropModal').off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    if(cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
             });
             $('#modal-crop-button').off('click').on('click', function(event){
                
                   let croppedCanvas = cropper.getCroppedCanvas({
                        width: 200,
                        height: 200,
                     });
                    croppedCanvas.toBlob(function (blob) {
                        let file = new File([blob], "cropped_image.jpg", {type: "image/jpeg"});
                        let filelist = [file];
                        let container = new DataTransfer();
                        for(let i=0; i < filelist.length; i++){
                            container.items.add(filelist[i]);
                        }
                        currentInput[0].files = container.files;
                        
                        // Update the preview with the cropped image inside closure
                        let previewReader = new FileReader()
                        previewReader.onload = function (event) {
                             currentPreview.attr('src', event.target.result).parent().show();
                            $('#cropModal').modal('hide');
                        }
                       previewReader.readAsDataURL(file);
                      });
                 });
          }
       });
    });
</script>