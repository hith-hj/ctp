<?php

namespace App\Repositories;

use App\Models\Attributes\Album;
use App\Models\Attributes\Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingRepository
{
    private $translatableFields = ['text', 'text_area', 'rich_text_box'];

    public function add(Request $request)
    {
        $type = $request->get('type');
        $className = uFirst($type);

        $setting = new Setting([
            'key' => Str::slug($request->get('key'), '-'),
            'type' => $type,
        ]);

        $setting->save();

        if (in_array($type, $this->translatableFields)) {
            $settingData = [];
            foreach (config('translatable.locales') as $locale) {
                if ($request->get($type.':'.$locale) != null) {
                    $settingData[$locale] = [
                        'value' => $request->input($type.':'.$locale),
                    ];
                }
            }

            $item = new $className($settingData);
        } elseif ($type == 'image') {
            $item = new Image();
            if ($request->hasFile('image')) {
                $item->value = Storage::disk('public')->put('settings', $request->file('image'));
            }
        } elseif ($type == 'album') {
            $item = new Album();
            $imagesNames = [];
            foreach ($request->file('album') as $image) {
                $imageName = Storage::disk('public')->put('settings', $image);
                array_push($imagesNames, $imageName);
            }
            $item->value = $imagesNames;
        } else { // number or checkbox or select
            $item = new $className([
                'value' => $request->get($type),
            ]);
        }

        $item->setting()->associate($setting);
        $item->save();

        $setting->save();
    }

    public function update(Request $request, Setting $setting)
    {
        $type = $request->get('type');
        $className = uFirst($type);

        $setting->detachAll();
        $setting->update($request->only(['key', 'type']));
        $setting->save();

        if (in_array($type, $this->translatableFields)) {
            $settingData = [];
            foreach (config('translatable.locales') as $locale) {
                if ($request->get($type.':'.$locale) != null) {
                    $settingData[$locale] = [
                        'value' => $request->input($type.':'.$locale),
                    ];
                }
            }
            $item = new $className($settingData);

        } elseif ($type == 'image') {
            $item = new Image();
            if ($request->hasFile('image')) {
                $item->value = Storage::disk('public')->put('settings', $request->file('image'));
            }
        } elseif ($type == 'album') {
            $item = new Album();
            if ($request->hasFile('album')) {
                $item->value = Storage::disk('public')->put('settings', $request->file('album'));
            }
        } else { // number or checkbox or select
            $item = new $className([
                'value' => $request->get($type),
            ]);
        }

        $item->setting()->associate($setting);
        $item->save();

        $setting->save();

    }

    public function delete(Setting $setting)
    {
        $setting->detachAll();
        $setting->delete();
    }

    public function getSettings()
    {
        return Setting::orderBy('created_at')->get();
    }
}
