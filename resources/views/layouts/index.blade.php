<!DOCTYPE html>
<html lang="en">

<head>
  <!--====== Required meta tags ======-->
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="description" content="BCS Exam Aid বাংলাদেশ সিভিল সার্ভিস (BCS) পরীক্ষা এবং অন্যান্য সরকারি চাকরি (NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ) পরীক্ষার প্রস্তুতির জন্য সেরা ডেডিকেটেড অনলাইন প্ল্যাটফর্ম। Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="BCS, Bangladesh Civil Service, NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ, Primary Exam, Job Circular, Bank Job Circular, Bank Job Exam, BCS Circular, বিসিএস পরীক্ষা, বার কাউন্সিল পরীক্ষা, জুডিশিয়াল পরীক্ষা, Judicial Exam, bcs book list, bcs book suggestion, BCS Preparation Books, বিসিএস প্রিলিমিনারি বই তালিকা, বিসিএস বই তালিকা, বিসিএস লিখিত বই তালিকা, bcs preliminary book list, bcs written book list, বিসিএস প্রিলিমিনারি পরীক্ষার সিলেবাস, বিসিএস পরীক্ষার সিলেবাস">
  <meta name="author" content="A. H. M. Azimul Haque">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!--====== Title ======-->
  {{-- <title>BCS Exam Aid</title> --}}
  <title>@yield('title')</title>
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/svg" />

  <!--====== Bootstrap css ======-->
  <link rel="stylesheet" href="{{ asset('vendor/frontend/css/bootstrap.min.css') }}" />

  <!--====== Line Icons css ======-->
  <link rel="stylesheet" href="{{ asset('vendor/frontend/css/lineicons.css') }}" />

  <!--====== Tiny Slider css ======-->
  <link rel="stylesheet" href="{{ asset('vendor/frontend/css/tiny-slider.css') }}" />

  <!--====== gLightBox css ======-->
  <link rel="stylesheet" href="{{ asset('vendor/frontend/css/glightbox.min.css') }}" />

  <link rel="stylesheet" href="{{ asset('vendor/frontend/css/style.css') }}" />
  @yield('third_party_stylesheets')
</head>

<body>

  <!--====== NAVBAR NINE PART START ======-->

  <section class="navbar-area navbar-nine">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">
              <img src="{{ asset('/') }}images/white-logo.png" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNine"
              aria-controls="navbarNine" aria-expanded="false" aria-label="Toggle navigation">
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse sub-menu-bar" id="navbarNine">
              <ul class="navbar-nav me-auto">
                <li class="nav-item">
                  <a class=" active" href="{{ route('index.index')  }}/#hero-area">Home</a>
                </li>
                <li class="nav-item">
                  <a class="" href="{{ route('index.index')  }}/#services">Services</a>
                </li>
                <li class="nav-item">
                  <a class="" href="{{ route('blogs.index')  }}">Blogs</a>
                </li>

                <li class="nav-item">
                  <a class="" href="{{ route('index.index')  }}/#pricing">Pricing</a>
                </li>
                <li class="nav-item">
                  <a class="" href="{{ route('index.index')  }}/#contact">Contact</a>
                </li>
              </ul>
            </div>

            <div class="navbar-btn d-none d-lg-inline-block">
              <a class="menu-bar" href="#side-menu-left"><i class="lni lni-menu"></i></a>
            </div>
          </nav>
          <!-- navbar -->
        </div>
      </div>
      <!-- row -->
    </div>
    <!-- container -->
  </section>

  <!--====== NAVBAR NINE PART ENDS ======-->

  <!--====== SIDEBAR PART START ======-->

  <div class="sidebar-left">
    <div class="sidebar-close">
      <a class="close" href="#close"><i class="lni lni-close"></i></a>
    </div>
    <div class="sidebar-content">
      <div class="sidebar-logo">
        <a href="/"><img src="{{ asset('/') }}images/logo.png" alt="Logo" /></a>
      </div>
      <p class="text">BCS Exam Aid</p>
      <!-- logo -->
      <div class="sidebar-menu">
        <h5 class="menu-title">Quick Links</h5>
        <ul>
          <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
          <li><a href="{{ route('index.terms-and-conditions') }}">Terms & Conditions</a></li>
          <li><a href="{{ route('index.privacy-policy') }}">Privacy Policy</a></li>
          <li><a href="{{ route('index.refund-policy') }}">Refund Policy</a></li>
          <li><a href="{{ route('index.index')  }}/#contact">Contact Us</a></li>
        </ul>
      </div>
      <!-- menu -->
      <div class="sidebar-social align-items-center justify-content-center">
        <h5 class="social-title">Follow Us On</h5>
        <ul>
          <li>
            <a href="https://www.facebook.com/BJS-Bar-Council-Online-Exam-106986888695432/"><i class="lni lni-facebook-filled"></i></a>
          </li>
          <li>
            <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
          </li>
          <li>
            <a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a>
          </li>
          <li>
            <a href="javascript:void(0)"><i class="lni lni-youtube"></i></a>
          </li>
        </ul>
      </div>
      <!-- sidebar social -->
    </div>
    <!-- content -->
  </div>
  <div class="overlay-left"></div>

  <!--====== SIDEBAR PART ENDS ======-->


  @yield('content')


  <!-- Start Footer Area -->
  <footer class="footer-area footer-eleven">
    <!-- Start Footer Top -->
    <div class="footer-top">
      <div class="container">
        <div class="inner-content">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
              <!-- Single Widget -->
              <div class="footer-widget f-about">
                <div class="logo">
                  <a href="/">
                    <img src="{{ asset('/') }}images/logo.png" alt="#" class="img-fluid" />
                  </a>
                </div>
                <p>
                  BCS EXAM AID is a dedicated online platform to take the best preparation for the Bangladesh Civil Service (BCS) Exam and Other Govt Job Exam.
                </p>
                <p class="copyright-text">
                  <span>© {{ date('Y') }} App Lab IT.</span>Designed and Developed by
                  <a href="https://orbachinujbuk.com" rel="nofollow"> A. H. M. Azimul Haque</a>
                </p>
              </div>
              <!-- End Single Widget -->
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <!-- Single Widget -->
              <div class="footer-widget f-link">
                <h5>Links</h5>
                <ul>
                  <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                  <li><a href="{{ route('index.terms-and-conditions') }}">Terms & Conditions</a></li>
                  <li><a href="{{ route('index.privacy-policy') }}">Privacy Policy</a></li>
                  <li><a href="{{ route('index.refund-policy') }}">Refund Policy</a></li>
                </ul>
              </div>
              <!-- End Single Widget -->
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <!-- Single Widget -->
              <div class="footer-widget f-link">
                <h5>Support</h5>
                <ul>
                  <li><a href="#pricing">Pricing</a></li>
                  <li><a href="javascript:void(0)">Documentation</a></li>
                  <li><a href="javascript:void(0)">Guides</a></li>
                  <li><a href="javascript:void(0)">API Status</a></li>
                </ul>
              </div>
              <!-- End Single Widget -->
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <!-- Single Widget -->
              <div class="footer-widget newsletter">
                <h5>Subscribe</h5>
                <a href='https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs' target="_blank"><img alt='Get it on Google Play' class="img-responsive" style="max-width: 200px; width: auto;" src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/></a>
                <form action="#" method="get" target="_blank" class="newsletter-form">
                  <input name="EMAIL" placeholder="Email address" required="required" type="email" />
                  <div class="button">
                    <button class="sub-btn">
                      <i class="lni lni-envelope"></i>
                    </button>
                  </div>
                </form>
              </div>
              <!-- End Single Widget -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <img src="{{ asset('images/Footer-Logo.png') }}" onmousedown="return false;" onselectstart="return false;">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End Footer Top -->
  </footer>
  <!--/ End Footer Area -->

  {{-- <div class="made-in-ayroui mt-4">
    <a href="https://ayroui.com" target="_blank" rel="nofollow">
      <img style="width:220px" src="{{ asset('/') }}images/ayroui.svg">
    </a>
  </div> --}}

  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

  <!--====== js ======-->
  <script src="{{ asset('vendor/frontend/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/frontend/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/frontend/js/main.js') }}"></script>
  <script src="{{ asset('vendor/frontend/js/tiny-slider.js') }}"></script>

  <script>

    //===== close navbar-collapse when a  clicked
    let navbarTogglerNine = document.querySelector(
      ".navbar-nine .navbar-toggler"
    );
    navbarTogglerNine.addEventListener("click", function () {
      navbarTogglerNine.classList.toggle("active");
    });

    // ==== left sidebar toggle
    let sidebarLeft = document.querySelector(".sidebar-left");
    let overlayLeft = document.querySelector(".overlay-left");
    let sidebarClose = document.querySelector(".sidebar-close .close");

    overlayLeft.addEventListener("click", function () {
      sidebarLeft.classList.toggle("open");
      overlayLeft.classList.toggle("open");
    });
    sidebarClose.addEventListener("click", function () {
      sidebarLeft.classList.remove("open");
      overlayLeft.classList.remove("open");
    });

    // ===== navbar nine sideMenu
    let sideMenuLeftNine = document.querySelector(".navbar-nine .menu-bar");

    sideMenuLeftNine.addEventListener("click", function () {
      sidebarLeft.classList.add("open");
      overlayLeft.classList.add("open");
    });

    //========= glightbox
    GLightbox({
      'href': 'https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM',
      'type': 'video',
      'source': 'youtube', //vimeo, youtube or local
      'width': 900,
      'autoplayVideos': true,
    });

  </script>

  @yield('third_party_scripts')
  @include('partials._messages')
</body>

</html>