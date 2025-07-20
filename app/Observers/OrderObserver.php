<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     *
     * @return void
     */
    public function creating(Order $order)
    {
        //TODO: SET OSG APP_ID & REST_API THEN UNCOMMENT SEND N TO WEB
        //           $order->sendNotificationToWeb();

        // $user = $order->client;
        // $user->sendNotification(config('app.title'), __('api.your_order_has_been_created_successfully'));

        // TODO: SET LARAVEL NOTIFICATIONS THEN UNCOMMENT SEND N TO VENDOR
        //          $vendor = $order->vendor;
        //          $vendor->sendNotification(config('app.title'), __('notification.new_order'));

        creation:
        $ordersCount = Order::whereYear('created_at', '=', date('Y'))->count();
        $sequenceNumber = 100000 + ++$ordersCount;
        $randomCode = generateRandomString(2, true);
        $orderCode = $sequenceNumber.'GL-'.date('y').$randomCode;

        if (Order::where('code', $orderCode)->exists()) {
            goto creation;
        }
        $order->code = $orderCode;
    }

    /**
     * Handle the Order "updated" event.
     *
     * @return void
     */
    public function updated(Order $order)
    {

    }
}
