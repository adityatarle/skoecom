@include('dashboard.layout.header')

<div class="container" style="background-color: white;">
    <h1 style="text-align:center; margin-bottom: 20px;">Product Items</h1>
     <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom:15px;">
         <a href="{{ route('admin.product.create') }}" class="btn btn-primary">Add New Product Item</a>
           @if(session('success'))
             <div class="alert alert-success">{{ session('success') }}</div>
         @endif
    </div>
    <div class="table-responsive">
       <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                 <tr>
                    <td title="{{ $product->name }}" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                       {{ Str::limit($product->name, 30) }}
                    </td>
                    <td title="{{ strip_tags($product->description) }}"
                        style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {!! Str::limit(strip_tags($product->description), 50) !!}
                    </td>

                     <td>{{ $product->price }}</td>
                    <td>
                       <div style="display:flex; flex-wrap: wrap;">
                           @if($product->images->isNotEmpty())
                                @foreach ($product->images as $image)
                                  <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" width="50" style="margin-right: 5px; margin-bottom: 5px;">
                                 @endforeach
                           @else
                             No Image
                          @endif
                     </div>
                    </td>
                    <td>
                         <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                           <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                       </form>
                    </td>
                 </tr>
                 @endforeach
             </tbody>
        </table>
        {{ $products->links() }}
    </div>
</div>
@include('dashboard.layout.footer')
