<div class="swiper-slide">
    <a href="{{ route('product.detail', $featured_product->slug) }}">
        <div class="product-collection-item">
            <div class="product-image">
                <img src="{{ $featured_product->featured_image ? asset($featured_product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                    alt="{{ $featured_product->name }}">
                @if (auth()->check() && auth()->user()->account_type === 'reseller')
                    <div class="badge">1%</div>
                @endif
            </div>
            <div class="product-content text-center">
                <h4>
                    {{ $featured_product->name }}
                </h4>
                <p class="product-reviews"><span class="product-stars">★★★★★</span> 0 Reivews</p>
                @if (auth()->check() && auth()->user()->account_type === 'reseller')
                    <span class="product-price">
                        {{ product_price_range($featured_product) }}
                    </span>
                    <span class="product-cross-price">
                        {{ normal_product_price_range($featured_product) }}
                    </span>
                @else
                    <span class="product-price">
                        {{ normal_product_price_range($featured_product) }}
                    </span>
                @endif

            </div>
            {{-- <div class="product-btn">
            <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To Cart</a>
        </div> --}}
        </div>
    </a>
</div>
