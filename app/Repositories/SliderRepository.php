<?php

namespace App\Repositories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderRepository
{
    public function add(Request $request)
    {
        $slider = new Slider(populateModelData($request, Slider::class));
        $slider->sort_order = $request->input('sort_order') ?? 1;
        $slider->background_image = uploadFile('background_image', 'sliders');
        $slider->responsive_image = uploadFile('responsive_image', 'sliders');
        $slider->save();
    }

    public function update(Request $request, Slider $slider)
    {
        $slider->update(populateModelData($request, Slider::class));
        if ($request->hasFile('background_image')) {
            // if there is an old background_image delete it
            if ($slider->background_image != null) {
                $slider->background_image = Storage::disk('public')->delete($slider->background_image);
            }

            // store the new background_image
            $slider->background_image = uploadFile('background_image', 'sliders');
        }

        if ($request->hasFile('responsive_image')) {
            // if there is an old responsive_image delete it
            if ($slider->responsive_image != null) {
                $slider->responsive_image = Storage::disk('public')->delete($slider->responsive_image);
            }

            // store the new responsive_image
            $slider->responsive_image = uploadFile('responsive_image', 'sliders');
        }
        $slider->save();
    }

    public function delete(Slider $slider)
    {
        if ($slider->background_image != null) {
            $slider->background_image = Storage::disk('public')->delete($slider->background_image);
        }

        if ($slider->responsive_image != null) {
            $slider->responsive_image = Storage::disk('public')->delete($slider->responsive_image);
        }

        $slider->delete();
    }

    public function getSliders(Request $request): Builder
    {
        $sliders = Slider::query();

        return $sliders->orderBy('created_at', 'desc');
    }
}
