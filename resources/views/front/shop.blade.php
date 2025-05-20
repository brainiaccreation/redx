@extends('front.layouts.app')
@section('title')
    Shop
@endsection
@section('content')
    <section class="shop-left-sideber-section section-padding fix">
        <div class="container">
            <div class="product-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="main-sideber">
                            <div class="single-sidebar-widget-2">
                                <div class="wid-title">
                                    <h5>price filter</h5>
                                </div>
                                <div class="range__barcustom">
                                    <div class="slider">
                                        <div class="progress" style="left: 25%; right: 25%;"></div>
                                    </div>
                                    <div class="range-input">
                                        <input type="range" class="range-min" min="0" max="10000"
                                            value="2500">
                                        <input type="range" class="range-max" min="1" max="10000"
                                            value="7500">
                                    </div>
                                    <div class="range-items">
                                        <div class="price-input d-flex">
                                            <div class="field">
                                                <span>{{ config('app.currency') }} </span>
                                                <input type="number" class="input-min" value="{{ $minPrice }}">
                                            </div>
                                            <div class="separators">-</div>
                                            <div class="field">
                                                <span>{{ config('app.currency') }} </span>
                                                <input type="number" class="input-max" value="{{ $maxPrice }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-sidebar-widget-2">
                                <div class="wid-title">
                                    <h5>Product Status</h5>
                                </div>
                                <div class="product-list">
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-2 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                On sale
                                            </span>
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox" checked="checked">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                In stock
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="single-sidebar-widget-2">
                                <div class="courses-list">
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                <span class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                                <span class="ratting-text">(22)</span>
                                            </span>
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                <span class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                </span>
                                                <span class="ratting-text">(15)</span>
                                            </span>
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                <span class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                </span>
                                                <span class="ratting-text">(03)</span>
                                            </span>
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                <span class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                </span>
                                                <span class="ratting-text">(00)</span>
                                            </span>
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                <span class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                    <i class="fas fa-star color-2"></i>
                                                </span>
                                                <span class="ratting-text">(00)</span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="single-sidebar-widget-2">
                                <div class="wid-title">
                                    <h5>Categories</h5>
                                </div>
                                <div class="widget-categories">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li><a
                                                    href="javascript::void(0);">{{ $category->name }}</a><span>{{ $category->products_count }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="single-sidebar-widget-2">
                                <div class="wid-title">
                                    <h5>Filter by Color</h5>
                                </div>
                                <div class="list">
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox" checked="checked">
                                                <span class="checkmark d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Red
                                            </span>
                                        </span>
                                        <span class="text">
                                            8
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-2 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Dark Blue
                                            </span>
                                        </span>
                                        <span class="text">
                                            14
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-3 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Orange
                                            </span>
                                        </span>
                                        <span class="text">
                                            18
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-4 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Purple
                                            </span>
                                        </span>
                                        <span class="text">
                                            23
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-5 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Yellow
                                            </span>
                                        </span>
                                        <span class="text">
                                            17
                                        </span>
                                    </label>
                                    <label class="checkbox-single">
                                        <span class="d-flex gap-xl-3 gap-2 align-items-center">
                                            <span class="checkbox-area d-center">
                                                <input type="checkbox">
                                                <span class="checkmark bg-6 d-center"></span>
                                            </span>
                                            <span class="text-color">
                                                Green
                                            </span>
                                        </span>
                                        <span class="text">
                                            15
                                        </span>
                                    </label>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <div class="row g-4" id="default-products">


                                @foreach ($products as $product)
                                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                        <div class="product-collection-item">
                                            <div class="product-image">
                                                <img src="{{ $product->featured_image ? asset($product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                                                    alt="{{ $product->name }}">
                                                {{-- <div class="badge">35%</div> --}}
                                            </div>
                                            <div class="product-content text-center">
                                                <h4>
                                                    <a
                                                        href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                </h4>
                                                <p class="product-reviews"><span class="product-stars">★★★★★</span> 0
                                                    Reivews
                                                </p>
                                                <span class="product-price">{{ product_price_range($product) }}</span>
                                                {{-- <span
                                                    class="product-cross-price">$19.00</span> --}}
                                            </div>
                                            {{-- <div class="product-btn">
                                                <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To
                                                    Cart</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="filtered-products" class="row g-4">
                            </div>
                        </div>
                        @if ($products->lastPage() > 1)
                            <div class="page-nav-wrap">
                                <ul>
                                    @if ($products->onFirstPage())
                                        <li><span class="page-numbers disabled"><i
                                                    class="fa-solid fa-arrow-left-long"></i></span></li>
                                    @else
                                        <li><a class="page-numbers" href="{{ $products->previousPageUrl() }}"><i
                                                    class="fa-solid fa-arrow-left-long"></i></a></li>
                                    @endif

                                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                                        <li class="{{ $i == $products->currentPage() ? 'active' : '' }}">
                                            <a class="page-numbers"
                                                href="{{ $products->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($products->hasMorePages())
                                        <li><a class="page-numbers" href="{{ $products->nextPageUrl() }}"><i
                                                    class="fa-solid fa-arrow-right-long"></i></a></li>
                                    @else
                                        <li><span class="page-numbers disabled"><i
                                                    class="fa-solid fa-arrow-right-long"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            function fetchFilteredProducts() {
                let min = $('.input-min').val();
                let max = $('.input-max').val();
                let search = $('input[name="search"]').val();

                $.ajax({
                    url: "{{ route('ajax.filter.products') }}",
                    method: "GET",
                    data: {
                        min_price: min,
                        max_price: max,
                        search: search,
                    },
                    beforeSend: function() {
                        $('#default-products').hide(); // hide default loop
                        $('#filtered-products').html('<p>Loading...</p>');
                    },
                    success: function(response) {
                        $('#filtered-products').html(response.html);
                    },
                    error: function() {
                        $('#filtered-products').html('<p>Error loading products.</p>');
                    }
                });
            }

            $('.input-min, .input-max, .range-min, .range-max').on('input change', function() {
                // sync range sliders with inputs if needed
                $('.input-min').val($('.range-min').val());
                $('.input-max').val($('.range-max').val());
                fetchFilteredProducts();
            });
        });
    </script>
@endsection
