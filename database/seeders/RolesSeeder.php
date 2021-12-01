<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'client',
            'client_moderator',
            'moderator',
            'programmer',
        ];

        foreach ($roles as $role) {
            Permission::create(['name' => $role]);
        }

        $client_role = Role::create(['name' => 'client']);
        $client_role->givePermissionTo('client_moderator');

        $client_moderator_role = Role::create(['name' => 'client_moderator']);
        $client_moderator_role->givePermissionTo('client');
        $client_moderator_role->givePermissionTo('moderator');

        $moderator_role = Role::create(['name' => 'moderator']);
        $moderator_role->givePermissionTo('client_moderator');
        $moderator_role->givePermissionTo('programmer');

        $programmer_role = Role::create(['name' => 'programmer']);
        $programmer_role->givePermissionTo('moderator');
    }
}
