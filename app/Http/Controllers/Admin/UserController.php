<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
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
                ->filterColumn('user_info', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereRaw("CONCAT(users.name, ' ', users.last_name) LIKE ?", ["%$keyword%"])
                            ->orWhere('users.email', 'like', "%$keyword%")
                            ->orWhere('users.phone', 'like', "%$keyword%")
                            ->orWhereRaw("CONCAT(users.email, ' ', users.phone) LIKE ?", ["%$keyword%"]);
                    });
                })
                ->filterColumn('wallet_balance', function ($query, $keyword) {
                    $query->where('wallet_balance', 'like', "%$keyword%")
                        ->orWhereRaw("FORMAT(wallet_balance, 2) LIKE ?", ["%$keyword%"]);
                })
                ->filterColumn('weekly_limit', function ($query, $keyword) {
                    $query->where('weekly_limit', 'like', "%$keyword%")
                        ->orWhereRaw("FORMAT(weekly_limit, 2) LIKE ?", ["%$keyword%"]);
                })
                ->filterColumn('account_type', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('account_type', 'like', "%$keyword%")
                            ->orWhereRaw("LOWER(account_type) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    });
                })
                ->orderColumn('user_info', function ($query, $order) {
                    $query->orderBy('name', $order)->orderBy('last_name', $order);
                })

                ->orderColumn('wallet_balance', function ($query, $order) {
                    $query->orderBy('wallet_balance', $order);
                })

                ->orderColumn('weekly_limit', function ($query, $order) {
                    $query->orderBy('weekly_limit', $order);
                })

                ->orderColumn('account_type', function ($query, $order) {
                    $query->orderBy('account_type', $order);
                })

                ->addColumn('user_info', function ($row) {
                    $fullName = $row->name . ' ' . $row->last_name;
                    $email = $row->email;
                    $phone = $row->phone;

                    return '
                   <div class="d-flex justify-items-center align-items-center">
                    <div class="user-name-avatar">' . usernameAvatar($fullName) . '</div>
                    <div class="ms-2">
                        <div class="font-medium text-gray-900">
                         <a href="' . route('admin.user.view', $row->id) . '" >
                            ' . e($fullName) . '
                            </a>
                        </div>
                        <div class="text-sm text-gray-500">
                            ' . e($email) . '
                        </div>' .
                        (!empty($phone) ? '<div class="text-xs text-gray-400">' . e($phone) . '</div>' : '') . '
                    </div>
                </div>';
                })
                ->addColumn('wallet_balance', function ($row) {
                    return '<span class="text-success" id="user-balance-' . $row->id . '">
                            <i class="ri-wallet-line"></i> ' . config('app.currency') . ' ' . number_format($row->wallet_balance, 2) . '
                        </span>';
                })
                ->addColumn('weekly_limit', function ($row) {
                    return '<span id="weekly-limit-' . $row->id . '" class="text-info">
                            <i class="ri-wallet-line"></i> ' . config('app.currency') . ' ' . number_format($row->weekly_limit, 2) . '
                        </span>';
                })
                ->addColumn('weekly_spent', function ($row) {
                    $weeklySpent = getWeeklySpent($row->id);
                    $weeklyLimit = $row->weekly_limit;
                    $percent = $weeklyLimit > 0 ? ($weeklySpent / $weeklyLimit) * 100 : 0;

                    return '
                    <div class="mb-1">
                        <span class="text-danger">
                            <i class="ri-arrow-down-line"></i> ' . config('app.currency') . ' ' . number_format($weeklySpent, 2) . '
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar ' . ($percent >= 100 ? 'bg-danger' : 'bg-success') . '" 
                            role="progressbar" style="width: ' . $percent . '%;" 
                            aria-valuenow="' . round($percent) . '" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <small class="text-muted">' . round($percent) . '% of ' . config('app.currency') . number_format($weeklyLimit, 2) . '</small>
                ';
                })
                ->addColumn('account_type', function ($row) {
                    $statusClasses = [
                        'pending'    => 'badge bg-warning-subtle text-warning fw-medium',
                        'normal'     => 'badge bg-danger-subtle text-danger fw-medium',
                        'completed'  => 'badge bg-success-subtle text-success fw-medium',
                        'failed'     => 'badge bg-danger-subtle text-danger fw-medium',
                        'reseller'   => 'badge bg-secondary-subtle text-secondary fw-medium',
                    ];
                    $badgeClass = $statusClasses[strtolower($row->account_type)] ?? 'badge bg-primary-subtle text-primary';
                    return '<div class="text-center"><h5><span class="' . $badgeClass . '">' . ucfirst($row->account_type) . '</span></h5></div>';
                })
                ->addColumn('action', function ($row) {
                    $isSuspended = $row->is_suspended;
                    $userId = $row->id;
                    $suspendTitle = $isSuspended == 1 ? 'Unsuspend User' : 'Suspend User';
                    $suspendIcon = $isSuspended == 1 ? 'ri-check-fill' : 'ri-forbid-line';
                    $suspendText = $isSuspended == 1 ? 'Unsuspend' : 'Suspend';

                    return "
                        <div class='d-flex align-items-center gap-2'>

                            <a href='javascript:void(0);'
                                class='action_btn edit-item open-balance-modal'
                                title='Add balance'
                                data-bs-toggle='modal'
                                data-bs-target='.bs-example-modal-center'
                                data-name='$row->name" . ' ' . "$row->last_name'
                                data-email='$row->email'
                                 data-id='$row->id'
                                data-balance='" . config('app.currency') . " " . number_format($row->wallet_balance, 2) . "'>
                                <i class='ri-wallet-line'></i>
                            </a>

                            <a href='javascript:void(0);' 
                                class='action_btn view-transactions edit-item' 
                                data-user-id='$userId' 
                                title='Transaction History' 
                                data-bs-toggle='modal' 
                                data-bs-target='.transaactionHistoryModal'>
                                <i class='ri-history-line'></i>
                            </a>

                            <a href='javascript:void(0);'
                                class='action_btn edit-item weekly-balance-modal'
                                title='Set limit'
                                data-bs-toggle='modal'
                                data-bs-target='.weeklyLimitModal'
                                data-name='$row->name" . ' ' . "$row->last_name'
                                data-email='$row->email'
                                 data-id='$row->id'
                                data-balance='" . number_format($row->wallet_balance, 2) . "'
                                data-limit='" . number_format($row->weekly_limit, 2) . "'
                                data-spent='" . getWeeklySpent($row->id) . "'>
                                <i class='ri-settings-2-line'></i>
                            </a>
                            
                            <div class='dropdown d-inline-block'>
                                <button class='btn btn-soft-danger btn-sm dropdown action_dropdown_btn edit-item' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='ri-more-fill align-middle'></i>
                                </button>
                                <ul class='dropdown-menu dropdown-menu-end'>
                                    <li>
                                        <a href='" . route('admin.user.view', $userId) . "' class='dropdown-item'>
                                            <i class='ri-eye-fill align-bottom me-2 text-muted'></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a href='" . route('admin.user.edit', $userId) . "' class='dropdown-item'>
                                            <i class='ri-pencil-fill align-bottom me-2 text-muted'></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button type='button'
                                            class='dropdown-item changeStatus'
                                            data-name='User'
                                            data-suspended='" . $isSuspended . "'
                                            data-id='" . $userId . "' data-bs-toggle='tooltip' data-bs-placement='bottom'
                                            title='" . $suspendTitle . "'>
                                            <i class='" . $suspendIcon . " align-bottom me-2 text-muted'></i> " . $suspendText . "
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    ";
                })


                ->rawColumns(['user_info', 'wallet_balance', 'weekly_limit', 'weekly_spent', 'account_type', 'action'])
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

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->wallet_balance += $request->amount;
        $user->save();
        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => $request->amount]);

        $wallet->balance += $request->amount;
        $wallet->save();

        WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'description' => $request->reason,
            'payment_method' => 'Manual',
            'status' => 'approved',
            'type' => 'credit',
            'wallet_id' => $wallet->id,
        ]);

        return response()->json([
            'success' => true,
            'new_balance' => $user->wallet_balance
        ]);
    }
    public function updateWeeklyLimit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weekly_limit' => 'required|numeric|min:0',
        ]);

        $user = User::find($request->user_id);
        $user->weekly_limit = $request->weekly_limit;
        $user->save();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'weekly_limit' => (float) $user->weekly_limit,
            'weekly_spent' => (float) getWeeklySpent($user->id),
        ]);
    }

    public function fetchTransactions(Request $request)
    {
        $userId = $request->user_id;

        $walletIds = Wallet::where('user_id', $userId)->pluck('id');
        $transactions = WalletTransaction::whereIn('wallet_id', $walletIds)
            ->latest()
            ->paginate(10);

        $data = $transactions->map(function ($tx) {
            return [
                'description' => $tx->description,
                'date' => runTimeDateFormat($tx->created_at),
                'amount' => number_format($tx->amount, 2),
                'type' => $tx->type,
                'status' => $tx->status,
            ];
        });

        return response()->json([
            'data' => $data,
            'has_more' => $transactions->hasMorePages()
        ]);
    }
}
