<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private $categoryRepository;

    public $resource = 'category';

    public function __construct(CategoryRepository $categoryRepository)
    {
        appendGeneralPermissions($this);
        $this->categoryRepository = $categoryRepository;
        view()->share('item', $this->resource);
        view()->share('class', Category::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository
            ->getCategories($request)
            ->paginate(10);

        return view('admin.category.index', compact('categories'));
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
    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categoryRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.categories.create');
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        return view('admin.crud.edit-new', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryRepository->update($request, $category);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->categoryRepository->delete($category);

        return redirect()->route('admin.categories.index')
            ->with('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));
    }

    public function deleteCategoryImage(Request $request, $id)
    {
        $this->categoryRepository->deleteCategoryImage($id);

        return redirect()->back()->with('success', 'category image deleted');
    }
}
