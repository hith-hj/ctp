<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function couponCheck($code)
    {
        $cart = Cart::query()->notActive()->whereUserId(auth('user')->id())->first();
        $coupon = Coupon::query()
            ->whereCode($code)
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->first();
        if (! $coupon) {
            request()->session()->flash('warring', __('front.invalid_code'));

            return response()->json(['error' => 'error', 'message' => __('front.invalid_code')]);
        } else {
            $cartPrice = $cart->total_price;

            if ($cartPrice > $coupon->min_amount) {
                $message = __('front.valid_code').$cartPrice;
                request()->session()->flash('success', __('front.valid_code'));

                return response()->json(['coupon' => $coupon, 'message' => $message]);
            } else {
                request()->session()->flash('warring', __('front.invalid_code'));

                return response()->json(['error' => 'error', 'message' => __('front.your_amount_not_en')]);
            }
        }
    }
}
