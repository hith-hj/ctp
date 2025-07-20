<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $request->request->add(['status' => 1]);
        $categories = $this->categoryRepository
            ->getCategories($request, $request->get('category_id'))
            ->paginate($limit);

        return $this->respondSuccess($categories->all(), $this->createApiPaginator($categories));

    }

    public function category($id): JsonResponse
    {
        $category = Category::query()->with('products')->where('id', $id)->first();

        if (! $category) {
            return $this->respondError(__('api.category_not_found'));
        }

        return $this->respondSuccess(
            $category
        );
    }

    public function categoryWithSubs($id): JsonResponse
    {
        $category = Category::with('subcategories')->where('id', $id)->first();

        if (! $category) {
            return $this->respondError(__('api.category_not_found'));
        }

        return $this->respondSuccess(
            $category
        );
    }

    public function withSubs(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $request->request->add(['status' => 1]);

        $categories = $this->categoryRepository
            ->getCategories($request, $request->get('category_id'), true)
            ->paginate($limit);

        return $this->respondSuccess($categories->all(), $this->createApiPaginator($categories));

    }
}
