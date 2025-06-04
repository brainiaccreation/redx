<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'user_type',
        'user_id',
        'action',
        'details',
        'ip',
        'status',
        'severity',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
