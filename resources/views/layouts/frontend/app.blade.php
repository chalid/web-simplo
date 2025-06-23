<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Home') | PT. Arjaya Berkah Marine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frontend/assets/img/favicon.ico/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/assets/img/favicon.ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/assets/img/favicon.ico/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/frontend/assets/img/favicon.ico/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/frontend/assets/img/favicon.ico/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','G-NLLC7CFGQ1');
    </script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=G-NLLC7CFGQ1" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header class="header-fix {{ request()->is('/') ? 'full' : '' }}"> <!-- tambahin class 'full' di home -->
        <div class="container-fluid">
            <nav class="header-menu">
                <div class="header-logo">
                    <h1 class="brand-logo" data-aos="fade-right">
                        <a href="{{ route('web_index') }}">
                            <span class="logo"></span>
                            <strong>PT. Arjaya Berkah Marine</strong>
                        </a>
                    </h1>
                </div>
                <div class="toggle-down">
                    <div class="menu-toggle-btn" data-aos="fade-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="menu">
                    <ul class="flat" data-aos="fade-left">
                        <li>
                            <a href="{{ route('web_story') }}">About</a>
                        </li>
                        <li>
                            <a href="{{ route('web_partner') }}">Partner</a>
                        </li>
                        <li>
                            <a href="{{ route('web_client') }}">Client</a>
                        </li>
                        <li>
                            <a href="{{ route('web_facility') }}">Facility</a>
                        </li>
                        <li>
                            <a href="{{ route('web_project') }}">Projects</a>
                        </li>
                        <li>
                            <a href="{{ route('web_product') }}">Products</a>
                        </li>
                        <li>
                            <a href="{{ route('web_xvessel') }}">Second Products</a>
                        </li>
                        <li>
                            <a href="{{ route('web_article') }}">Article</a>
                        </li>
                        <li>
                            <a href="{{ route('web_contact') }}">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')
    <footer>
        <div class="nav-top">
            <div class="container">
                <div class="footer-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="footer-logo">
                                        <a href="{{ route('web_index') }}">
                                            <span class="logo"></span>
                                            <strong>PT. Arjaya Berkah Marine</strong>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="address text-center-mobile">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <address>
                                            Mangunreja <br>
                                            Puloampel, Serang, <br>
                                            Banten, 42455, Indonesia
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="phone text-center-mobile">
                                        <ul>
                                            <li>
                                                <a href="mailto:arjayamarine@gmail.com">
                                                    <i class="fas fa-envelope"></i>
                                                    <span>arjayamarine@gmail.com</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="tel:+6281932995665">
                                                    <i class="fas fa-phone-alt"></i>
                                                    <span>+62 819-3299-5665</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 phone-email">
                                    <div class="social-media text-center-mobile">
                                        <h6>Social Media</h6>
                                        <ul class="social flat">
                                            <li class="facebook">
                                                <a href="#" target="_blank">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li class="youtube">
                                                <a href="https://www.youtube.com/channel/UCcQuKf59WFDn2LvF28B6jkA" target="_blank">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
                                            <li class="instagram">
                                                <a href="https://www.instagram.com/arjayamarine/" target="_blank" title="@arjayamarine">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-bottom">
            <div class="container">
                <p class="copyright">Copyright © 2020 PT. Arjaya Berkah Marine. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    @yield('script')
    <script src="{{ asset('assets/frontend/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGFigOKuVyg2z0JAb0AGN-H5znZkV35fA"></script>
    <script src="{{ asset('assets/frontend/js/main.min.js') }}"></script>
</body>
</html>