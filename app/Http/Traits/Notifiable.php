<?php

namespace App\Http\Traits;

trait Notifiable
{
    public function sendNotificationToMobile($title, $message, $userId = null)
    {

        $appID = config('dev_creds.OSG_APP_ID');
        $restApi = config('dev_creds.OSG_REST_API');

        $content = [
            'en' => $message,
        ];

        $headings = [
            'en' => $title,
        ];

        if ($userId) {
            $fields = [
                'app_id' => $appID,
                'filters' => [['field' => 'tag', 'key' => 'userId', 'relation' => '=', 'value' => $userId]],
                'contents' => $content,
                'headings' => $headings,
            ];
        } else {
            $fields = [
                'app_id' => $appID,
                'filters' => [['field' => 'tag', 'key' => 'type', 'relation' => '=', 'value' => 'mobile']],
                'contents' => $content,
                'headings' => $headings,
            ];
        }

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$restApi,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response);
        if (isset($result->errors) && $result->errors) {
            throw new \Exception($result->errors[0]);
        }

        //        return $response;
    }

    public function sendNotificationToWeb()
    {
        $appID = config('dev_creds.OSG_APP_ID');
        $restApi = config('dev_creds.OSG_REST_API');

        $content = [
            'en' => __('notification.new_order'),
        ];

        $headings = [
            'en' => config('app.title'),
        ];

        $fields = [
            'app_id' => $appID,
            'filters' => [['field' => 'tag', 'key' => 'admin', 'relation' => '=', 'value' => 'true']],
            'contents' => $content,
            'headings' => $headings,
            'url' => route('admin.orders.index'),
            'chrome_web_image' => asset('custom/logo-icon.png'),
        ];

        $fields = json_encode($fields);
        //        print("\nJSON sent:\n");
        //        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$restApi,
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

    }
}
