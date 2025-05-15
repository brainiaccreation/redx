<div class="swiper-slide">
    <div class="product-collection-item">
        <div class="product-image">
            <img src="{{ $featured_product->featured_image ? asset($featured_product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                alt="{{ $featured_product->name }}">
            <div class="badge">35%</div>
        </div>
        <div class="product-content text-center">
            <h4>
                <a href="{{ route('product.detail', $featured_product->slug) }}">{{ $featured_product->name }}</a>
            </h4>
            <p class="product-reviews"><span class="product-stars">★★★★★</span> 0 Reivews</p>
            <span class="product-price">$19.00</span> <span class="product-cross-price">$19.00</span>
        </div>
        <div class="product-btn">
            <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To Cart</a>
        </div>
    </div>
</div>
