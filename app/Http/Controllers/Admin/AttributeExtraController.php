<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Repositories\AttributeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeExtraController extends Controller
{
    private $attributeRepository;

    public $resource = 'attribute';

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
        view()->share('item', $this->resource);
        view()->share('class', Attribute::class);
    }

    public function attributesAutoComplete(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $models = $this->attributeRepository->attributesAutoComplete($search);

        return response()->json([
            'results' => $models,
        ]);
    }

    public function getCategoryAttributes(Request $request): JsonResponse
    {
        $category = Category::find($request->get('id'));
        $product = Product::find($request->get('product'));
        $html = '';

        if ($category) {
            if ($product) {
                foreach ($category->attributes as $attribute) {
                    $productAttribute = ProductAttribute::where('product_id', $product->id)
                        ->where('attribute_id', $attribute->id)->first();
                    if ($productAttribute) {
                        $oldValue = $productAttribute->value;
                    } else {
                        $oldValue = null;
                    }

                    $html .= renderAttributeInput($attribute, $oldValue);
                }
            } else {
                foreach ($category->attributes as $attribute) {
                    $html .= renderAttributeInput($attribute);
                }
            }
        }

        return response()->json([
            'id' => $request->get('id'),
            'htmlResponse' => $html,
        ]);
    }
}
