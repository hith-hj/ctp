<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class CategoryRepository
{
    public function add(Request $request)
    {
        $category = new Category(populateModelData($request, Category::class));

        $category->sort_order = $request->input('sort_order') ?? 1;
        $category->is_active = $request->get('is_active') ?? 0;

        $category->category()->associate($category->getParent());

        if ($request->hasFile('image')) {
            $category->image = Storage::disk('public')->put('categories', $request->file('image'));
            ImageOptimizer::optimize('storage/'.$category->image);
        }

        $category->save();

        if ($request->has('attributes')) {
            $category->attributes()->attach($request->input('attributes'));
        }
    }

    public function update(Request $request, Category $category)
    {
        $category->parent_category = null;
        $category->update(populateModelData($request, Category::class));
        $category->sort_order = $request->input('sort_order') ?? 1;

        // update subcategories parent id
        if ($request->get('parent_category') != null && $request->get('parent_category') != '0') {
            Category::query()->where('parent_category', '=', $category->id)
                ->update(['parent_category' => $request->input('parent_category')]);
        }

        $category->category()->associate($category->getParent());
        if ($request->has('attributes')) {
            $category->attributes()->detach();
            $category->attributes()->attach($request->input('attributes'));
        }
        if ($request->hasFile('image')) {
            // if there is an old image delete it
            if ($category->image != null) {
                $category->image = Storage::disk('public')->delete($category->image);
            }

            // store the new image
            $category->image = Storage::disk('public')->put('categories', $request->file('image'));
            ImageOptimizer::optimize('storage/'.$category->image);
        }
        if ($request->hasFile('image')) {
            // if there is an old image delete it
            if ($category->image != null) {
                $category->image = Storage::disk('public')->delete($category->image);
            }
            // store the new image
            $category->image = Storage::disk('public')->put('categories', $request->file('image'));
            ImageOptimizer::optimize('storage/'.$category->image);
        }
        if ($request->has('delete_category_image') && ! is_null($request->delete_category_image)) {
            if ($category->image != null) {
                $category->image = Storage::disk('public')->delete($category->image);
            }
            $category->image = null;
        }
        $category->save();

    }

    public function delete(Category $category)
    {
        if ($category->image != null) {
            $category->image = Storage::disk('public')->delete($category->image);
        }
        Category::where('parent_category', $category->id)->delete();
        $category->delete();
    }

    public function getCategories(Request $request, $categoryId = null, $withSubs = false): Builder
    {
        if ($withSubs) {
            $categories = Category::query()->with('subcategories');
        } else {
            $categories = Category::query();
        }

        if ($categoryId == null) {
            $categories->where('parent_category', null)->where('id', '<>', $categoryId);
        } else {
            $categories->where('parent_category', $categoryId);
        }

        if ($request->query('status') != null) {
            $categories->where('is_active', $request->query('status'));
        }

        if ($request->query('search') != null) {
            $tokens = convertToSeparatedTokens($request->query('search'));

            $categories->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        return $categories->orderByDesc('sort_order')->orderByDesc('created_at');
    }

    public function deleteCategoryImage($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image != null) {
            Storage::disk('public')->delete($category->image);
        }

        return $category->update(['image' => null]);
    }
}
