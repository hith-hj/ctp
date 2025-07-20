<?php

namespace App\Http\Traits;

use App\Models\Admin;
use Illuminate\Http\Request;

trait ShiftTrait
{
    public function addHours(Request $request, Admin $store)
    {
        foreach ($request->get('days') as $day) {
            $store->shifts()->firstOrCreate([
                'day' => $day['day'],
                'open_time' => $day['open_time'],
                'close_time' => $day['close_time'],
            ]);
        }
    }

    public function updateHours(Request $request, Admin $store)
    {
        $shifts = $store->shifts()->pluck('id')->toArray();
        foreach ($request->get('days') as $day) {
            $shift = $store->shifts()->updateOrCreate([
                'day' => $day['day'],
                'open_time' => $day['open_time'],
                'close_time' => $day['close_time'],
            ], [
                'day' => $day['day'],
                'open_time' => $day['open_time'],
                'close_time' => $day['close_time'],
            ]);

            if (! $shift->wasRecentlyCreated) {
                $shifts = array_diff($shifts, [$shift->id]);
            }
        }
        $store->shifts()->whereIn('id', $shifts)->delete();
    }
}
