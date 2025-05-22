@extends('front.layouts.app')
@section('title')
    Reset Password
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
                                    Reset Password
                                </li>
                            </ul>
                        </div>
                        <div class="account-box">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h3>Forgot Password?</h3>
                            <h6>Wait, I remember my password... <a href="{{ route('login') }}"><span>Click here</span></a>
                            </h6>
                            <div class="contact-form-item">
                                <form method="POST" action="{{ route('password.email') }}" id="contact-form2">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-clt">
                                                <input type="email" name="email"
                                                    class="@error('email') is-invalid @enderror" id="email20"
                                                    placeholder="Your Email" value="{{ old('email') }}" required
                                                    autocomplete="email" autofocus>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12">
                                            <button type="submit" class="theme-btn header-btn w-100">
                                                Send Password Reset Link
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
