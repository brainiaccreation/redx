 <!--<< Header Area >>-->

 <head>
     <!-- ========== Meta Tags ========== -->
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="author" content="Brainiac Creation">
     <!-- ======== Page title ============ -->
     <title>@yield('title') | RedX</title>
     <!--<< Favcion >>-->
     <link rel="shortcut icon" href="{{ URL('front/assets') }}/img/logo-favicon.jpg">
     <!--<< Bootstrap min.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/bootstrap.min.css">
     <!--<< All Min Css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/all.min.css">
     <!--<< Animate.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/animate.css">
     <!--<< Magnific Popup.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/magnific-popup.css">
     <!--<< MeanMenu.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/meanmenu.css">
     <!--<< Swiper Bundle.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/swiper-bundle.min.css">
     <!--<< Nice Select.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/nice-select.css">
     <!--<< Color.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/color.css">
     <!--<< Main.css >>-->
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/main.css">
     <link rel="stylesheet" href="{{ URL('front/assets') }}/css/custom.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
         integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
     @yield('head')
 </head>
