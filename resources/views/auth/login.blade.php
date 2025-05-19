@extends('front.layouts.app')
@section('title')
    Login
@endsection
@section('content')
    <!-- Shop-categories-Section Start -->
    <section class="my-account-section section-padding fix">
        <div class="container">
            <div class="account-wrapper">
                <div class="shape-1 float-bob-x">
                    <img src="{{ URL('front/assets') }}/img/shape-1.png" alt="img">
                </div>
                <div class="shape-2 float-bob-y">
                    <img src="{{ URL('front/assets') }}/img/shape-2.png" alt="img">
                </div>
                <div class="shape-3 float-bob-y">
                    <img src="{{ URL('front/assets') }}/img/dot.png" alt="img">
                </div>
                <div class="shape-4 float-bob-x">
                    <img src="{{ URL('front/assets') }}/img/shape-3.png" alt="img">
                </div>
                <div class="shape-5 float-bob-y">
                    <img src="{{ URL('front/assets') }}/img/man-shape.png" alt="img">
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
                                    My account
                                </li>
                            </ul>
                        </div>
                        <div class="account-box">
                            <h3>Login to Sofia.</h3>
                            <h6>Don’t have an account? <a href="{{ route('register') }}"><span>Create a free
                                        account</span></a></h6>
                            <div class="account-item">
                                <div class="google-image">
                                    <img src="{{ URL('front/assets') }}/img/google.png" alt="img">
                                    <h6>Sign in with google</h6>
                                </div>
                                <div class="facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                </div>
                                <div class="apple">
                                    <i class="fa-brands fa-apple"></i>
                                </div>
                            </div>
                            <p>or Sign in with Email</p>
                            <div class="contact-form-item">
                                <form method="POST" action="{{ route('login') }}" id="contact-form2">
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
                                            <div class="form-clt">
                                                <input type="password" name="password" id="email21" placeholder="Password"
                                                    class="@error('password') is-invalid @enderror" required
                                                    autocomplete="current-password">
                                                <div class="icon">
                                                    <i class="fa-regular fa-eye"></i>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="from-cheak-items">
                                                <div class="form-check d-flex gap-2 from-customradio">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                        id="flexRadioDefault2" name="remember"
                                                        {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Remember Me
                                                    </label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}"><span>Forgot
                                                            Password?</span></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="theme-btn header-btn w-100">
                                                Login
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
