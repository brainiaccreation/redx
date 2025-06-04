<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class UpdatePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate related tables
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Define fresh permissions
        $permissions = [
            'display admin dashboard',

            'list categories',
            'add category',
            'edit category',
            'toggle category status',
            'delete category',

            'list products',
            'add product',
            'edit product',
            'toggle product status',
            'delete product',

            'view profile settings',

            // Changed: user → customer
            'list customers',
            'edit customer',
            'view customer',
            'toggle customer status',
            'delete customer',
            'toggle customer suspend',
            'add customer balance',
            'update customer weekly limit',
            'view customer transactions',

            // Changed: member → user
            'list users',
            'add user',
            'edit user',
            'view user',
            'toggle user status',
            'delete user',
            'change user password',

            'list gift card codes',
            'add gift card code',
            'edit gift card code',
            'toggle gift card code status',
            'delete gift card code',

            'list home sliders',
            'add home slider',
            'edit home slider',
            'delete home slider',

            'list orders',
            'view order details',

            'sales report',
            'sales report generate',

            'list wallet topups',
            'view wallet topup',
            'approve wallet topup',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $customerRole = Role::where('name', 'customer')->first();

        if ($adminRole) {
            $adminRole->syncPermissions($permissions);
        }

        if ($staffRole) {
            $staffPermissions = [
                'display admin dashboard',
                'list products',
                'list orders',
                'view order details',
                'view profile settings',
            ];
            $staffRole->syncPermissions($staffPermissions);
        }

        if ($customerRole) {
            $customerRole->syncPermissions(['view profile settings']);
        }
    }
}
