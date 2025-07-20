<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\ApiController;
use App\Models\Attribute;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function attributes(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $request->request->add(['status' => 1]);
        $categories = $this->categoryRepository
            ->getCategories($request)
            ->paginate($limit);

        $minPrice = Product::query()->min('price');
        $maxPrice = Product::query()->max('price');

        $attributes = Attribute::all()->makeVisible('values');
        $attributes->each(function ($attribute) {
            $attribute->{$attribute->type} = $attribute->values;
        });

        return $this->respondSuccess([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'categories' => $categories->all(),
            'attributes' => $attributes,
        ], $this->createApiPaginator($categories));

    }
}
