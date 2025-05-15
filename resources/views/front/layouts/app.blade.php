<!DOCTYPE html>
<html lang="en">
@include('front.layouts.partials.head')
@yield('style')

<body>

    @include('front.layouts.partials.topbar')

    @yield('content')

    @include('front.layouts.partials.footer')
    @include('front.layouts.partials.script')

</body>

</html>
