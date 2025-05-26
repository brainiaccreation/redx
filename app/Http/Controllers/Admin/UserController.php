<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function list()
    {
        return view('admin.users.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role_id', '!=', 1)->select('users.*');
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('wallet_balance', function ($row) {

                    return  config('app.currency') . ' ' . number_format($row->wallet_balance, 2);
                })

                ->addColumn('account_type', function ($row) {
                    $statusClasses = [
                        'pending'    => 'badge bg-warning-subtle text-warning fw-medium',
                        'normal' => 'badge bg-danger-subtle text-danger fw-medium',
                        'completed'  => 'badge bg-success-subtle text-success fw-medium',
                        'failed'     => 'badge bg-danger-subtle text-danger fw-medium',
                        'reseller'  => 'badge bg-secondary-subtle text-secondary fw-medium',
                    ];
                    $badgeClass = $statusClasses[$row->account_type] ?? 'badge bg-primary-subtle text-primary';
                    return '<h5><span class="' . $badgeClass . '">' . ucfirst($row->account_type) . '</span></h5>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div style="display: flex; gap: 8px;">
                        <a href="' . route('admin.user.view', $row->id) . '" class="action_btn edit-item">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="' . route('admin.user.edit', $row->id) . '" class="action_btn edit-item">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form method="POST" action="' . route('admin.user.destroy', $row->id) . '" style="display:inline;" onsubmit="return false;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit"
                                    class="action_btn ' . ($row->is_suspended == 1 ? 'success-item' : 'delete-item') . ' changeStatus"
                                    data-name="User"
                                    data-suspended="' . $row->is_suspended . '" data-toggle="tooltip" data-placement="top"
                                    title="' . ($row->is_suspended == 1 ? 'Unsuspend User' : 'Suspend User') . '">
                                    <i class="' . ($row->is_suspended == 1 ? 'ri-check-fill' : 'ri-forbid-line') . '"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['wallet_balance', 'account_type', 'action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function view($id)
    {
        $user = User::find($id);
        return view('admin.users.view', compact('user'));
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $request->validate([
            'name'         => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:150|unique:users,email,' . $id,
            'phone'        => 'nullable|string|max:25',
            'country'      => 'nullable|string|max:100',
            'towncity'     => 'nullable|string|max:100',
            'address'      => 'nullable|string|max:350',
            'address2'     => 'nullable|string|max:350',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->towncity = $request->towncity;
        $user->address = $request->address;
        $user->address2 = $request->address2;
        $user->is_suspended = $request->is_suspended ? 1 : 0;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Str::slug($user->name) . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('user/avatar/');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }

            $avatar->move($path, $filename);
            $user->avatar = 'user/avatar/' . $filename;
        }
        $user->update();
        return redirect()->route('admin.users.list')->with('success', 'Request has been completed');
    }

    public function toggleSuspend(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'is_suspended' => 'required|in:0,1'
        ]);

        $user = User::findOrFail($request->id);
        $user->is_suspended = $request->is_suspended == 1 ? 0 : 1;
        $user->save();

        return response()->json(['is_suspended' => $user->is_suspended]);
    }
}
