<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Repositories\SliderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    private $sliderRepository;

    public $resource = 'slider';

    public function __construct(SliderRepository $sliderRepository)
    {
        appendGeneralPermissions($this);
        $this->sliderRepository = $sliderRepository;
        view()->share('item', $this->resource);
        view()->share('class', Slider::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $sliders = $this->sliderRepository
            ->getSliders($request)
            ->paginate(10);

        return view('admin.crud.index', compact('sliders'));
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
    public function store(SliderRequest $request): RedirectResponse
    {
        dd($request->all());
        $this->sliderRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.sliders.create');
        }

        return redirect()->route('admin.sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(Slider $slider)
    {
        return view('admin.crud.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Slider $slider)
    {
        return view('admin.crud.edit-new', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider): RedirectResponse
    {
        $this->sliderRepository->update($request, $slider);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.sliders.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Slider $slider): RedirectResponse
    {
        $this->sliderRepository->delete($slider);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.sliders.index');
    }
}
