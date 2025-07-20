<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function changeLanguage($local): RedirectResponse
    {

        if ($local == 'ar' || $local == 'en') {
            app()->setLocale($local);
            App::setLocale($local);
            Config::set('translatable.locale', $local);
            Session::put('lang', $local);

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
