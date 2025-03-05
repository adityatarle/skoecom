<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\Storage;  // Remove Storage Facade

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new ProductCategory();
        $category->name = $request->input('name');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
             $image->move(public_path('images'), $imageName); // Move to public/images
            $category->image = 'images/' . $imageName;  // Store the path
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }

    public function edit(ProductCategory $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
           'name' => 'required|unique:product_categories,name,' . $category->id,
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

         $category->name = $request->input('name');

        if ($request->hasFile('image')) {
            // Delete the previous image if it exists
            if ($category->image) {
                $fullPath = public_path($category->image);
                if(file_exists($fullPath)) {
                   unlink($fullPath);
                }
            }
            
           $image = $request->file('image');
           $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName); // Move to public/images
            $category->image = 'images/' . $imageName;  // Store the path
        }

        $category->save();

        return Redirect::route('admin.category.index')->with('success', 'Category updated successfully!');
    }

   public function destroy(ProductCategory $category)
    {
       if ($category->products()->count() > 0) {
          return Redirect::route('admin.category.index')->with('error', 'Cannot delete category if it has assigned products!');
       }
         // Delete the image from the disk before deleting the record
         if($category->image){
            $fullPath = public_path($category->image);
              if (file_exists($fullPath)) {
                  unlink($fullPath);
              }
           }

       $category->delete();

       return Redirect::route('admin.category.index')->with('success', 'Category deleted successfully!');
   }
}