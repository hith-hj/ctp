<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Currency
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('appcurrency')) {
            $currency = Session::get('appcurrency');
        } elseif (request('appcurrency')) {
            $currency = request('appcurrency');
        } else {
            $currency = getMainCurrency()?->code ?? 'USD';
        }

        if ($request->hasHeader('Accept-Currency')) {
            if (in_array($request->header('Accept-Currency'), getCurrenciesCodes())) {
                $currency = $request->header('Accept-Currency');
            }
        }

        // set app currency
        Session::put('appcurrency', $currency);

        return $next($request);
    }
}
