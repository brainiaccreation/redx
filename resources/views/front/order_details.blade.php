@extends('front.layouts.app')
@section('title')
    Order Details {{ $order->order_number }}
@endsection
@section('content')
    <!-- My-account-Section Start -->
    <section class="my-account-section section-padding fix">
        <div class="container">
            <div class="my-account-wrapper">
                <div class="row g-4">

                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h3>Order Details #{{ $order->order_number }}</h3>
                            </div>
                            <div class="">
                                <h6>Status: <span style="color:#666C78">{{ ucfirst($order->status) }}</span></h6>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div id="Curriculum" class="tab-pane show active">
                                <div class="cart-list-area">
                                    <div class="table-responsive">
                                        <table class="table common-table">
                                            <thead data-aos="fade-down">
                                                <tr>
                                                    <th class="text-center">Product</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr class="align-items-center py-3">
                                                        <td>
                                                            <div class="cart-item-thumb d-flex align-items-center gap-4">
                                                                {{-- <i class="fas fa-times"></i> --}}
                                                                <img class="w-100"
                                                                    src="{{ $item->product->featured_image ? asset($item->product->featured_image) : URL('front/assets/img/cart/03.jpg') }}"
                                                                    alt="{{ $item->product->name }}">
                                                                <div class="d-flex flex-column bd-highlight mb-3">
                                                                    <div class="bd-highlight">
                                                                        <a
                                                                            href="{{ route('product.detail', $item->product->slug) }}"><span
                                                                                class="text-nowrap">{{ $item->product->name . ' - ' . $item->variant->name }}</span></a>
                                                                    </div>
                                                                    <div class="bd-highlight">
                                                                        @if ($item->giftCardCode && $item->giftCardCode->code)
                                                                            {{-- <div class="gift-card-container">
                                                                                <div class="gift-card-label">YOUR GIFT CARD
                                                                                    CODE
                                                                                </div>
                                                                                <div class="gift-card-code-wrapper">
                                                                                    <div class="gift-card-code">
                                                                                        {{ $item->giftCardCode->code }}
                                                                                    </div>
                                                                                    <button class="copy-button"
                                                                                        onclick="navigator.clipboard.writeText('{{ $item->giftCardCode->code }}')">Copy</button>
                                                                                </div>
                                                                            </div> --}}
                                                                            <div
                                                                                class="gift-card-containmultiple codes gift-card-container">
                                                                                <div class="gift-card-label">YOUR GIFT CARD
                                                                                    CODE</div>
                                                                                <div class="gift-card-code-wrapper">
                                                                                    <div class="gift-card-code">
                                                                                        {{ $item->giftCardCode->code }}
                                                                                    </div>
                                                                                    <button class="copy-button"
                                                                                        onclick="copyToClipboard(this, '{{ $item->giftCardCode->code }}')">Copy</button>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="price-usd">
                                                                {{ $item->quantity }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="price-usd">
                                                                {{ number_format($item->price * $item->quantity, 2) }}
                                                                {{ config('app.currency') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="border-top border-top-dashed">
                                                    <td colspan="2"></td>
                                                    <td colspan="2" class="fw-medium p-0">
                                                        <table class="table table-borderless mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Sub Total :</td>
                                                                    <td class="text-center">
                                                                        {{ number_format($order->total_amount, 2) }}
                                                                        {{ config('app.currency') }}</td>
                                                                </tr>

                                                                <tr class="border-top border-top-dashed">
                                                                    <th scope="row">Total :</th>
                                                                    <th class="text-center">
                                                                        {{ number_format($order->total_amount, 2) }}
                                                                        {{ config('app.currency') }}</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function copyToClipboard(button, code) {
            navigator.clipboard.writeText(code).then(function() {
                const originalText = button.innerText;
                button.innerText = "Copied!";
                button.disabled = true;

                setTimeout(function() {
                    button.innerText = originalText;
                    button.disabled = false;
                }, 2000); // 2 seconds
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
@endsection
