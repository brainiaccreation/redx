<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $roles = ['admin', 'staff', 'customer'];
        foreach ($roles as $roleName) {
            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName, 'guard_name' => 'web']);
            }
        }

        // Define all permissions based on admin routes
        $permissions = [
            'display admin dashboard',
            'list categories',
            'get categories',
            'add category',
            'store category',
            'edit category',
            'update category',
            'toggle category status',
            'delete category',
            'list products',
            'get products',
            'add product',
            'store product',
            'edit product',
            'update product',
            'toggle product status',
            'delete product',
            'logout admin',
            'view profile settings',
            'update profile',
            'list users',
            'get users',
            'edit user',
            'view user',
            'update user',
            'toggle user status',
            'delete user',
            'toggle user suspend',
            'add user balance',
            'update user weekly limit',
            'view user transactions',
            'list members',
            'get members',
            'edit member',
            'view member',
            'update member',
            'toggle member status',
            'delete member',
            'list gift card codes',
            'get gift card codes',
            'add gift card code',
            'store gift card code',
            'edit gift card code',
            'update gift card code',
            'toggle gift card code status',
            'delete gift card code',
            'get gift card variants',
            'list home sliders',
            'get home sliders',
            'add home slider',
            'store home slider',
            'edit home slider',
            'update home slider',
            'delete home slider',
            'list orders',
            'get orders',
            'view order details',
            'update order status',
            'get wallet topups',
            'list wallet topups',
            'view wallet topup',
            'approve wallet topup',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
            }
        }

        // Assign all permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions($permissions);

        // Assign limited permissions to staff role
        $staffRole = Role::where('name', 'staff')->first();
        $staffPermissions = [
            'display admin dashboard',
            'list products',
            'get products',
            'view order details',
            'list orders',
            'get orders',
        ];
        $staffRole->syncPermissions($staffPermissions);

        // Assign minimal permissions to customer role
        // $customerRole = Role::where('name', 'customer')->first();
        // $customerPermissions = [
        //     'view profile settings',
        //     'update profile',
        // ];
        // $customerRole->syncPermissions($customerPermissions);

        // Create test users if they don't exist
        $admin = User::where('email', 'admin@gmail.com')->first();

        if ($admin) {
            $admin->assignRole('admin');
        }

        if (!User::where('email', 'staff@example.com')->exists()) {
            $staff = User::create([
                'name' => 'Staff',
                'last_name' => 'User',
                'email' => 'staff@example.com',
                'password' => bcrypt('12345678'),
                'avatar' => '/admin/assets/images/users/user-dummy-img.jpg',
            ]);
            $staff->assignRole('staff');
        }

        // if (!User::where('email', 'customer@example.com')->exists()) {
        //     $customer = User::create([
        //         'first_name' => 'Customer',
        //         'last_name' => 'User',
        //         'email' => 'customer@example.com',
        //         'password' => bcrypt('password'),
        //         'avatar' => 'avatars/customer.png',
        //     ]);
        //     $customer->assignRole('customer');
        // }
    }
}
