@extends('front.layouts.app')
@section('title')
    {{ $current_category->name }} | Category
@endsection
@section('content')
    <section class="shop-left-sideber-section section-padding fix">
        <div class="container">
            <div class="product-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <form action="{{ route('filter.products') }}" method="GET">
                            <input type="hidden" name="category" value="{{ request('category', $current_category->slug) }}">
                            <div class="main-sideber">
                                <div class="single-sidebar-widget-2">
                                    <div class="wid-title">
                                        <h5>price filter</h5>
                                    </div>
                                    <div class="range__barcustom">
                                        @php
                                            $minPercent = (request('minPrice', $minPrice) / 10000) * 100;
                                            $maxPercent = 100 - (request('maxPrice', $maxPrice) / 10000) * 100;
                                        @endphp

                                        <div class="slider">
                                            <div class="progress"
                                                style="left: {{ $minPercent }}%; right: {{ $maxPercent }}%;"></div>
                                        </div>

                                        <div class="range-input">
                                            <input type="range" class="range-min"
                                                min="{{ request('minPrice', $minPrice) }}"
                                                max="{{ request('maxPrice', $maxPrice) }}"
                                                value="{{ request('minPrice', $minPrice) }}">
                                            <input type="range" class="range-max"
                                                min="{{ request('minPrice', $minPrice) }}"
                                                max="{{ request('maxPrice', $maxPrice) }}"
                                                value="{{ request('maxPrice', $maxPrice) }}">
                                        </div>
                                        <div class="range-items">
                                            <div class="price-input d-flex">
                                                <div class="field">
                                                    <span>{{ config('app.currency') }} </span>
                                                    <input type="number" class="input-min"
                                                        value="{{ request('minPrice', $minPrice) }}" step="0.1"
                                                        name="minPrice">
                                                </div>
                                                <div class="separators">-</div>
                                                <div class="field">
                                                    <span>{{ config('app.currency') }} </span>
                                                    <input type="number" class="input-max"
                                                        value="{{ request('maxPrice', $maxPrice) }}" step="0.1"
                                                        name="maxPrice">
                                                </div>
                                            </div>
                                        </div>
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
                                                <li
                                                    class="{{ $category->unique_id == $current_category->unique_id ? 'active' : '' }}">
                                                    <a href="javascript:void(0);"
                                                        class="{{ $category->unique_id == $current_category->unique_id ? 'active' : '' }}">{{ $category->name }}</a>
                                                    <span
                                                        class="{{ $category->unique_id == $current_category->unique_id ? 'active' : '' }}">
                                                        {{ $category->products_count }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="">
                                        <a href="{{ route('front.shop') }}" class="custom-filterbtnr" id="resetFilter">
                                            <span>Reset</span>
                                        </a>
                                    </div>
                                    <div class="px-2">
                                        <button type="submit" class="custom-resetbtnr" id="applyFilter">
                                            <span>Apply Filter</span>
                                        </button>
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
                        </form>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <div class="row g-4" id="default-products">
                                <h2>{{ $current_category->name }}</h2>

                                @foreach ($products as $product)
                                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                        <a href="{{ route('product.detail', $product->slug) }}">
                                            <div class="product-collection-item">
                                                <div class="product-image">
                                                    <img src="{{ $product->featured_image ? asset($product->featured_image) : URL('front/assets/img/product/01.jpg') }}"
                                                        alt="{{ $product->name }}">
                                                    @if (auth()->check() && auth()->user()->account_type === 'reseller')
                                                        <div class="badge">1%</div>
                                                    @endif
                                                </div>
                                                <div class="product-content text-center">
                                                    <h4>
                                                        {{ $product->name }}
                                                    </h4>
                                                    <p class="product-reviews"><span class="product-stars">★★★★★</span> 0
                                                        Reivews
                                                    </p>
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
                                                    {{-- <span
                                                    class="product-cross-price">$19.00</span> --}}
                                                </div>
                                                {{-- <div class="product-btn">
                                                <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">Add To
                                                    Cart</a>
                                            </div> --}}
                                            </div>
                                        </a>
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
        const inputMin = document.querySelector('.input-min');
        const inputMax = document.querySelector('.input-max');

        inputMin.addEventListener('input', () => {
            const minVal = parseFloat(inputMin.value);
            const maxVal = parseFloat(inputMax.value);

            if (minVal >= maxVal) {
                inputMin.value = (maxVal - 0.1).toFixed(1);
            }
        });

        inputMax.addEventListener('input', () => {
            const minVal = parseFloat(inputMin.value);
            const maxVal = parseFloat(inputMax.value);

            if (maxVal <= minVal) {
                inputMax.value = (minVal + 0.1).toFixed(1);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            function fetchFilteredProducts() {
                let min = $('.input-min').val();
                let max = $('.input-max').val();
                let search = $('input[name="search"]').val();

                // $.ajax({
                //     url: "{{ route('filter.products') }}",
                //     method: "GET",
                //     data: {
                //         min_price: min,
                //         max_price: max,
                //         search: search,
                //     },
                //     beforeSend: function() {
                //         $('#default-products').hide(); // hide default loop
                //         $('#filtered-products').html('<p>Loading...</p>');
                //     },
                //     success: function(response) {
                //         $('#filtered-products').html(response.html);
                //     },
                //     error: function() {
                //         $('#filtered-products').html('<p>Error loading products.</p>');
                //     }
                // });
            }

            $('.input-min, .input-max, .range-min, .range-max').on('input change', function() {
                // sync range sliders with inputs if needed
                var inputmin = $('.input-min').val();
                var inputmax = $('.input-max').val();
                // $('.input-min').val($('.range-min').val());
                // $('.input-max').val($('.range-max').val());


                $('.range-min').val(inputmin);
                $('.range-max').val(inputmax);
                fetchFilteredProducts();
            });
        });
    </script>
@endsection
