<style>
    .header-1 .header-main .header-right .menu-cart.style-2 .cart-icon::before {
        content: "{{ getCartCount() }}" !important;
    }
</style>
<!-- Back To Top Start -->
<button id="back-top" class="back-to-top">
    <i class="fa-regular fa-arrow-up"></i>
</button>

<!--<< Mouse Cursor Start >>-->
<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>

<!-- fix-area Start -->
<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{ route('front.home') }}">
                            <img src="{{ URL('front/assets') }}/img/logo/logo.png" alt="logo-img">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <p class="text d-none d-xl-block">
                    Nullam dignissim, ante scelerisque the is euismod fermentum odio sem semper the is erat, a
                    feugiat leo urna eget eros. Duis Aenean a imperdiet risus.
                </p>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h4>Contact Info</h4>
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a target="_blank" href="#">Main Street, Melbourne, Australia</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="mailto:info@example.com"><span
                                        class="mailto:info@example.com">info@example.com</span></a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-clock"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a target="_blank" href="#">Mod-friday, 09am -05pm</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="far fa-phone"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="tel:+11002345909">+11002345909</a>
                            </div>
                        </li>
                    </ul>
                    <div class="header-button mt-4">

                    </div>
                    <a href="contact.html" class="theme-btn"><span>Let’s Talk <i
                                class="fa-solid fa-arrow-right"></i></span></a>
                    <div class="social-icon d-flex align-items-center">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div>

<!-- Sidebar Area Here -->
<div id="targetElement" class="side_bar slideInRight side_bar_hidden">
    <div class="side_bar_overlay"></div>
    <div class="cart-title mb-50">
        <h4>Log in</h4>
    </div>
    <div class="login-sidebar">
        <form action="#" id="contact-form" method="POST">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="form-clt">
                        <span>Username or email address *</span>
                        <input type="text" name="name15" id="name15" placeholder="">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-clt">
                        <span>Password *</span>
                        <input id="password" type="password" placeholder="">
                        <div class="icon"><i class="fa-regular fa-eye"></i></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button class="custom-rdxbtnr w-100" type="submit"><span>Log In</span></button>
                </div>
                <div class="col-lg-12">
                    <div class="from-cheak-items">
                        <div class="form-check d-flex gap-2 from-customradio">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Remember Me
                            </label>
                        </div>
                        <p>Forgot Password?</p>
                    </div>
                </div>
            </div>
        </form>
        <p class="text">Or login with</p>
        <div class="social-item">
            <a href="#" class="facebook-text custom-rdxbtnb"><img src="{{ URL('front/assets') }}/img/facebook.png"
                    alt="img">FACEBOOK</a>
            <a href="#" class="facebook-text google-text custom-rdxbtnb"><img
                    src="{{ URL('front/assets') }}/img/google.png" alt="img">Google</a>
        </div>
        <div class="user-icon-box">
            <img src="{{ URL('front/assets') }}/img/user.png" alt="img">
            <p>No account yet?</p>
            <a href="account.html">Create an Account</a>
        </div>
    </div>
    <button id="closeButton" class="x-mark-icon"><i class="fas fa-times"></i></button>
</div>

<!-- Header top Section Start -->
<div class="header-top-section style-2">
    <div class="container">
        <div class="header-top-wrapper style-2">
            <ul class="contact-list">
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:info@redxgame.com">info@redxgame.com</a>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:+40276328246">+402 763 282 46</a>
                </li>
            </ul>
            <div class="flag-wrapper">
                <div class="content">
                    <button id="openButton" class="account-text d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        Log in
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Header Section Start -->
<header id="header-sticky" class=" header-1 header-2">
    <div class="container">
        <div class="mega-menu-wrapper">
            <div class="header-main">
                <div class="header-left">
                    <div class="logo">
                        <a href="{{ route('front.home') }}" class="header-logo">
                            <img src="{{ URL('front/assets') }}/img/logo/logo.png" alt="logo-img">
                        </a>
                        <a href="{{ route('front.home') }}" class="header-logo-2 d-none">
                            <img src="{{ URL('front/assets') }}/img/logo/logo.png" alt="logo-img">
                        </a>
                    </div>
                </div>
                <div class="header-right d-flex justify-content-end align-items-center">

                    <div class="mean__menu-wrapper">
                        <div class="main-menu">
                            <nav id="mobile-menu" style="display: block;">
                                <ul>
                                    <li class="has-dropdown {{ request()->routeIs('front.home') ? 'active' : '' }}">
                                        <a href="{{ route('front.home') }}">
                                            Home
                                        </a>
                                    </li>
                                    <li class="has-dropdown {{ request()->routeIs('front.about') ? 'active' : '' }}">
                                        <a href="{{ route('front.about') }}">
                                            About Us
                                        </a>
                                    </li>
                                    <li class="has-dropdown  {{ request()->routeIs('front.shop') ? 'active' : '' }}">
                                        <a href="{{ route('front.shop') }}">
                                            Shop
                                        </a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="#">
                                            Services
                                        </a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="#">
                                            Our Games
                                        </a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="#">
                                            Blog
                                        </a>
                                    </li>
                                    <li
                                        class="has-dropdown {{ request()->routeIs('front.contact') ? 'active' : '' }}">
                                        <a href="{{ route('front.contact') }}">Contact Us</a>
                                    </li>
                                    <li
                                        class="has-dropdown {{ request()->routeIs('myaccount', 'user.order.details') ? 'active' : '' }}">
                                        @auth
                                            <a href="{{ route('myaccount') }}">My Account</a>
                                        @else
                                            <a href="{{ route('login') }}">Login</a>
                                        @endauth
                                    </li>


                                </ul>
                            </nav>
                        </div>
                    </div>
                    <a href="#0" class="search-trigger search-icon"><i
                            class="fa-regular fa-magnifying-glass"></i></a>
                    {{-- <ul class="header-icon">

                        <li>
                            <a href="#"><i class="fa-regular fa-heart"></i><span class="number">4</span></a>
                        </li>
                    </ul> --}}
                    <div class="menu-cart style-2">
                        <div class="cart-box">
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach (topBarCarts() as $topBarCart)
                                @php
                                    $subtotal = $topBarCart->price * $topBarCart->quantity;
                                    $totalPrice += $subtotal;
                                @endphp
                                <ul>
                                    <li>
                                        <img src="{{ $topBarCart->product->featured_image ? asset($topBarCart->product->featured_image) : URL('front/assets/img/cart/03.jpg') }}"
                                            alt="image">
                                        <div class="cart-product">
                                            <a href="{{ route('product.detail', $topBarCart->product->slug) }}">{{ $topBarCart->product->name }}
                                                -
                                                {{ $topBarCart->product_variant->name }}</a>
                                            <span>{{ config('app.currency') }}
                                                {{ calculatedPrice($topBarCart->price * $topBarCart->quantity) }}</span>
                                        </div>
                                    </li>
                                </ul>
                            @endforeach

                            @if (!empty(topBarCarts()) && count(topBarCarts()) > 0)
                                <div class="shopping-items">
                                    <span>Total :</span>
                                    <span>{{ config('app.currency') }} {{ calculatedPrice($totalPrice) }}</span>
                                </div>
                            @else
                                <div class="text-center mt-3">
                                    <h4>
                                        No Items in Cart
                                    </h4>
                                </div>
                            @endif
                            <div class="cart-button mb-4">
                                <a href="{{ route('front.cart') }}" class="custom-rdxbtnp">
                                    View Cart
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('front.cart') }}" class="cart-icon">
                            <i class="fa-sharp fa-regular fa-bag-shopping"></i>
                        </a>
                    </div>
                    <div class="header__hamburger d-xl-none my-auto">
                        <div class="sidebar__toggle">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- search-wrap Start -->
<div class="search-wrap">
    <div class="search-inner">
        <i class="fas fa-times search-close" id="search-close"></i>
        <div class="search-cell">
            <form method="get" action="{{ route('front.shop') }}">
                <div class="search-field-holder" style="position: relative;">
                    <input type="search" name="search" id="search-input" class="main-search-input"
                        placeholder="Search..." autocomplete="off" value="{{ request('search') }}">
                    <ul id="suggestion-box"
                        style="position:absolute; top:100%; left:0; right:0; background:#fff; z-index:999; list-style:none; padding:0; margin:0; display:none; border:1px solid #ddd;">
                    </ul>
                </div>
            </form>


        </div>
    </div>
</div>
