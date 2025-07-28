<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\ProductPricingDetail;
use App\Models\Subcategory; // Make sure Subcategory model is imported
use Illuminate\Http\Request;
use HTMLPurifier;         // Import HTMLPurifier
use HTMLPurifier_Config;  // Import HTMLPurifier Config

class ProductController extends Controller
{

    // --- Helper function to configure and run HTMLPurifier ---
    private function purifyHtml($dirtyHtml)
    {
        $config = HTMLPurifier_Config::createDefault();

        // --- Configure Allowed HTML Elements and Attributes ---
        // Adjust this list based on exactly what you want to allow from Summernote
        $config->set('HTML.Allowed',
            'p[style],strong,b,em,i,u,ul,ol,li,' . // Basic text & lists
            'a[href|title|target|style],' .      // Links (allow href, title, target, style)
            'br,' .                             // Line breaks
            'span[style],' .                     // Spans (allow style for inline formatting)
            'h1[style],h2[style],h3[style],h4[style],h5[style],h6[style],' . // Headings
            'img[src|alt|title|width|height|style],' . // Images (if you allow them in description)
            'blockquote[style],' .              // Blockquotes
            'table[summary|style|class|width|border|cellspacing|cellpadding],' . // Tables
            'thead,tbody,tfoot,tr,' .            // Table structure
            'th[style|scope|abbr|colspan|rowspan],' . // Table headers
            'td[style|colspan|rowspan]'          // Table cells
        );

        // --- Configure Allowed CSS Properties (if using inline styles) ---
        // Be specific here for security. Add only properties you trust.
        $config->set('CSS.AllowedProperties',
            'text-align, font-weight, font-style, text-decoration,' . // Basic text styles
            'color, background-color,' .       // Colors
            'width, height,' .                 // Dimensions (useful for images/tables)
            'border, border-collapse, border-spacing, padding, margin' // Table/layout styles
            // Add more properties if needed, e.g., 'font-size', 'list-style-type'
        );

        // --- Optional: Other Configurations ---
        $config->set('AutoFormat.AutoParagraph', true); // Automatically add <p> tags
        $config->set('AutoFormat.RemoveEmpty', true);   // Remove empty tags like <p></p>
        $config->set('HTML.TargetBlank', true);         // Make external links open in a new tab

        $purifier = new HTMLPurifier($config);
        return $purifier->purify($dirtyHtml);
    }


    public function index()
    {
        $products = Product::with('images')->latest()->paginate(10);
        return view('admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation remains the same
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Description is just a string initially
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Added webp
            'components' => 'required|array',
            'components.*.name' => 'required|string',
            'components.*.weight' => 'nullable|numeric',
            'components.*.rate' => 'nullable|numeric',
            'components.*.total_value' => 'required|numeric'
        ]);

        // *** Purify the description HTML ***
        $clean_description = $this->purifyHtml($request->input('description', '')); // Pass empty string if null

        $product = new Product();
        $product->name = $request->input('name');
        // *** Use the purified description ***
        $product->description = $clean_description;
        $product->category_id = $request->input('category_id');
        $product->sub_category_id = $request->input('sub_category_id');
        $product->price = $request->input('price');
        $product->labour_charges = $request->input('labour_charges');
        $product->gst_percentage = $request->input('gst_percentage');
        $product->save(); // Save product first to get ID

        // Store Pricing Details
        if ($request->has('components')) {
            foreach ($request->components as $component) {
                ProductPricingDetail::create([
                    'product_id' => $product->id,
                    'component' => $component['name'],
                    'weight' => $component['weight'] ?? null,
                    'rate' => $component['rate'] ?? null,
                    'total_value' => $component['total_value']
                ]);
            }
        }

        // Store product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Consider using a more robust way to generate unique names if needed
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName); // Store in a 'products' subfolder
                ProductImage::create([
                    'product_id' => $product->id,
                    // Store relative path from public directory
                    'image_path' => 'images/products/' . $imageName,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $product->load('pricingDetails', 'images'); // Eager load relationships

        return view('admin.product.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        // Validation remains the same
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Description is just a string initially
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Added webp
            'components' => 'required|array',
            'components.*.name' => 'required|string',
            'components.*.weight' => 'nullable|numeric',
            'components.*.rate' => 'nullable|numeric',
            'components.*.total_value' => 'required|numeric',
            'removed_images' => 'nullable|string' // Expecting JSON string of image IDs
        ]);

        // *** Purify the description HTML ***
        $clean_description = $this->purifyHtml($request->input('description', '')); // Pass empty string if null

        // Update Product Details
        $product->update([
            'name' => $request->input('name'),
            // *** Use the purified description ***
            'description' => $clean_description,
            'category_id' => $request->input('category_id'),
            'sub_category_id' => $request->input('sub_category_id'),
            'price' => $request->input('price'),
            'labour_charges' => $request->input('labour_charges'),
            'gst_percentage' => $request->input('gst_percentage')
        ]);

        // Update Product Pricing Details (Remove Old & Insert New)
        $product->pricingDetails()->delete(); // More Eloquent way
        if ($request->has('components')) {
            foreach ($request->components as $component) {
                // Use create directly on the relationship
                $product->pricingDetails()->create([
                    'component' => $component['name'],
                    'weight' => $component['weight'] ?? null,
                    'rate' => $component['rate'] ?? null,
                    'total_value' => $component['total_value']
                ]);
            }
        }

        // Handle Image Removal
        if ($request->filled('removed_images')) {
             try {
                // Attempt to decode JSON, handle potential errors
                $removeImageIds = json_decode($request->input('removed_images'), true, 512, JSON_THROW_ON_ERROR);

                if (!empty($removeImageIds) && is_array($removeImageIds)) {
                    // Find images belonging to this product with the given IDs
                    $imagesToRemove = $product->images()->whereIn('id', $removeImageIds)->get();

                    foreach ($imagesToRemove as $image) {
                        $filePath = public_path($image->image_path);
                        if (file_exists($filePath)) {
                            @unlink($filePath); // Use @ to suppress errors if file is already gone
                        }
                        $image->delete(); // Delete the database record
                    }
                }
             } catch (\JsonException $e) {
                  // Log the error or handle it appropriately
                  \Log::error('Failed to decode removed_images JSON: ' . $e->getMessage());
             }
        }


        // Handle New Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                // Use create directly on the relationship
                $product->images()->create([
                    'image_path' => 'images/products/' . $imageName,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Optional: Delete associated images from storage first
        foreach ($product->images as $image) {
            $filePath = public_path($image->image_path);
            if (file_exists($filePath)) {
                 @unlink($filePath);
            }
        }
        // Deleting the product might cascade delete images/pricing via model relationships if set up

        $product->delete(); // This should trigger cascade deletes if set up in migrations/models
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully!');
    }


    // --- Inquiry Methods ---
    public function storeInquiry(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        ProductInquiry::create($validatedData); // Use validated data
        return response()->json(['message' => 'Thank you for submitting your inquiry! We will be in touch soon.']);
    }

    public function showInquiries()
    {
        $productInquiries = ProductInquiry::with('product')->latest()->paginate(10);
        return view('admin.product.inquiries', compact('productInquiries'));
    }

    public function destroyInquiry(ProductInquiry $productInquiry)
    {
        $productInquiry->delete();
        return redirect()->back()->with('success', 'Product inquiry deleted successfully!');
    }

    // --- Route for Subcategory AJAX ---
     public function getSubcategoriesByCategory(Request $request)
     {
         $request->validate(['category_id' => 'required|integer|exists:product_categories,id']);
         $subcategories = Subcategory::where('category_id', $request->category_id)->get(['id', 'name']);
         return response()->json($subcategories);
     }
}