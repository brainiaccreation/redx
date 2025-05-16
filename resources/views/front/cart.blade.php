@extends('front.layouts.app')
@section('title')
    Cart
@endsection
@section('content')
    <!-- cart section start -->
    <div class="cart-section section-padding">
        <div class="container">
            <div class="cart-list-area">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                                    $total += $subtotal;
                                @endphp
                                <tr class="align-items-center py-3">
                                    <td>
                                        <div class="cart-item-thumb d-flex align-items-center gap-4">
                                            <i class="fas fa-times"></i>
                                            <img class="w-100"
                                                src="{{ $cartItem->product->featured_image ? asset($cartItem->product->featured_image) : URL('front/assets/img/cart/03.jpg') }}"
                                                alt="{{ $cartItem->product->name }}">
                                            <span class="head text-nowrap">{{ $cartItem->product->name }} -
                                                {{ $cartItem->product_variant->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="price-usd">
                                            ${{ number_format($cartItem->price, 2) }} RM
                                        </span>
                                    </td>
                                    <td class="price-quantity text-center">
                                        <div
                                            class="quantity d-inline-flex align-items-center justify-content-center gap-1 py-2 px-4 border n50-border_20 text-sm">
                                            <button class="quantityDecrement"><i class="fal fa-minus"></i></button>
                                            <input type="text" value="{{ $cartItem->quantity }}" class="quantityValue">
                                            <button class="quantityIncrement"><i class="fal fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="price-usd">
                                            ${{ number_format($cartItem->price * $cartItem->quantity, 2) }} USD
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <h2>Total: ${{ number_format($total, 2) }}</h2>
                </div>
                <input type="hidden" id="update-cart-url" value="{{ route('cart.update') }}">
                <div
                    class="coupon-items d-flex flex-md-nowrap flex-wrap justify-content-between align-items-center gap-4 pt-4">
                    <form action="#" class="d-flex flex-sm-nowrap flex-wrap align-items-center gap-3">
                        <input type="text" placeholder="Enter coupon code">
                        <button type="submit" class="custom-rdxbtnr">Apply</button>
                    </form>
                    <button type="button" class="custom-rdxbtnr">Update Cart</button>
                    <a href="{{ route('checkout') }}" class="custom-rdxbtnr">Checkout</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.quantityIncrement, .quantityDecrement', function() {
            const row = $(this).closest('tr');
            const input = row.find('.quantityValue');
            let quantity = parseInt(input.val());
            quantity = $(this).hasClass('quantityIncrement') ? quantity : quantity;
            if (quantity < 1) quantity = 1;

            input.val(quantity);
            const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
            const subtotal = price * quantity;

            row.find('.price-usd').last().text('$' + subtotal.toFixed(2) + ' USD');

            updateCartTotal();
        });

        function updateCartTotal() {
            let total = 0;

            $('.price-quantity').each(function() {
                const row = $(this).closest('tr');
                const price = parseFloat(row.find('.price-usd').first().text().replace(/[^\d.]/g, ''));
                const quantity = parseInt(row.find('.quantityValue').val());
                total += price * quantity;
            });

            $('h2:contains("Total:")').text('Total: $' + total.toFixed(2));
        }
    </script>
@endsection
