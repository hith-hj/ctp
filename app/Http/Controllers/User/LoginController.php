<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function create()
    {
        return view('website.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (auth('user')->attempt($credentials)) {
            if (! auth('user')->user()->isActive()) {
                $user = auth('user')->user();
                auth('user')->logout();
                Session::flash('error', __('front.please_verify_your_account'));
                $request->session()->put('user', $user);

                return redirect()->route('user.verification.notice');
            }

            return redirect()->route('user.index');
        } else {
            Session::flash('error', __('front.wrong_credentials'));

            return redirect()->route('user.login')->withInput();
        }
    }

    public function logout(): RedirectResponse
    {
        auth('user')->logout();

        return redirect()->route('user.index');
    }
}
