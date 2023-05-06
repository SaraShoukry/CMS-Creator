<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'crud operators']);
        Permission::create(['name' => 'crud entities']);
        Permission::create(['name' => 'crud custom attributes']);
        Permission::create(['name' => 'assign custom attribute to entity']);

        Permission::create(['name' => 'enter entities']);
        Permission::create(['name' => 'fetch entities']);
        Permission::create(['name' => 'fetch specific entity']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $operator_role = Role::create(['name' => 'operator']);
        $operator_role->givePermissionTo('enter entities');
        $operator_role->givePermissionTo('fetch entities');
        $operator_role->givePermissionTo('fetch specific entity');

        // or may be done by chaining
        $admin_role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['crud operators', 'crud entities', 'crud custom attributes', 'assign custom attribute to entity']);



        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'username' => 'AdminUser',
            'password' => bcrypt('admin@123'),
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($admin_role);
    }
}
