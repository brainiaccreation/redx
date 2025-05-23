@extends('front.layouts.app')
@section('title')
    Register
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
                            <h3>Create New Account</h3>
                            <h6>Already have an account ? <a href="{{ route('login') }}"><span>Login</span></a></h6>
                            <div class="account-item">
                                <div class="google-image">
                                    <img src="{{ URL('front/assets') }}/img/google.png" alt="img">
                                    {{-- <h6>Sign in with google</h6> --}}
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
                                                <input type="text" name="name"
                                                    class="@error('name') is-invalid @enderror" id="name20"
                                                    placeholder="Your Name" value="{{ old('name') }}" required
                                                    autocomplete="name" autofocus>
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
                                                <input type="password" name="password" id="password2" placeholder="Password"
                                                    class="@error('password') is-invalid @enderror" required
                                                    autocomplete="new-password">
                                                <div class="icon toggle-password" data-target="#password2">
                                                    <i class="far fa-eye-slash"></i>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-clt">
                                                <input type="password" name="password_confirmation" id="password3"
                                                    placeholder="Confirm Password"
                                                    class="@error('password') is-invalid @enderror" required
                                                    autocomplete="new-password">
                                                <div class="icon toggle-password" data-target="#password3">
                                                    <i class="far fa-eye-slash"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="theme-btn header-btn w-100">
                                                Register
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
