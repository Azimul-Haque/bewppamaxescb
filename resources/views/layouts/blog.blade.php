@extends('layouts.index')
@section('title') @yield('title-secondary') @endsection

@yield('third_party_stylesheets')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">@yield('content')</div>
            <div class="col-md-3 col-sm-4 col-md-offset-1 sidebar xs-margin-top-ten">
                @include('partials._blog_sidebar')
            </div>
        </div>
    </div>
@endsection

@yield('third_party_scripts')
@include('partials._messages')