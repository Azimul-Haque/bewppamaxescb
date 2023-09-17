@extends('layouts.blog')
@section('title-secondary') {{ $blog->title }} - BCS Exam - বিসিএস পরীক্ষা @endsection

@section('third_party_stylesheets-s')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
    @if($blog->featured_image != null)
        <meta property="og:image" content="{{ asset('images/blogs/'.$blog->featured_image) }}" />
    @else
        <meta property="og:image" content="{{ asset('images/abc.png') }}" />
    @endif

    <meta property="og:title" content="{{ $blog->title }} | {{ $blog->user->name }}"/>
    <meta name="description" property="og:description" content="{{ substr(strip_tags($blog->body), 0, 200) }}" />
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="TenX">
    <meta property="og:locale" content="en_US">
    <meta property="fb:admins" content="100001596964477">
    <meta property="fb:app_id" content="163879201229487">
    <meta property="og:type" content="article">
    <!-- Open Graph - Article -->
    <meta name="article:section" content="{{ $blog->blogcategory->name }}">
    <meta name="article:published_time" content="{{ $blog->created_at}}">
    <meta name="article:author" content="{{ Request::url('blogger/profile/'.$blog->user->unique_key) }}">
    <meta name="article:tag" content="{{ $blog->blogcategory->name }}">
    <meta name="article:modified_time" content="{{ $blog->updated_at}}">

    <style type="text/css">
        .youtibecontainer {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
        }
        .youtubeiframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content-s')
    {{-- facebook comment plugin --}}
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2&appId=163879201229487&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    {{-- facebook comment plugin --}}
    <section style="padding-top: 150px; padding-bottom: 50px;">
        <h2 class="blog-details-headline text-black">{{ $blog->title }}</h2>
    </section>
@endsection

@section('third_party_scripts-s')

@endsection