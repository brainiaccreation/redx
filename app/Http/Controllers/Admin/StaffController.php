<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin|staff']);
    }

    public function list()
    {
        return view('admin.users.list');
    }
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('users.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(users.name, ' ', users.last_name) LIKE ?", ["%$keyword%"]);
                })
                ->filterColumn('email', function ($query, $keyword) {
                    $query->where('email', 'like', "%$keyword%");
                })
                ->filterColumn('role', function ($query, $keyword) {
                    $query->whereHas('roles', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('name', $order)->orderBy('last_name', $order);
                })
                ->orderColumn('email', function ($query, $order) {
                    $query->orderBy('email', $order);
                })
                ->orderColumn('role', function ($query, $order) {
                    $query->orderBy('roles.name', $order);
                })
                ->addColumn('profile', function ($row) {
                    $fullName = $row->name . ' ' . $row->last_name;
                    $avatar = $row->avatar
                        ? '<img src="' . asset($row->avatar) . '" alt="' . e($fullName) . '" class="rounded-circle" width="40" height="40">'
                        : '<div class="user-name-avatar">' . usernameAvatar($fullName) . '</div>';

                    return '
                    <div class="d-flex align-items-center">
                        ' . $avatar . '
                    </div>';
                })
                ->addColumn('name', function ($row) {
                    return e($row->name . ' ' . $row->last_name);
                })
                ->addColumn('email', function ($row) {
                    return e($row->email);
                })
                ->addColumn('role', function ($row) {
                    return ucfirst($row->getRoleNames()->implode(', '));
                })
                ->addColumn('action', function ($row) {
                    return Blade::render('
                        <div style="display: flex; gap: 8px;">
                            @hasRoutePermission("admin.user.edit")
                                <a href="{{ route("admin.user.edit", $row->id) }}" class="action_btn edit-item">
                                    <i class="ri-edit-line"></i>
                                </a>
                            @endhasRoutePermission

                            @hasRoutePermission("admin.user.destroy")
                                <form method="POST" action="{{ route("admin.user.destroy", $row->id) }}" style="display:inline;">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="action_btn delete-item show_confirm" data-name="Member">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            @endhasRoutePermission

                            @if (
                                !auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission("admin.user.edit")) &&
                                !auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission("admin.user.destroy"))
                            )
                                <span>-</span>
                            @endif
                        </div>
                    ', ['row' => $row]);
                })

                ->rawColumns(['profile', 'action'])
                ->make(true);
        }
    }
    public function add()
    {
        $roles = Role::whereIn('name', ['admin', 'staff'])->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'address2' => $request->address2,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Str::slug($user->name . '-' . $user->id) . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('user/avatar/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $avatar->move($path, $filename);

            $user->avatar = 'user/avatar/' . $filename;
            $user->save();
        }

        $user->assignRole($request->role);

        return redirect()->route('admin.users.list')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $roles = Role::whereIn('name', ['admin', 'staff', 'customer'])->get();
        $user = User::find($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'role' => 'required|string|exists:roles,name',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find($id);
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->address2 = $request->address2;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = Str::slug($user->name . '-' . $user->id) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('user/avatars'), $filename);
            $user->avatar = 'user/avatars/' . $filename;
        }

        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.list')->with('success', 'Request has been completed.');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users.list')->with('success', 'Request has been completed.');
    }
}
