@extends('front.layouts.app')
@section('title')
    Carts
@endsection
@section('content')
    <!-- cart section start -->
    <div class="cart-section section-padding">
        <div class="container">
            @if (!empty($cartItems) && count($cartItems) > 0)
                <div class="cart-list-area">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($cartItems)
                        <div class="table-responsive">
                            <table class="table common-table">
                                <thead data-aos="fade-down">
                                    <tr>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        @php
                                            $subtotal = $cartItem->price * $cartItem->quantity;
                                            // $total += $subtotal;
                                        @endphp
                                        <tr class="align-items-center py-3"data-product-id="{{ isset($cartItem->product_id) ? $cartItem->product_id : (isset($cartItem->product['id']) ? $cartItem->product['id'] : '') }}"
                                            data-variant-id="{{ isset($cartItem->variant_id) ? $cartItem->variant_id : (isset($cartItem->product_variant['id']) ? $cartItem->product_variant['id'] : '') }}"
                                            data-is-model="{{ isset($cartItem->id) ? 'true' : 'false' }}">
                                            <td>
                                                <div class="cart-item-thumb d-flex align-items-center gap-4">
                                                    <i class="fas fa-times remove-cart-item" style="cursor:pointer;"
                                                        title="Remove item"></i>
                                                    <img src="{{ $cartItem->product->featured_image ? asset($cartItem->product->featured_image) : URL('front/assets/img/cart/03.jpg') }}"
                                                        alt="{{ $cartItem->product->name }}">
                                                    <div class="d-flex flex-column">
                                                        <span class="head">{{ $cartItem->product->name }} -
                                                            {{ $cartItem->product_variant->name }}</span>
                                                        @if ($cartItem->game_user_id)
                                                            <span class="text-sm d-flex text-nowrap"> <span
                                                                    class="text-dark">User
                                                                    ID: &nbsp;</span>
                                                                {{ $cartItem->game_user_id }}</span>
                                                        @endif
                                                        @if ($cartItem->game_server_id)
                                                            <span class="text-sm d-flex text-nowrap"> <span
                                                                    class="text-dark">Server
                                                                    ID: &nbsp;</span>
                                                                {{ $cartItem->game_server_id }}</span>
                                                        @endif
                                                        @if ($cartItem->game_user_name)
                                                            <span class="text-sm d-flex text-nowrap"> <span
                                                                    class="text-dark">User Name: &nbsp;</span>
                                                                {{ $cartItem->game_user_name }}</span>
                                                        @endif
                                                        @if ($cartItem->game_email)
                                                            <span class="text-sm d-flex text-nowrap"> <span
                                                                    class="text-dark">Email: &nbsp;</span>
                                                                {{ $cartItem->game_email }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="price-usd">
                                                    {{ number_format($cartItem->price, 2) }} {{ config('app.currency') }}
                                                </span>
                                            </td>
                                            <td class="price-quantity text-center">
                                                <div
                                                    class="quantity d-inline-flex align-items-center justify-content-center gap-1 py-2 px-4 border n50-border_20 text-sm">
                                                    <button class="quantityDecrement"><i class="fal fa-minus"></i></button>
                                                    <input type="text" value="{{ $cartItem->quantity }}"
                                                        class="quantityValue">
                                                    <button class="quantityIncrement"><i class="fal fa-plus"></i></button>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="price-usd">
                                                    {{ number_format($cartItem->price * $cartItem->quantity, 2) }}
                                                    {{ config('app.currency') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <h2>Total: {{ config('app.currency') }} {{ number_format($total, 2) }}</h2>
                        </div>
                    @endif

                    <input type="hidden" id="update-cart-url" value="{{ route('cart.update') }}">
                    @if ($cartItems)
                        <div
                            class="coupon-items d-flex flex-md-nowrap flex-wrap justify-content-end align-items-center gap-4 pt-4">
                            {{-- <form action="#" class="d-flex flex-sm-nowrap flex-wrap align-items-center gap-3">
                                <input type="text" placeholder="Enter coupon code">
                                <button type="submit" class="custom-rdxbtnr">Apply</button>
                            </form> --}}
                            <button type="button" class="custom-rdxbtnr">Update Cart</button>
                            <a href="{{ route('checkout') }}" class="custom-rdxbtnr">Checkout</a>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <h2>No items in cart</h2>
                </div>
            @endif

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const appCurrency = "{{ config('app.currency') }}";

        $(document).on('click', '.quantityIncrement, .quantityDecrement', function() {
            const row = $(this).closest('tr');
            const input = row.find('.quantityValue');
            let quantity = parseInt(input.val());
            const isIncrement = $(this).hasClass('quantityIncrement');

            quantity = isIncrement ? quantity + 1 : quantity - 1;
            if (quantity < 0) quantity = 0;

            input.val(quantity);

            handleQuantityChange(row, quantity);

            // const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
            // const subtotal = price * quantity;
            // row.find('.price-usd').last().text(appCurrency + subtotal.toFixed(2));

            // updateCartTotal();
        });

        $(document).on('keyup', '.quantityValue', function() {
            const input = $(this);
            const row = input.closest('tr');
            let quantity = parseInt(input.val());

            if (isNaN(quantity) || quantity < 0) {
                quantity = 0;
            }

            input.val(quantity);
            handleQuantityChange(row, quantity);
        });

        function handleQuantityChange(row, quantity) {
            const productId = row.data('product-id');
            const variantId = row.data('variant-id');
            const isModel = row.data('is-model');

            if (quantity === 0) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        variant_id: variantId,
                        is_model: isModel
                    },
                    success: function(res) {
                        row.remove();
                        toastr.success(res.message);
                        updateCartTotal();
                    },
                    error: function() {
                        toastr.error('Error removing item.');
                    }
                });
            } else {
                const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
                const subtotal = price * quantity;
                row.find('.price-usd').last().text(subtotal.toFixed(2) + ' ' + appCurrency);
                updateCartTotal();
            }
        }

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

            $('h2:contains("Total:")').text('Total: ' + appCurrency + ' ' + total.toFixed(2));
        }
    </script>
    <script>
        $(document).on('click', '.custom-rdxbtnr:contains("Update Cart")', function() {
            let items = [];

            $('tr[data-product-id]').each(function() {
                const row = $(this);
                const productId = row.data('product-id');
                const variantId = row.data('variant-id');
                const isModel = row.data('is-model');
                const quantity = parseInt(row.find('.quantityValue').val());

                if (!isNaN(quantity) && quantity >= 0) {
                    items.push({
                        product_id: productId,
                        variant_id: variantId,
                        is_model: isModel,
                        quantity: quantity
                    });
                }
            });

            const url = $('#update-cart-url').val();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: items
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                    } else {
                        toastr.error('Something went wrong.');
                    }
                },
                error: function() {
                    toastr.error('Error updating cart.');
                }
            });
        });
        // cart remove
        $(document).on('click', '.remove-cart-item', function() {
            const row = $(this).closest('tr');
            const productId = row.data('product-id');
            const variantId = row.data('variant-id');
            const isModel = row.data('is-model');
            const url = "{{ route('cart.remove') }}";

            if (!confirm('Are you sure you want to remove this item?')) return;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    variant_id: variantId,
                    is_model: isModel
                },
                success: function(res) {
                    row.remove();
                    toastr.success(res.message);
                    updateCartTotal();

                },
                error: function() {
                    toastr.error('Error occurred while removing item.');
                }
            });
        });
    </script>
@endsection
