<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Administrator with full access',
        ]);

        $managerRole = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Manager with limited access',
        ]);

        $userRole = Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Regular user',
        ]);

        // Create permissions
        $permissions = [
            // User permissions
            [
                'name' => 'View Users',
                'slug' => 'users.view',
                'description' => 'Can view users',
            ],
            [
                'name' => 'Create Users',
                'slug' => 'users.create',
                'description' => 'Can create users',
            ],
            [
                'name' => 'Edit Users',
                'slug' => 'users.edit',
                'description' => 'Can edit users',
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'users.delete',
                'description' => 'Can delete users',
            ],

            // Role permissions
            [
                'name' => 'View Roles',
                'slug' => 'roles.view',
                'description' => 'Can view roles',
            ],
            [
                'name' => 'Create Roles',
                'slug' => 'roles.create',
                'description' => 'Can create roles',
            ],
            [
                'name' => 'Edit Roles',
                'slug' => 'roles.edit',
                'description' => 'Can edit roles',
            ],
            [
                'name' => 'Delete Roles',
                'slug' => 'roles.delete',
                'description' => 'Can delete roles',
            ],

            // Permission permissions
            [
                'name' => 'View Permissions',
                'slug' => 'permissions.view',
                'description' => 'Can view permissions',
            ],
            [
                'name' => 'Assign Permissions',
                'slug' => 'permissions.assign',
                'description' => 'Can assign permissions',
            ],

            // General admin permissions
            [
                'name' => 'Access Admin Area',
                'slug' => 'admin.access',
                'description' => 'Can access admin area',
            ],
            [
                'name' => 'Manage Settings',
                'slug' => 'settings.manage',
                'description' => 'Can manage application settings',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to roles
        $adminRole->givePermissionsTo([
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'permissions.view', 'permissions.assign',
            'admin.access', 'settings.manage',
        ]);

        $managerRole->givePermissionsTo([
            'users.view', 'users.create', 'users.edit',
            'roles.view',
            'permissions.view',
            'admin.access',
        ]);

        $userRole->givePermissionsTo([
            'users.view',
        ]);

        // Assign admin role to first user if exists
        $user = User::first();
        if ($user) {
            $user->assignRoles(['admin']);
        }
    }
}
