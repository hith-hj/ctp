<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CountryRepository
{
    public function add(Request $request)
    {
        $country = new Country(populateModelData($request, Country::class));
        $country->flag = uploadImage('flag', 'countries');
        $country->save();
    }

    public function update(Request $request, Country $country)
    {
        $country->update(populateModelData($request, Country::class));
        $country->flag = uploadImage('flag', 'countries');
        $country->save();
    }

    public function delete(Country $country)
    {
        $country->delete();
    }

    public function getCountries(Request $request): Builder
    {
        $countries = Country::query();

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $countries->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        return $countries->orderBy('sort_order');
    }
}
