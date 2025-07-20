<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function changeCurrency($code): RedirectResponse
    {
        if (in_array($code, getCurrenciesCodes())) {
            Session::put('appcurrency', $code);
        }

        return redirect()->back();
    }
}
