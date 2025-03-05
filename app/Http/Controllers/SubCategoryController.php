<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        // Get all subcategories with their category names
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id', // Fix: Use 'category_id' instead of 'category_id'
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory = new Subcategory();
        $subcategory->name = $request->input('name');
        $subcategory->category_id = $request->input('category_id'); // Fix: Store category_id instead of category_id

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $subcategory->image = 'images/' . $imageName;
        }

        $subcategory->save();

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory created successfully');
    }


    public function edit(Subcategory $subcategory)
    {
        $categories = ProductCategory::all();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id', // Fix: Use 'category_id'
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory->name = $request->input('name');
        $subcategory->category_id = $request->input('category_id'); // Fix: Store category_id instead of category_id

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                unlink(public_path($subcategory->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $subcategory->image = 'images/' . $imageName;
        }

        $subcategory->save();

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory updated successfully');
    }


    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory deleted successfully');
    }

    public function getByCategory(Request $request)
    {
        $subcategories = \App\Models\Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

}
