<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    public function add(Request $request): User
    {
        $user = new User($request->all());
        $user->phone_number = preg_replace('/\s+/', '', $request->get('phone_number'));

        if (! $request->has('email')) {
            $user->email = 'user'.generateRandomString(4).'@mile.com';
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('users', $request->file('avatar'));
        }

        $user->save();

        return $user;
    }

    public function update(Request $request, User $user)
    {

        $user->update($request->except(['password']));

        if ($request->hasFile('avatar')) {
            // if there is an old avatar delete it
            if ($user->avatar != null) {
                $user->avatar = Storage::disk('public')->delete($user->avatar);
            }

            // store the new image
            $user->avatar = Storage::disk('public')->put('users', $request->file('avatar'));
        }

        $user->save();
    }

    public function updateAccount(Request $request, User $user)
    {

        if ($request->has('last_name')) {
            $user->update(['last_name' => $request->get('last_name')]);
        }

        if ($request->has('first_name')) {
            $user->update(['first_name' => $request->get('first_name')]);
        }

        if ($request->has('email')) {
            $user->update(['email' => $request->get('email')]);
        }

        if ($request->has('phone_number')) {
            $user->update(['phone_number' => $request->get('phone_number')]);
        }

        if ($request->hasfile('avatar')) {
            $user->avatar = Storage::disk('public')->delete($user->avatar);
            $avatar = Storage::disk('public')->put('users', $request->file('avatar'));
            $user->update(['avatar' => $avatar]);
        }

        return $user;
    }

    public function delete(User $user)
    {
        if ($user->avatar != null) {
            $user->avatar = Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
    }

    public function getUsers(Request $request, $user = null): Builder
    {
        $users = User::query();

        if ($request->has('status') && $request->get('status') != null) {
            $users = $users->where('status', $request->get('status'));
        }

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $users->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', $tokens);
        }

        return $users->orderBy('created_at');
    }

    public function usersAutoComplete($search)
    {
        return User::where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name.' ('.$result->email.')',
                ];
            });
    }

    public function getUsersDataTable(Request $request): LengthAwarePaginator
    {
        $admins = User::query();

        if ($request->has('query')) {
            if (isset($request->get('query')['status']) != null) {
                $admins->where('status', $request->get('query')['status']);
            }

            if (isset($request->get('query')['from_date']) != null) {
                $admins->where('created_at', '>=', $request->get('query')['from_date']);
            }

            if (isset($request->get('query')['to_date']) != null) {
                $admins->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
            }

            if (isset($request->get('query')['search']) != null) {
                $tokens = convertToSeparatedTokens($request->get('query')['search']);
                $admins->whereRaw('MATCH(first_name, last_name, email, phone_number) AGAINST(? IN BOOLEAN MODE)', $tokens);
            }
        }

        if ($request->has('sort')) {
            $field = $request->get('sort')['field'];
            if (! in_array($field, app(User::class)->getFillable())) {
                $field = 'id';
            }
            $admins = $admins->orderBy($field, $request->get('sort')['sort'] ?? 'asc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        } else {
            $admins = $admins->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        }

        return $admins;
    }
}
