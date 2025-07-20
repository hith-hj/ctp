<?php

use App\Models\Currency;
use Illuminate\Support\Facades\Session;

function getMainCurrency()
{
    // return Currency::whereRate(1)->first();
    return Currency::Where('is_default', 1)->first();
}

function convertCurrency($from_currency, $to_currency): string
{
    $apikey = config('dev_creds.OPEN_EXCHANGE_API_KEY');

    $from_Currency = urlencode($from_currency);
    $to_Currency = urlencode($to_currency);
    $query = "{$from_Currency}_{$to_Currency}";

    // change to the free URL if you're using the free version
    $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
    $obj = json_decode($json, true);
    $val = floatval($obj["$query"]);

    return number_format($val, 2, '.', '');
}

function getCurrenciesCodes(): array
{
    return Currency::all()->pluck('code')->toArray();
}

function getCurrencies()
{
    return Currency::all();
}

function getAppCurrency()
{
    if (Session::has('appcurrency')) {
        return Currency::whereCode(Session::get('appcurrency'))->first();
    } else {
        return getMainCurrency();
    }
}
