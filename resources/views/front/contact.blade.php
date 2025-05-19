@extends('front.layouts.app')
@section('title')
    Contact
@endsection
@section('content')
    <!-- Shop-left-sideber-Section Start -->
    <section class="pages-banner-section">
        <div class="hero-2">
            <div class="hero-bg" style="background-image: url({{ URL('front/assets') }}/img/banner-cbg.jpg);">
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
                        <div class="section-title-area pbanner-content">
                            <div class="">
                                <div class="section-title style-3">
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        Keep In Touch with Us
                                    </h2>
                                </div>
                                <ul class="list wow fadeInUp" data-wow-delay=".5s">
                                    <li>Home</li> -
                                    <li>Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section-2 pt-5">
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
                                            technologies. We are specialized in developing out-of-the-box solutions using
                                            emerging technologies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-right">
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fa-thin fa-comments"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    <a href="mailto:info@redxgame.com">
                                        info@redxgame.com
                                    </a>
                                </h6>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fa-thin fa-location-pin"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    84 sleepy hollow <br>
                                    johor, Malaysia 1432
                                </h6>
                            </div>
                        </div>
                        <div class="contact-item mb-0">
                            <div class="icon">
                                <i class="fa-thin fa-share-nodes"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    Find on social media
                                </h6>
                            </div>
                        </div>
                        <div class="social-icon d-flex align-items-center">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="bg-2"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-6">
                    <div class="contact-box-wrapper contact-chome">
                        <div class="comment-form-wrap">
                            <p class="pb-5 fs-5 text-center">We are ready to discuss the details of your project and answer
                                any of your questions.</p>
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


    <!-- map-Section Start -->
    <div class="map-section section-padding pt-0">
        <div class="container">
            <div class="map-items">
                <div class="googpemap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6678.7619084840835!2d144.9618311901502!3d-37.81450084255415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642b4758afc1d%3A0x3119cc820fdfc62e!2sEnvato!5e0!3m2!1sen!2sbd!4v1641984054261!5m2!1sen!2sbd"
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
