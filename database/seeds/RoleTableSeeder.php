<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);

        // $role = Role::where('name', 'Super Admin')->first();
		// $role->givePermissionTo(Permission::all());

        $user =User::find(1);
        $user->assignRole($role->name);
    }
}
