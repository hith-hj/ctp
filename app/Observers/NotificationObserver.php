<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\User;

class NotificationObserver
{
    /**
     * Handle the Notification "creating" event.
     *
     * @return void
     */
    public function creating(Notification $notification)
    {
        try {

            if ($notification->user_id) {

                $notification->sendToTopic($notification->title, $notification->message, $notification->user->firebase_token);
            } else {

                $all = User::query()->whereNotNull('firebase_token')->pluck('firebase_token')->toArray();
                $notification->sendToTopic($notification->title, $notification->message, $all);
            }
        } catch (\Exception $e) {
            //TODO NOTIFY ADMIN THERE NOTIFICATION ISSUE
        }
    }
}
