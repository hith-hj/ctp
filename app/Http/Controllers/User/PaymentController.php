<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $model;

    public function payment($id, $type = 'order')
    {
        abort_if(! in_array($type, ['order']), 404);
        try {
            return view('website.pages.payment', [
                'order' => Order::findOrFail($id),
                'intent' => User::findOrFail(auth('user')->id())->createSetupIntent(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Payment Error: {$e->getMessage()}");
        }
    }

    public function purchase(Request $request)
    {
        $user = auth('user')->user();
        $order = Order::findOrFail($request->id);
        $paymentMethod = $request->input('payment_method');
        $order->update([
            'payment_method_id' => $paymentMethod,
            'payment_method_type' => 'strip',
            'payment_method_status' => 'pending',
        ]);
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        $price = getTotalPrice($order->total_price, $order->cart->calculateShippingPrice());
        $price = (number_format($price, 2, '.', '') * 100);
        try {
            $user->charge(
                $price,
                $paymentMethod,
                ['return_url' => route('payment.success')]
            );

            return redirect()->route('payment.success');
        } catch (\Exception $e) {
            $order->update(['payment_method_status' => 'faild']);

            return redirect()->route('payment.faild', ['msg' => $e->getMessage()]);
        }
    }

    public function paymentSuccess()
    {
        $user = auth('user')->user();
        $order = $user->orders()
            ->where([['payment_method_status', 'pending'], ['payment_method_type', 'strip']])
            ->first();
        if ($order !== null) {
            $order->update(['payment_method_status' => 'success']);
        }

        return redirect()->route('user.order')->with('success', 'Payment Success');
    }

    public function paymentFaild(Request $request, $msg = '')
    {
        return redirect()->route('user.order')->with('error', 'Payment Faild,'.$msg);
    }

    public function checkout(Request $request)
    {
        abort_if(! in_array($request->type, ['product']), 404);
        $order = Order::findOrFail($request->id);
        try {
            return $request->user()->checkoutCharge($order->price * 100, $order->name, $request->quantity ?? 1);
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Payment Error: {$e->getMessage()}");
        }
    }
}
