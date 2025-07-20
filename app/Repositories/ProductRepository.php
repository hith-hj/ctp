<?php

namespace App\Repositories;

use App\Http\Traits\ProductTrait;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductRepository
{
    use ProductTrait;

    public function add(Request $request)
    {
        $product = new Product(populateModelData($request, Product::class));
        $product->category()->associate($request->get('category'));
        $product = $this->uploadMedia($request, $product);
        $product->admin_id = Admin::role('Admin')->first()->id;
        $product->save();
        $this->addAttributes($request, $product);

        return $product;
    }

    public function getCategories()
    {

    }

    public function update(Request $request, Product $product)
    {
        $product->update(populateModelData($request, Product::class));
        $product->category()->associate($request->get('category'));
        $product = $this->updateMedia($request, $product);
        $product->save();
        $this->updateAttributes($request, $product);
    }

    public function delete(Product $product)
    {
        $inventory = DB::table('inventory')->where('product_id', $product->id);
        if ($inventory->exists()) {
            $inventory->delete();
        }
        $ranges = DB::table('product_price_ranges')->where('product_id', $product->id);
        if ($ranges->exists()) {
            $ranges->delete();
        }
        $product->delete();
    }

    public function getProducts(Request $request): Builder
    {

        $products = Product::query();

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $products->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        if ($categories = $request->categories) {
            if (gettype($categories) != 'array') {
                $categories = explode(',', $categories);
            }
            $products->whereIn('category_id', $categories);
        }

        if ($categoryId = $request->get('category')) {
            $category = Category::query()->find($categoryId);
            if ($category && $category->parent_category) {
                $products->where('category_id', $categoryId);
            } elseif ($category) {
                $ids = $category->subcategories()->get()->pluck('id')->toArray();
                $products->whereIn('category_id', $ids);
            }
        }

        if ($request->filled('max_price')) {
            $products->where('price', '<=', $request->max_price);
        }

        if ($request->filled('min_price')) {
            $products->where('price', '>=', $request->min_price);
        }

        if ($adminId = $request->get('portal_id')) {
            $products->where('admin_id', $adminId);
        }

        if ($request->has('sort_by')) {
            if (isset($request->sort_by['price']) && ! is_null($request->sort_by['price']) && in_array($request->sort_by['price'], ['asc', 'desc'])) {
                $products->orderBy('price', $request->sort_by['price']);
            }
            if (isset($request->sort_by['created_at']) && ! is_null($request->sort_by['created_at']) && in_array($request->sort_by['created_at'], ['asc', 'desc'])) {
                $products->orderBy('created_at', $request->sort_by['created_at']);
            }
        }
        /** FILTER BY ATTRIBUTES **/
        $attributes = preg_grep('/^attribute_[1-9]+$/', array_keys($request->all()));
        $attributes = $request->only($attributes);

        if ($attributes) {
            $products->whereHas('values', function ($query) use ($attributes) {
                foreach ($attributes as $key => $attribute) {
                    $id = (int) (string) Str::of($key)->replace('attribute_', '');
                    $query->where('attribute_id', $id)
                        ->where('value', $attribute);
                }
            });
        }

        if (Auth::check() && auth()->user()->hasRole(['Admin'])) {
            $products = $products->where('admin_id', auth()->id());
        }

        return $products;
    }

    public function productsAutoComplete($search)
    {
        $products = Product::query();
        $tokens = convertToSeparatedTokens($search);

        $products->whereHas('translations', function ($query) use ($tokens) {
            $query
                ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
        });
        $products->orWhereRaw('MATCH(sku) AGAINST(? IN BOOLEAN MODE)', $tokens);

        if (! auth()->user()->hasRole('Admin')) {
            $products = $products->where('admin_id', auth()->id());
        }

        return $products
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name.' ('.$result->sku.') ',
                ];
            });
    }

    public function getProductsDataTable(Request $request): LengthAwarePaginator
    {
        $products = Product::query();

        if ($request->has('query')) {
            if (isset($request->get('query')['status']) != null) {
                $products->where('status', $request->get('query')['status']);
            }

            if (isset($request->get('query')['from_date']) != null) {
                $products->where('created_at', '>=', $request->get('query')['from_date']);
            }

            if (isset($request->get('query')['category']) != null) {
                $products->where('category_id', $request->get('query')['category']);
            }

            if (isset($request->get('query')['to_date']) != null) {
                $products->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
            }

            if (isset($request->get('query')['search']) != null) {
                $tokens = convertToSeparatedTokens($request->get('query')['search']);

                $products->whereHas('translations', function ($query) use ($tokens) {
                    $query
                        ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
                });
                $products->orWhereRaw('MATCH(sku) AGAINST(? IN BOOLEAN MODE)', $tokens);
            }
        }

        if ($request->has('sort')) {
            if ($request->get('sort')['field'] == 'name') {
                $products = $products->orderByTranslation($request->get('sort')['field'], $request->get('sort')['sort'] ?? 'asc')
                    ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
            } else {
                $products = $products->orderBy($request->get('sort')['field'], $request->get('sort')['sort'] ?? 'asc')
                        ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
            }
        } else {
            $products = $products->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        }

        return $products;

    }
}
