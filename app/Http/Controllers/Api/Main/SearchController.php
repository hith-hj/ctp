<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\ApiController;
use App\Models\CategoryTranslation;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends ApiController
{
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('query');

        $results = Search::new()
            ->add(CategoryTranslation::class, 'name')
            ->add(ProductTranslation::class, ['name', 'description'])
            ->add(Product::class, 'sku')
            ->beginWithWildcard()
            ->endWithWildcard()
            ->orderByDesc()
            ->paginate(10)
            ->get($search)
            ->all();

        if (! count($results)) {
            return $this->respondSuccess([]);
        }

        $items = [];
        foreach ($results as $result) {
            if (! in_array($result, $items)) {
                $item = $this->manipulateData($result);
                array_push($items, $item);
            }
        }

        return $this->respondSuccess($items);
    }

    public function manipulateData($result)
    {
        $className = class_basename($result);
        switch ($className) {
            case 'ProductTranslation':
                $result = $result->product;
                $result->image = $result->featured_image;
                $result->class = __('admin.product');
                break;
            case 'CategoryTranslation':
                $result = $result->category;
                $result->class = __('admin.category');
                break;
            case 'Product':
                $result->image = $result->featured_image;
                $result->class = __('admin.product');
                break;
            case 'Admin':
                $result->image = $result->avatar;
                $result->class = $result->hasRole('vendor') ? __('admin.vendor') : $result->hasRole('Admin');
                break;
        }

        return $result;
    }
}
