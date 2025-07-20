<?php

namespace App\Repositories;

use App\Http\Traits\ShiftTrait;
use App\Models\Admin;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminRepository
{
    use ShiftTrait;

    public function add(Request $request)
    {
        $admin = new Admin(populateModelData($request, Admin::class));

        if ($request->has('password')) {
            $admin->password = bcrypt($request->get('password'));
        }

        if ($request->hasFile('avatar')) {
            $admin->avatar = Storage::disk('public')->put('admins', $request->file('avatar'));
        }

        $admin->syncRoles($request->get('role'));

        $admin->save();

    }

    public function update(Request $request, Admin $admin)
    {

        foreach ($admin->roles()->get() as $role) {
            $admin->removeRole($role);
        }
        $adminRole = Role::find($request->role);

        // $admin->syncRoles($request->get('role'));
        $admin->syncRoles($adminRole);

        $admin->update(populateModelData($request, Admin::class));

        if ($request->has('password')) {
            $admin->password = bcrypt($request->get('password'));
        }

        if ($request->hasFile('avatar')) {
            if ($admin->avatar != null) {
                $admin->avatar = Storage::disk('public')->delete($admin->avatar);
            }

            $admin->avatar = Storage::disk('public')->put('admins', $request->file('avatar'));
        }

        $admin->save();

    }

    public function delete(Admin $admin)
    {
        if ($admin->image != null) {
            $admin->image = Storage::disk('public')->delete($admin->image);
        }

        $admin->delete();
    }

    public function getAdmins(Request $request, $withProducts = false): Builder
    {
        if ($withProducts) {
            $admins = Admin::query()->with('products');
        } else {
            $admins = Admin::query();
        }

        if ($role = $request->get('role')) {
            $admins = $admins->role($role);
        }

        if ($status = $request->get('status')) {
            $admins = $admins->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $admins->where(function ($query) use ($request) {
                $search = $request->get('search');
                $tokens = convertToSeparatedTokens($search);
                $query
                    ->whereRaw('MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)', $tokens);
                // ->orWhereHas('translations', function ($query) use ($tokens, $request) {
                //     $query
                //         ->whereRaw("MATCH(company_name, about) AGAINST(? IN BOOLEAN MODE)", $tokens);
                // });
            });
        }

        return $admins->orderBy('created_at');
    }

    public function getAdminsDataTable(Request $request): LengthAwarePaginator
    {

        $admins = Admin::query();

        if ($request->has('query')) {
            if (isset($request->get('query')['status']) != null) {
                $admins->where('status', $request->get('query')['status']);
            }

            if (isset($request->get('query')['role']) != null) {
                $role = Role::find($request->get('query')['role']);
                $admins = $admins->role($role);
                // $admins = $admins->role($request->get('query')['role']);
            }

            if (isset($request->get('query')['from_date']) != null) {
                $admins->where('created_at', '>=', $request->get('query')['from_date']);
            }

            if (isset($request->get('query')['to_date']) != null) {
                $admins->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
            }

            if (isset($request->get('query')['search']) != null) {
                $admins->where(function ($query) use ($request) {
                    $tokens = convertToSeparatedTokens($request->get('query')['search']);
                    $query
                        ->whereRaw('MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)', $tokens);
                    // ->orWhereHas('translations', function ($query) use ($tokens, $request) {
                    //     $query
                    //         ->whereRaw("MATCH(company_name, about) AGAINST(? IN BOOLEAN MODE)", $tokens);
                    // });
                });
            }
        }

        if ($request->has('sort') && $request->get('sort')['field'] != 'role') {
            $admins = $admins->orderBy($request->get('sort')['field'], $request->get('sort')['sort'] ?? 'asc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        } else {
            $admins = $admins->orderBy('id', 'desc')
                    ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        }

        return $admins;
    }

    public function getVendors(Request $request): Builder
    {

        $admins = Admin::query();
        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $admins->whereRaw('MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)', $tokens);
        }
        if ($role = $request->get('role')) {
            $admins = $admins->role('retail');
        }

        return $admins->orderByDesc('created_at');
    }

    public function getVendorCategory($user)
    {
        $categories = Category::query()->whereNotNull('parent_category');

        if ($user->hasRole('retail')) {
            $categories = $categories->whereIn('type', ['retail']);
        } elseif ($user->hasRole('grocery')) {
            $categories = $categories->where('type', 'grocery');
        } elseif ($user->hasRole('service-provider')) {
            $categories = $categories->where('type', 'service');
        } else {
            return [];
        }

        return $categories;
    }
}
