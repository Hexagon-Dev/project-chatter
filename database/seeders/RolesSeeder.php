<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::query()->create(['name' => 'FirstProject']);

        $permissions = [
            'c_cm',
            'cm_m',
            'm_p',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $client = User::factory()->create([
            'name' => 'client',
            'email' => 'client@example.com',
            'password' => 'password',
            'project_id' => '1',
        ]);
        $client_role = Role::create(['name' => 'client']);
        $client_role->givePermissionTo('c_cm');
        $client->assignRole($client_role);

        $client_moderator = User::factory()->create([
            'name' => 'client_moderator',
            'email' => 'client_moderator@example.com',
            'password' => 'password',
            'project_id' => '1',
        ]);
        $client_moderator_role = Role::create(['name' => 'client_moderator']);
        $client_moderator_role->givePermissionTo('c_cm');
        $client_moderator_role->givePermissionTo('cm_m');
        $client_moderator->assignRole($client_moderator_role);

        $moderator = User::factory()->create([
            'name' => 'moderator',
            'email' => 'moderator@example.com',
            'password' => 'password',
            'project_id' => '1',
        ]);
        $moderator_role = Role::create(['name' => 'moderator']);
        $moderator_role->givePermissionTo('cm_m');
        $moderator_role->givePermissionTo('m_p');
        $moderator->assignRole($moderator_role);

        $programmer = User::factory()->create([
            'name' => 'programmer',
            'email' => 'programmer@example.com',
            'password' => 'password',
            'project_id' => '1',
        ]);
        $programmer_role = Role::create(['name' => 'programmer']);
        $programmer_role->givePermissionTo('m_p');
        $programmer->assignRole($programmer_role);
    }
}
