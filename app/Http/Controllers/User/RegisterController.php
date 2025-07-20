<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ActivateUserRequest;
use App\Http\Requests\API\ResetPasswordConfirmRequest;
use App\Http\Traits\TwilioTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use TwilioTrait;

    public function create()
    {
        return view('website.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'first_name' => ['required', 'string', 'min:4'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email:dns', 'unique:users,email'],
            'phone_number' => ['required', 'regex:/^[+][0-9]{1,3}[0-9]{6,9}$/', 'unique:users,phone_number'],
            'password' => ['required', 'min:6', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:512'],
        ], [
            'email.unique' => 'Email is already taken',
            'phone_number.regex' => 'Phone number should be valid',
            'phone_number.unique' => 'Phone number is already taken',
        ]);
        if ($request->hasFile('avatar')) {
            $validate['avatar'] = Storage::disk('public')->put('users', $request->file('avatar'));
        } else {
            $validate['avatar'] = Str::of(Storage::putFile('public/users/default', (base_path('public/assets/media/users/default.jpg'))))->replace('public/', '');
        }
        $user = User::create($validate);
        try {
            $user = $user->sendEmailVerificationCode();
            $user->save();
            session()->put('user', $user);

            return redirect()->route('user.verification.notice');
        } catch (\Exception $e) {
            // if ($user->avatar){
            //     $user->avatar = Storage::disk('public')->delete($user->avatar);
            // }
            // $user->delete();
            // return redirect()->back()->with('error','Couldn\'t send your verification email,please try later');
            $user->update(['status' => 1, 'email_verified_at' => now()]);
            auth('user')->login($user);

            return redirect()->route('user.index');
        }
    }

    public function verificationCode(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'code' => ['required', 'digits:6'],
        ]);
        $user = User::find($request->user_id);
        if (! $user || $user->code != $request->code) {
            return redirect()->back()->with('error', 'Code do not match our records');
        }
        $user->checkEmailVerificationCode();
        $user->save();
        auth('user')->login($user);
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.index');
        } else {
            return redirect()->route('user.login');
        }
    }

    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);
        $user = User::find($request->user_id);
        if (! $user) {
            return redirect()->back()->with('error', 'User not found');
        }
        if ($user->updated_at->addMinutes(10) > now()) {
            return redirect()->back()->with('error', 'You need to wait 10 minuts');
        }
        $user->sendEmailVerificationCode();
        $user->save();
        session()->put('user', $user);

        return redirect()->back()->with('success', 'Code resend');
    }

    public function verification()
    {
        $user = \session()->get('user');

        return view('website.auth.verification', compact('user'));
    }

    public function activeUser(ActivateUserRequest $request): RedirectResponse
    {
        $code = implode($request->get('activation_code'));
        $mobile = $request->get('phone_number');
        $user = User::query()->where('phone_number', $mobile)->first();

        if (! $user) {
            $request->session()->flash('error', __('front.wrong'));

            return redirect()->route('register');
        }

        if ($user->isActive()) {
            $request->session()->flash('error', __('api.user_already_active'));

            return redirect()->back();
        }

        if ($user->code == $code) {
            $user->activateUserAccount()->save();
            auth('user')->login($user);

            return redirect()->route('user.index');
        } else {
            $request->session()->flash('error', __('front.the_code is invalid'));

            return redirect()->route('user.verification')->with(['user' => $user]);
        }
    }

    public function forgetPassword()
    {
        return view('website.auth.forget-password');
    }

    public function sendCode(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);
        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();
        if ($user) {
            try {
                $user = $user->generatePasswordToken();
                if ($user instanceof User) {
                    $user->save();
                    $request->session()->flash('success', __('front.we_send_a_code'));
                    $request->session()->put('user', $user);

                    return redirect()->route('user.get-code');
                } else {
                    $request->session()->flash('error', __('front.invalid_number'));

                    return redirect()->route('user.forget-password');
                }
            } catch (\Exception $e) {
                $request->session()->flash('error', __('front.invalid_number'));

                return redirect()->route('user.forget-password');
            }
        } else {
            $request->session()->flash('error', __('front.user_not_registered'));

            return redirect()->route('user.register');
        }
    }

    public function getCodePage()
    {
        $user = \session()->get('user');

        return view('website.auth.check-code', compact('user'));
    }

    public function checkCode(ResetPasswordConfirmRequest $request): RedirectResponse
    {
        $code = implode($request->get('reset_token'));
        $mobile = $request->get('phone_number');
        $user = User::where('phone_number', $mobile)->first();

        $checkCode = $user->checkPasswordCode($code);
        if ($checkCode) {
            $user->reset_verified = 'yes';
            $passwordChanged = $user->changePassword($request->get('password'));

            if ($passwordChanged) {
                $request->session()->flash('success', __('front.password_changed'));

                return redirect()->route('user.register');
            } else {
                $request->session()->flash('error', __('front.password_not_changed'));

                return redirect()->route('user.register');
            }
        } else {
            $request->session()->flash('error', __('front.code_not_valid'));

            return redirect()->route('user.forget-password');
        }
    }

    public function resendVerification(Request $request): JsonResponse
    {
        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();
        $user = $user->generateActivationCode();
        /** @var User|bool $errorOrUser */
        if (($user instanceof User)) {
            $user->save();

            return response()->json(['success']);
        } else {
            return response()->json(['error']);
        }
    }
}
