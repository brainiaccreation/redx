<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function list() {
        return view('admin.users.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role_id', '!=', 1)->select('users.*'); 
            return DataTables::of($data)
                ->addIndexColumn()

                // ->addColumn('status', function ($row) {
                //     $checked = $row->is_suspended == 1 ? 'checked' : '';
                //     return '
                //         <div class="text-center">
                //             <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                //                 <input type="checkbox" class="form-check-input is_suspended" id="customSwitchsizemd" data-id="' . $row->id . '" ' . $checked . '>
                //             </div>
                //         </div>
                //     ';
                // })

                ->addColumn('action', function ($row) {
                    return '
                        <div style="display: flex; gap: 8px;">
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

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function edit($id) {
        $user = User::find($id);
        return view('admin.users.edit',compact('user'));
    }
    public function update(Request $request, $id) {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'is_suspended' => 'nullable|boolean',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_suspended = $request->is_suspended ? 1 : 0;
        $user->update();
        return redirect()->route('admin.users.list')->with('success','Request has been completed');

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