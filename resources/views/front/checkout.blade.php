@extends('front.layouts.app')
@section('title')
    Checkout
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

                                                {{-- <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Country*</span>
                                                        <input name="country" id="country" placeholder="Country"
                                                            value="{{ auth()->check() ? auth()->user()->country : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Street Address*</span>
                                                        <input name="address" id="userAddress"
                                                            placeholder="Home number and street name"
                                                            value="{{ auth()->check() ? auth()->user()->address : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Street Address*</span>
                                                        <input name="address2" id="userAddress2"
                                                            placeholder="Apartment, suite, unit, etc. (optional)"
                                                            value="{{ auth()->check() ? auth()->user()->address2 : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Town/ City*</span>
                                                        <input name="towncity" id="towncity" placeholder="City"
                                                            value="{{ auth()->check() ? auth()->user()->towncity : '' }}">
                                                    </div>
                                                </div> --}}
                                                @if (!auth()->check())
                                                    <div class="col-lg-12">
                                                        <div class="input-single">
                                                            <span>Phone*</span>
                                                            <input name="phone" id="phone" placeholder="phone"
                                                                value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                                                        </div>
                                                    </div>
                                                @endif
                                                {{-- <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>Email Address*</span>
                                                        <input name="email" id="email22" placeholder="email"
                                                            value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-lg-12">
                                                    <div class="input-check payment-save">
                                                        <input type="checkbox" class="form-check-input" name="save-for-next"
                                                            id="saveForNext111">
                                                        <label for="saveForNext111">Save for my next payment</label>
                                                    </div>
                                                    <div class="input-check payment-save style-2">
                                                        <input type="checkbox" class="form-check-input" name="save-for-next"
                                                            id="saveForNext2">
                                                        <label for="saveForNext2">Ship to a different address?</label>
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-12">
                                                    <div class="input-single">
                                                        <span>order notes (optional)</span>
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
                                    {{-- <div class="checkout-item d-flex justify-content-between">
                                    <p>Shipping</p>
                                    <div class="shopping-items">
                                        <div class="form-check d-flex align-items-center from-customradio">
                                            <label class="form-check-label">
                                                Free Shipping
                                            </label>
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault12">
                                        </div>
                                        <div class="form-check d-flex align-items-center from-customradio">
                                            <label class="form-check-label">
                                                Local: $15.00
                                            </label>
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault123">
                                        </div>
                                        <div class="form-check d-flex align-items-center from-customradio">
                                            <label class="form-check-label">
                                                Flat rate: $10.00
                                            </label>
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault124">
                                        </div>
                                    </div>
                                </div> --}}
                                    <div class="checkout-item d-flex align-items-center justify-content-between">
                                        <p>Total</p>
                                        <p>{{ config('app.currency') }} {{ calculatedPrice($total) }}</p>
                                    </div>
                                    <div class="checkout-item-2">
                                        {{-- <div class="form-check-2 d-flex align-items-center from-customradio-2">
                                            <input class="form-check-input" type="radio" name="payment_mode"
                                                id="payment_mode1222">
                                            <label class="form-check-label" for="payment_mode1222">
                                                Direct bank transfer
                                            </label>
                                        </div>
                                        <p>
                                            Make your payment directly into our bank account please use your Order ID as the
                                            payment reference. Your order will not be shipped until the funds have cleared
                                            in our account.
                                        </p> --}}
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
                                    <button type="submit" class="custom-rdxbtnr">
                                        Procced To Checkout
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
