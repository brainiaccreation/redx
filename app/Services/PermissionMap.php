<?php

namespace App\Services;

class PermissionMap
{
    protected static $permissionMap = [
        'admin.dashboard' => 'display admin dashboard',
        'admin.profile.settings' => 'view profile settings',

        // Categories
        'admin.categories.list' => 'list categories',
        'admin.category.add' => 'add category',
        'admin.category.edit' => 'edit category',
        'admin.category.status' => 'toggle category status',
        'admin.category.destroy' =>      'delete category',

        // Products
        'admin.products.list' => 'list products',
        'admin.product.add' => 'add product',
        'admin.product.edit' => 'edit product',
        'admin.product.status' => 'toggle product status',
        'admin.product.destroy' => 'delete product',

        // Customers
        'admin.customers.list' => 'list customers',
        'admin.customer.view' => 'view customer',
        'admin.customer.edit' => 'edit customer',
        'admin.customer.status' => 'toggle customer status',
        'admin.customer.destroy' => 'delete customer',
        'admin.customer.toggle_suspend' => 'toggle customer suspend',
        'admin.customer.add_balance' => 'add customer balance',
        'admin.customer.transactions' => 'view customer transactions',

        // Staff/Admin Users
        'admin.users.list' => 'list users',
        'admin.user.add' => 'add user',
        'admin.user.view' => 'view user',
        'admin.user.edit' => 'edit user',
        'admin.user.status' => 'toggle user status',
        'admin.user.destroy' => 'delete user',
        'admin.users.change-password' => 'change user password',

        // Gift Card Codes
        'admin.code.list' => 'list gift card codes',
        'admin.code.add' => 'add gift card code',
        'admin.code.edit' => 'edit gift card code',
        'admin.code.status' => 'toggle gift card code status',
        'admin.code.destroy' => 'delete gift card code',

        // Home Sliders
        'admin.home_sliders.list' => 'list home sliders',
        'admin.home_slider.add' => 'add home slider',
        'admin.home_slider.edit' => 'edit home slider',
        'admin.home_slider.destroy' => 'delete home slider',

        // Orders
        'admin.orders.list' => 'list orders',
        'admin.order.details' => 'view order details',

        // Sales Report
        'admin.sales.report' => 'sales report',
        'admin.sales.pdf' => 'sales report generate',

        // Wallet Topups
        'admin.wallet.list' => 'list wallet topups',
        'admin.wallet.show' => 'view wallet topup',
        'admin.wallet.approve' => 'approve wallet topup',
    ];

    public static function getPermission($routeName)
    {
        return self::$permissionMap[$routeName] ?? null;
    }
}
