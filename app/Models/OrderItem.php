<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'game_id',
        'server_id',
        'user_name',
        'email',
        'special_instructions',
        'status',
        'delivery_method',
        'code_id',
        'delivery_status',
        'is_code_emailed'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    public function giftCardCode()
    {
        return $this->belongsTo(GiftCardCode::class, 'code_id');
    }
}
