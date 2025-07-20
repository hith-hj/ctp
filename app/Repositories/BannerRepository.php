<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BannerRepository
{
    public function add(Request $request)
    {

        $applies_option = getItemInArrayByColumn($request->get('applies_to'), config('banner_applies_options'), 'id');
        $banner = new Banner(populateModelData($request, Banner::class));
        $banner->sort_order = $request->get('sort_order');
        $banner->model_type = $applies_option['model'];
        $banner->model_id = $request->get($applies_option['name']);
        $banner->applies_to = $request->get('applies_to');
        $banner->image = uploadFile('image', 'banners');
        $banner->save();
    }

    public function update(Request $request, Banner $banner)
    {
        $applies_option = getItemInArrayByColumn($request->get('applies_to'), config('banner_applies_options'), 'id');
        $banner->update([
            'sort_order' => $request->get('sort_order'),
            'model_type' => $applies_option['model'],
            'applies_to' => $request->get('applies_to'),
            'model_id' => $request->get($applies_option['name']),
        ]);
        $banner->update(populateModelData($request, Banner::class));
        if ($request->file('image')) {
            $banner->image = uploadFile('image', 'banners');
        }

        $banner->save();
    }

    public function delete(Banner $banner)
    {
        $banner->delete();
    }

    public function getBanners(): Builder
    {
        return Banner::query()->orderBy('sort_order');
    }
}
