<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletLog;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
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
            $data = WalletTransaction::orderBy('created_at', 'desc')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->wallet->user->name . ' ' . $row->wallet->user->last_name;
                })
                ->addColumn('amount', function ($row) {
                    return config('app.currency') . ' ' . number_format($row->amount, 2);
                })
                ->addColumn('payment_method', function ($row) {
                    return ucfirst($row->payment_method);
                })
                ->addColumn('status', function ($row) {
                    $statusClass = match ($row->status) {
                        'pending' => 'bg-warning-subtle text-warning',
                        'approved' => 'bg-success-subtle text-success',
                        'rejected' => 'bg-secondary-subtle text-secondary',
                        default => 'bg-info-subtle text-info'
                    };
                    return '<h5><span class="badge ' . $statusClass . '">' . ucfirst($row->status) . '</span></h5>';
                })
                ->addColumn('type', function ($row) {
                    return ucfirst($row->type);
                })
                ->addColumn('submitted_at', function ($row) {
                    return runTimeDateFormat($row->created_at);
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div style="display: flex;justify-content: center; gap: 8px;">
                            <a href="' . route('admin.wallet.show', $row->id) . '" class="action_btn edit-item">
                                <i class="ri-eye-line"></i>
                            </a>
                            
                        </div>
                    ';
                })

                ->rawColumns(['status', 'submitted_at', 'action'])
                ->make(true);
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
