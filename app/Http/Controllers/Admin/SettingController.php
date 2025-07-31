<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }
    public function update(Request $request)
    {
        $fields = [
            'contact_address', 'contact_phone', 'contact_email',
            'seo_home_title', 'seo_home_description', 'seo_home_keywords',
            'footer_home', 'footer_store', 'footer_promotion', 'footer_privacy', 'footer_terms', 'footer_sitemap', 'footer_support', 'footer_contacts'
        ];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field, ''));
        }
        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully!');
    }
}