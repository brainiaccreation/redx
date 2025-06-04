<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Request;

class Logger
{
    public static function log($type, $userType, $userId, $action, $details = null, $status = 'success', $severity = 'info')
    {
        Log::create([
            'type'       => $type,
            'user_type'  => $userType,
            'user_id'    => $userId,
            'action'     => $action,
            'details'    => $details,
            'ip'         => Request::ip(),
            'status'     => $status,
            'severity'   => $severity,
        ]);
    }
}
