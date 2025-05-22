@extends('front.layouts.app')
@section('title')
    Verify Your Email Address
@endsection
@section('content')
    <!-- Shop-categories-Section Start -->
    <section class="my-account-section section-padding fix">
        <div class="container">
            <div class="account-wrapper">
                <div class="shape-1 float-bob-x">
                    <img src="{{ asset('front/assets') }}/img/shape-1.png" alt="img">
                </div>
                <div class="shape-2 float-bob-y">
                    <img src="{{ asset('front/assets') }}/img/shape-2.png" alt="img">
                </div>
                <div class="shape-3 float-bob-y">
                    <img src="{{ asset('front/assets') }}/img/dot.png" alt="img">
                </div>
                <div class="shape-4 float-bob-x">
                    <img src="{{ asset('front/assets') }}/img/shape-3.png" alt="img">
                </div>
                <div class="shape-5 float-bob-y">
                    <img src="{{ asset('front/assets') }}/img/man-shape.png" alt="img">
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="content">
                            <h2>My account</h2>
                            <ul class="list">
                                <li>
                                    <a href="{{ route('front.home') }}">Home</a>
                                </li>
                                <li>
                                    Verify Your Email Address
                                </li>
                            </ul>
                        </div>
                        <div class="account-box">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <h6> {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},<a href="{{ route('login') }}"></a>
                            </h6>
                            <div class="contact-form-item">
                                <form method="POST" action="{{ route('verification.resend') }}" id="contact-form2">
                                    @csrf
                                    <div class="row g-4">


                                        <div class="col-lg-12">
                                            <button type="submit" class="theme-btn header-btn w-100">
                                                {{ __('click here to request another') }}
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
@endsection
