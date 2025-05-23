<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_id', 'type', 'amount', 'description', 'payment_method', 'receipt_image', 'status'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
