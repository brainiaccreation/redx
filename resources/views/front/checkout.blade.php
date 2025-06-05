@extends('front.layouts.app')
@section('title')
    Checkout
@endsection

@section('style')
    <style>
        .coupon-section {
            /* background: white;
                                                                                                            padding: 25px;
                                                                                                            margin: 20px 0;
                                                                                                            border-radius: 10px;
                                                                                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
        }

        .coupon-input-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .coupon-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            color: #000000d9;
        }

        .coupon-input:focus {
            outline: none;
            border-color: #e60000;
            color: #000000d9;
        }

        .applied-coupon {
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            animation: slideInUp 0.5s ease;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .coupon-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .coupon-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
            font-size: 16px;
        }

        .remove-coupon {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 5px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .remove-coupon:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .price-breakdown {
            /* background: white;
                                                                                                        padding: 25px;
                                                                                                        border-radius: 10px;
                                                                                                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                                                                                        margin-top: 20px; */
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .price-row:last-child {
            border-bottom: none;
            font-size: 20px;
            font-weight: bold;
            color: #e60000;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #f0f0f0;
        }

        .original-price {
            color: #999;
            text-decoration: line-through;
        }

        .discount-amount {
            color: #00b894;
            font-weight: bold;
        }

        .success-message {
            background: #00b894;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
            animation: fadeIn 0.5s ease;
        }

        .error-message {
            background: #ff4757;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
            animation: fadeIn 0.5s ease;
        }

        .from-customradio-2 {
            margin-bottom: 3px;
            gap: 1rem;
            font-size: 1.1rem;
            font-weight: 400;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Checkout Section Start -->
    <section class="checkout-section fix section-padding">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="checkout-wrapper">
                <form action="{{ route('checkout.process') }}" method="post">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <form action="#" method="post">
                                <div class="checkout-single-wrapper">
                                    <div class="checkout-single boxshado-single">
                                        <h4>Billing Details</h4>
                                        <div class="checkout-single-form">
                                            <div class="row g-4">
                                                @if (!auth()->check())
                                                    <div class="col-lg-6">
                                                        <div class="input-single">
                                                            <span>First Name*</span>
                                                            <input type="text" name="name" id="userFirstName"
                                                                required="" placeholder="First Name"
                                                                value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="input-single">
                                                            <span>Last Name*</span>
                                                            <input type="text" name="last_name" id="userLastName"
                                                                required="" placeholder="Last Name"
                                                                value="{{ auth()->check() ? auth()->user()->last_name : '' }}">
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (!auth()->check())
                                                    <div class="col-lg-12">
                                                        <div class="input-single">
                                                            <span>Whatsapp Number*</span>
                                                            <input name="phone" id="phone"
                                                                placeholder="Whatsapp Number"
                                                                value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Order notes (optional)</span>
                                                        <textarea name="notes" id="notes" placeholder="Notes about your order, e.g special notes for delivery."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="checkout-order-area">
                                <h3>Our Order</h3>
                                <div class="product-checout-area">
                                    <div class="checkout-item d-flex align-items-center justify-content-between">
                                        <p>Product</p>
                                        <p>Subtotal</p>
                                    </div>
                                    @foreach ($cartItems as $cart)
                                        <div class="checkout-item d-flex align-items-center justify-content-between">
                                            <p>{{ $cart->product->name }} - {{ $cart->product_variant->name }}</p>
                                            <p>{{ config('app.currency') }}
                                                {{ calculatedPrice($cart->price * $cart->quantity) }}</p>
                                        </div>
                                    @endforeach
                                    <!-- Coupon Section -->
                                    <div class="coupon-section">
                                        <h3 style="margin-bottom: 15px; color: #333;">Apply Coupon</h3>
                                        <div id="appliedCoupon"></div>
                                        <div class="coupon-input-container">
                                            <input type="text" class="coupon-input" id="coupon_code" name="coupon_code"
                                                placeholder="Enter coupon code">
                                            <button type="button" class="custom-rdxbtnr"
                                                id="apply-coupon-btn">Apply</button>
                                        </div>
                                        <div id="coupon-message"></div>
                                        <!-- Hidden input to store coupon ID -->
                                        <input type="hidden" name="coupon_id" id="coupon_id" value="">
                                        <input type="hidden" name="applied_coupon_code" id="applied_coupon_code"
                                            value="">
                                    </div>
                                    <!-- Price Breakdown -->
                                    <div class="price-breakdown">
                                        <div class="price-row">
                                            <span>Subtotal:</span>
                                            <span id="originalPrice">{{ config('app.currency') }}
                                                {{ calculatedPrice($total) }}</span>
                                        </div>
                                        <div class="price-row" id="discountRow" style="display: none;">
                                            <span>Discount:</span>
                                            <span class="discount-amount" id="discountAmount">-
                                                {{ config('app.currency') }} 0.00</span>
                                        </div>
                                        <div class="price-row">
                                            <span>Total:</span>
                                            <span id="finalTotal">{{ config('app.currency') }}
                                                {{ calculatedPrice($total) }}</span>
                                        </div>
                                    </div>
                                    <!-- Payment Methods -->
                                    <div class="">
                                        @if (auth()->check() && auth()->user()->wallet_balance && auth()->user()->wallet_balance > 0)
                                            <div class="form-check-3 d-flex align-items-center from-customradio-2 mt-3">
                                                <input class="form-check-input" type="radio" value="wallet"
                                                    name="payment_mode" id="payment_mode12223">
                                                <label class="form-check-label" for="payment_mode12223">
                                                    Wallet
                                                </label>
                                            </div>
                                        @endif
                                        <div class="form-check-3 d-flex align-items-center from-customradio-2 mt-3">
                                            <input class="form-check-input" type="radio" value="stripe"
                                                name="payment_mode" id="payment_mode12224">
                                            <label class="form-check-label" for="payment_mode12224">
                                                Stripe
                                            </label>
                                        </div>
                                        <div class="form-check-3 d-flex align-items-center from-customradio-2 mt-3">
                                            <input class="form-check-input" type="radio" name="payment_mode"
                                                id="payment_mode12225" checked value="paydibs">
                                            <label class="form-check-label" for="payment_mode12225">
                                                Paydibs
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="custom-rdxbtnr mt-4">
                                        Proceed To Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const appCurrency = "{{ config('app.currency') }}";
        let originalTotal = {{ $total ?? 0 }};
        let currentTotal = {{ $total ?? 0 }};
        let appliedCoupon = null;

        $(document).on('click', '.quantityIncrement, .quantityDecrement', function() {
            const row = $(this).closest('tr');
            const input = row.find('.quantityValue');
            let quantity = parseInt(input.val());
            const isIncrement = $(this).hasClass('quantityIncrement');

            quantity = isIncrement ? quantity + 1 : quantity - 1;
            if (quantity < 1) quantity = 1;

            input.val(quantity);
            const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
            const subtotal = price * quantity;
            row.find('.price-usd').last().text(subtotal.toFixed(2) + ' ' + appCurrency);

            updateCartTotal();
        });

        function updateCartTotal() {
            let total = 0;

            $('.price-quantity').each(function() {
                const row = $(this).closest('tr');
                const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
                const quantity = parseInt(row.find('.quantityValue').val());
                if (!isNaN(quantity)) {
                    total += price * quantity;
                }
            });

            originalTotal = total;

            // Reapply coupon if it exists
            if (appliedCoupon) {
                $.ajax({
                    url: "{{ route('coupon.apply') }}",
                    type: "POST",
                    data: {
                        code: appliedCoupon.code,
                        total: originalTotal,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.error) {
                            currentTotal = response.new_total;
                            appliedCoupon.coupon_id = response.coupon_id; // Update coupon_id if needed
                            appliedCoupon.coupon_code = response.coupon_code; // Update coupon_code if needed
                            $('#coupon_id').val(appliedCoupon.coupon_id); // Update hidden input
                            $('#applied_coupon_code').val(appliedCoupon.coupon_code); // Set hidden input

                            updatePriceDisplay();
                        } else {
                            appliedCoupon = null;
                            $('#coupon_id').val(''); // Clear hidden input
                            $('#applied_coupon_code').val(''); // Set hidden input

                            currentTotal = originalTotal;
                            $('#appliedCoupon').html('');
                            updatePriceDisplay();
                            showMessage('Coupon is no longer valid due to quantity change.', 'error');
                        }
                    },
                    error: function() {
                        appliedCoupon = null;
                        $('#coupon_id').val(''); // Clear hidden input
                        $('#applied_coupon_code').val(''); // Set hidden input

                        currentTotal = originalTotal;
                        $('#appliedCoupon').html('');
                        updatePriceDisplay();
                        showMessage('Error reapplying coupon. Coupon removed.', 'error');
                    }
                });
            } else {
                currentTotal = originalTotal;
                $('#coupon_id').val(''); // Clear hidden input if no coupon
                $('#applied_coupon_code').val(''); // Set hidden input

                updatePriceDisplay();
            }
        }

        function updatePriceDisplay() {
            $('#originalPrice').text(appCurrency + ' ' + originalTotal.toFixed(2));
            $('#finalTotal').text(appCurrency + ' ' + currentTotal.toFixed(2));

            if (appliedCoupon) {
                let discountAmount = originalTotal - currentTotal;
                if (discountAmount > 0) {
                    $('#discountRow').show();
                    $('#discountAmount').text('- ' + appCurrency + ' ' + discountAmount.toFixed(2));
                } else {
                    $('#discountRow').hide();
                }
            } else {
                $('#discountRow').hide();
            }
        }

        // Enhanced Coupon Application
        $('#apply-coupon-btn').on('click', function() {
            const couponCode = $('#coupon_code').val().trim();

            if (!couponCode) {
                showMessage('Please enter a coupon code', 'error');
                return;
            }

            if (appliedCoupon && appliedCoupon.code === couponCode.toUpperCase()) {
                showMessage('This coupon is already applied!', 'error');
                return;
            }

            $.ajax({
                url: "{{ route('coupon.apply') }}",
                type: "POST",
                data: {
                    code: couponCode,
                    total: originalTotal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.error) {
                        showMessage(response.error, 'error');
                    } else {
                        appliedCoupon = {
                            code: couponCode.toUpperCase(),
                            type: response.discount_type,
                            value: response.discount_value,
                            description: response.description,
                            coupon_id: response.coupon_id, // Store coupon ID
                            coupon_code: response.coupon_code // Store coupon CODE
                        };

                        currentTotal = response.new_total;
                        $('#coupon_id').val(appliedCoupon.coupon_id); // Set hidden input
                        $('#applied_coupon_code').val(appliedCoupon.coupon_code); // Set hidden input
                        displayAppliedCoupon();
                        updatePriceDisplay();
                        $('#coupon_code').val('');
                        $('#applied_coupon_code').val('');
                        showMessage('Coupon "' + couponCode.toUpperCase() + '" applied successfully!',
                            'success');
                    }
                },
                error: function() {
                    showMessage('Error applying coupon. Please try again.', 'error');
                }
            });
        });

        function displayAppliedCoupon() {
            const container = $('#appliedCoupon');
            container.html('');

            if (appliedCoupon) {
                const couponDiv = $(`
                    <div class="applied-coupon">
                        <div class="coupon-info">
                            <span class="coupon-icon">🎫</span>
                            <div>
                                <strong>${appliedCoupon.code}</strong>
                                <div style="font-size: 14px; opacity: 0.9;">${appliedCoupon.description}</div>
                            </div>
                        </div>
                        <button type="button" class="remove-coupon" onclick="removeCoupon()">Remove</button>
                    </div>
                `);
                container.append(couponDiv);
            }
        }

        function removeCoupon() {
            appliedCoupon = null;
            currentTotal = originalTotal;
            $('#coupon_id').val(''); // Clear hidden input
            $('#applied_coupon_code').val(''); // Set hidden input

            updatePriceDisplay();
            $('#appliedCoupon').html('');
            showMessage('Coupon removed successfully!', 'success');
        }

        function showMessage(message, type) {
            const messageDiv = $('#coupon-message');
            messageDiv.html(`<div class="${type}-message">${message}</div>`);

            setTimeout(() => {
                messageDiv.html('');
            }, 3000);
        }

        // Initialize price display
        updatePriceDisplay();
    </script>
@endsection
