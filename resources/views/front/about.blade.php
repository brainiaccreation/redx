@extends('front.layouts.app')
@section('title')
    About
@endsection
@section('content')
    <!-- About-Section Start -->
    <section class="about-section section-padding fix">
        <div class="container">
            <div class="about-wrapper-2">
                <div class="row g-4 align-items-center">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="about-left-content">
                            <h4>Our Journey</h4>
                            <h3>Your world at a glance</h3>
                            <p>
                                Founded in a quaint but vibrant corner of the city, Oliva Beauty began as a small dream with
                                a big vision. Our founder, a passionate advocate for natural, also to feel confident in
                                their skin.
                            </p>
                            <div class="content">
                                <h3>Our Mission</h3>
                                <p>
                                    Founded in a quaint but vibrant corner of the city, Oliva Beauty began as a small dream
                                    with a big vision. Our founder, to feel confident in their skin.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="about-image about-image-clip">
                            <img src="{{ URL('front/assets') }}/img/about-1.jpg" alt="img">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="about-right">
                            <h3>
                                About Company
                            </h3>
                            <p>
                                With a slim design, a vibrant entertainment system, and outstanding performance, the new
                                Galaxy Tab A7 is a stylish new companion for your life.Dive head-first into the things you
                                love, and easily share your favorite moments. Learn, explore, connect and be inspired.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- video-bg-Section Start -->
    <div class="video-bg-section video-about-section fix">
        <div class="container-fluid">
            <div class="video-wrapper bg-cover"
                style="background-image: url({{ URL('front/assets') }}/img/about-video.jpg);">
                <a href="https://www.youtube.com/watch?v=O3zmfntbSr8" class="video-btn video-popup">
                    <i class="fa-duotone fa-play"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- About-Section Start -->
    <section class="about-section section-padding fix">
        <div class="container">
            <div class="about-wrapper style-2">
                <div class="row g-4">
                    <div class="col-xl-6">
                        <div class="about-image">
                            <img src="{{ URL('front/assets') }}/img/about-2.jpg" alt="img" class="wow fadeInUp"
                                data-wow-delay=".3s">
                            <div class="about-image-2">
                                <img src="{{ URL('front/assets') }}/img/about-3.jpg" alt="img" class="wow fadeInUp"
                                    data-wow-delay=".5s">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-content">
                            <div class="section-title style-2">
                                <h6 class="sub-title wow fadeInUp">
                                    Unity Collection
                                </h6>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    Shop our limited
                                    Edition Collaborations
                                </h2>
                            </div>
                            <div class="text">
                                <p class="wow fadeInUp" data-wow-delay=".5s">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel mi quam. Fusce vehicula vitae mauris sit amet tempor. Donec consectetur lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna. dolore magna
                                </p>
                                <a href="about.html" class="theme-btn wow fadeInUp" data-wow-delay=".7s">More about us <i
                                        class="fa-regular fa-arrow-right"></i></a>
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
                        <img src="{{ URL('front/assets') }}/img/google-icon.png" width="100%" />
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
                                    <img src="{{ URL('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>They took our ideas and turned them into a stunning reality</h3>
                                <p>“We were definitely happy with the final result and the team has been very easy to work
                                    with which is always greatly appreciated.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ URL('front/assets') }}/img/testimonial/avatar-1.jpg"
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
                                    <img src="{{ URL('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>Very flexible way of working with high focus on quality.</h3>
                                <p>“I was very satisfied with the collaboration. The communication and pace of getting
                                    things done were really good and the artist was able to adopt the graphical style of the
                                    game almost instantly.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ URL('front/assets') }}/img/testimonial/avatar-1.jpg"
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
                                    <img src="{{ URL('front/assets') }}/img/reviews-quote.png">
                                </div>
                                <h3>Good quality of work, and always looking for ways to help.</h3>
                                <p>“Thanks to their connections, one of the games they worked on was featured in their media
                                    outlets. Their timeliness and ability to work on tricky platforms and succeed are
                                    outstanding.”</p>
                                <div class="client-info-item">
                                    <div class="client-info">
                                        <div class="client-image">
                                            <img src="{{ URL('front/assets') }}/img/testimonial/avatar-1.jpg"
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
@endsection
