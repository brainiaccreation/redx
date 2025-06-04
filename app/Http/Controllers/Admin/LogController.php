<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function list()
    {
        return view('admin.logs.list');
    }

    public function get(Request $request)
    {
        $query = Log::with('user')->where('user_type', 'admin')->select('*');

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('user', function ($log) {
                $name = $log->user ? $log->user->name : 'Guest';
                $type = ucfirst($log->user_type ?? 'system');
                $action = ucfirst($log->action ?? 'Action');

                return '<h6 style="margin-bottom: 0px;"><strong>' . e($name) . '</strong></h6><small class="text-muted">' . $type . ' • ' . $action . '</small>';
            })


            ->editColumn('status', function ($log) {
                $class = match ($log->status) {
                    'success' => 'text-success',
                    'failed', 'error' => 'text-danger',
                    'pending' => 'text-warning',
                    default => 'text-secondary',
                };
                return '<span class="' . $class . '">' . ucfirst($log->status) . '</span>';
            })

            ->editColumn('severity', function ($log) {
                $class = match ($log->severity) {
                    'info' => 'text-info',
                    'warning' => 'text-warning',
                    'error' => 'text-danger',
                    default => 'text-muted',
                };
                return '<span class="' . $class . '">' . ucfirst($log->severity) . '</span>';
            })

            ->editColumn('created_at', function ($log) {
                return $log->created_at->format('d M Y h:i A');
            })

            ->rawColumns(['user', 'status', 'severity'])
            ->make(true);
    }
}
