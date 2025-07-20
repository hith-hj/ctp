<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceRepository
{
    public function add(Request $request)
    {
        $service = new Service(populateModelData($request, Service::class));

        $service->featured_image = uploadFile('featured_image', 'services');
        $service->images = uploadMultiImages('images', 'services');
        $service->category()->associate($request->get('category'));

        if (! auth()->user()->hasRole('Admin')) {
            $service->admin_id = auth()->id();
        }
        $service->save();
    }

    public function update(Request $request, Service $service)
    {
        $service->update(populateModelData($request, Service::class));
        $service->featured_image = uploadFile('featured_image', 'services', $service->featured_image);
        $service->images = uploadMultiImages('images', 'services', $service->images);
        $service->category()->associate($request->get('category'));
        $service->save();
    }

    public function delete(Service $service)
    {
        if ($service->featured_image != null) {
            Storage::disk('public')->delete($service->featured_image);
        }

        if ($service->images != null) {
            foreach ($service->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $service->delete();
    }

    public function getServices(Request $request, $withOwner = false): Builder
    {
        if ($withOwner) {
            $services = Service::query()->with('owner');
        } else {
            $services = Service::query();
        }

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $services->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        if ($maxPrice = $request->get('max_price')) {
            $services->where('price', '<', $maxPrice);
        }

        if ($minPrice = $request->get('min_price')) {
            $services->where('price', '>', $minPrice);
        }

        if ($adminId = $request->get('portal_id')) {
            $services->where('admin_id', $adminId);
        }

        if ($categoryId = $request->get('category_id')) {
            $services->where('category_id', $categoryId);
        }

        if ($categoryId = $request->get('category')) {
            $category = Category::query()->find($categoryId);
            if ($category && $category->parent_category) {
                $services->where('category_id', $categoryId);
            } elseif ($category) {
                $ids = $category->subcategories()->get()->pluck('id')->toArray();
                $services->whereIn('category_id', $ids);
            }
        }

        if (Auth::check() && auth()->user()->hasRole(['retail', 'grocery'])) {
            $services = $services->where('admin_id', auth()->id());
        }

        return $services;
    }

    public function servicesAutoComplete($search)
    {
        $services = Service::query();
        $tokens = convertToSeparatedTokens($search);

        $services->whereHas('translations', function ($query) use ($tokens) {
            $query
                ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
        });

        if (! auth()->user()->hasRole('Admin')) {
            $services = $services->where('admin_id', auth()->id());
        }

        return $services
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name,
                ];
            });
    }

    public function getServicesDataTable(Request $request): LengthAwarePaginator
    {
        $services = Service::query();

        if ($request->has('query')) {
            if (isset($request->get('query')['status']) != null) {
                $services->where('status', $request->get('query')['status']);
            }

            if (isset($request->get('query')['category']) != null) {
                $services->where('category_id', $request->get('query')['category']);
            }

            if (isset($request->get('query')['from_date']) != null) {
                $services->where('created_at', '>=', $request->get('query')['from_date']);
            }

            if (isset($request->get('query')['to_date']) != null) {
                $services->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
            }

            if (isset($request->get('query')['search']) != null) {
                $tokens = convertToSeparatedTokens($request->get('query')['search']);

                $services->whereHas('translations', function ($query) use ($tokens) {
                    $query
                        ->whereRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE)', $tokens);
                });
            }
        }

        if ($request->has('sort')) {
            if ($request->get('sort')['field'] == 'name') {
                $services = $services->orderByTranslation($request->get('sort')['field'], $request->get('sort')['sort'] ?? 'asc')
                    ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
            } else {
                $services = $services->orderBy($request->get('sort')['field'], $request->get('sort')['sort'] ?? 'asc')
                        ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
            }
        } else {
            $services = $services->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        }

        return $services;

    }
}
