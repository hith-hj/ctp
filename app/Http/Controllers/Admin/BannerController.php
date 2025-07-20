<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $bannerRepository;

    public $resource = 'banner';

    public function __construct(BannerRepository $bannerRepository)
    {
        appendGeneralPermissions($this);
        $this->bannerRepository = $bannerRepository;
        view()->share('item', $this->resource);
        view()->share('class', Banner::class);

    }

    public function index()
    {
        $banners = $this->bannerRepository
            ->getBanners()
            ->paginate(10);

        return view('admin.crud.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.crud.edit-new');

    }

    public function store(Request $request): RedirectResponse
    {
        $this->bannerRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.banners.create');
        }

        return redirect()->route('admin.banners.index');
    }

    public function edit(Banner $banner)
    {
        return view('admin.crud.edit-new', compact('banner'));

    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $this->bannerRepository->update($request, $banner);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.banners.index');
    }

    public function destroy(Request $request, Banner $banner)
    {
        $this->bannerRepository->delete($banner);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.banners.index');
    }

    public function getModels(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $model = $request->get('model');
        $displayColumn = $request->get('displayColumn');
        $models = $model::query();

        if ($request->has('searchColumns')) {
            $searchColumns = unserialize(urldecode($request->get('searchColumns')));
            if ($searchColumns[0]['isTranslate']) {
                $models = $models->whereHas('translations', function ($query) use ($searchColumns, $search) {

                    $query->Where($searchColumns[0]['columnName'], 'LIKE', "%{$search}%");
                });
            } else {
                $models->Where($searchColumns[0]['columnName'], 'LIKE', "%{$search}%");
            }

            unset($searchColumns[0]);

            foreach ($searchColumns as $searchColumn) {
                if ($searchColumn['isTranslate']) {
                    $models = $models->whereHas('translations', function ($query) use ($searchColumn, $search) {
                        $query
                            ->orWhere($searchColumn['columnName'], 'LIKE', "%{$search}%");
                    });
                } else {
                    $models->orWhere($searchColumn['columnName'], 'LIKE', "%{$search}%");
                }
            }
        } else {
            switch ($model) {
                case 'App\Models\Admin':
                    $models = $models->role(['retail', 'service-provider', 'shipping-provider'])->where($request->get('searchColumn'), 'LIKE', "%{$search}%");
                    break;
                default:
                    $models = $models->where($request->get('searchColumn'), 'LIKE', "%{$search}%");
                    break;
            }
        }
        $models = $models->take(5)
            ->get()->map(function ($result) use ($displayColumn) {
                return [
                    'id' => $result->id,
                    'text' => $result->$displayColumn,
                ];
            });

        return response()->json([
            'results' => $models,
        ]);
    }
}
