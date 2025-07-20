<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\ActivateUserRequest;
use App\Http\Requests\API\LoginUserRequest;
use App\Http\Requests\API\ResetPasswordConfirmRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request)
    {
        $user = $this->userRepository->add($request);

        $errorOrUser = $user->generateActivationCode();

        /** @var User|bool $errorOrUser */
        if (! ($errorOrUser instanceof User)) {
            $user->delete();

            return $this->respondError($errorOrUser);

            return $this->respondError(["we couldn't send verification code, please check your phone number correctly"]);
        } else {
            $errorOrUser->save();
        }

        if (! $user->token) {
            $token = $user->createToken('API');
            $user->token = $token->plainTextToken;
            $user->save();
        }

        return $this->respondSuccess(
            [
                'token' => $user->token,
                'user' => $user,
            ]
        );
    }

    public function activateUser(ActivateUserRequest $request): JsonResponse
    {
        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();

        if ($user->isActive()) {
            return $this->respondError(__('api.user_already_active'));
        }

        if ($user) {
            if ($user->code == $request->get('activation_code')) {
                $user->activateUser()->save();
                if (! $user->token) {
                    $token = $user->createToken('API');
                    $user->token = $token->plainTextToken;
                    $user->save();
                }

                return $this->respondSuccess([
                    'token' => $user->token,
                    'user' => $user,
                ]);
            }

            return $this->respondError(__('api.code_not_valid'));
        }

        return $this->respondError(__('api.user_not_found'));
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        //    return dd($request)->all();
        $credentials = $request->only('phone_number', 'password');
        if (auth('api')->attempt($credentials)) {

            $user = User::whereId(auth('api')->id())->first();
            if ($user->status == User::STATUS_INACTIVE) {
                return $this->respondError(__('api.please_verify_your_account'));
            }
            if (! $user->token) {
                $token = $user->createToken('API');
                $user->token = $token->plainTextToken;
                $user->save();
            }

            return $this->respondSuccess([
                'token' => $user->token,
                'user' => $user,
            ]);
        }

        return $this->respondError(__('api.username_or_password_invalid'));
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();

        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }
        if (! Hash::check($request->get('old_password'), $user->password)) {
            return $this->respondError(__('api.wrong_password'));
        }

        $user->password = ($request->get('new_password'));
        $user->save();

        return $this->respondSuccess($user);
    }

    public function forgetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|exists:users,phone_number',
        ]);

        if ($validator->fails()) {
            Log::error($validator->errors());

            return $this->respondError($validator->errors()->first(), $validator->errors()->getMessages());
        }

        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();
        $errorOrUser = $user->generatePasswordToken();

        /** @var User|bool $errorOrUser */
        if (! ($errorOrUser instanceof User)) {
            return $this->respondError(["we couldn't send verification code, please check your phone number correctly"]);
        } else {
            $errorOrUser->save();
        }

        return $this->respondSuccess();

    }

    public function forgetPasswordConfirm(ResetPasswordConfirmRequest $request): JsonResponse
    {
        $user = User::query()->where('phone_number', $request->get('phone_number'))->first();

        $checkCode = $user->checkPasswordCode($request->get('reset_token'));
        if ($checkCode) {
            $user->reset_verified = 'yes';
            $passwordChanged = $user->changePassword($request->get('password'));

            if ($passwordChanged) {
                return $this->respondSuccess(__('api.password_changed'));
            }

            return $this->respondSuccess(__('api.password_not_changed'));
        }

        return $this->respondSuccess(__('api.code_not_valid'));

    }

    public function profile(Request $request): JsonResponse
    {
        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        return $this->respondSuccess($user);
    }

    public function profilePost(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $this->userRepository->update($request, $user);

        if (! $user->token) {
            $token = $user->createToken('API');
            $user->token = $token->plainTextToken;
            $user->save();
        }

        return $this->respondSuccess([
            'token' => $user->token,
            'user' => $user,
        ]);
    }

    public function appInfo(Request $request): JsonResponse
    {
        $request->validate([
            'mobile_id' => 'required',
        ]);
        $mobileId = $request->get('mobile_id');

        $user = User::where('mobile_id', $mobileId)->first();
        if ($user) {
            $this->profilePost($request);
        } else {
            $user = $this->userRepository->add($request);
            $user->generateActivationCode()->save();
        }
        if (! $user->token) {
            $token = $user->createToken('API');
            $user->token = $token->plainTextToken;
            $user->save();
        }

        return $this->respondSuccess([
            'token' => $user->token,
            'version' => 1.0,
            'app_store' => '',
            'play_store' => '',
            'is_urgent' => false,
            'user' => $user,
        ]);
    }

    public function resetPasswordForm(Request $request)
    {
        $request->request->set('reset_token', $request->reset_token);

        return view('auth.reset-password-form', ['request' => $request]);
    }
}
