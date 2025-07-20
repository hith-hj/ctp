<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingExtraController extends Controller
{
    public $resource = 'setting';

    public function __construct()
    {
        appendGeneralPermissions($this);
        view()->share('item', $this->resource);
        view()->share('class', Setting::class);
        view()->share('custom', true);
    }

    public function about()
    {
        $setting = Setting::where('key', 'app.about-us')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function contact()
    {
        $setting = Setting::where('key', 'app.contact-us')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function terms()
    {
        $setting = Setting::where('key', 'app.terms-conditions')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function privacy()
    {
        $setting = Setting::where('key', 'app.privacy-policy')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function accessibility()
    {
        $setting = Setting::where('key', 'app.accessibility')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function adminEmail()
    {
        $setting = Setting::where('key', 'admin.email')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function adminName()
    {
        $setting = Setting::where('key', 'admin.name')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function siteEmail()
    {
        $setting = Setting::where('key', 'site.email')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function sitePhone()
    {
        $setting = Setting::where('key', 'site.mobile')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function currencyRate()
    {
        $setting = Setting::where('key', 'site.currency-rate')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function newArrivalImage()
    {
        $setting = Setting::where('key', 'site.new-arrivals-image')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function footerAddress()
    {
        $setting = Setting::where('key', 'site.footer-address')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function aboutTitle()
    {
        $setting = Setting::where('key', 'app.about-us-title')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function aboutImage()
    {
        $setting = Setting::where('key', 'app.about-us-image')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }

    public function aboutAlbum()
    {
        $setting = Setting::where('key', 'app.about-us-album')->first();

        return view('admin.crud.edit-new', compact('setting'));
    }
}
