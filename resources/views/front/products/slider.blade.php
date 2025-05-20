<div class="swiper-slide">
    <div class="product-collection-item">
        <div class="product-image">
            <img src="{{ $featured_product->featured_image ? asset($featured_product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                alt="{{ $featured_product->name }}">
            {{-- <div class="badge">35%</div> --}}
        </div>
        <div class="product-content text-center">
            <h4>
                <a href="{{ route('product.detail', $featured_product->slug) }}">{{ $featured_product->name }}</a>
            </h4>
            <p class="product-reviews"><span class="product-stars">★★★★★</span> 0 Reivews</p>
            @if (auth()->check() && auth()->user()->account_type === 'reseller')
                <span class="product-price">
                    {{ product_price_range($product) }}
                </span>
                <span class="product-cross-price">
                    {{ normal_product_price_range($product) }}
                </span>
            @else
                <span class="product-price">
                    {{ normal_product_price_range($product) }}
                </span>
            @endif

        </div>
        {{-- <div class="product-btn">
            <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To Cart</a>
        </div> --}}
    </div>
</div>
