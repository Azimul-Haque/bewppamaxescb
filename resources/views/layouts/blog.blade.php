@extends('layouts.index')
@section('title') @yield('title-secondary') @endsection

@section('meta-data')
    @yield('meta-data')
@endsection

@section('third_party_stylesheets')
    @yield('third_party_stylesheets-s')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style type="text/css">
        /* Global Blog Styles */
        body {
            background-color: #f4f7f6;
        }
        .blog-header-section {
            padding-top: 130px; 
            padding-bottom: 30px;
            background-color: #ffffff; 
            border-bottom: 1px solid #eeeeee;
        }
        .blog-header-title {
            font-weight: 800;
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .main-content-area {
            padding-top: 50px;
            padding-bottom: 80px;
        }
        
        /* Sidebar Specific */
        .sidebar-wrapper {
            padding-top: 0; /* মোবাইল ফ্রেন্ডলি করার জন্য টপ প্যাডিং কমানো হয়েছে */
        }

        @media (min-width: 992px) {
            .sidebar-wrapper {
                padding-left: 30px; /* ডেস্কটপে কন্টেন্ট থেকে সাইডবারের দূরত্ব */
            }
        }

        @media (max-width: 768px) {
            .blog-header-section {
                padding-top: 100px;
            }
            .blog-header-title {
                font-size: 22px;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <section class="blog-header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="blog-header-title">
                        <i class="fas fa-feather-alt text-primary me-2"></i>@yield('header-s')
                    </h4>
                </div>
            </div>
        </div>
    </section>

    <section class="main-content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    @yield('content-s')
                </div>

                <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                    <div class="sidebar-wrapper">
                        @include('partials._blog_sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('third_party_scripts')
    @yield('third_party_scripts-s')
@endsection