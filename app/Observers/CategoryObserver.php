<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     *
     * @return void
     */
    public function creating(Category $category)
    {
        $category->slug = Str::slug($category->name).'-'.rand(1, 1000);
    }

    /**
     * Handle the Category "updating" event.
     *
     * @return void
     */
    public function updating(Category $category)
    {
        $category->slug = Str::slug($category->name).'-'.rand(1, 1000);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @return void
     */
    public function updated(Category $category)
    {
        //        $category->parentCategory()->each(function ($subcategory) use ($category){
        //            $subcategory->section()->associate($category->section_id);
        //        });
    }
}
