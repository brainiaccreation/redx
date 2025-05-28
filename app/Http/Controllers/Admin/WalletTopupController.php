<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletLog;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class WalletTopupController extends Controller
{
    public function list()
    {
        return view('admin.wallet.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = WalletTransaction::query()
                    ->join('wallets', 'wallet_transactions.wallet_id', '=', 'wallets.id')
                    ->join('users', 'wallets.user_id', '=', 'users.id')
                    ->select(
                        'wallet_transactions.*',
                        'users.name as user_name',
                        'users.last_name as user_last_name',
                        'wallets.user_id'
                    );

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('user', function ($row) {
                        return '<a href="' . route('admin.user.view', $row->user_id) . '">' . $row->user_name . ' ' . $row->user_last_name . '</a>';
                    })
                    ->addColumn('amount', function ($row) {
                        return config('app.currency') . ' ' . number_format($row->amount, 2);
                    })
                    ->addColumn('payment_method', fn($row) => ucfirst(strtolower($row->payment_method)))
                    ->addColumn('status', function ($row) {
                        $statusClass = match (strtolower($row->status)) {
                            'pending' => 'bg-warning-subtle text-warning',
                            'approved' => 'bg-success-subtle text-success',
                            'rejected' => 'bg-secondary-subtle text-secondary',
                            default => 'bg-info-subtle text-info'
                        };
                        return '<h5><span class="badge ' . $statusClass . '">' . ucfirst(strtolower($row->status)) . '</span></h5>';
                    })
                    ->addColumn('type', fn($row) => ucfirst(strtolower($row->type)))
                    ->addColumn('submitted_at', fn($row) => runTimeDateFormat($row->created_at))
                    ->addColumn('action', function ($row) {
                        return '
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="' . route('admin.wallet.show', $row->id) . '" class="action_btn edit-item">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>';
                    })
                    // Filtering
                    ->filterColumn('payment_method', function ($query, $keyword) {
                        $query->whereRaw("LOWER(wallet_transactions.payment_method) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $query->whereRaw("LOWER(wallet_transactions.status) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    })
                    ->filterColumn('type', function ($query, $keyword) {
                        $query->whereRaw("LOWER(wallet_transactions.type) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    })
                    ->filterColumn('user', function ($query, $keyword) {
                        $query->whereRaw("LOWER(CONCAT(COALESCE(users.name, ''), ' ', COALESCE(users.last_name, ''))) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                    })
                    ->filterColumn('submitted_at', function ($query, $keyword) {
                        $query->where(function ($q) use ($keyword) {
                            $q->whereDate('wallet_transactions.created_at', $keyword)
                                ->orWhereRaw("DATE_FORMAT(wallet_transactions.created_at, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"])
                                ->orWhereRaw("DATE_FORMAT(wallet_transactions.created_at, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                                ->orWhereRaw("DATE_FORMAT(wallet_transactions.created_at, '%M') LIKE ?", ["%{$keyword}%"]);
                        });
                    })
                    // Sorting
                    ->orderColumn('user', function ($query, $order) {
                        $query->orderByRaw("LOWER(CONCAT(COALESCE(users.name, ''), ' ', COALESCE(users.last_name, ''))) $order");
                    })
                    ->orderColumn('amount', fn($query, $order) => $query->orderBy('wallet_transactions.amount', $order))
                    ->orderColumn('payment_method', fn($query, $order) => $query->orderByRaw("LOWER(wallet_transactions.payment_method) $order"))
                    ->orderColumn('status', fn($query, $order) => $query->orderByRaw("LOWER(wallet_transactions.status) $order"))
                    ->orderColumn('type', fn($query, $order) => $query->orderByRaw("LOWER(wallet_transactions.type) $order"))
                    ->orderColumn('submitted_at', fn($query, $order) => $query->orderBy('wallet_transactions.created_at', $order))
                    ->rawColumns(['user', 'status', 'submitted_at', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while processing the request.'], 500);
            }
        }
    }
    public function show($id)
    {
        $transaction = WalletTransaction::findOrFail($id);
        return view('admin.wallet.detail', compact('transaction'));
    }

    public function approve(Request $request, $id)
    {
        $transaction = WalletTransaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'This transaction is already processed.');
        }

        if ($request->action === 'approve') {
            $transaction->wallet->user->increment('wallet_balance', $transaction->amount);
            if ($transaction->wallet->user->wallet_balance >= 10000 && $transaction->wallet->user->account_type !== 'reseller') {
                $transaction->wallet->user->account_type = 'reseller';
                $transaction->wallet->user->save();
            }
            $transaction->status = 'approved';
            $transaction->save();

            WalletLog::create([
                'user_id' => $transaction->wallet->user_id,
                'amount' => $transaction->amount,
                'type' => 'topup',
                'source' => 'bank_transfer',
                'status' => 'success',
            ]);

            return redirect()->back()
                ->with('success', 'Top-up approved and funds transferred to user wallet.');
        }

        if ($request->action === 'reject') {
            $transaction->status = 'rejected';
            $transaction->save();

            return redirect()->back()
                ->with('success', 'Top-up request rejected.');
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }
}
