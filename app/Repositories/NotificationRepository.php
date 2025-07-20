<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class NotificationRepository
{
    public function add(Request $request)
    {
        $notification = new Notification(populateModelData($request, Notification::class));

        if ($request->get('user_id')) {
            $notification->user()->associate($request->input('user_id'));
        }

        if ($request->hasFile('image')) {
            $notification->image = Storage::disk('public')->put('notifications', $request->file('image'));
            ImageOptimizer::optimize('storage/'.$notification->image);
        }

        $notification->save();
    }

    public function update(Request $request, Notification $notification)
    {
        $notification->update(populateModelData($request, Notification::class));

        if ($request->get('user_id')) {
            $notification->user()->associate($request->input('user_id'));
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($notification->image);
            $notification->image = Storage::disk('public')->put('notifications', $request->file('image'));
            ImageOptimizer::optimize('storage/'.$notification->image);
        }
        $notification->save();

    }

    public function delete(Notification $notification)
    {
        $notification->delete();
    }

    public function getNotifications(Request $request)
    {
        $notifications = Notification::withTranslation();

        if ($request->query('user_id') != null) {
            $notifications->where('user_id', $request->query('user_id'));
        }

        if ($request->query('search') != null) {
            $tokens = convertToSeparatedTokens($request->query('search'));

            $notifications->whereHas('translations', function ($query) use ($tokens) {
                $query
                    ->whereRaw('MATCH(title, message) AGAINST(? IN BOOLEAN MODE)', $tokens);
            });
        }

        return $notifications;
    }
}
