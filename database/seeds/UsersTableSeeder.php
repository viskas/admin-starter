<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => 'Admin',
            'last_name'  => 'User',
            'email'    => 'admin@demo.com',
            'password' => 'adminadmin1A',
            'email_verified_at' => now(),
        ]);

        $role = Role::create(['name' => 'Admin']);

        foreach ($this->permissionArray() as $key => $item) {
            $permission = Permission::create([
                'group' => $item['group'],
                'name' => $item['name'],
                'description' => $item['description']
            ]);

            $permission->assignRole($role);
        }

        $user->assignRole('Admin');
    }

    private function permissionArray()
    {
        return [
            [
                'group' => 'Profile',
                'name' => 'view profile',
                'description' => 'Change profile',
            ],
            [
                'group' => 'Sessions',
                'name' => 'view sessions',
                'description' => 'View sessions',
            ],
            [
                'group' => 'Sessions',
                'name' => 'delete sessions',
                'description' => 'Delete sessions',
            ],
            [
                'group' => 'Users',
                'name' => 'view users',
                'description' => 'View users',
            ],
            [
                'group' => 'Users',
                'name' => 'create users',
                'description' => 'Create users',
            ],
            [
                'group' => 'Users',
                'name' => 'update users',
                'description' => 'Update users',
            ],
            [
                'group' => 'Users',
                'name' => 'reset 2fa users',
                'description' => 'Reset User 2fa Auth',
            ],
            [
                'group' => 'Users',
                'name' => 'impersonate users',
                'description' => 'Login as another user',
            ],
            [
                'group' => 'Users',
                'name' => 'delete users',
                'description' => 'Delete users',
            ],
            [
                'group' => 'Roles',
                'name' => 'view roles',
                'description' => 'View roles'
            ],
            [
                'group' => 'Roles',
                'name' => 'create roles',
                'description' => 'Create roles'
            ],
            [
                'group' => 'Roles',
                'name' => 'update roles',
                'description' => 'Update roles'
            ],
            [
                'group' => 'Categories',
                'name' => 'view categories',
                'description' => 'View Categories'
            ],
            [
                'group' => 'Categories',
                'name' => 'create categories',
                'description' => 'Create Categories'
            ],
            [
                'group' => 'Categories',
                'name' => 'update categories',
                'description' => 'Update Categories'
            ],
            [
                'group' => 'Categories',
                'name' => 'delete categories',
                'description' => 'Delete Categories'
            ],
            [
                'group' => 'News',
                'name' => 'view news',
                'description' => 'View News'
            ],
            [
                'group' => 'News',
                'name' => 'create news',
                'description' => 'Create News'
            ],
            [
                'group' => 'News',
                'name' => 'update news',
                'description' => 'Update News'
            ],
            [
                'group' => 'News',
                'name' => 'delete news',
                'description' => 'Delete News'
            ],
            [
                'group' => 'Translations',
                'name' => 'view translations',
                'description' => 'View Translations'
            ],
            [
                'group' => 'Translations',
                'name' => 'update translations',
                'description' => 'Update Translations'
            ],
            [
                'group' => 'Translations',
                'name' => 'rescan translations',
                'description' => 'Rescan Translations'
            ],
            [
                'group' => 'Translations',
                'name' => 'export translations',
                'description' => 'Export Translations'
            ],
            [
                'group' => 'Translations',
                'name' => 'create translations',
                'description' => 'Upload Translations File'
            ],
            [
                'group' => 'Translations',
                'name' => 'delete translations',
                'description' => 'Delete Translations'
            ],
            [
                'group' => 'System settings',
                'name' => 'view system settings',
                'description' => 'View System Settings'
            ],
            [
                'group' => 'System settings',
                'name' => 'update system settings',
                'description' => 'Update System Settings'
            ]
        ];
    }
}
