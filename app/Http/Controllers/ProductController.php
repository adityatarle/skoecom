<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\ProductPricingDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function header()
{
    $categories = ProductCategory::with('subcategories')->get();
    return view('layout.header', compact('categories'));
}

    public function index()
    {
        $products = Product::with('images')->latest()->paginate(10); // Fetch 10 products per page
        return view('admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.product.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'components' => 'required|array',
            'components.*.name' => 'required|string',
            'components.*.weight' => 'nullable|numeric',
            'components.*.rate' => 'nullable|numeric',
            'components.*.total_value' => 'required|numeric'
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = strip_tags($request->input('description'), '<p><a><b><strong><i><ul><li><br><span>');
        $product->category_id = $request->input('category_id');
        $product->sub_category_id = $request->input('sub_category_id'); // ✅ Store subcategory
        $product->price = $request->input('price');
        $product->labour_charges = $request->input('labour_charges'); // Store labour charges
        $product->gst_percentage = $request->input('gst_percentage'); // Store GST percentage
        $product->save();

        foreach ($request->components as $component) {
            ProductPricingDetail::create([
                'product_id' => $product->id,
                'component' => $component['name'],
                'weight' => $component['weight'] ?? null,
                'rate' => $component['rate'] ?? null,
                'total_value' => $component['total_value']
            ]);
        }

        // Store product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'images/' . $imageName,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }


    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        // Fetch subcategories based on the selected category
        $subcategories = \App\Models\Subcategory::where('category_id', $product->category_id)->get();

        // Load product pricing details
        $product->load('pricingDetails', 'images');

        return view('admin.product.edit', compact('product', 'categories', 'subcategories'));
    }



    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'components' => 'required|array',
            'components.*.name' => 'required|string',
            'components.*.weight' => 'nullable|numeric',
            'components.*.rate' => 'nullable|numeric',
            'components.*.total_value' => 'required|numeric'
        ]);

        // Update Product Details
        $product->update([
            'name' => $request->input('name'),
            'description' => strip_tags($request->input('description'), '<p><a><b><strong><i><ul><li><br><span>'),
            'category_id' => $request->input('category_id'),
            'sub_category_id' => $request->input('sub_category_id'),
            'price' => $request->input('price'),
            'labour_charges' => $request->input('labour_charges'),
            'gst_percentage' => $request->input('gst_percentage')
        ]);

        // Update Product Pricing Details (Remove Old & Insert New)
        ProductPricingDetail::where('product_id', $product->id)->delete();
        foreach ($request->components as $component) {
            ProductPricingDetail::create([
                'product_id' => $product->id,
                'component' => $component['name'],
                'weight' => $component['weight'] ?? null,
                'rate' => $component['rate'] ?? null,
                'total_value' => $component['total_value']
            ]);
        }

        // Handle Image Removal
        if ($request->input('removed_images')) {
            $removeImages = json_decode($request->input('removed_images'), true);
            if (!empty($removeImages)) {
                $imagesToRemove = ProductImage::whereIn('id', $removeImages)->get();
                foreach ($imagesToRemove as $image) {
                    if (file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path)); // Delete from storage
                    }
                    $image->delete();
                }
            }
        }

        // Handle Image Upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'images/' . $imageName,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }




    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully!');
    }

    public function storeInquiry(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        ProductInquiry::create($request->all());
        return response()->json(['message' => 'Thank you for submitting your inquiry! We will be in touch soon.']);
    }

    // Add this method to handle showing inquiries
    public function showInquiries()
    {
        $productInquiries = ProductInquiry::with('product')->latest()->paginate(10); // Fetch 10 inquiries per page
        return view('admin.product.inquiries', compact('productInquiries'));
    }

    public function destroyInquiry(ProductInquiry $productInquiry)
    {
        $productInquiry->delete();
        return redirect()->back()->with('success', 'Product inquiry deleted successfully!');
    }
}
