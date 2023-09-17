@extends('layouts.index')
@section('title') @yield('title-secondary') @endsection

@section('third_party_stylesheets')
    @yield('third_party_stylesheets-s')
@endsection

@section('content')
    <section style="background-color: #F4F4F4;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">@yield('content-s')</div>
                <div class="col-md-3 col-sm-4 col-md-offset-1 sidebar" style="padding-top: 150px; padding-bottom: 50px;">
                    @include('partials._blog_sidebar')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="background-color: #F4F4F4;">
                    Latest Blog
                </div>
            </div>
        </div>
    </section>
@endsection

@section('third_party_stylesheets')
    @yield('third_party_scripts-s')
@endsection