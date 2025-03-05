<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
   {
       $request->validate([
           'is_approved' => 'required|boolean',
       ]);

       $review->update(['is_approved' => $request->is_approved]);

       return redirect()->route('admin.reviews.index')->with('success', 'Review status updated successfully.');
    }

    public function destroy(Review $review)
   {
      $review->delete();
       return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
   }

}