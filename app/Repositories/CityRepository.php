<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CityRepository
{
    public function add(Request $request)
    {
        $city = new City(populateModelData($request, City::class));
        $city->save();
    }

    public function update(Request $request, City $city)
    {
        $city->update(populateModelData($request, City::class));
        $city->save();
    }

    public function delete(City $city)
    {
        $city->delete();
    }

    public function getCities(Request $request): Builder
    {
        $cities = City::query();

        if ($country = $request->get('country')) {
            $cities->where('country_id', $country);
        }

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $cities->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        return $cities->orderBy('sort_order');
    }
}
