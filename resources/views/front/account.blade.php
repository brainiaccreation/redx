@extends('front.layouts.app')
@section('title')
    My Account
@endsection
@section('content')
    <!-- My-account-Section Start -->
    <section class="my-account-section section-padding fix">
        <div class="container">
            <div class="my-account-wrapper">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="wrap-sidebar-account">
                            <div class="sidebar-account">
                                <div class="account-avatar">
                                    <div class="image">
                                        <img src="{{ auth()->user()->avatar ? URL(auth()->user()->avatar) : URL('front/assets//img/avater.jpg') }}"
                                            alt="{{ auth()->user()->name }} {{ auth()->user()->last_name }}">
                                    </div>
                                    <h6 class="mb_4">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h6>
                                    <div class="body-text-1">{{ auth()->user()->email }}</div>
                                </div>
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="#Course" data-bs-toggle="tab" class="nav-link active">
                                            <i class="fa-regular fa-user"></i>
                                            Account Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#Curriculum" data-bs-toggle="tab" class="nav-link">
                                            <i class="fa-sharp fa-regular fa-bag-shopping"></i>
                                            Your Orders
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#Instructors" data-bs-toggle="tab" class="nav-link">
                                            <i class="fa-regular fa-location-dot"></i>
                                            My Address
                                        </a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="javascript:void();" class="nav-link"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-regular fa-share-from-square"></i>
                                            Logout
                                        </a>



                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="tab-content">
                            <div id="Course" class="tab-pane fade show active">
                                <div class="account-details">
                                    {{-- <form action="#" id="contact-form2" method="POST"> --}}
                                    <div class="account-info">
                                        <h3>Information</h3>
                                        <form action="{{ route('user.updateProfile', auth()->user()->id) }}" method="POST">
                                            @csrf
                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="name" id="name"
                                                            placeholder="First Name"
                                                            value="{{ old('name', auth()->user()->name) }}"
                                                            class="@error('name') is-invalid @enderror">
                                                    </div>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="last_name" id="name2"
                                                            placeholder="Last Name"
                                                            value="{{ old('last_name', auth()->user()->last_name) }}"
                                                            class="@error('last_name') is-invalid @enderror">
                                                    </div>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="email" name="email" id="email"
                                                            placeholder="Email"value="{{ old('email', auth()->user()->email) }}"
                                                            class="@error('email') is-invalid @enderror">
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="phone" id="number"
                                                            placeholder="Phone No"
                                                            value="{{ old('phone', auth()->user()->phone) }}"
                                                            class="@error('phone') is-invalid @enderror">
                                                    </div>
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-clt">
                                                        <div class="form">
                                                            <input type="text" name="country" id="number"
                                                                placeholder="Country"
                                                                value="{{ old('country', auth()->user()->country) }}"
                                                                class="@error('country') is-invalid @enderror">
                                                        </div>
                                                    </div>
                                                    @error('country')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="custom-rdxbtnr">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="account-password">
                                        <div class="account-info">
                                            <h3>Change Password</h3>
                                            <form action="{{ route('change.password') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password2" type="password" name="old_password"
                                                                placeholder="Password"
                                                                class="@error('old_password') is-invalid @enderror"
                                                                required>
                                                            <div class="icon">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('old_password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password3" name="new_password" type="password"
                                                                placeholder="Create Password"
                                                                class="@error('new_password') is-invalid @enderror"
                                                                required>
                                                            <div class="icon">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('new_password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password4" type="password"
                                                                placeholder="Confirm Password"
                                                                name="new_password_confirmation"
                                                                class="@error('new_password_confirmation') is-invalid @enderror"
                                                                required>
                                                            <div class="icon">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('new_password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" class="custom-rdxbtnr">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div id="Curriculum" class="tab-pane fade">
                                <div class="cart-list-area">
                                    <div class="table-responsive">
                                        <table class="table common-table">
                                            <thead data-aos="fade-down">
                                                <tr>
                                                    <th class="text-center">Order ID</th>
                                                    <th class="text-center">Payment Method</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr class="align-items-center py-3">
                                                        <td>
                                                            <div class="cart-item-thumb d-flex align-items-center gap-4">
                                                                {{-- <i class="fas fa-times"></i> --}}
                                                                {{-- <img class="w-100"
                                                                    src="{{ URL('front/assets') }}/img/cart/03.jpg"
                                                                    alt="product"> --}}
                                                                <a href="{{ route('user.order.details', $order->unique_id) }}"
                                                                    style="color: #011e5e;"><span
                                                                        class="text-nowrap">#{{ $order->order_number }}</span></a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="price-usd">
                                                                {{ ucfirst($order->payment_method) }}
                                                            </span>
                                                        </td>

                                                        <td class="text-center">
                                                            <span class="price-usd">
                                                                {{ number_format($order->total_amount, 2) }}
                                                                {{ config('app.currency') }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="price-usd">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="Instructors" class="tab-pane fade">
                                <div class="axil-dashboard-address">
                                    <p class="notice-text">The following addresses will be used on the checkout page by
                                        default.</p>
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="address-info">
                                                <div
                                                    class="addrss-header d-flex align-items-center justify-content-between">
                                                    <h4 class="title">Shipping Address</h4>
                                                    <a href="#" class="address-edit"><i
                                                            class="far fa-edit"></i></a>
                                                </div>
                                                <ul class="address-details">
                                                    <li>Name: Annie Mario</li>
                                                    <li>
                                                        <span>Email:</span>
                                                        <a href="mailto:cartly@gmail.com">cartly@gmail.com</a>
                                                    </li>
                                                    <li>
                                                        <span>Phone:</span>
                                                        <a href="tel:+67041390762">+670 413 90 762</a>
                                                    </li>
                                                    <li class="style-2">7398 Smoke Ranch Road <br>
                                                        Las Vegas, Nevada 89128</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="address-info">
                                                <div
                                                    class="addrss-header d-flex align-items-center justify-content-between">
                                                    <h4 class="title">Shipping Address</h4>
                                                    <a href="#" class="address-edit"><i
                                                            class="far fa-edit"></i></a>
                                                </div>
                                                <ul class="address-details">
                                                    <li>Name: Annie Mario</li>
                                                    <li>
                                                        <span>Email:</span>
                                                        <a href="mailto:cartly@gmail.com">cartly@gmail.com</a>
                                                    </li>
                                                    <li>
                                                        <span>Phone:</span>
                                                        <a href="tel:+67041390762">+670 413 90 762</a>
                                                    </li>
                                                    <li class="style-2">7398 Smoke Ranch Road <br>
                                                        Las Vegas, Nevada 89128</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="Reviews" class="tab-pane fade">
                                <div class="account-wrapper">
                                    <div class="account-box">
                                        <h3 class="mb-3">Login to Sofia.</h3>
                                        <h6>Don’t have an account? <span>Create a free account</span></h6>
                                        <p class="mt-4">or Sign in with Email</p>
                                        <div class="contact-form-item">
                                            <form action="#" id="contact-form3" method="POST">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input type="text" name="email" id="email20"
                                                                placeholder="Your Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input type="text" name="subject" id="email21"
                                                                placeholder="Password">
                                                            <div class="icon">
                                                                <i class="fa-regular fa-eye"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="from-cheak-items">
                                                            <div class="form-check d-flex gap-2 from-customradio">
                                                                <input class="form-check-input" type="radio"
                                                                    name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Remember Me
                                                                </label>
                                                            </div>
                                                            <span>Forgot Password?</span>
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
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
