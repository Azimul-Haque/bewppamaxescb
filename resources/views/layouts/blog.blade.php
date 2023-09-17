@extends('layouts.index')
@section('title') @yield('title-secondary') @endsection

@section('third_party_stylesheets')
    @yield('third_party_stylesheets-s')

    <style type="text/css">
        .blog-image {
            overflow: hidden;
            background: rgb(161, 161, 161);
        }
        .col-md-offset-1 {
            margin-left: 8.33333333%;
        }
        .blog-title, .blog-title a {
            font-size: 30px;
            font-weight: bold;
            color: #000000;
        }
        .separator-line {
            height: 2px;
            margin: 0 auto;
            width: 30px;
            margin: 7% auto;
        }
    </style>
@endsection

@section('content')
    <section style="background-color: #FAFAFA;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">@yield('content-s')</div>
                <div class="col-md-3 col-sm-4 col-md-offset-1 sidebar" style="padding-top: 150px; padding-bottom: 50px;">
                    @include('partials._blog_sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('third_party_stylesheets')
    @yield('third_party_scripts-s')
@endsection