<div class="small text-dark">
    {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
</div>
<div class="progress mt-1" style="height: 8px;">
    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ min($coupon->usage_percentage, 100) }}%;"
        aria-valuenow="{{ min($coupon->usage_percentage, 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
