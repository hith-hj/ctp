<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function add(Request $request)
    {

        // $role = new Role($request->all());
        $role = new Role();
        $role->guard_name = 'web';
        $role->name = $request['name:en'];
        $role->save();

        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                Permission::findOrCreate($permission);
                $role->givePermissionTo($permission);
            }
        }
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());

        // revoke old permissions
        foreach ($role->permissions->whereNotIn('name', $request->permissions) as $permission) {
            $role->revokePermissionTo($permission);
        }

        // give new permissions
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                Permission::findOrCreate($permission);
                $role->givePermissionTo($permission);
            }
        }

        $role->save();

    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function getRoles()
    {
        return Role::orderBy('created_at')->paginate(10);
    }
}
