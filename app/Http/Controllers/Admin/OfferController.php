<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public $resource = 'offer';

    public function __construct()
    {
        view()->share('item', $this->resource);
        view()->share('class', Setting::class);
    }

    public function index()
    {
        $offers = DB::table('offers')->get();

        return view('admin.offers.index', ['offers' => $offers]);
    }

    public function create(Request $request)
    {
        $products = Product::get(['id']);
        if (! $request->filled('id')) {
            return view('admin.offers.create', ['products' => $products]);
        }
        $offer = DB::table('offers')->where('id', $request->id)->first();

        return view('admin.offers.create', ['offer' => $offer, 'products' => $products]);
    }

    public function storeOffer(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:150'],
            'image' => ['required', 'image', 'dimensions:max_width=400,max_height=400'],
            'product_id' => ['nullable', 'exists:products,id'],
        ]);
        $data['sort_order'] = $request->input('sort_order') ?? 1;
        $data['image'] = Storage::disk('public')->put('offers', $request->file('image'));
        $offer = DB::table('offers')->insert($data);

        return redirect()->route('admin.offers.index')->with('success', 'Offer is created');
    }

    public function updateOffer(Request $request, $id)
    {
        $offer = DB::table('offers')->where('id', $id);
        if (! $offer->exists()) {
            return redirect()->back()->with('error', 'Offer is not found');
        }
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:150'],
            'image' => ['sometimes', 'required', 'image', 'dimensions:max_width=400,max_height=400'],
            'product_id' => ['nullable', 'exists:products,id'],
        ]);
        try {
            if ($request->has('image') && $request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('offers', $request->file('image'));
                Storage::disk('public')->delete($offer->first()->image);
            }
            $offer->update($data);

            return redirect()->route('admin.offers.index')->with('success', 'Offer is updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'something went wrong try again later');
        }
    }

    public function deleteOffer($id)
    {
        $offer = DB::table('offers')->where('id', $id);
        if ($offer->exists()) {
            Storage::disk('public')->delete($offer->first()->image);
            $offer->delete();

            return redirect()->route('admin.offers.index')->with('success', 'offer is deleted');
        } else {
            return redirect()->back()->with('error', 'offer is not found');
        }
    }
}
