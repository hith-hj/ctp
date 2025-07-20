<?php

namespace App\Http\Traits;

use SebastianBergmann\Diff\ConfigurationException;
use Twilio\Exceptions\ConfigurationException as TwilioConfigurationException;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

trait TwilioTrait
{
    public function sendSms($recipients, $message)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_ACCOUNT_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');

        try {
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($recipients,
                ['from' => $twilio_number, 'body' => $message]);

            return false;
        } catch (ConfigurationException|RestException|TwilioConfigurationException|TwilioException $e) {
            return $e->getMessage();
        }
    }
}
