<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'guest_email',
        'guest_phone',
        'status',
        'total_amount',
        'currency',
        'payment_method',
        'payment_id',
        'is_paid',
        'wallet_amount_used',
        'coupon_code',
        'discount_amount',
        'notes',
        'unique_id',
        'delivery_status',
        'refund_status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refundRequest()
    {
        return $this->hasOne(RefundRequest::class, 'order_id');
    }

    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class, 'id', 'order_id');
    }
}
