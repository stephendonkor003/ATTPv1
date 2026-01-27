<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourin - Travel Agency HTML Template</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- CSS Files -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Covered+By+Your+Grace&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel='stylesheet' href='assets/css/bootstrap-datepicker.css'>
    <link rel='stylesheet' href='assets/css/jquery-ui.css'>
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/icons/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/niceselect.css">
    <link rel="stylesheet" href="assets/css/YouTubePopUp.css">
    <link rel="stylesheet" href="assets/css/scroll-up.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>
    <div class="container">
        <!-- Start Preloader -->
        <div class="preloader_wrap" onload="preloader()">
            <div class="preloaderstyle_wrap"><span class="preloaderStyle"></span></div>
            <div class="preloader_logo"><img src="assets/img/preloader.svg" alt=""></div>
        </div>
        <!-- End Preloader -->

        <!-- Offcanvas Area Start -->
        <div class="fix-area">
            <div class="offcanvas__info">
                <div class="offcanvas__wrapper">
                    <div class="offcanvas__content">
                        <div class="offcanvas__top d-flex justify-content-between align-items-center">
                            <div class="offcanvas__logo">
                                <a href="index.html">
                                    <img src="assets/img/logo.svg" alt="edutec">
                                </a>
                            </div>
                            <div class="offcanvas__close">
                                <button>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mobile-menu fix mb-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="offcanvas__overlay"></div>
        <!-- Start Header -->

        <!-- Start Header Top -->
        <header class="header_top">
            <div class="container-xxl container-fluid">
                <div class="row">
                    <div class="col-md-6 col-12 mb-md-0 mb-sm-2 text-center text-md-start">
                        <span class="align-self-center"><i class="ph ph-map-pin"></i> 68 Road Taxax, USA</span>
                        <div class="hline align-self-center"></div>
                        <span class="align-self-center tnumber"><a href="tel:+85654987"><i class="ph ph-phone"></i>
                                (+85) - 654 987</a></span>
                    </div>

                    <div class="col-md-6 col-12 text-center text-md-end">
                        <span class="align-self-center"><a href="#"><i class="ph ph-user-circle"></i> Sign in or
                                Register</a></span>
                        <div class="hline align-self-center"></div>
                        <ul class="align-self-center">
                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- End Header Top -->

        <!-- Start Header -->
        <header id="tr_header">
            <div class="container-xxl container-fluid">
                <div class="row">
                    <div
                        class="col-xl-7 col-md-3 col-12 gap-3 d-lg-flex d-block text-md-start text-center align-self-center">
                        <div class="site_logo d-inline-block">
                            <a href="index.html"><img src="assets/img/logo.svg" alt="Tourin"></a>
                        </div>

                        <nav class="main-menu align-self-center">
                            <ul>
                                <li><a href="index.html">Home <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="index.html">Home 1</a></li>
                                        <li><a href="index2.html">Home 2</a></li>
                                    </ul>
                                </li>
                                <li><a href="destination.html">Destination</a></li>
                                <li><a href="tour.html">Tour <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="tour-list.html">Tour with Sidebar</a></li>
                                        <li><a href="tour-grid.html">Tour Grids</a></li>
                                        <li><a href="tour-details.html">Tour Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Blog <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="blog-grids.html">Blog Grids</a></li>
                                        <li><a href="blog.html">Blog Standard</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>

                                <li><a href="#">Pages <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="blog.html">Blog List</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="tour.html">Tour</a></li>
                                        <li><a href="tour-details.html">Tour Details</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div><!-- End Col -->

                    <div class="col-xl-5 col-md-9 col-12">
                        <div class="header_right d-flex justify-content-lg-end justify-content-center">
                            <div class="call_us d-flex gap-3 align-self-center">
                                <i class="ph ph-headset align-self-center"></i>
                                <div class="call_content align-self-center">
                                    <span>Call Anytime</span>
                                    <a href="tel:+8801546857487">(86) - 1546 857</a>
                                </div>
                            </div>

                            <div class="cart_search d-flex align-self-center">
                                <span class="hcart"><a href="cart.html"><i
                                            class="ph ph-shopping-cart-simple"></i></a><span>3</span></span>
                                <span class="hsearch"><a href="#"><i
                                            class="ph ph-magnifying-glass"></i></a></span>
                            </div>

                            <a href="#" class="yellow_btn d-none d-md-block align-self-center"><span>Booking
                                    Now</span></a>

                            <div class="header__hamburger d-xl-none my-auto">
                                <div class="sidebar__toggle">
                                    <i class="ph ph-list"></i>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Col -->
                </div>
            </div>
        </header>
        <!-- End Header -->

        @yield('content')

        @include('partials.footer')
    </div>

    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/67e250e47dde98190e0727b4/1in60nvkh';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

    <script>
        function toggleBreadcrumbMenu() {
            const menu = document.getElementById('breadcrumbMenu');
            menu.classList.toggle('show');
        }
    </script>

</body>

</html>
