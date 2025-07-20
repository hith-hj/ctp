<?php

namespace App\Observers;

use App\Models\OrderDetail;

class OrderDetailObserver
{
    /**
     * Handle the OrderDetail "created" event.
     *
     * @return void
     */
    public function creating(OrderDetail $orderDetail)
    {
        creation:
        $ordersCount = OrderDetail::whereYear('created_at', '=', date('Y'))->count();
        $sequenceNumber = 100000 + ++$ordersCount;
        $randomCode = generateRandomString(2, true);
        $orderDetailCode = $sequenceNumber.'GL-'.date('y').$randomCode;

        if (OrderDetail::where('code', $orderDetailCode)->exists()) {
            goto creation;
        }
        $orderDetail->code = $orderDetailCode;
    }

    /**
     * Handle the OrderDetail "updated" event.
     *
     * @return void
     */
    public function updated(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "deleted" event.
     *
     * @return void
     */
    public function deleted(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "restored" event.
     *
     * @return void
     */
    public function restored(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(OrderDetail $orderDetail)
    {
        //
    }
}
