<?php

namespace App\Http\Traits;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

trait ProductTrait
{
    public function addAttributes(Request $request, Product $product)
    {
        if ($request->has('attributes')) {
            foreach ($request->get('attributes') as $key => $attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $key,
                    'value' => $attribute,
                ]);
            }
        }
    }

    public function updateAttributes(Request $request, Product $product)
    {
        if ($request->has('attributes')) {
            $productAttributes = $product->attributes()->pluck('attributes.id')->toArray();
            foreach ($request->get('attributes') as $key => $attribute) {

                if ($attribute) {

                    $attributeObject = Attribute::find($key);
                    if ($attributeObject->type == 'checkbox') {
                        $attribute = $attribute == 'on' || $attribute == 1 ? '1' : '0';
                    }

                    $productAttributes = array_diff($productAttributes, [$key]);

                    ProductAttribute::updateOrCreate([
                        'product_id' => $product->id,
                        'attribute_id' => $key,
                    ], [
                        'product_id' => $product->id,
                        'attribute_id' => $key,
                        'value' => $attribute,
                    ]);

                }
                ProductAttribute::where('product_id', $product->id)->whereIn('attribute_id', $productAttributes)->delete();
            }
        }
    }

    public function uploadMedia(Request $request, Product $product): Product
    {
        if ($request->hasFile('images')) {
            $imagesNames = [];
            foreach ($request->file('images') as $image) {
                $imageName = Storage::disk('public')->put('products', $image);
                ImageOptimizer::optimize('storage/'.$imageName);

                array_push($imagesNames, $imageName);
            }
            $product->images = $imagesNames;
        }

        if ($request->hasFile('featured_image')) {
            $product->featured_image = Storage::disk('public')->put('products/featured', $request->file('featured_image'));
            ImageOptimizer::optimize('storage/'.$product->featured_image);
        }

        return $product;
    }

    public function updateMedia(Request $request, Product $product)
    {
        if ($request->hasFile('images')) {
            // if there is an old image delete it
            if ($product->images != null) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // store the new image
            $imageNames = [];
            foreach ($request->file('images') as $image) {
                $imageName = Storage::disk('public')->put('products', $image);
                ImageOptimizer::optimize('storage/'.$imageName);
                array_push($imageNames, $imageName);
            }
            $product->images = $imageNames;
        }
        if ($request->hasFile('featured_image')) {
            Storage::disk('public')->delete($product->featured_image);
            $product->featured_image = Storage::disk('public')->put('products/featured', $request->file('featured_image'));
            //            ImageOptimizer::optimize('storage/'.$product->featured_image);
        }

        return $product;
    }

    public function addColors(Request $request): array
    {
        $colors = [];
        if ($request->has('colors')) {
            foreach ($request->get('colors') as $color) {
                $colors[] = $color['colors'];
            }

        }

        return $colors;
    }

    public function addSizes(Request $request): array
    {
        $sizes = [];
        if ($request->has('sizes')) {
            $sizes = [];
            foreach ($request->get('sizes') as $size) {
                $sizes[] = $size['sizes'];
            }
        }

        return $sizes;
    }
}
