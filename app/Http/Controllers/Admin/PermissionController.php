<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function list()
    {
        return view('admin.permissions.list');
    }

    public function get(Request $request)
    {
        $roles = Role::select(['id', 'name', 'created_at']);
        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role) {
                return '<a href="' . route('admin.permissions.manage', $role) . '" class="action_btn edit-item"><i class="ri-settings-2-line"></i></a>';
            })
            ->editColumn('name', function ($role) {
                return ucfirst($role->name);
            })
            ->editColumn('created_at', function ($role) {
                return runTimeDateFormat($role->created_at);
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereDate('roles.created_at', $keyword)
                        ->orWhereRaw("DATE_FORMAT(roles.created_at, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"])
                        ->orWhereRaw("DATE_FORMAT(roles.created_at, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                        ->orWhereRaw("DATE_FORMAT(roles.created_at, '%M') LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('roles.created_at', $order);
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function manage(Role $role)
    {
        $permissions = Permission::all();
        $modules = [
            'Dashboard' => ['display admin dashboard'],
            'Profile' => ['view profile settings'],
            'Categories' => ['list categories', 'add category', 'edit category', 'toggle category status', 'delete category'],
            'Products' => ['list products', 'add product', 'edit product', 'toggle product status', 'delete product'],
            'Customers' => ['list customers', 'edit customer', 'view customer', 'toggle customer status', 'delete customer', 'toggle customer suspend', 'add customer balance', 'update customer weekly limit', 'view customer transactions'],
            'Users' => ['list users', 'add user', 'edit user', 'view user', 'toggle user status', 'delete user', 'change user password'],
            'Gift Card Codes' => ['list gift card codes', 'add gift card code', 'edit gift card code', 'toggle gift card code status', 'delete gift card code'],
            'Home Sliders' => ['list home sliders', 'add home slider', 'edit home slider', 'delete home slider'],
            'Orders' => ['list orders', 'view order details'],
            'Sales Report' => ['sales report', 'sales report generate'],
            'Wallet' => ['list wallet topups', 'view wallet topup', 'approve wallet topup'],
            // 'Permissions' => ['view permissions'],
        ];

        return view('admin.permissions.manage', compact('role', 'permissions', 'modules'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        // return $request;
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.permissions.list')->with('success', 'Request has been completed.');
    }
}
