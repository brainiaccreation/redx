<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function list()
    {
        return view('admin.members.list');
    }
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = User::role(['admin', 'staff'])->select('users.*');

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

                    return '
                    <div style="display: flex; gap: 8px;">
                        <a href="' . route('admin.member.edit', $row->id) . '" class="action_btn edit-item">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form method="POST" action="' . route('admin.member.destroy', $row->id) . '" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="action_btn delete-item show_confirm" data-name="Member">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['profile', 'action'])
                ->make(true);
        }
    }
    public function add()
    {
        $roles = Role::whereIn('name', ['admin', 'staff'])->get();
        return view('admin.members.create', compact('roles'));
    }

    public function store(Request $request)
    {
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

        $user->assignRole($request->role);

        return redirect()->route('admin.members.index')->with('success', 'Request has been completed.');
    }

    public function edit(User $staff)
    {
        $roles = Role::whereIn('name', ['admin', 'staff'])->get();
        return view('admin.members.edit', compact('staff', 'roles'));
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $staff->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'address2' => $request->address2,
        ]);

        if ($request->filled('password')) {
            $staff->update(['password' => Hash::make($request->password)]);
        }

        $staff->syncRoles($request->role);

        return redirect()->route('admin.members.index')->with('success', 'Request has been completed.');
    }

    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('admin.members.index')->with('success', 'Request has been completed.');
    }
}
