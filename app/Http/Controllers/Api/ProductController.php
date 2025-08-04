<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products with pagination and filters
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'category_id' => 'nullable|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort_by' => 'nullable|in:name,price,created_at',
            'sort_order' => 'nullable|in:asc,desc',
            'search' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = Product::with(['category', 'subcategory', 'images', 'pricingDetails']);

            // Apply filters
            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->sub_category_id) {
                $query->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->min_price) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->max_price) {
                $query->where('price', '<=', $request->max_price);
            }

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }

            // Apply sorting
            $sortBy = $request->sort_by ?? 'created_at';
            $sortOrder = $request->sort_order ?? 'desc';
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = $request->per_page ?? 15;
            $products = $query->paginate($perPage);

            // Transform data for API response
            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'labour_charges' => $product->labour_charges,
                    'gst_percentage' => $product->gst_percentage,
                    'featured' => $product->featured,
                    'on_sale' => $product->on_sale,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'subcategory' => $product->subcategory ? [
                        'id' => $product->subcategory->id,
                        'name' => $product->subcategory->name
                    ] : null,
                    'images' => $product->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => $image->image_path,
                            'is_primary' => $image->is_primary ?? false
                        ];
                    }),
                    'pricing_breakup' => $product->getPricingBreakup(),
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => [
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                        'from' => $products->firstItem(),
                        'to' => $products->lastItem()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific product
     */
    public function show(Product $product)
    {
        try {
            $product->load(['category', 'subcategory', 'images', 'pricingDetails']);

            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'labour_charges' => $product->labour_charges,
                'gst_percentage' => $product->gst_percentage,
                'featured' => $product->featured,
                'on_sale' => $product->on_sale,
                'category' => $product->category ? [
                    'id' => $product->category->id,
                    'name' => $product->category->name
                ] : null,
                'subcategory' => $product->subcategory ? [
                    'id' => $product->subcategory->id,
                    'name' => $product->subcategory->name
                ] : null,
                'images' => $product->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => $image->image_path,
                        'is_primary' => $image->is_primary ?? false
                    ];
                }),
                'pricing_breakup' => $product->getPricingBreakup(),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Product retrieved successfully',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get featured products
     */
    public function featured(Request $request)
    {
        try {
            $perPage = $request->per_page ?? 10;
            $products = Product::with(['category', 'subcategory', 'images'])
                ->where('featured', true)
                ->latest()
                ->paginate($perPage);

            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'featured' => $product->featured,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'images' => $product->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => $image->image_path,
                            'is_primary' => $image->is_primary ?? false
                        ];
                    }),
                    'created_at' => $product->created_at
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Featured products retrieved successfully',
                'data' => [
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve featured products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products on sale
     */
    public function onSale(Request $request)
    {
        try {
            $perPage = $request->per_page ?? 10;
            $products = Product::with(['category', 'subcategory', 'images'])
                ->where('on_sale', true)
                ->latest()
                ->paginate($perPage);

            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'on_sale' => $product->on_sale,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'images' => $product->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => $image->image_path,
                            'is_primary' => $image->is_primary ?? false
                        ];
                    }),
                    'created_at' => $product->created_at
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Sale products retrieved successfully',
                'data' => [
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve sale products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2|max:255',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = $request->query;
            $perPage = $request->per_page ?? 15;

            $products = Product::with(['category', 'subcategory', 'images'])
                ->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhereHas('subcategory', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->latest()
                ->paginate($perPage);

            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'featured' => $product->featured,
                    'on_sale' => $product->on_sale,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'subcategory' => $product->subcategory ? [
                        'id' => $product->subcategory->id,
                        'name' => $product->subcategory->name
                    ] : null,
                    'images' => $product->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => $image->image_path,
                            'is_primary' => $image->is_primary ?? false
                        ];
                    }),
                    'created_at' => $product->created_at
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Search results retrieved successfully',
                'data' => [
                    'query' => $query,
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                        'from' => $products->firstItem(),
                        'to' => $products->lastItem()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}