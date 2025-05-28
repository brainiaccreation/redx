@extends('front.layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <!-- Hero Section Start -->
    <section class="hero-section-2">
        <div class="arrow-button">
            <button class="array-prev">
                <i class="fa-light fa-chevron-left"></i>
            </button>
            <button class="array-next">
                <i class="fa-light fa-chevron-right"></i>
            </button>
        </div>
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                @foreach ($homeSliders as $homeSlider)
                    <div class="swiper-slide custom-hero-swiper">
                        <div class="hero-2">
                            <div class="hero-bg "
                                style="background-image: url({{ asset($homeSlider->background_image) }});">
                                <div class="hero-overlay"></div>
                                <div class="hitboox-border-shape bottom-right">
                                    <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                                        </path>
                                        <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                                    </svg>
                                </div>
                                <div class="hitboox-border-shape bottom-left">
                                    <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                                        </path>
                                        <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            <h1>
                                                {{ $homeSlider->heading }}
                                            </h1>
                                            <div class="hero-icon-item">
                                                <div class="herobtn">
                                                    <a href="javascript:void(0);" class="custom-rdxbtn">Our Games</a>
                                                </div>
                                                <div class="icon-item style-2">
                                                    <div class="content">
                                                        <p>{{ $homeSlider->content }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- 
                <div class="swiper-slide custom-hero-swiper">
                    <div class="hero-2">
                        <div class="hero-bg " style="background-image: url({{ asset('front/assets') }}/img/hero/bg-2.jpg);">
                            <div class="hero-overlay"></div>
                            <div class="hitboox-border-shape bottom-right">
                                <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                                    </path>
                                    <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                                </svg>
                            </div>
                            <div class="hitboox-border-shape bottom-left">
                                <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                                    </path>
                                    <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="hero-content">
                                        <h1>
                                            Bringing Virtual <br>Worlds to Life
                                        </h1>
                                        <div class="hero-icon-item">
                                            <div class="herobtn">
                                                <a href="javascript:void(0);" class="custom-rdxbtn">Our Games</a>
                                            </div>
                                            <div class="icon-item style-2">
                                                <div class="content">
                                                    <p>A game studio crafting exciting, high-quality video games,<br>
                                                        prioritizing immersive gameplay and mechanics.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Product-collection Section Start -->
    <section class="product-collection-section section-padding fix">
        <div class="container">
            <div class="section-title-area pb-4">
                <div class="">
                    <div class="section-title style-3 gap-4">
                        <h6 class="sub-title wow fadeInUp">Shop</h6>
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            our products
                        </h2>
                    </div>
                    <div class="hero-icon-item d-flex gap-4 ms-5">
                        <div class="herobtn">
                            <a href="{{ route('front.shop') }}" class="custom-rdxbtnb">View All Products</a>
                        </div>
                        <div class="icon-item style-2">
                            <div class="content">
                                <p>A game studio crafting exciting, high-quality video games,<br> prioritizing immersive
                                    gameplay and mechanics.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="row">
                    @foreach ($products as $product)
                        @include('front.products.list')
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Cosmetics Collection Section Start -->
    <section class="banner-section-2">
        <div class="hero-2">
            <div class="hero-bg" style="background-image: url({{ asset('front/assets') }}/img/banner-cbg.jpg);">
                <div class="left-cbanner-img">
                    <img src="{{ asset('front/assets') }}/img/h1_img-4.png">
                </div>
                <div class="left-cbanner-fire">
                    <img src="{{ asset('front/assets') }}/img/h1_img-3.png">
                </div>
                <div class="left-cbanner-spot animate">
                    <img src="{{ asset('front/assets') }}/img/fire-spot.png">
                </div>
                <div class="hitboox-border-shape top-right">
                    <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                        </path>
                        <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                    </svg>
                </div>
                <div class="hitboox-border-shape bottom-left">
                    <svg viewBox="0 0 160 60" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M147.269 54.72L117.876 25.28C114.502 21.9015 109.919 20 105.145 20H0V60H160C155.226 60 150.642 58.0985 147.269 54.72Z">
                        </path>
                        <path d="M0 0V20H20C8.95435 20 0 11.0457 0 0Z"></path>
                    </svg>
                </div>
            </div>
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="section-title-area cbanner-content">
                            <div class="">
                                <div class="section-title style-3 gap-4">
                                    <h6 class="sub-title wow fadeInUp">Our Features</h6>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        a good team delivers <br>a great work
                                    </h2>
                                </div>
                                <div class="hero-icon-item d-flex gap-4 ms-5">
                                    <div class="icon-item style-2">
                                        <div class="content">
                                            <p>We are specialized in developing out-of-the-box solutions using emerging
                                                technologies</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial-Section Start -->
    <section class="testimonial-section section-padding fix">
        <div class="container">
            <div class="row d-flex gap-5">
                <div class="section-title style-3 gap-4 col-lg-5">
                    <h6 class="sub-title wow fadeInUp">
                        Testimonials
                    </h6>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        trusted by top gaming publishers
                    </h2>
                </div>
                <div class="col-lg-3 review-htext wow fadeInUp ps-5" data-wow-delay=".3s">
                    <p class="fs-5">Trusted by <b class="highlight">1,800+</b> happy customers and player</p>
                </div>
                <div class="col-lg-3 review-htext d-flex gap-3 wow fadeInUp" data-wow-delay=".3s">
                    <div class="review-icon">
                        <img src="{{ asset('front/assets') }}/img/google-icon.png" width="100%" />
                    </div>
                    <div class="review-text">
                        <p class="fs-5"><b>4.9/5</b> <span class="review-hstar">★★★★★</span></p>
                        <p>Based on 1,847 reviews </p>
                    </div>
                </div>
            </div>
            <div class="swiper testimonial-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-box-item">
                            <div class="testimonial-content">
                                <div class="testimonial-quote-icon">
                                    <img src="{{ asset('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>They took our ideas and turned them into a stunning reality</h3>
                                <p>“We were definitely happy with the final result and the team has been very easy to
                                    work with which is always greatly appreciated.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ asset('front/assets') }}/img/testimonial/avatar-1.jpg"
                                                alt="img">
                                        </div>
                                        <div class="text">
                                            <h6>Jake Weary</h6>
                                            <p>Product Designer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-box-item">
                            <div class="testimonial-content">
                                <div class="testimonial-quote-icon">
                                    <img src="{{ asset('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>Very flexible way of working with high focus on quality.</h3>
                                <p>“I was very satisfied with the collaboration. The communication and pace of getting
                                    things done were really good and the artist was able to adopt the graphical style of
                                    the game almost instantly.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ asset('front/assets') }}/img/testimonial/avatar-1.jpg"
                                                alt="img">
                                        </div>
                                        <div class="text">
                                            <h6>Jake Weary</h6>
                                            <p>Product Designer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-box-item">
                            <div class="testimonial-content">
                                <div class="testimonial-quote-icon">
                                    <img src="{{ asset('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>Good quality of work, and always looking for ways to help.</h3>
                                <p>“Thanks to their connections, one of the games they worked on was featured in their
                                    media outlets. Their timeliness and ability to work on tricky platforms and succeed
                                    are outstanding.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ asset('front/assets') }}/img/testimonial/avatar-1.jpg"
                                                alt="img">
                                        </div>
                                        <div class="text">
                                            <h6>Jake Weary</h6>
                                            <p>Product Designer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-dot3 mt-5">
                <div class="dot"></div>
            </div>
        </div>
    </section>

    <section class="bottom-hero-section section-padding">
        <div class="th-slider hero-cta-slider1" id="heroSlider1" data-slider-options='{"effect":"fade"}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-cta-inner">
                        <div class="container-fluid th-container2">
                            <div class="hero-shape-area">
                                <div class="hero-bg-shape">
                                    <div class="hero-bg-border-anime"
                                        data-mask-src="{{ asset('front/assets') }}/img/hero/hero-bg-shape.png">
                                    </div>
                                    <svg viewBox="0 0 1600 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1599 30V490C1599 506.016 1586.02 519 1570 519H1062.43C1054.74 519 1047.36 515.945 1041.92 510.506L1009.49 478.08C1003.68 472.266 995.795 469 987.574 469H612.426C604.205 469 596.32 472.266 590.506 478.08L558.08 510.506C552.641 515.945 545.265 519 537.574 519H30C13.9837 519 1 506.016 1 490V30C1 13.9837 13.9837 1 30 1H400H537.574C545.265 1 552.641 4.05535 558.08 9.4939L590.506 41.9203C596.32 47.7339 604.205 51 612.426 51H987.574C995.795 51 1003.68 47.7339 1009.49 41.9203L1041.92 9.4939C1047.36 4.05535 1054.74 1 1062.43 1H1200H1570C1586.02 1 1599 13.9837 1599 30Z"
                                            fill="black" stroke="url(#paint0_linear1_47_22)" stroke-width="2" />
                                        <mask id="mask0_47_22" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0">
                                            <path
                                                d="M1600 490V30C1600 13.4315 1586.57 0 1570 0H1200H1062.43C1054.47 0 1046.84 3.1607 1041.21 8.7868L1008.79 41.2132C1003.16 46.8393 995.53 50 987.574 50H612.426C604.47 50 596.839 46.8393 591.213 41.2132L558.787 8.7868C553.161 3.16071 545.53 0 537.574 0H400H30C13.4315 0 0 13.4314 0 30V490C0 506.569 13.4315 520 30 520H537.574C545.53 520 553.161 516.839 558.787 511.213L591.213 478.787C596.839 473.161 604.47 470 612.426 470H987.574C995.53 470 1003.16 473.161 1008.79 478.787L1041.21 511.213C1046.84 516.839 1054.47 520 1062.43 520H1570C1586.57 520 1600 506.569 1600 490Z"
                                                fill="black" />
                                        </mask>
                                        <g mask="url(#mask0_47_22)">
                                            <g filter="url(#filter0_f_47_22)">
                                                <circle cx="1413" cy="314" r="287" fill="var(--theme)"
                                                    fill-opacity="0.2" />
                                            </g>
                                            <g filter="url(#filter01_f_47_22)">
                                                <circle cx="231" cy="172" r="229" fill="var(--theme)"
                                                    fill-opacity="0.5" />
                                            </g>
                                        </g>
                                        <defs>
                                            <filter id="filter0_f_47_22" x="566" y="-533" width="1694" height="1694"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <filter id="filter01_f_47_22" x="-558" y="-617" width="1578" height="1578"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <linearGradient id="paint0_linear1_47_22" x1="0" y1="0"
                                                x2="1600" y2="520" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="var(--theme)" />
                                                <stop offset="1" stop-color="var(--theme)" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="verses-thumb d-xl-none d-block">
                                        <img src="{{ asset('front/assets') }}/img/tournament/game-vs1.svg"
                                            alt="tournament image">
                                    </div>
                                    <div class="hero-img1 z-index-common" data-ani="slideinleft" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-1.png" alt="Image">
                                    </div>
                                    <div class="hero-img2 z-index-common" data-ani="slideinright" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-2.png" alt="Image">
                                    </div>
                                </div>
                                <div class="title-area mb-0">
                                    <h2 class="sec-title text-white custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.1s">Join The Big Tournaments</h2>
                                    <p class="mt-30 mb-30 custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">Beyond esports tournaments, include a broader calendar of
                                        gaming events, conferences, and conventions. and connect with each other.</p>
                                    <div class="btn-group custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">
                                        <a href="javascript:void(0);" class="custom-rdxbtn">Our Games</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-cta-inner">
                        <div class="container-fluid th-container2">
                            <div class="hero-shape-area">
                                <div class="hero-bg-shape">
                                    <div class="hero-bg-border-anime"
                                        data-mask-src="{{ asset('front/assets') }}/img/hero/hero-bg-shape.png">
                                    </div>
                                    <svg viewBox="0 0 1600 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1599 30V490C1599 506.016 1586.02 519 1570 519H1062.43C1054.74 519 1047.36 515.945 1041.92 510.506L1009.49 478.08C1003.68 472.266 995.795 469 987.574 469H612.426C604.205 469 596.32 472.266 590.506 478.08L558.08 510.506C552.641 515.945 545.265 519 537.574 519H30C13.9837 519 1 506.016 1 490V30C1 13.9837 13.9837 1 30 1H400H537.574C545.265 1 552.641 4.05535 558.08 9.4939L590.506 41.9203C596.32 47.7339 604.205 51 612.426 51H987.574C995.795 51 1003.68 47.7339 1009.49 41.9203L1041.92 9.4939C1047.36 4.05535 1054.74 1 1062.43 1H1200H1570C1586.02 1 1599 13.9837 1599 30Z"
                                            fill="black" stroke="url(#paint0_linear2_47_22)" stroke-width="2" />
                                        <mask id="mask1_47_22" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0">
                                            <path
                                                d="M1600 490V30C1600 13.4315 1586.57 0 1570 0H1200H1062.43C1054.47 0 1046.84 3.1607 1041.21 8.7868L1008.79 41.2132C1003.16 46.8393 995.53 50 987.574 50H612.426C604.47 50 596.839 46.8393 591.213 41.2132L558.787 8.7868C553.161 3.16071 545.53 0 537.574 0H400H30C13.4315 0 0 13.4314 0 30V490C0 506.569 13.4315 520 30 520H537.574C545.53 520 553.161 516.839 558.787 511.213L591.213 478.787C596.839 473.161 604.47 470 612.426 470H987.574C995.53 470 1003.16 473.161 1008.79 478.787L1041.21 511.213C1046.84 516.839 1054.47 520 1062.43 520H1570C1586.57 520 1600 506.569 1600 490Z"
                                                fill="black" />
                                        </mask>
                                        <g mask="url(#mask1_47_22)">
                                            <g filter="url(#filter1_f_47_22)">
                                                <circle cx="1413" cy="314" r="287" fill="var(--theme)"
                                                    fill-opacity="0.2" />
                                            </g>
                                            <g filter="url(#filter02_f_47_22)">
                                                <circle cx="231" cy="172" r="229" fill="var(--theme)"
                                                    fill-opacity="0.5" />
                                            </g>
                                        </g>
                                        <defs>
                                            <filter id="filter1_f_47_22" x="566" y="-533" width="1694" height="1694"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <filter id="filter02_f_47_22" x="-558" y="-617" width="1578" height="1578"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <linearGradient id="paint0_linear2_47_22" x1="0" y1="0"
                                                x2="1600" y2="520" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="var(--theme)" />
                                                <stop offset="1" stop-color="var(--theme)" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="verses-thumb d-xl-none d-block">
                                        <img src="{{ asset('front/assets') }}/img/tournament/game-vs1.svg"
                                            alt="tournament image">
                                    </div>
                                    <div class="hero-img1 z-index-common" data-ani="slideinleft" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-3.png" alt="Image">
                                    </div>
                                    <div class="hero-img2 z-index-common" data-ani="slideinright" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-4.png" alt="Image">
                                    </div>
                                </div>
                                <div class="title-area mb-0">
                                    <h2 class="sec-title text-white custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.1s">Join The Big Tournaments</h2>
                                    <p class="mt-30 mb-30 custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">Beyond esports tournaments, include a broader calendar of
                                        gaming events, conferences, and conventions. and connect with each other.</p>
                                    <div class="btn-group custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">
                                        <a href="javascript:void(0);" class="custom-rdxbtn">Our Games</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-cta-inner">
                        <div class="container-fluid th-container2">
                            <div class="hero-shape-area">
                                <div class="hero-bg-shape">
                                    <div class="hero-bg-border-anime"
                                        data-mask-src="{{ asset('front/assets') }}/img/hero/hero-bg-shape.png">
                                    </div>
                                    <svg viewBox="0 0 1600 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1599 30V490C1599 506.016 1586.02 519 1570 519H1062.43C1054.74 519 1047.36 515.945 1041.92 510.506L1009.49 478.08C1003.68 472.266 995.795 469 987.574 469H612.426C604.205 469 596.32 472.266 590.506 478.08L558.08 510.506C552.641 515.945 545.265 519 537.574 519H30C13.9837 519 1 506.016 1 490V30C1 13.9837 13.9837 1 30 1H400H537.574C545.265 1 552.641 4.05535 558.08 9.4939L590.506 41.9203C596.32 47.7339 604.205 51 612.426 51H987.574C995.795 51 1003.68 47.7339 1009.49 41.9203L1041.92 9.4939C1047.36 4.05535 1054.74 1 1062.43 1H1200H1570C1586.02 1 1599 13.9837 1599 30Z"
                                            fill="black" stroke="url(#paint0_linear3_47_22)" stroke-width="2" />
                                        <mask id="mask2_47_22" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0">
                                            <path
                                                d="M1600 490V30C1600 13.4315 1586.57 0 1570 0H1200H1062.43C1054.47 0 1046.84 3.1607 1041.21 8.7868L1008.79 41.2132C1003.16 46.8393 995.53 50 987.574 50H612.426C604.47 50 596.839 46.8393 591.213 41.2132L558.787 8.7868C553.161 3.16071 545.53 0 537.574 0H400H30C13.4315 0 0 13.4314 0 30V490C0 506.569 13.4315 520 30 520H537.574C545.53 520 553.161 516.839 558.787 511.213L591.213 478.787C596.839 473.161 604.47 470 612.426 470H987.574C995.53 470 1003.16 473.161 1008.79 478.787L1041.21 511.213C1046.84 516.839 1054.47 520 1062.43 520H1570C1586.57 520 1600 506.569 1600 490Z"
                                                fill="black" />
                                        </mask>
                                        <g mask="url(#mask2_47_22)">
                                            <g filter="url(#filter3_f_47_22)">
                                                <circle cx="1413" cy="314" r="287" fill="var(--theme)"
                                                    fill-opacity="0.2" />
                                            </g>
                                            <g filter="url(#filter03_f_47_22)">
                                                <circle cx="231" cy="172" r="229" fill="var(--theme)"
                                                    fill-opacity="0.5" />
                                            </g>
                                        </g>
                                        <defs>
                                            <filter id="filter3_f_47_22" x="566" y="-533" width="1694" height="1694"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <filter id="filter03_f_47_22" x="-558" y="-617" width="1578" height="1578"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                    result="shape" />
                                                <feGaussianBlur stdDeviation="280"
                                                    result="effect1_foregroundBlur_47_22" />
                                            </filter>
                                            <linearGradient id="paint0_linear3_47_22" x1="0" y1="0"
                                                x2="1600" y2="520" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="var(--theme)" />
                                                <stop offset="1" stop-color="var(--theme)" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="verses-thumb d-xl-none d-block">
                                        <img src="{{ asset('front/assets') }}/img/tournament/game-vs1.svg"
                                            alt="tournament image">
                                    </div>
                                    <div class="hero-img1 z-index-common" data-ani="slideinleft" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-5.png" alt="Image">
                                    </div>
                                    <div class="hero-img2 z-index-common" data-ani="slideinright" data-ani-delay="0.4s">
                                        <img src="{{ asset('front/assets') }}/img/hero/hero-1-6.png" alt="Image">
                                    </div>
                                </div>
                                <div class="title-area mb-0">
                                    <h2 class="sec-title text-white custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.1s">Join The Big Tournaments</h2>
                                    <p class="mt-30 mb-30 custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">Beyond esports tournaments, include a broader calendar of
                                        gaming events, conferences, and conventions. and connect with each other.</p>
                                    <div class="btn-group custom-anim-top wow animated" data-wow-duration="1.3s"
                                        data-wow-delay="0.2s">
                                        <a href="javascript:void(0);" class="custom-rdxbtn">Our Games</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="slider-pagination"></div>
        </div>
    </section>

    <!-- Product-collection Section Start -->
    <section class="hero-section-2 product-collection-section-2 section-padding fix">
        <div class="container">
            <div class="section-title text-center">
                <h6 class="sub-title wow fadeInUp">
                    Shop Now
                </h6>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    Featured Products
                </h2>
            </div>
        </div>
        <div class="container th-container2">
            <div class="tab-content">
                <div class="swiper discover-slider">
                    <div class="swiper-wrapper">
                        @foreach ($featured_products as $featured_product)
                            @include('front.products.slider')
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="arrow-button">
                <button class="array-prev">
                    <i class="fa-light fa-chevron-left"></i>
                </button>
                <button class="array-next">
                    <i class="fa-light fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>


    <section class="contact-section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title-area contact-ctext-inner">
                        <div>
                            <div class="section-title style-3 gap-4">
                                <h6 class="sub-title wow fadeInUp">Leave a Request</h6>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    Make your game ideal real
                                </h2>
                            </div>
                            <div class="hero-icon-item d-flex gap-4 ms-5">
                                <div class="icon-item style-2">
                                    <div class="content">
                                        <p>We are specialized in developing out-of-the-box solutions using emerging
                                            technologies. We are specialized in developing out-of-the-box solutions
                                            using emerging technologies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-6">
                    <div class="contact-box-wrapper contact-chome">
                        <div class="comment-form-wrap">
                            <p class="pb-5 fs-5 text-center">We are ready to discuss the details of your project and
                                answer any of your questions.</p>
                            <form action="contact.php" id="contact-form2" method="POST">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="text" name="name" id="name" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="text" name="email" id="email20" placeholder="E-mail">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="text" name="company" id="company" placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="message" id="message" placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="custom-rdxbtnr">
                                            Submit Request
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
