<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserNotificationController extends ApiController
{
    public function updateFirebaseToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());

            return $this->respondError($validator->errors()->first(), $validator->errors()->getMessages());
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $user
            ->setFirebaseToken($request->get('firebase_token'))
            ->save();

        return $this->respondSuccess();
    }

    public function userNotifications(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $notifications = $user->userNotifications()->paginate($limit);

        return $this->respondSuccess($notifications->all(), $this->createApiPaginator($notifications));
    }

    public function changeLang(Request $request): JsonResponse
    {
        $request->validate([
            'lang' => 'required|in:ar,en',
        ]);

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $user->changeLang($request->get('lang'));
        $user->save();

        return $this->respondSuccess($user);
    }

    public function changeNotificationStatus(Request $request): JsonResponse
    {
        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $user->toggleNotificationStatus()->save();

        return $this->respondSuccess([
            'notification-status' => $user->app_notification_status,
        ]);
    }

    public function deleteNotification($id): JsonResponse
    {
        Notification::query()->findOrFail($id)->delete();

        return $this->respondSuccess('success');
    }

    public function lastNotification(Request $request): JsonResponse
    {
        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $notification = $user->userNotifications()->orderBy('created_at', 'desc')->first();

        return $this->respondSuccess($notification);
    }
}
