<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\ApiController;
use App\Http\Traits\ProductTrait;
use App\Models\Admin;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\RecentlyView;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    private $productRepository;

    use ProductTrait;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request): JsonResponse
    {

        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $request->request->add(['status' => 1]);

        $user = $this->getUser($request);

        $products = $this->productRepository
            ->getProducts($request);

        if ($request->has('new')) {
            $products = $products->orderByDesc('id')
                ->paginate($limit);
        } else {
            $products = $products->paginate($limit);
        }

        if ($user) {
            $productsPage = $this->likedByUser($products, $user)->all();
        } else {
            $productsPage = $products->all();
        }

        return $this->respondSuccess($productsPage, $this->createApiPaginator($products));
    }

    public function modernProduct(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $request->request->add(['status' => 1]);

        $user = $this->getUser($request);

        $products = $this->productRepository
            ->getProducts($request)
            ->orderByDesc('id')
            ->paginate($limit);

        if ($user) {
            $productsPage = $this->likedByUser($products, $user)->all();
        } else {
            $productsPage = $products->all();
        }

        return $this->respondSuccess($productsPage, $this->createApiPaginator($products));
    }

    public function product($id, Request $request): JsonResponse
    {

        $product = Product::query()
            ->with('owner')
            ->where('id', $id)
            ->first();

        if (! $product) {
            return $this->respondError(__('api.product_not_found'));
        }

        $user = $this->getUser($request);

        if ($user) {
            $product->liked_by = $product->isLikedBy($user);

            RecentlyView::query()->updateOrCreate(
                ['product_id' => $product->id, 'user_id' => $user->id],
                ['product_id' => $product->id, 'user_id' => $user->id]
            );

        }

        return $this->respondSuccess($product);
    }

    public function myProducts(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondSuccess(__('api.user_not_found'));
        }

        $userId = $user->id;

        $products = CartItem::query()
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($limit);

        $productsPage = $this->likedByUser($products, $user)->all();

        return $this->respondSuccess($productsPage, $this->createApiPaginator($products));
    }

    public function companies(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $vendors = Admin::query()
            ->role(['retail', 'service-provider', 'grocery'])
            ->paginate($limit);

        return $this->respondSuccess($vendors->all(), $this->createApiPaginator($vendors));

    }
}
