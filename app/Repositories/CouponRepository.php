<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CouponRepository
{
    public function add(Request $request)
    {
        $coupon = new Coupon(populateModelData($request, Coupon::class));
        $coupon->save();
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update(populateModelData($request, Coupon::class));
        $coupon->save();
    }

    public function delete(Coupon $coupon)
    {
        $coupon->delete();
    }

    public function getCoupons(Request $request): Builder
    {
        $coupons = Coupon::query();

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $coupons->where(function ($query) use ($tokens) {
                $query->whereRaw('MATCH(name, code) AGAINST(? IN BOOLEAN MODE)', $tokens)
                    ->orWhereHas('translations', function ($query) use ($tokens) {
                        $query->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
                    });
            });

        }

        if ($maxPrice = $request->get('max_value')) {
            $coupons->where('value', '<', $maxPrice);
        }

        if ($minPrice = $request->get('min_value')) {
            $coupons->where('value', '>', $minPrice);
        }

        return $coupons;
    }

    public function couponsAutoComplete($search)
    {
        $coupons = Coupon::query();
        $tokens = convertToSeparatedTokens($search);

        $coupons->where(function ($query) use ($tokens) {
            $query->whereRaw('MATCH(code) AGAINST(? IN BOOLEAN MODE)', $tokens)
                ->orWhereHas('translations', function ($query) use ($tokens) {
                    $query
                        ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
                });
        });

        return $coupons
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name,
                ];
            });
    }
}
