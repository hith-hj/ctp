<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttributeController extends Controller
{
    private $attributeRepository;

    public $resource = 'attribute';

    public function __construct(AttributeRepository $attributeRepository)
    {
        appendGeneralPermissions($this);
        $this->attributeRepository = $attributeRepository;
        view()->share('item', $this->resource);
        view()->share('class', Attribute::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepository
            ->getAttributes($request)
            ->paginate(10);

        return view('admin.crud.index', compact('attributes'));
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
    public function store(AttributeRequest $request): RedirectResponse
    {
        $this->attributeRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.attributes.create');
        }

        return redirect()->route('admin.attributes.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(Attribute $attribute)
    {
        return view('admin.crud.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.crud.edit-new', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $this->attributeRepository->update($request, $attribute);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.attributes.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Attribute $attribute): RedirectResponse
    {
        $this->attributeRepository->delete($attribute);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.attributes.index');
    }
}
