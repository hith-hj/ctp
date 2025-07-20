<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::first();
        $Admin = Role::findOrCreate('Admin');
        $admin->syncRoles($Admin->id);
        $permissions = config('permission.permissions');
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
            $Admin->givePermissionTo($permission);
        }
    }
}
