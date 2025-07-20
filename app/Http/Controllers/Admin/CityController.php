<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    private $cityRepository;

    public $resource = 'city';

    public function __construct(CityRepository $cityRepository)
    {
        appendGeneralPermissions($this);
        $this->cityRepository = $cityRepository;
        view()->share('item', $this->resource);
        view()->share('class', City::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $cities = $this->cityRepository
            ->getCities($request)
            ->paginate(10);

        return view('admin.crud.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request): RedirectResponse
    {
        $this->cityRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.cities.create');
        }

        return redirect()->route('admin.cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(City $city)
    {
        return view('admin.crud.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(City $city)
    {
        return view('admin.crud.edit-new', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city): RedirectResponse
    {
        $this->cityRepository->update($request, $city);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.cities.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, City $city): RedirectResponse
    {
        $this->cityRepository->delete($city);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.cities.index');
    }
}
