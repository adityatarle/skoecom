<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = [
            // Contact Information
            'contact_address' => Setting::get('contact_address', ''),
            'contact_phone' => Setting::get('contact_phone', ''),
            'contact_email' => Setting::get('contact_email', ''),
            
            // Homepage SEO
            'seo_home_title' => Setting::get('seo_home_title', config('app.name')),
            'seo_home_description' => Setting::get('seo_home_description', ''),
            'seo_home_keywords' => Setting::get('seo_home_keywords', ''),
            
            // Footer Links
            'footer_home' => Setting::get('footer_home', '/'),
            'footer_store' => Setting::get('footer_store', '/products'),
            'footer_promotion' => Setting::get('footer_promotion', '/promotion'),
            'footer_privacy' => Setting::get('footer_privacy', '/privacy-policy'),
            'footer_terms' => Setting::get('footer_terms', '/terms-of-use'),
            'footer_sitemap' => Setting::get('footer_sitemap', '/sitemap'),
            'footer_support' => Setting::get('footer_support', '/support'),
            'footer_contacts' => Setting::get('footer_contacts', '/contact'),
            
            // Newsletter Settings
            'newsletter_title' => Setting::get('newsletter_title', 'Our Newsletter'),
            'newsletter_description' => Setting::get('newsletter_description', 'Get E-mail updates about our latest shop and special offers.'),
            'newsletter_placeholder' => Setting::get('newsletter_placeholder', 'Email address...'),
            'newsletter_button_text' => Setting::get('newsletter_button_text', 'Subscribe'),
        ];
        
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'contact_address' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            
            'seo_home_title' => 'nullable|string|max:60',
            'seo_home_description' => 'nullable|string|max:160',
            'seo_home_keywords' => 'nullable|string|max:255',
            
            'footer_home' => 'nullable|string|max:255',
            'footer_store' => 'nullable|string|max:255',
            'footer_promotion' => 'nullable|string|max:255',
            'footer_privacy' => 'nullable|string|max:255',
            'footer_terms' => 'nullable|string|max:255',
            'footer_sitemap' => 'nullable|string|max:255',
            'footer_support' => 'nullable|string|max:255',
            'footer_contacts' => 'nullable|string|max:255',
            
            'newsletter_title' => 'nullable|string|max:100',
            'newsletter_description' => 'nullable|string|max:255',
            'newsletter_placeholder' => 'nullable|string|max:100',
            'newsletter_button_text' => 'nullable|string|max:50',
        ]);

        $settings = $request->only([
            'contact_address', 'contact_phone', 'contact_email',
            'seo_home_title', 'seo_home_description', 'seo_home_keywords',
            'footer_home', 'footer_store', 'footer_promotion', 'footer_privacy',
            'footer_terms', 'footer_sitemap', 'footer_support', 'footer_contacts',
            'newsletter_title', 'newsletter_description', 'newsletter_placeholder', 'newsletter_button_text'
        ]);

        foreach ($settings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully!');
    }
}