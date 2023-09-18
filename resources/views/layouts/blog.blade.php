@extends('layouts.index')
@section('title') @yield('title-secondary') @endsection

@section('third_party_stylesheets')
    @yield('third_party_stylesheets-s')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
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
            margin: 1% auto;
        }
        .blog-like, .blog-share, .comment {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-right: 25px;
        }
        .btn.btn-small {
            font-size: 11px;
            padding: 2px 14px;
            letter-spacing: 1px;
            border-radius: 0px;
        }
        .highlight-button {
            border: 2px solid #000;
            display: inline-block;
            padding: 8px 20px 9px;
            font-size: 12px;
            color: #000;
            background-color: transparent;
        }
        /*.widget-posts li {
            padding: 10px 0;
        }
        .widget-posts-details {
            position: relative;
            overflow: hidden;
            top: -4px;
            font-size: 12px;
            line-height: 14px;
        }*/
        .overflowellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <section style="padding-top: 150px; padding-bottom: 60px;background-color: #FFFFFF; height: 100px; border-bottom: 1px solid #F4F4F4;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>@yield('header-s')</h4>
                </div>
            </div>
        </div>
    </section>
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

@section('third_party_scripts')
    @yield('third_party_scripts-s')
@endsection