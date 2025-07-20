<?php

use Illuminate\Support\Facades\Log;
use SebastianBergmann\Diff\ConfigurationException;
use SMSGlobal\Credentials;
use SMSGlobal\Resource\Sms;
use Twilio\Exceptions\ConfigurationException as TwilioConfigurationException;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

function sendSms($recipients, $message)
{
    /**  RETURN FALSE IMMEDIATELY IF WE DIDN'T SET CREDENTIALS YET */
    $account_sid = 'account_sid';
    $auth_token = 'auth_token';
    $twilio_number = '+447830377358';

    try {
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message]);

        return false;
    } catch (ConfigurationException|RestException|TwilioConfigurationException|TwilioException $e) {
        return $e->getMessage();
    }
}

function sendWhatsAppMessage($recipients, $message)
{
    $account_sid = 'account_sid';
    $auth_token = 'auth_token';
    $twilio_number = '+447830377358';

    try {
        $client = new Client($account_sid, $auth_token);

        $client->messages
            ->create('whatsapp:'.$recipients, // to
                [
                    'from' => "whatsapp:$twilio_number",
                    'body' => 'join parent-build',
                ]
            );

        return false;
    } catch (ConfigurationException|RestException|TwilioConfigurationException|TwilioException $e) {
        return $e->getMessage();
    }

}

function sendSmsGlob($recipients, $message)
{
    Credentials::set('api_key', 'api_secret');
    $sms = new Sms();

    try {
        $sms->sendToOne($recipients, $message);

        return false;
    } catch (Exception $e) {
        Log::critical($e->getMessage());

        return $e->getMessage();
    }
}
