@extends('layouts.blog')
@section('title-secondary') ব্লগ-Blog | BCS Exam - বিসিএস পরীক্ষা | বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

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
    <meta name="article:section" content="{{ $blog->category->name }}">
    <meta name="article:published_time" content="{{ $blog->created_at}}">
    <meta name="article:author" content="{{ Request::url('blogger/profile/'.$blog->user->unique_key) }}">
    <meta name="article:tag" content="{{ $blog->category->name }}">
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
    <section style="padding-top: 150px; padding-bottom: 50px;">
        @foreach ($blogs as $blog)
        <div class="blog-listing blog-listing-classic no-margin-top wow fadeIn">
            <!-- post image -->
            @if($blog->featured_image != null)
                <div class="blog-image"><a href="{{ route('blog.single', $blog->slug) }}"><img src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="" style="width: 100%;" /></a></div>
            @endif
            <!-- end post image -->
            <div class="blog-details">
                <div class="blog-date">Posted by <a href="{{ route('blogger.profile', $blog->user->id) }}"><b>{{ $blog->user->name }}</b></a> | {{ date('F d, Y', strtotime($blog->created_at)) }} | <a href="{{ route('blog.categorywise', $blog->blogcategory->name) }}">{{ $blog->blogcategory->name }}</a> </div>
                <div class="blog-title"><a href="{{ route('blog.single', $blog->slug) }}">
                    {{ $blog->title }}
                </a></div>
                <div style="text-align: justify;">
                    @if(strlen(strip_tags($blog->body))>600)
                        {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+500))." [...] " }}

                    @else
                        {{ strip_tags($blog->body) }}
                    @endif
                </div>
                <div class="separator-line bg-black no-margin-lr margin-four"></div>
                <div>
                    <a href="#!" class="blog-like"><i class="fa fa-heart-o"></i>{{ $blog->likes }} Like(s)</a>
                    <a href="#!" class="comment"><i class="fa fa-comment-o"></i>
                    <span id="comment_count{{ $blog->id }}"></span>
                     comment(s)</a>
                </div>
                <a class="highlight-button btn btn-small xs-no-margin-bottom" href="{{ route('blog.single', $blog->slug) }}">Continue Reading</a>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
        <script type="text/javascript">
            // $.ajax({
            //     url: "https://graph.facebook.com/v2.2/?fields=share{comment_count}&id={{ url('/blog/'.$blog->slug) }}",
            //     dataType: "jsonp",
            //     success: function(data) {
            //         $('#comment_count{{ $blog->id }}').text(data.share.comment_count);
            //     }
            // });
        </script>
        @endforeach
        <!-- end post item -->
        {{-- paginating --}}
        {{ $blogs->links() }}
    </section>
@endsection

@section('third_party_scripts-s')

@endsection