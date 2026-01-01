@extends('layouts.blog')
@section('title-secondary') {{ $blog->title }} - BCS Exam Aid- বিসিএস পরীক্ষা @endsection

@section('third_party_stylesheets-s')
    @if($blog->featured_image != null)
        <meta property="og:image" content="{{ asset('images/blogs/'.$blog->featured_image) }}" />
    @else
        <meta property="og:image" content="{{ asset('images/bcs-exam-aid-banner.png') }}" />
    @endif
    
    <meta name="keywords" content="{{ $blog->keywords ? $blog->keywords : 'BCS, বিসিএস, bcs book list, bcs book suggestion, BCS Preparation Books, বিসিএস প্রিলিমিনারি বই তালিকা, বিসিএস বই তালিকা, বিসিএস লিখিত বই তালিকা, bcs preliminary book list, bcs written book list, বিসিএস প্রিলিমিনারি পরীক্ষার সিলেবাস, বিসিএস পরীক্ষার সিলেবাস' }}">
    <meta property="og:title" content="{{ $blog->title }}"/>
    <meta property="og:description" content="{{ $blog->description ? $blog->description : mb_substr(strip_tags($blog->body), 0, 200) }}" />
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="BCS Exam Aid">
    <meta property="og:locale" content="en_US">
    <meta property="fb:admins" content="100001596964477">
    <meta property="fb:app_id" content="1471913530260781">
    <meta property="og:image:alt" content="{{ $blog->title }}" />
    <meta property="og:image:width" content="1025" />
    <meta property="og:image:height" content="542" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta name="article:section" content="{{ $blog->blogcategory->name }}">
    <meta name="article:published_time" content="{{ $blog->created_at}}">
    <meta name="article:author" content="{{ Request::url('blogger/profile/'.$blog->user->unique_key) }}">
    <meta name="article:tag" content="{{ $blog->blogcategory->name }}">
    <meta name="article:modified_time" content="{{ $blog->updated_at }}">

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ $blog->title }}",
        "description": "{{ $blog->description ?? mb_substr(strip_tags($blog->body), 0, 200) }}",
        "image": "{{ asset('images/blogs/'.$blog->featured_image) ?? asset('images/bcs-exam-aid-banner.png') }}",
        "url": "{{ url()->current() }}",
        "author": {
          "@type": "Person",
          "name": "{{ $blog->user->name ?? 'এ. এইচ. এম. আজিমুল হক' }}"
        },
        "datePublished": "{{ $blog->created_at ?? now()->toIso8601String() }}",
        "dateModified": "{{ $blog->updated_at ?? now()->toIso8601String() }}"
        }
    </script>

    <style type="text/css">
        .blog-single-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .blog-single-content {
            font-size: 17px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }
        .blog-single-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }
        .youtibecontainer {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
            margin: 20px 0;
        }
        .youtubeiframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 8px;
        }
        .author-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .author-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        .social-share-links .btn {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #fff;
            transition: 0.3s;
        }
        .btn-facebook { background: #3b5998; }
        .btn-twitter { background: #1da1f2; }
        .btn-linkedin { background: #0077b5; }
        .social-share-links .btn:hover { opacity: 0.8; transform: scale(1.1); }
    </style>
@endsection

@section('header-s')
    {{ $blog->title }}
@endsection

@section('content-s')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/bn_IN/sdk.js#xfbml=1&version=v12.0&appId=163879201229487"></script>

    <div class="blog-single-card">
        <h1 class="mb-3 font-weight-bold" style="color: #222; font-size: 32px;">{{ $blog->title }}</h1>
        
        <div class="mb-4 text-muted" style="font-size: 14px;">
            <i class="far fa-user"></i> <a href="{{ route('blogger.profile', $blog->user->id) }}"><b>{{ $blog->user->name }}</b></a> 
            <span class="mx-2">|</span>
            <i class="far fa-calendar-alt"></i> {{ date('F d, Y', strtotime($blog->created_at)) }} 
            <span class="mx-2">|</span>
            <i class="far fa-folder"></i> <a href="{{ route('blog.categorywise', str_replace(' ', '-', $blog->blogcategory->name)) }}">{{ $blog->blogcategory->name }}</a>
        </div>

        @if($blog->featured_image != null)
            <img src="{{ asset('images/blogs/'.$blog->featured_image) }}" class="img-fluid rounded shadow-sm mb-4" alt="{{ $blog->title }}" style="width: 100%;">
        @endif

        <div class="blog-single-content">
            {!! $blog->body !!}
            
            {{-- Tag checking logic preserved --}}
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<strong>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</strong>"))
            @else </strong> @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<b>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</b>"))
            @else </b> @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<em>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</em>"))
            @else </em> @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<p>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</p>"))
            @else </p> @endif
        </div>

        <hr class="my-5">

        {{-- Action Bar: Likes, Views, Share --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <a href="javascript:void(0)" class="btn btn-light rounded-pill px-4 me-2" onclick="likeBlog({{ $blog->id }})" title="Click to Like/Unlike!">
                    <i class="far fa-heart" id="like_icon"></i> <span id="like_span">{{ $blog->likes }} Like(s)</span>
                </a>
                <span class="text-muted ms-3"><i class="fas fa-eye"></i> {{ $blog->views }} Views</span>
            </div>
            <div class="social-share-links mt-3 mt-md-0">
                <span class="me-3 font-weight-bold">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="btn btn-facebook" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" class="btn btn-twitter" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title=BCS%20Exam%20Aid&summary={{ $blog->title }}" class="btn btn-linkedin" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        {{-- Author Section --}}
        <div class="author-box shadow-sm">
            <img src="{{ $blog->user->image ? asset('images/users/'.$blog->user->image) : asset('images/user.png') }}" class="author-img" alt="Author">
            <div>
                <h5 class="mb-1 font-weight-bold">{{ $blog->user->name }}</h5>
                <p class="text-muted mb-0" style="font-size: 14px;">{{ $blog->user->designation ?? 'বিশেষজ্ঞ কন্টেন্ট নির্মাতা' }}</p>
                <a href="{{ route('blogger.profile', $blog->user->id) }}" class="small text-primary">প্রোফাইল দেখুন »</a>
            </div>
        </div>

        {{-- Facebook Comments --}}
        <div class="mt-5">
            <h4 class="font-weight-bold mb-4"><i class="far fa-comments"></i> আলোচনা ও মন্তব্য</h4>
            <div class="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="5"></div>
        </div>
    </div>
@endsection

@section('third_party_scripts-s')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.note-video-clip').each(function() {
                var tmp = $(this).parent().html();
                $(this).parent().html('<div class="youtibecontainer">'+tmp+'</div>');
            });
            $('.note-video-clip').addClass('youtubeiframe');
            $('.note-video-clip').removeAttr('width');
            $('.note-video-clip').removeAttr('height');
            
            checkLiked();
        });

        function likeBlog(blog_id) {
            $.get(window.location.protocol + "//" + window.location.host + "/like/" + blog_id, function(data, status){
                checkLiked();
            });
        }

        function checkLiked() {
            $.get(window.location.protocol + "//" + window.location.host + "/check/like/" + {{ $blog->id }}, function(data, status){
                if(data.status == 'liked') {
                    $('#like_span').text(data.likes +' Liked');
                    $('#like_icon').css('color', 'red').attr('class', 'fas fa-heart');
                } else {
                    $('#like_span').text(data.likes +' Like');
                    $('#like_icon').css('color', '').attr('class', 'far fa-heart');
                }
            });
        }
    </script>
@endsection