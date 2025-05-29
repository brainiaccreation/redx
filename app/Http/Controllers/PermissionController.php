<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $roles = Role::whereIn('name', ['admin', 'staff'])->get();
        $permissions = Permission::all();
        return view('permissions.index', compact('roles', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('permissions.index')->with('success', 'Permissions updated successfully.');
    }
}
