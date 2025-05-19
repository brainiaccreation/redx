@foreach ($products as $product)
    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
        <div class="product-collection-item">
            <div class="product-image">
                <img src="{{ $product->featured_image ? asset($product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                    alt="{{ $product->name }}">
                <div class="badge">35%</div>
            </div>
            <div class="product-content text-center">
                <h4>
                    <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                </h4>
                <p class="product-reviews"><span class="product-stars">★★★★★</span> 0
                    Reivews
                </p>
                <span class="product-price">$19.00</span> <span class="product-cross-price">$19.00</span>
            </div>
            <div class="product-btn">
                <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To Cart</a>
            </div>
        </div>
    </div>
@endforeach
@if ($products->isEmpty())
    <p>No products found in this price range.</p>
@endif
