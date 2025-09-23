@extends('layouts.blog')
@section('title-secondary') ব্লগ-Blog | BCS Exam - বিসিএস পরীক্ষা | বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

@section('meta-data')
    <meta name="description" content="BCS Exam Aid বাংলাদেশ সিভিল সার্ভিস (BCS) পরীক্ষা এবং অন্যান্য সরকারি চাকরি (NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ) পরীক্ষার প্রস্তুতির জন্য সেরা ডেডিকেটেড অনলাইন প্ল্যাটফর্ম। Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="BCS, Bangladesh Civil Service, NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ, Primary Exam, Job Circular, Bank Job Circular, Bank Job Exam, BCS Circular, বিসিএস পরীক্ষা, বার কাউন্সিল পরীক্ষা, জুডিশিয়াল পরীক্ষা, Judicial Exam, bcs book list, bcs book suggestion, BCS Preparation Books, বিসিএস প্রিলিমিনারি বই তালিকা, বিসিএস বই তালিকা, বিসিএস লিখিত বই তালিকা, bcs preliminary book list, bcs written book list, বিসিএস প্রিলিমিনারি পরীক্ষার সিলেবাস, বিসিএস পরীক্ষার সিলেবাস">
@endsection

@section('third_party_stylesheets-s')
    
@endsection

@section('header-s')
    ব্লগ সমূহ
@endsection

@section('content-s')
    <section style="padding-top: 50px; padding-bottom: 50px;">
        @foreach ($blogs as $blog)
        <div class="blog-listing blog-listing-classic no-margin-top wow fadeIn">
            <!-- post image -->
            @if($blog->featured_image != null)
                <div><a class="blog-image" href="{{ route('blog.single', $blog->slug) }}"><img class="img-responsive" src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="" style="width: 100%;" /></a></div><br/>
            @endif
            <!-- end post image -->
            <div class="blog-details">
                <div class="blog-date">Posted by <a href="{{ route('blogger.profile', $blog->user->id) }}"><b>{{ $blog->user->name }}</b></a> | {{ date('F d, Y', strtotime($blog->created_at)) }} | <a href="{{ route('blog.categorywise', str_replace(" ", "-", $blog->blogcategory->name)) }}">{{ $blog->blogcategory->name }}</a> </div>
                <div class="blog-title">
                    <a href="{{ route('blog.single', $blog->slug) }}">
                        {{ $blog->title }}
                    </a>
                </div>
                <div style="text-align: justify;">
                    @if(strlen(strip_tags($blog->body))>600)
                        {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+500))."... " }}
                    @else
                        {{ strip_tags($blog->body) }}
                    @endif
                </div>
                <div class="separator-line bg-black no-margin-lr margin-four"></div>
                <div style="margin-bottom: 10px;">
                    <a href="#!" class="blog-like"><i class="far fa-heart"></i> {{ $blog->likes }} Like(s)</a>
                    <a href="#!" class="comment"><i class="far fa-comment"></i>
                    <span id="comment_count{{ $blog->id }}"></span>
                     comment(s)</a>
                </div>
                <a class="highlight-button btn btn-small xs-no-margin-bottom" href="{{ route('blog.single', $blog->slug) }}">Read More »</a>
                </br>
                </br>
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