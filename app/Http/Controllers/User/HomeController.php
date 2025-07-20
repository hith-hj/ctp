<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        // $banners = Banner::query()->sorted()->get();
        $offers = DB::table('offers')->get();
        $sliders = Slider::query()->sorted()->get();
        $products = Product::query()->active()->sorted()->orderByDesc('created_at')->take(3)->get();
        $listProduct = Product::query()->active()->inRandomOrder()->take(8)->get();
        $subCategories = Category::query()->active()->whereNotNull('parent_category')->get();

        return view('website.pages.home', compact('sliders', 'products', 'listProduct', 'subCategories', 'offers'));
    }

    public function categories()
    {
        $categories = Category::query()->active()->whereNull('parent_category')->get();

        return view('website.pages.category.main-categories', compact('categories'));
    }

    public function changeLang()
    {
        if ($local = request('lang')) {
            app()->setLocale(request('lang'));
            App::setLocale($local);
            Config::set('translatable.locale', $local);
            Session::put('lang', $local);

            return redirect()->back();
        }
    }

    public function about()
    {
        return view('website.pages.about');
    }

    public function contact()
    {
        return view('website.pages.contact');
    }

    public function contactUs(Request $request)
    {
        $request->validate([
            'name' => 'string|max:20',
            'email' => 'string|email:dns',
            'message' => 'string|max:400',
        ]);
        $lastEmail = Contact::where([['email', $request->email], ['name', $request->name]])->latest()->first();
        if (! is_null($lastEmail) && $lastEmail->created_at->addDays(1) > now()) {
            Session::flash('error', 'You need to wait 1 day to send again');

            return redirect()->back();
        }
        $mail = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        Mail::to('info@click-to-pick.com')->send(new ContactUs($mail->name, $mail->email, $mail->message));
        Session::flash('success', 'Your message is sent');

        return redirect()->route('user.index');
    }
}
