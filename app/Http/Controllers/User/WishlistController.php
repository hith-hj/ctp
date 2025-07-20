<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;

class WishlistController extends Controller
{
    public function index()
    {
        $user = User::with('wishlist')->findOrFail(auth('user')->id());
        $favorites = $user->wishlist()->paginate(10);

        return view('website.pages.wishlist', compact('user', 'favorites'));
    }

    public function store(Product $product)
    {
        $user = auth('user')->user();
        if (Favorite::whereProductId($product->id)->whereUserId($user->id)->exists()) {
            $favorite = Favorite::whereProductId($product->id)->whereUserId($user->id)->first();
            $favorite->delete();
            $itemCount = getCountWishlistItems();

            return response()->json(['message' => 'success', 'value' => __('front.item_removed_from_wish_list'), 'deleted' => 1, 'countItems' => $itemCount]);
        } else {
            $user->wishList()->attach($product->id);
        }
        $itemCount = getCountWishlistItems();

        return response()->json(['message' => 'success', 'status' => 200, 'value' => $product->id, 'countItems' => $itemCount]);
    }
}
