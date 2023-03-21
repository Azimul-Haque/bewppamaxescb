<!DOCTYPE html>
<html lang="en">

<head>
  <!--====== Required meta tags ======-->
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="description" content="BJS & BAR EXAM is a dedicated online platform to take the best preparation for the Bangladesh Judicial Service (BJS) Exam and Bar Council Exam. Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="BJS, Bar Council, BJS Exam, Bar Council Exam, বিজেএস পরীক্ষা, বার কাউন্সিল পরীক্ষা, জুডিশিয়াল পরীক্ষা, Judicial Exam">
    <meta name="author" content="A. H. M. Azimul Haque">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!--====== Title ======-->
  <title>BJS & Bar Exam</title>

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
                  <a class="page-scroll active" href="#hero-area">Home</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#services">Services</a>
                </li>

                <li class="nav-item">
                  <a class="page-scroll" href="#pricing">Pricing</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#contact">Contact</a>
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
      <p class="text">BJS & Bar Council Exam</p>
      <!-- logo -->
      <div class="sidebar-menu">
        <h5 class="menu-title">Quick Links</h5>
        <ul>
          <li><a href="{{ route('index.terms-and-conditions') }}">Terms & Conditions</a></li>
          <li><a href="{{ route('index.privacy-policy') }}">Privacy Policy</a></li>
          <li><a href="{{ route('index.refund-policy') }}">Refund Policy</a></li>
          <li><a href="#contact">Contact Us</a></li>
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

  <!-- Start header Area -->
  <section id="hero-area" class="header-area header-eight">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 col-12">
          <div class="header-content">
            <h1>Best online platform to gear up your BJS & Bar Council Exam preparation!</h1>
            <p>
              BJS & BAR EXAM is a dedicated online platform to take the best preparation for the Bangladesh Judicial Service (BJS) Exam and Bar Council Exam.
            </p>
            <div class="button">
              <a href="javascript:void(0)" class="btn primary-btn">Get Started</a>
              <a href="https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM"
                class="glightbox video-button">
                <span class="btn icon-btn rounded-full">
                  <i class="lni lni-play"></i>
                </span>
                <span class="text">Watch Intro</span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12">
          <div class="header-image">
            <img src="{{ asset('/') }}images/header/home.png" alt="#" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End header Area -->

  <!--====== ABOUT FIVE PART START ======-->

  <section class="about-area about-five">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-12">
          <div class="about-image-five">
            <svg class="shape" width="106" height="134" viewBox="0 0 106 134" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <circle cx="1.66654" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="132" r="1.66667" fill="#DADADA" />
            </svg>
            <img src="{{ asset('/') }}images/about/about-img1.jpg" alt="about" />
          </div>
        </div>
        <div class="col-lg-6 col-12">
          <div class="about-five-content">
            <h6 class="small-title text-lg">OUR STORY</h6>
            <h2 class="main-title fw-bold">Our team comes with the experience and knowledge</h2>
            <div class="about-five-tab">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-who-tab" data-bs-toggle="tab" data-bs-target="#nav-who"
                    type="button" role="tab" aria-controls="nav-who" aria-selected="true">Who We Are</button>
                  <button class="nav-link" id="nav-vision-tab" data-bs-toggle="tab" data-bs-target="#nav-vision"
                    type="button" role="tab" aria-controls="nav-vision" aria-selected="false">our Vision</button>
                  <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history"
                    type="button" role="tab" aria-controls="nav-history" aria-selected="false">our History</button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-who" role="tabpanel" aria-labelledby="nav-who-tab">
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page
                    when
                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                    distribution of letters, look like readable English.</p>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have in some
                    form,
                    by injected humour.</p>
                </div>
                <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page
                    when
                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                    distribution of letters, look like readable English.</p>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have in some
                    form,
                    by injected humour.</p>
                </div>
                <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page
                    when
                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                    distribution of letters, look like readable English.</p>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have in some
                    form,
                    by injected humour.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- container -->
  </section>

  <!--====== ABOUT FIVE PART ENDS ======-->

  <!-- ===== service-area start ===== -->
  <section id="services" class="services-area services-eight">
    <!--======  Start Section Title Five ======-->
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Services</h6>
              <h2 class="fw-bold">Our Best Services</h2>
              <p>
                Get the full access from BJS & Bar Council Exam System and be confident before the recruitment exam.
              </p>
            </div>
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>
    <!--======  End Section Title Five ======-->
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-capsule"></i>
            </div>
            <div class="service-content">
              <h4>BJS MCQ Exam</h4>
              <p>
                Smooth BJS MCQ Exam System to gear up your BJS preparation.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-bootstrap"></i>
            </div>
            <div class="service-content">
              <h4>Bar Council Exam</h4>
              <p>
                Smooth Bar MCQ Exam System to gear up your Bar Council preparation.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-shortcode"></i>
            </div>
            <div class="service-content">
              <h4>Topic Based</h4>
              <p>
                Topic Based exam system to help you improve on specific topics.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-dashboard"></i>
            </div>
            <div class="service-content">
              <h4>Target Based</h4>
              <p>
                Target Based exam system to help you improve on specific target.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-layers"></i>
            </div>
            <div class="service-content">
              <h4>Fully Access</h4>
              <p>
                Get full access to our modern exam system built with passion.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-reload"></i>
            </div>
            <div class="service-content">
              <h4>Regular Updates</h4>
              <p>
                Based on syllabus and curriculum, updates will be available.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ===== service-area end ===== -->


  <!-- Start Pricing  Area -->
  <section id="pricing" class="pricing-area pricing-fourteen">
    <!--======  Start Section Title Five ======-->
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Pricing</h6>
              <h2 class="fw-bold">Pricing & Plans</h2>
              <p>
                সব থেকে কম মূল্যে আমাদের প্যাকেজগুলো কিনে আপনি আপনার বিজেএস ও বার পরীক্ষার প্রস্তুতিকে আরও শাণিত করুন।
              </p>
            </div>
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>
    <!--======  End Section Title Five ======-->
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">মাসিক</h6>
                <p>৩০ দিনের জন্য অ্যাপের সব ফিচার অ্যাভেইলেবল থাকবে</p>
                <div class="price">
                  <h2 class="amount">
                    <span class="currency">৳</span>২৯<span class="duration">/৩০ দিন </span>
                  </h2>
                </div>
            </div>

            <div class="light-rounded-buttons">
              <a href="javascript:void(0)" class="btn primary-btn-outline">
                শুরু করুন!
              </a>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিজেএস কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বার কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="pricing-style-fourteen middle">
            <div class="table-head">
              <h6 class="title">ত্রৈমাসিক</h6>
                <p>৯০ দিনের জন্য অ্যাপের সব ফিচার অ্যাভেইলেবল থাকবে</p>
                <div class="price">
                  <h2 class="amount">
                    <span class="currency">৳</span>৭৯<span class="duration">/৯০ দিন </span>
                  </h2>
                </div>
            </div>

            <div class="light-rounded-buttons">
              <a href="javascript:void(0)" class="btn primary-btn">
                শুরু করুন!
              </a>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিজেএস কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বার কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">অর্ধ-বার্ষিক</h6>
                <p>৬ মাসের জন্য অ্যাপের সব ফিচার অ্যাভেইলেবল থাকবে</p>
                <div class="price">
                  <h2 class="amount">
                    <span class="currency">৳</span>১৬৯<span class="duration">/৬ মাস </span>
                  </h2>
                </div>
            </div>

            <div class="light-rounded-buttons">
              <a href="javascript:void(0)" class="btn primary-btn-outline">
                শুরু করুন!
              </a>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিজেএস কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বার কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">বার্ষিক</h6>
                <p>১ বছরের জন্য অ্যাপের সব ফিচার অ্যাভেইলেবল থাকবে</p>
                <div class="price">
                  <h2 class="amount">
                    <span class="currency">৳</span>৩২৯<span class="duration">/১ বছর </span>
                  </h2>
                </div>
            </div>

            <div class="light-rounded-buttons">
              <a href="javascript:void(0)" class="btn primary-btn-outline">
                শুরু করুন!
              </a>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিজেএস কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বার কোর্স এক্সেস</li>
                <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ End Pricing  Area -->



  <!-- Start Cta Area -->
  <section id="call-action" class="call-action">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-9">
          <div class="inner-content">
            <h2>We love to make perfect <br />solutions for your BJS & Bar preparation</h2>
            <p>
              BJS & BAR EXAM is a dedicated online platform to take the best preparation for the Bangladesh Judicial Service (BJS) Exam and Bar Council Exam.
            </p>
            <div class="light-rounded-buttons">
              <a href="javascript:void(0)" class="btn primary-btn-outline">Get Started</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Cta Area -->

  <!-- ========================= contact-section start ========================= -->
  <section id="contact" class="contact-section">
    <div class="container">
      <div class="row">
        <div class="col-xl-4">
          <div class="contact-item-wrapper">
            <div class="row">
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-phone"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Contact</h4>
                    <p>+8801837409842</p>
                    <p>bjsexam@gmail.com</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-map-marker"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Address</h4>
                    <p>31/13, Block C, Tajmahal Road, Mohammadpur, Dhaka</p>
                    <p>Bangladesh</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-alarm-clock"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Schedule</h4>
                    <p>24 Hours / 7 Days Open</p>
                    <p>Office time: 10 AM - 5:30 PM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8">
          <div class="contact-form-wrapper">
            <div class="row">
              <div class="col-xl-10 col-lg-8 mx-auto">
                <div class="section-title text-center">
                  <span> Get in Touch </span>
                  <h2>
                    Ready to Get Started
                  </h2>
                  <p>
                    Send us messages.
                  </p>
                </div>
              </div>
            </div>
            <form action="#" class="contact-form">
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="name" id="name" placeholder="Name" required />
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" id="email" placeholder="Email" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="phone" id="phone" placeholder="Phone" required />
                </div>
                <div class="col-md-6">
                  <input type="text" name="subject" id="email" placeholder="Subject" required />
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <textarea name="message" id="message" placeholder="Type Message" rows="5"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="button text-center rounded-buttons">
                    <button type="submit" class="btn primary-btn rounded-full">
                      Send Message
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ========================= contact-section end ========================= -->

  <!-- ========================= map-section end ========================= -->
  <section class="map-section map-style-9">
    <div class="map-container">
      <object style="border:0; height: 500px; width: 100%;"
        data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14606.067929552457!2d90.35101528681905!3d23.76459799164188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c09f9ba3d447%3A0x1babce9f1c6c95a3!2sMohammadpur%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1655394465359!5m2!1sen!2sbd"></object>
    </div>
    </div>
  </section>
  <!-- ========================= map-section end ========================= -->

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
                  Making the world a better place through constructing elegant
                  hierarchies.
                </p>
                <p class="copyright-text">
                  <span>© 2022 App Lab IT.</span>Designed and Developed by
                  <a href="https://orbachinujbuk.com" rel="nofollow"> Azimul Haque</a>
                </p>
              </div>
              <!-- End Single Widget -->
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <!-- Single Widget -->
              <div class="footer-widget f-link">
                <h5>Links</h5>
                <ul>
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
                <p>Subscribe to our newsletter for the latest updates</p>
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
        </div>
      </div>
    </div>
    <!--/ End Footer Top -->
  </footer>
  <!--/ End Footer Area -->

  <div class="made-in-ayroui mt-4">
    <!-- <a href="https://ayroui.com" target="_blank" rel="nofollow">
      <img style="width:220px" src="{{ asset('/') }}images/ayroui.svg">
    </a> -->
  </div>

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
</body>

</html>