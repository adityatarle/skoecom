@include('dashboard.layout.header')

<div class="container">
    <h1>Product Inquiries</h1>

    @if (count($productInquiries) > 0)
        <table class="table">
            <thead>
                <tr>
                     <th>Product</th>
                     <th>Name</th>
                     <th>Quantity</th>
                     <th>Phone</th>
                     <th>Message</th>
                     <th>Submitted At</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach($productInquiries as $inquiry)
                     <tr>
                         <td>{{ $inquiry->product->name }}</td>
                         <td>{{ $inquiry->name }}</td>
                         <td>{{ $inquiry->quantity }}</td>
                         <td>{{ $inquiry->phone ?? 'N/A' }}</td>
                         <td>{{ $inquiry->message }}</td>
                         <td>{{ $inquiry->created_at }}</td>
                         <td>
                             <form action="{{ route('admin.product.inquiry.destroy', $inquiry->id) }}" method="POST" style="display: inline-block;">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this inquiry?')">Delete</button>
                             </form>
                         </td>
                     </tr>
                 @endforeach
             </tbody>
         </table> <br>
          {{ $productInquiries->links() }}
    @else
        <p>No product inquiries yet.</p>
    @endif
</div>

@include('dashboard.layout.footer')