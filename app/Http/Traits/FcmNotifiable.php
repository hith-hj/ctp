<?php

namespace App\Http\Traits;

trait FcmNotifiable
{
    public function sendToTopic($title, $body, $token)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $subData = [
            'title' => $title,
            'content' => $body,
            'ar_title' => $title,
            'ar_content' => $body,
            'payload' => '',

        ];

        $data = [
            'data' => $subData,
            'notification' => $subData,
        ];

        $notification = [
            'body' => $body,
            'title' => $title,
        ];

        if (is_array($token)) {
            foreach ($token as $userFCM) {
                $fcmNotification = [
                    'to' => $userFCM,
                    'data' => $data,
                    'notification' => $notification,
                ];
            }
        } else {
            $fcmNotification = [
                'to' => $token, //single token
                'data' => $data,
                'notification' => $notification,
            ];

        }

        $headers = [
            'Authorization: key='.config('firebase.FCM_SERVER_KEY'),
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        dd(config('firebase.FCM_SERVER_KEY'), $result);
        curl_close($ch);

    }
}
