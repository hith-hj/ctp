<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CategoryTranslation;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function search(Request $request): string
    {
        $search = $request->get('query');

        $results = Search::new()
            ->add(CategoryTranslation::class, 'name')
            ->add(ProductTranslation::class, ['name', 'description'])
            ->add(Product::class, 'sku')
            ->add(User::class, ['name', 'email'])
            ->add(Admin::class, ['name', 'email', 'username'])
            ->beginWithWildcard()
            ->endWithWildcard()
            ->orderByDesc()
            ->paginate(10)
            ->get($search)
            ->all();

        $dataNone = '<div class="quick-search-result"><div class="text-muted">No record found</div>';
        if (! count($results)) {
            return $dataNone;
        }

        $dataHtml = '<div class="font-size-sm text-primary font-weight-bolder text-uppercase mb-2">Results</div>';
        $dataHtml .= '<div class="mb-10">';
        $ids = [];
        foreach ($results as $result) {
            if (! in_array($result->id, $ids)) {
                $item = $this->manipulateData($result);
                $dataHtml .= view('admin.layouts.panels._search_item', compact('item'));
                array_push($ids, $result->id);
            }
        }
        $dataHtml .= '<div class="mb-10">';
        $dataHtml .= '</div>';

        return $dataHtml;
    }

    public function manipulateData($result)
    {
        $className = class_basename($result);
        switch ($className) {
            case 'ProductTranslation':
                $result = $result->product;
                $result->image = $result->featured_image;
                $result->url = route('admin.products.show', ['product' => $result->id]);
                $result->class = __('admin.product');
                break;
            case 'CategoryTranslation':
                $result = $result->category;
                $result->url = route('admin.categories.show', ['category' => $result->id]);
                $result->class = __('admin.category');
                break;
            case 'Product':
                $result->image = $result->featured_image;
                $result->url = route('admin.products.show', ['product' => $result->id]);
                $result->class = __('admin.product');
                break;
            case 'Admin':
                $result->image = $result->avatar;
                $result->url = route('admin.admins.show', ['admin' => $result->id]);
                $result->class = $result->hasRole('supplier') ? __('admin.supplier') : ($result->hasRole('vendor') ? __('admin.vendor') : __('admin.admin'));
                break;
            case 'User':
                $result->image = $result->avatar;
                $result->url = route('admin.users.show', ['user' => $result->id]);
                $result->class = $result->is_designer ? __('user.designer') : __('user.client');
                break;
        }

        return $result;
    }
}
