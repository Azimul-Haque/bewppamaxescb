@extends('layouts.index')
@section('title') BCS Exam - বিসিএস পরীক্ষা | বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

@section('third_party_stylesheets')
<style type="text/css">
  .pricing-style-fourteen .currency {
      font-weight: 200;
      color: var(--dark-3);
      font-size: 22px;
      position: absolute;
      left: -40px;
      top: 6px; 
  }
  .pricing-style-fourteen .amount {
      font-size: 45px;
  }
  .pricing-style-fourteen .duration {
      font-size: 16px;
  }
</style>
@endsection

@section('content')
    <!-- Start header Area -->
    <section id="hero-area" class="header-area header-eight">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-12 col-12">
            <div class="header-content">
              <h1 style="padding-top: 7px;">বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম!</h1>
              <p>
                <b>BCS EXAM AID</b> is a dedicated online platform to take the best preparation for the Bangladesh Civil Service (BCS) Exam and Other Govt Job Exam.
              </p>
              <div class="button">
                {{-- <a href="javascript:void(0)" class="btn primary-btn">Get Started</a> --}}
                <a href='https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs' target="_blank"><img alt='Get it on Google Play' class="img-responsive" style="max-width: 250px; width: auto;" src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/></a>
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
              <img src="{{ asset('/') }}images/header/home.jpg" alt="#" />
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
              <img src="{{ asset('/') }}images/about/about-img2.jpg" alt="about" />
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="about-five-content">
              <h6 class="small-title text-lg">আমাদের সম্পর্কে</h6>
              <h2 class="main-title fw-bold">অভিজ্ঞতা ও প্রয়োজনীয়তা বিশ্লেষণ করে সমাধান প্রণয়নকারী</h2>
              <div class="about-five-tab">
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-who-tab" data-bs-toggle="tab" data-bs-target="#nav-who"
                      type="button" role="tab" aria-controls="nav-who" aria-selected="true">আমরা কারা?</button>
                    <button class="nav-link" id="nav-vision-tab" data-bs-toggle="tab" data-bs-target="#nav-vision"
                      type="button" role="tab" aria-controls="nav-vision" aria-selected="false">আমাদের লক্ষ্য</button>
                    {{-- <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history"
                      type="button" role="tab" aria-controls="nav-history" aria-selected="false">our History</button> --}}
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-who" role="tabpanel" aria-labelledby="nav-who-tab">
                    <p>আমরা কয়েকজন বাংলাদেশ সিভিল সার্ভিসের প্রশাসন, পুলিশসহ শীর্ষ ক্যাডারের সদস্য এবং বিসিএস ও অন্যান্য সরকারি চাকরির পরীক্ষার এক্সপার্টদের সমন্বয়ে গঠিত টিম। বিগত বছরগুলোর প্রশ্ন বিশ্লেষণ, প্রশ্নের প্যাটার্ন অনুসন্ধান  ও সর্বোচ্চ স্ট্র্যাটেজি অনুধাবন করে আমরা বিসিএস ও অন্যান্য সরকারি চাকরির পরীক্ষার্থীদের জন্য সর্বোত্তম সমাধানটি নিয়ে এসেছি।</p>
                    <p>আমাদের এন্ড্রয়েড অ্যাপটি ব্যবহার করে দেশের যেকোন প্রান্তে বসে প্রতিযোগিতামূলক বিসিএস-সহ যেকোন সরকারি চাকরির পরীক্ষার প্রস্তুতি নিতে পারবেন খুব সহজেই! </p>
                  </div>
                  <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                    <p>গতানুগতিক অন্যান্য চাকুরির (যেমন বিসিএস) প্রস্তুতির জন্য প্রচুর রিসোর্স অনলাইনেই পাওয়া যায়। কিন্তু সেগুলো থেকে চাকরির সর্বোচ্চ প্রস্তুতি কতটুকু হলো তা বোঝার জন্য হাজার হাজার টাকা খরচ করে কোচিং-এ যেতে হয়!</p>
                    <p>কর্মব্যস্ত চাকরিজীবী থেকে শুরু করে বিশ্ববিদ্যালয়ের হলে বসে প্রস্তুতি নিতে থাকা চাকরি প্রার্থী যেন সরকারি চাকরির পরীক্ষার প্রস্তুতি ঘরে বসেই নিতে পারেন, তাদের দোর গোড়ায় এ সেবাটি পৌঁছে দেওয়াই আমাদের লক্ষ্য।</p>
                  </div>
                  {{-- <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page
                      when
                      looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                      distribution of letters, look like readable English.</p>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have in some
                      form,
                      by injected humour.</p>
                  </div> --}}
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
                <h6>সেবাসমূহ</h6>
                <h2 class="fw-bold">আমাদের অ্যাপের সেবাসমূহ</h2>
                <p>
                  বিসিএস ও অন্যান্য সরকারি চাকরির পরীক্ষার প্রস্তুতি নিতে অ্যাপটির সর্বোচ্চ ব্যবহার নিশ্চিত করুন এবং নিয়োগ পরীক্ষায় আত্মবিশ্বাসী হয়ে যান!
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
                <h4>BCS MCQ Exam</h4>
                <p>
                  আপনার বিসিএস পরীক্ষার প্রস্তুতির জন্য সেরা MCQ পরীক্ষার ব্যবস্থা!
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
                <h4>Other Gobt Job Exam</h4>
                <p>
                  আপনার  অন্যান্য সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা MCQ পরীক্ষার ব্যবস্থা!
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
                  সুনির্দিষ্টভাবে প্রতি বিষয়ে ভালো করার জন্য বিষয়ভিত্তিক পরীক্ষা পদ্ধতি।
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
                <h4>Target Based Courses</h4>
                <p>
                  লক্ষ্য অর্জন করতে নির্দিষ্ট সময়ভিত্তিক কোর্সের মাধ্যমে পরীক্ষা পদ্ধতি।
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
                  অত্যাধুনিক প্রযুক্তি ব্যবহার নিশ্চিত করে সর্বোত্তম একটি পরীক্ষা ব্যবস্থা।
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
                  বিসিএস ও অন্যান্য সরকারি চাকরির পরীক্ষার সিলেবাস ও পাঠ্যক্রমের উপর ভিত্তি নিয়মিত আপডেট।
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
                  সব থেকে কম মূল্যে আমাদের প্যাকেজগুলো কিনে আপনি আপনার বিসিএস ও অন্যান্য সরকারি চাকরির পরীক্ষার প্রস্তুতিকে আরও শাণিত করুন।
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
          @foreach($packages as $package)
            <div class="col-lg-3 col-md-6 col-12">
              <div class="pricing-style-fourteen @if($package->suggested == 1) middle @endif">
                <div class="table-head">
                  <h6 class="title">{{ $package->name }}</h6>
                    <p>{{ $package->tagline }}</p>
                    <div class="price">
                      <h2 class="amount">
                        <span class="currency"><strike>৳ {{ bangla($package->strike_price) }}</strike></span> ৳ {{ bangla($package->price) }}<span class="duration">/{{ $package->duration }}</span>
                      </h2>
                    </div>
                </div>

                <div class="light-rounded-buttons">
                  <button type="button" data-bs-toggle="modal" data-bs-target="#packageModal{{ $package->id }}" class="btn @if($package->suggested == 1) primary-btn @else primary-btn-outline @endif">
                    শুরু করুন!
                  </button>
                </div>

                <div class="table-content">
                  <ul class="table-list">
                    <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                    <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিসিএস কোর্স এক্সেস</li>
                    <li> <i class="lni lni-checkmark-circle"></i> অন্যান্য চাকরির কোর্স এক্সেস</li>
                    <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                    {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
                  </ul>
                </div>
              </div>
            </div>
            <div class="modal fade" id="packageModal{{ $package->id }}" data-bs-backdrop="static">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">{{ $package->name }} প্ল্যান সাবস্ক্রাইব করুন</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <form method="post" action="{{ route('index.payment.proceed') }}">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                      <b>প্যাকেজঃ</b> {{ $package->name }} ({{ $package->tagline }})<br/>
                      <b>প্যাকেজের মেয়াদঃ</b> {{ $package->duration }}<br/><br/>
                      <big><b>প্যাকেজের মূল্যঃ</b> <small><strike>৳ {{ bangla($package->strike_price) }}</strike></small> ৳ {{ bangla($package->price) }}</big><br/><br/>
                      <b>ফিচারসমূহঃ</b>
                      <div class="table-content">
                        <ul class="table-list">
                          <li> <i class="lni lni-checkmark-circle"></i> অ্যাপের ফিচারসমূহের এক্সেস</li>
                          <li> <i class="lni lni-checkmark-circle"></i> সম্পূর্ণ বিসিএস কোর্স এক্সেস</li>
                          <li> <i class="lni lni-checkmark-circle"></i> অন্যান্য চাকরির কোর্স এক্সেস</li>
                          <li> <i class="lni lni-checkmark-circle"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li>
                          {{-- <li> <i class="lni lni-checkmark-circle deactive"></i> মডেল টেস্ট ও সাবজেক্টিভ প্রস্তুতি</li> --}}
                        </ul>
                      </div><br/>
                      <label>
                        অ্যাপে ব্যবহৃত ১১ ডিজিটের মোবাইল নম্বরটি লিখুন<br/>
                        @if(Auth::guest())
                          <span style="color: green; font-size: 10px;">রেজিস্ট্রেশন না করে থাকলে <a href="#!">ক্লিক করুন</a></span> 
                        @endif
                      </label>
                      <input type="number" name="user_number" onkeypress="if(this.value.length==11) return false;" class="form-control" placeholder="অ্যাপে ব্যবহৃত মোবাইল নাম্বারটি লিখুন" @if(!Auth::guest()) value="{{ Auth::user()->mobile }}" @endif required><br/>

                      <small>
                        <a href="{{ route('index.terms-and-conditions') }}" target="_blank">Terms & Conditions</a>, <a href="{{ route('index.privacy-policy') }}" target="_blank">Privacy Policy</a> & <a href="{{ route('index.refund-policy') }}" target="_blank">Refund Policy</a>
                      </small>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ফিরে যান</button> --}}
                        <input type="hidden" name="amount" value="{{ $package->price }}" required>
                        <input type="hidden" name="package_id" value="{{ $package->id }}" required>
                        <button type="submit" class="btn primary-btn-outline">৳ {{ bangla($package->price) }} পরিশোধ করুন</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
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
              <h2>বাংলাদেশ সিভিল সার্ভিস পরীক্ষা অথবা <br />অন্যান্য সরকারি চাকরির প্রস্তুতি নিয়ে চিন্তিত?</h2>
              <p>
                জ্যাম ঠেলে সময় খরচ করে কোচিং এ গিয়ে পরীক্ষার প্রস্তুতি নেওয়ার থেকে বাসায় বসে সে সময়টুকু কাজে লাগান, পাশাপাশি আমাদের অ্যাপের কোর্সগুলোতে অংশ নিয়ে পরীক্ষার প্রস্তুতিকে  শাণিত করুন! 
              </p>
              <div class="light-rounded-buttons">
                {{-- <a href="javascript:void(0)" class="btn primary-btn-outline">Get Started</a> --}}
                <a href='https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs' target="_blank"><img alt='Get it on Google Play' class="img-responsive" style="max-width: 300px; width: auto;" src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/></a>
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
                      <p>bcsexamaid@gmail.com</p>
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
@endsection

@section('third_party_scripts')

@endsection