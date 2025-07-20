<?php

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

function getMainCategories()
{
    return Category::active()->whereNull('parent_category')->orderBy('sort_order')->get();
}

function getMainProductCategories()
{
    return Category::query()->active()->sorted()->whereNull('parent_category')->paginate(9);
}
function getBannerCategories()
{
    return Category::active()
        ->whereNull('parent_category')
        ->whereHas('subcategories', function ($query) {
            $query->withCount('products')
                ->having('products_count', '>', 0);
        })
        ->take(3)->get();
}

function getLastProducts(Category $category)
{
    $categories = Category::query()->active()
        ->where('parent_category', $category->id)->pluck('id');

    return Product::query()->active()->orderByDesc('created_at')
        ->whereIn('category_id', $categories)->take(4)->get();

}

function getRandomProducts(Category $category)
{
    $categories = Category::query()->active()
        ->where('parent_category', $category->id)->pluck('id');

    return Product::query()->active()
        ->whereIn('category_id', $categories)->
        inRandomOrder()->take(8)->get();
}

function getbanner(Category $category)
{
    $baner = Banner::query()->where('model_id', $category->id)->first();

    return $baner;
}

function getCountCartItems(): int
{
    $cart = Cart::with('items')->notActive()
        ->where('user_id', auth('user')->id())
        ->orderByDesc('created_at')->first();
    if ($cart) {
        if ($cart->items) {
            return count($cart->items);
        }
    }

    return 0;
}

function getCountWishlistItems(): int
{

    $user = auth('user')->user();
    if (! $user) {
        return 0;
    }

    $items = $user->wishList()->count();
    if ($items) {
        return $items;
    }

    return 0;
}

function checkCurrentLang(): bool
{
    if (session()->get('lang') == 'ar') {
        return true;
    }

    return false;
}

function getTotalPrice($subTotalPrice, $shippingPrice): float
{
    $finalPrice = $subTotalPrice + $shippingPrice;

    return round($finalPrice, 2);
}

function getSetting($key)
{
    return DB::table('admin_setting')->where('setting_key', $key)->pluck('setting_value')->first();
}
