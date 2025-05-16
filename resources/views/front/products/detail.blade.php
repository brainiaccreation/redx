@extends('front.layouts.app')
@section('title')
    {{ $product->name }} | Detail
@endsection
@section('content')
    <!-- Shop Details Section Start -->
    <section class="shop-details-section section-padding fix shop-bg">
        <div class="container">
            <div class="shop-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="shop-details-image">
                            <div class="tab-content">
                                <div id="thumb1" class="tab-pane fade show active">
                                    <div class="shop-thumb">
                                        <img src="{{ $product->featured_image ? asset($product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                </div>
                                {{-- <div id="thumb2" class="tab-pane fade">
                                    <div class="shop-thumb">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </div>
                                </div>
                                <div id="thumb3" class="tab-pane fade">
                                    <div class="shop-thumb">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </div>
                                </div>
                                <div id="thumb4" class="tab-pane fade">
                                    <div class="shop-thumb">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </div>
                                </div>
                                <div id="thumb5" class="tab-pane fade">
                                    <div class="shop-thumb">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <ul class="nav">
                                <li class="nav-item">
                                    <a href="#thumb1" data-bs-toggle="tab" class="nav-link ps-0 active">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#thumb2" data-bs-toggle="tab" class="nav-link">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#thumb3" data-bs-toggle="tab" class="nav-link">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#thumb4" data-bs-toggle="tab" class="nav-link">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#thumb5" data-bs-toggle="tab" class="nav-link">
                                        <img src="{{ URL('front/assets') }}/img/product/01.jpg" alt="img">
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details-content">
                            <h3 class="pb-3">{{ $product->name }}</h3>
                            <div class="star pb-3">
                                <a href="#"> <i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"> <i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <span>(25 Customer Review)</span>
                            </div>
                            <p class="mb-3">
                                {{ $product->short_description }}
                            </p>
                            <div class="price-list">
                                <h3>Select Package</h3>
                                <div class="row">
                                    @foreach ($product->variants as $variant)
                                        <div class="col-6 col-md-6 card-container">
                                            <div class="pricing-card" data-id="{{ $variant->id }}"
                                                data-name="{{ $variant->name }}" data-sku="{{ $variant->sku }}"
                                                data-price="{{ $variant->price }}"
                                                data-product-id="{{ $variant->product_id }}">
                                                <div class="lattice-count">{{ $variant->name }}</div>
                                                <div class="price">RM {{ $variant->price }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <h3 id="product_price">0.00</h3>
                            </div>
                            <div class="cart-quantity">
                                <label for="user_id" class="form-label">User ID <span class="text-danger">*</span> </label>
                                <input type='text' name='user_id' placeholder="Please enter your User ID here"
                                    class='form-control'>
                            </div>
                            <div class="cart-wrp">
                                <div class="cart-quantity">
                                    <form id='myform' method='POST' class='quantity' action='#'>
                                        <input type='button' value='-' class='qtyminus minus'>
                                        <input type='number' name='quantity' value='0' class='qty'>
                                        <input type='button' value='+' class='qtyplus plus'>
                                    </form>
                                </div>
                                <a href="javascript:void(0);" class="icon">
                                    <i class="far fa-heart"></i>
                                </a>
                                <div class="social-profile">
                                    <span class="plus-btn"><i class="far fa-share"></i></span>
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-btn">
                                <a href="javascript::void(0);" class="custom-rdxbtnr add-to-cart-btn"
                                    data-id="{{ $variant->id }}" data-product-id="{{ $product->id }}"
                                    data-price="{{ $variant->price }}" id="addToCartBtn">
                                    <span> Add to cart</span>

                                </a>
                                <a href="product-details.html" class="custom-rdxbtnbl">
                                    <span> Buy now</span>
                                </a>
                            </div>
                            {{-- <h6 class="details-info"><span>SKU:</span> <a href="product-details.html">124224</a></h6> --}}
                            <h6 class="details-info"><span>Categories:</span> <a
                                    href="product-details.html">{{ $product->category->name }}</a></h6>
                            {{-- <h6 class="details-info style-2"><span>Tags:</span> <a href="product-details.html">
                                    <b>accessories</b> <b>business</b></a></h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Single-tab Section Start -->
    <section class="single-tab-section section-padding fix pt-0">
        <div class="container">
            <div class="single-tab">
                <ul class="nav mb-5">
                    <li class="nav-item">
                        <a href="#description" data-bs-toggle="tab" class="nav-link ps-0 active">
                            <h6>Description</h6>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#additional" data-bs-toggle="tab" class="nav-link">
                            <h6>Additional Information </h6>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="#review" data-bs-toggle="tab" class="nav-link">
                            <h6>reviews (2)</h6>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="description" class="tab-pane fade show active">
                        <div class="description-items">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="description-content">
                                        <h3>Product descriptions</h3>
                                        <p class="mb-4">
                                            {!! $product->description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="additional" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Weight</td>
                                        <td>240 Ton</td>
                                    </tr>
                                    <tr>
                                        <td>Dimensions</td>
                                        <td>20 × 30 × 40 cm</td>
                                    </tr>
                                    <tr>
                                        <td>Colors</td>
                                        <td>Black, Blue, Green</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <div id="review" class="tab-pane fade">
                        <div class="review-items">
                            <div class="admin-items d-flex flex-wrap flex-md-nowrap align-items-center pb-4">
                                <div class="admin-img pb-4 pb-md-0 me-4">
                                    <img src="{{ URL('front/assets') }}/img/testimonial/avatar-1.jpg" alt="img">
                                </div>
                                <div class="content p-4">
                                    <div class="head-content pb-1 d-flex flex-wrap justify-content-between">
                                        <h5>miklos salsa<span>27June 2025 at 5.44pm</span></h5>
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Curabitur vulputate
                                        vestibulum Phasellus rhoncus dolor eget viverra pretium.Curabitur vulputate
                                        vestibulum Phasellus rhoncus dolor eget viverra pretium.
                                    </p>
                                </div>
                            </div>
                            <div class="admin-items d-flex flex-wrap flex-md-nowrap align-items-center pb-4">
                                <div class="admin-img pb-4 pb-md-0 me-4">
                                    <img src="{{ URL('front/assets') }}/img/testimonial/avatar-1.jpg" alt="img">
                                </div>
                                <div class="content p-4">
                                    <div class="head-content pb-1 d-flex flex-wrap justify-content-between">
                                        <h5>Ethan Turner <span>27June 2025 at 5.44pm</span></h5>
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Curabitur vulputate
                                        vestibulum Phasellus rhoncus dolor eget viverra pretium.Curabitur vulputate
                                        vestibulum Phasellus rhoncus dolor eget viverra pretium.
                                    </p>
                                </div>
                            </div>
                            <div class="review-title mt-5 py-15 mb-30">
                                <h4>add a review</h4>
                                <div class="rate-now d-flex align-items-center">
                                    <p>Rate this product? *</p>
                                    <div class="star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="review-form">
                                <form action="#" id="contact-form2" method="POST">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <input type="text" name="name" id="name"
                                                    placeholder="Full Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-clt">
                                                <input type="text" name="email" id="email"
                                                    placeholder="email addres">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".8">
                                            <div class="form-clt-big form-clt">
                                                <textarea name="message" id="message" placeholder="message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".9">
                                            <button type="submit" class="theme-btn hover-color">
                                                Post Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product-collection Section Start -->
    <section class="product-collection-section-2 section-padding pt-0 fix">
        <div class="container">
            <div class="section-title style-2 text-center">
                <h6 class="sub-title wow fadeInUp">
                    Next day Products
                </h6>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    Related Products
                </h2>
            </div>
            <div class="tab-content">
                <div class="row">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                            <div class="product-collection-item">
                                <div class="product-image">
                                    <img src="{{ $relatedProduct->featured_image ? asset($relatedProduct->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                                        alt="{{ $relatedProduct->name }}">
                                    <div class="badge">35%</div>
                                </div>
                                <div class="product-content text-center">
                                    <h4>
                                        <a
                                            href="{{ route('product.detail', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                                    </h4>
                                    <p class="product-reviews"><span class="product-stars">★★★★★</span> 0 Reivews</p>
                                    <span class="product-price">$19.00</span> <span
                                        class="product-cross-price">$19.00</span>
                                </div>
                                <div class="product-btn">
                                    <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.pricing-card', function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $('.pricing-card').removeClass('active');
                $(this).addClass('active');
            }
        });
    </script>
    <script>
        let selectedPrice = 0;

        $(document).on('click', '.pricing-card', function() {
            $('.pricing-card').removeClass('active');
            $(this).addClass('active');

            selectedPrice = parseFloat($(this).data('price'));
            let qty = parseInt($('.qty').val());

            updatePriceDisplay(selectedPrice, qty);
        });

        $('.qtyplus').click(function() {
            setTimeout(() => {
                let qty = parseInt($('.qty').val());
                updatePriceDisplay(selectedPrice, qty);
            }, 200);
        });

        $('.qtyminus').click(function() {
            setTimeout(() => {
                let qty = parseInt($('.qty').val());
                updatePriceDisplay(selectedPrice, qty);
            }, 200);
        });

        function updatePriceDisplay(price, quantity) {
            let total = (price * quantity).toFixed(2);
            $('#product_price').text(`RM ${total}`);
        }

        $('.qty').on('input', function() {
            let qty = parseInt($(this).val());
            updatePriceDisplay(selectedPrice, qty);
        });
    </script>
    <script>
        $(document).ready(function() {

            // Handle variant selection
            $('.pricing-card').on('click', function() {
                $('.pricing-card').removeClass('selected');
                $(this).addClass('selected');
            });

            // Handle Add to Cart button
            $('#addToCartBtn').on('click', function() {
                var selected = $('.pricing-card.selected');

                if (selected.length === 0) {
                    alert('Please select a variant.');
                    return;
                }
                var userId = $("input[name='user_id']").val().trim();

                if (userId === '') {
                    alert('Please enter your User ID.');
                    return;
                }
                var variant = {
                    id: selected.data('id'),
                    name: selected.data('name'),
                    sku: selected.data('sku'),
                    price: selected.data('price'),
                    product_id: selected.data('product-id')
                };

                console.log("Selected Variant:", variant);

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        variant_id: variant.id,
                        product_id: variant.product_id,
                        price: variant.price,
                        quantity: 1,
                        game_user_id: userId
                    },
                    success: function(response) {
                        alert('Item added to cart successfully');
                    },
                    error: function(xhr) {
                        alert('Failed to add to cart');
                    }
                });
            });

        });
    </script>
@endsection
