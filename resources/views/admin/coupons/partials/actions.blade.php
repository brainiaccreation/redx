<div class="d-flex gap-2">
    <button onclick="openModal({{ json_encode($coupon) }})" class="action_btn edit-item">
        <i class="ri-edit-line"></i>
    </button>
    <button onclick="deleteCoupon({{ $coupon->id }})" class="action_btn delete-item show_confirm">
        <i class="bx bx-trash"></i>
    </button>
</div>
