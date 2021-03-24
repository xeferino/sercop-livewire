<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //roles
        $super_admin = Role::create(['name' => 'super-admin', 'description' => 'Super Administrador']);
        $admin       = Role::create(['name' => 'administer', 'description' => 'Administrador del sistema']);
        $user        = Role::create(['name' => 'user', 'description' => 'Usuario del sistema']);

        //permissions users
        Permission::create(['name' => 'create-role', 'description' => 'Crear rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'edit-role', 'description' => 'Editar rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'show-role', 'description' => 'listado y detalle de rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'delete-role', 'description' => 'Eliminar de rol en el sistema'])->syncRoles([$super_admin]);

        //Permission::create(['name' => 'create-permission', 'description' => 'Crear permiso en el sistema'])->syncRoles([$super_admin]);
        //Permission::create(['name' => 'edit-permission', 'description' => 'Editar permiso en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'show-permission', 'description' => 'listado y detalle de permiso en el sistema'])->syncRoles([$super_admin]);
        //Permission::create(['name' => 'delete-permission', 'description' => 'Eliminar de permiso en el sistema'])->syncRoles([$super_admin]);

        Permission::create(['name' => 'create-user', 'description' => 'Crear usuario en el sistema'])->syncRoles([$super_admin, $admin]);
        Permission::create(['name' => 'edit-user', 'description' => 'Editar usuario en el sistema'])->syncRoles([$super_admin, $admin]);
        Permission::create(['name' => 'show-user', 'description' => 'listado y detalle de usuario en el sistema'])->syncRoles([$super_admin, $admin, $user]);
        Permission::create(['name' => 'delete-user', 'description' => 'Eliminar de usuario en el sistema'])->syncRoles([$super_admin]);

        //permissions departments
        Permission::create(['name' => 'create-department', 'description' => 'Crear departamento en el sistema'])->syncRoles([$super_admin, $admin]);
        Permission::create(['name' => 'edit-department', 'description' => 'Editar departamento en el sistema'])->syncRoles([$super_admin, $admin]);
        Permission::create(['name' => 'show-department', 'description' => 'listado y detalle de departamento en el sistema'])->syncRoles([$super_admin, $admin, $user]);
        Permission::create(['name' => 'delete-department', 'description' => 'Eliminar de departamento en el sistema'])->syncRoles([$super_admin]);

        //setting users system default
        User::create([
                'name'              => 'Super Admin',
                'surname'           => 'Root',
                'email'             => 'root@root.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('root')
            ])->assignRole($super_admin);

        User::create([
                'name'              => 'User',
                'surname'           => 'System',
                'email'             => 'user@system.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('user')
            ])->assignRole($user);

        User::create([
                'name'              => 'Administer',
                'surname'           => 'System',
                'email'             => 'administer@system.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('administer')
            ])->assignRole($admin);
    }
}
