<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\ApiController;
use App\Http\Traits\ProductTrait;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteProductController extends ApiController
{
    use ProductTrait;

    public function addToFavorite(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|numeric|exists:products,id',
        ]);

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        if (Favorite::query()->where('product_id', $request->get('product_id'))->where('user_id', $user->id)->exists()) {
            $favorite = Favorite::query()->where('product_id', $request->get('product_id'))->where('user_id', $user->id)->first();
            $favorite->delete();
            $msg = __('api.item_removed_from_wish_list');
        } else {
            $user->wishList()->attach($request->get('product_id'));
            $msg = __('api.item_added_to_wish_list');
        }

        return $this->respondSuccess($msg);
    }

    public function getFavorite(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $favorites = $user->wishList()->paginate($limit);

        $favoritesPage = $this->likedByUser($favorites, $user)->all();

        return $this->respondSuccess($favoritesPage, $this->createApiPaginator($favorites));
    }
}
