<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('type')->orderBy('sort_order')->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:slider,fullwidth,newsletter',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'price_text' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Store in public disk
                $path = $image->storeAs('banners', $imageName, 'public');
                $data['image'] = 'storage/' . $path;
                
                // Ensure the file exists
                if (!Storage::disk('public')->exists('banners/' . $imageName)) {
                    throw new \Exception('Failed to store image file');
                }
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])->withInput();
            }
        }

        $data['is_active'] = $request->boolean('is_active');

        Banner::create($data);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'type' => 'required|in:slider,fullwidth,newsletter',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'price_text' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                // Delete old image
                if ($banner->image) {
                    $oldPath = str_replace('storage/', '', $banner->image);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Store in public disk
                $path = $image->storeAs('banners', $imageName, 'public');
                $data['image'] = 'storage/' . $path;
                
                // Ensure the file exists
                if (!Storage::disk('public')->exists('banners/' . $imageName)) {
                    throw new \Exception('Failed to store image file');
                }
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])->withInput();
            }
        }

        $data['is_active'] = $request->boolean('is_active');

        $banner->update($data);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        // Delete image file
        if ($banner->image) {
            $path = str_replace('storage/', '', $banner->image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        
        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner status updated successfully.');
    }
}