<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        // Get all subcategories with their category names and parent subcategory
        $subcategories = Subcategory::with(['category', 'parentSubcategory'])->get();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $parentSubcategories = Subcategory::whereNull('parent_subcategory_id')->get();
        return view('admin.subcategory.create', compact('categories', 'parentSubcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'parent_subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory = new Subcategory();
        $subcategory->name = $request->input('name');
        $subcategory->category_id = $request->input('category_id');
        $subcategory->parent_subcategory_id = $request->input('parent_subcategory_id');

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
        $parentSubcategories = Subcategory::whereNull('parent_subcategory_id')
            ->where('id', '!=', $subcategory->id)
            ->get();
        return view('admin.subcategory.edit', compact('subcategory', 'categories', 'parentSubcategories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'parent_subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory->name = $request->input('name');
        $subcategory->category_id = $request->input('category_id');
        $subcategory->parent_subcategory_id = $request->input('parent_subcategory_id');

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
        $subcategories = Subcategory::where('category_id', $request->category_id)
            ->whereNull('parent_subcategory_id')
            ->get();
        return response()->json($subcategories);
    }

    public function getSubcategoriesByParent(Request $request)
    {
        $subcategories = Subcategory::where('parent_subcategory_id', $request->parent_id)->get();
        return response()->json($subcategories);
    }
}
