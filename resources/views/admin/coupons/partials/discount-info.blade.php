<div class="small text-dark">
    {{ $coupon->formatted_value }}
</div>
<div class="small text-muted">
    Min: ${{ number_format($coupon->min_amount, 2) }} | Max:
    ${{ $coupon->max_discount ? number_format($coupon->max_discount, 2) : 'N/A' }}
</div>
