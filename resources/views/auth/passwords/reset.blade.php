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
                            <h3>Create new password</h3>
                            <h6>Your new password must be different from previous used password.
                            </h6>
                            <div class="contact-form-item">
                                <form method="POST" action="{{ route('password.update') }}" id="contact-form2">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-clt">
                                                <input type="email" name="email"
                                                    class="@error('email') is-invalid @enderror" id="email20"
                                                    placeholder="Your Email" value="{{ $email ?? old('email') }}" required
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
                                                Reset Password
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
