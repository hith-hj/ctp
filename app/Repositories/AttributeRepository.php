<?php

namespace App\Repositories;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeRepository
{
    public function add(Request $request)
    {
        $attribute = new Attribute(populateModelData($request, Attribute::class));
        $attribute->save();
    }

    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update(populateModelData($request, Attribute::class));
        $attribute->save();
    }

    public function delete(Attribute $attribute)
    {
        $attribute->delete();
    }

    public function getAttributes(Request $request)
    {
        $attributes = Attribute::withTranslation();

        if ($type = $request->get('type')) {
            $attributes->where('type', $type);
        }

        if ($useAsFilter = $request->get('use_as_filter')) {
            $attributes->where('use_as_filter', $useAsFilter);
        }

        if ($request->query('search') != null) {
            $tokens = convertToSeparatedTokens($request->query('search'));

            $attributes->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        return $attributes;
    }

    public function attributesAutoComplete($search)
    {
        $attributes = Attribute::query();
        $tokens = convertToSeparatedTokens($search);
        $attributes->whereHas('translations', function ($query) use ($tokens) {
            $query
                ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
        });

        return $attributes
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name,
                ];
            });
    }
}
