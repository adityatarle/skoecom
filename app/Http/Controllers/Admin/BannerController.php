<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banner.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banners'), $imageName);
            $data['image'] = 'images/banners/' . $imageName;
        }
        Banner::create($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully!');
    }
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }
    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banners'), $imageName);
            $data['image'] = 'images/banners/' . $imageName;
        }
        $banner->update($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully!');
    }
    public function destroy(Banner $banner)
    {
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully!');
    }
}