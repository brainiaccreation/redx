<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'expiry_date',
        'status',
        'description'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    // Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    // Accessors
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date < Carbon::now()->toDateString();
    }

    public function getUsagePercentageAttribute()
    {
        return $this->usage_limit > 0 ? round(($this->used_count / $this->usage_limit) * 100, 2) : 0;
    }

    public function getFormattedValueAttribute()
    {
        return $this->type === 'percentage' ? $this->value . '%' : '$' . number_format($this->value, 2);
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->is_expired) {
            return '<span class="badge badge-danger">Expired</span>';
        }

        switch ($this->status) {
            case 'active':
                return '<span class="badge badge-success">Active</span>';
            case 'inactive':
                return '<span class="badge badge-secondary">Inactive</span>';
            default:
                return '<span class="badge badge-secondary">Unknown</span>';
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNotExpired($query)
    {
        return $query->where('expiry_date', '>=', Carbon::now()->toDateString());
    }

    public function scopeValid($query)
    {
        return $query->active()->notExpired();
    }

    // Methods
    public function canBeUsed()
    {
        return $this->status === 'active'
            && !$this->is_expired
            && $this->used_count < $this->usage_limit;
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    // public function calculateDiscount($amount)
    // {
    //     if (!$this->canBeUsed() || $amount < $this->min_amount) {
    //         return 0;
    //     }

    //     $discount = 0;

    //     if ($this->type === 'percentage') {
    //         $discount = ($amount * $this->value) / 100;
    //     } else {
    //         $discount = $this->value;
    //     }

    //     // Apply maximum discount limit if set
    //     if ($this->max_discount && $discount > $this->max_discount) {
    //         $discount = $this->max_discount;
    //     }

    //     return round($discount, 2);
    // }

    public function calculateDiscount($amount)
    {
        if (!$this->canBeUsed() || $amount < $this->min_amount) {
            return 0;
        }
        $discount = 0;

        $discount = $this->type === 'percentage'
            ? ($amount * $this->value) / 100
            : $this->value;

        // Apply maximum discount only for percentage type
        if ($this->type === 'percentage' && $this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }

        return round($discount, 2);
    }
}
