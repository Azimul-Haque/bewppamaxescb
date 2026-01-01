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
    <!-- <meta name="og:description" content="{{ $blog->description ?? mb_substr(strip_tags($blog->body), 0, 200) }}" /> -->
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="BCS Exam Aid">
    <meta property="og:locale" content="en_US">
    <meta property="fb:admins" content="100001596964477">
    <meta property="fb:app_id" content="1471913530260781">
    <meta property="og:type" content="article">
    <meta property="og:image:alt" content="{{ $blog->title }}" />
    <meta property="og:image:width" content="1025" />
    <meta property="og:image:height" content="542" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Open Graph - Article -->
    <meta name="article:section" content="{{ $blog->blogcategory->name }}">
    <meta name="article:published_time" content="{{ $blog->created_at}}">
    <meta name="article:author" content="{{ Request::url('blogger/profile/'.$blog->user->unique_key) }}">
    <meta name="article:tag" content="{{ $blog->blogcategory->name }}">
    <meta name="article:modified_time" content="{{ $blog->updated_at }}">

    <!-- Structured data JSON-LD (optional but highly recommended) -->
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

    <style type="text/css">
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
            width: 40px;
            height: 40px;
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

    <div class="blog-single-wrapper">
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
        </div>

        <hr class="my-5">

        {{-- Action Bar: Likes, Views, Share --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <a href="javascript:void(0)" class="btn btn-light rounded-pill px-4 me-2" onclick="likeBlog({{ $blog->id }})">
                    <i class="far fa-heart" id="like_icon"></i> <span id="like_span">{{ $blog->likes }} Like(s)</span>
                </a>
                <span class="text-muted ms-3"><i class="fas fa-eye"></i> {{ $blog->views }} Views</span>
            </div>
            <div class="social-share-links mt-3 mt-md-0">
                <span class="me-3 font-weight-bold">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="btn btn-facebook" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" class="btn btn-twitter" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" class="btn btn-linkedin" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        {{-- Author Section --}}
        <div class="author-box shadow-sm">
            <img src="{{ $blog->user->image ? asset('images/users/'.$blog->user->image) : asset('images/default-user.png') }}" class="author-img" alt="Author">
            <div>
                <h5 class="mb-1 font-weight-bold">{{ $blog->user->name }}</h5>
                <p class="text-muted mb-0" style="font-size: 14px;">{{ $blog->user->designation ?? 'Expert Content Creator' }}</p>
                <a href="{{ route('blogger.profile', $blog->user->id) }}" class="small text-primary">View Profile »</a>
            </div>
        </div>

        {{-- Facebook Comments --}}
        <div class="mt-5">
            <h4 class="font-weight-bold mb-4"><i class="far fa-comments"></i> আলোচনা ও মন্তব্য</h4>
            <div class="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="5"></div>
        </div>
    </div>


















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
    <section style="padding-top: 50px; padding-bottom: 50px;">
        <h2 class="blog-details-headline text-black">{{ $blog->title }}</h2>
        <div class="blog-date no-padding-top">Posted by <a href="{{ route('blogger.profile', $blog->user->id) }}"><b>{{ $blog->user->name }}</b></a> | {{ date('F d, Y', strtotime($blog->created_at)) }} | <a href="{{ route('blog.categorywise', str_replace(" ", "-", $blog->blogcategory->name)) }}">{{ $blog->blogcategory->name }}</a> </div>
        {{-- strtolower() টা সমাধান করা লাগবে --}}
        @if($blog->featured_image != null)
            <div class="blog-image margin-eight"><img src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="" style="width: 100%;"></div><br/>
        @endif

        <div class="" style="overflow-wrap: break-word; ">
            {!! $blog->body !!}
            {{-- solved the strong, em and p problem --}}
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<strong>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</strong>"))
            @else
              </strong>
            @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<b>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</b>"))
            @else
              </b>
            @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<b>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</b>"))

            @else
              </b>
            @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<em>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</em>"))

            @else
              </em>
            @endif
            @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<p>") == substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</p>"))
            @else
              </p>
            @endif
            {{-- solved the strong, em and p problem --}}
        </div>
        <hr/>

        <div>
            <a href="#!" class="blog-like" onclick="likeBlog({{ $blog->id }})" title="Click to Like/Unlike!">
                <i class="far fa-heart" id="like_icon"></i>
                <span id="like_span">{{ $blog->likes }} Like(s)</span>
            </a>
            <a href="#" class="blog-like"><i class="fas fa-eye"></i> {{ $blog->views }} View(s)</a>
            <a href="#" class="blog-share" data-toggle="modal" data-target="#shareModal" title="Click to Share this Article!"><i class="fas fa-share-alt"></i> Share</a>
            {{-- <a href="#" class="comment"><i class="fa fa-comment-o"></i><span class="fb-comments-count" data-href="{{ Request::url() }}"></span> comment(s)</a> --}}
            {{-- <a href="#" class="comment"><i class="fa fa-comment-o"></i>
            <span id="comment_count"></span> comment(s)</a>
            <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
            <script type="text/javascript">
                $.ajax({
                    url: "https://graph.facebook.com/v2.2/?fields=share{comment_count}&id={{ Request::url() }}",
                    dataType: "jsonp",
                    success: function(data) {
                        if(data.share) {
                            $('#comment_count').text(data.share.comment_count);
                        } else {
                            $('#comment_count').text(0);
                        }
                    }
                });
            </script> --}}
        </div>

        {{-- <div class="text-center margin-ten no-margin-bottom about-author text-left bg-gray">
            <div class="blog-comment text-left clearfix no-margin">
                <!-- author image -->
                <a class="comment-avtar no-margin-top"><img src="{{ asset('images/users/'.$blog->user->image) }}" alt=""></a>
                <!-- end author image -->
                <!-- author text -->
                <div class="comment-text overflow-hidden position-relative">
                    <h5 class="widget-title">About The Author</h5>
                    <a href="{{ route('blogger.profile', $blog->user->id) }}"><p class="blog-date no-padding-top">{{ $blog->user->name }}</p></a>
                    <p class="about-author-text no-margin">
                        {{ $blog->user->designation }}<br/>
                        {{ $blog->user->email }}
                    </p>
                </div>
                <!-- end author text -->
            </div>
        </div> --}}
        <br/>
        <div class="blog-comment-main xs-no-padding-top">
            <h5 class="widget-title">Article Comments</h5>
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
        <div class="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="5"></div>

    </section>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-share-alt" aria-hidden="true"></i> Share this Blog</h4>
            </div>
            <div class="modal-body">
              <p>
              <!-- social icon -->
              <div class="text-center margin-ten padding-four no-margin-top">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-facebook"></i></a>
                  <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-twitter"></i></a>
                  {{-- <a href="https://plus.google.com/share?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-google-plus"></i></a> --}}
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url()}}&title=IIT%20Alumni%20Association&summary={{ $blog->title }}&source=IITAlumni" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-linkedin"></i></a>
              </div>
              <!-- end social icon -->
              </p>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
          </div>
          
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
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            checkLiked();
        });

        // like or dislike
        function likeBlog(blog_id) {
          // console.log(user_id +','+ blog_id);
          $.get(window.location.protocol + "//" + window.location.host + "/like/" + blog_id, function(data, status){
              console.log("Data: " + data + "\nStatus: " + status);
              checkLiked();
          });
        }

        // check liked or not, based on cookies
        function checkLiked() {
          $.get(window.location.protocol + "//" + window.location.host + "/check/like/" + {{ $blog->id }}, function(data, status){
              // console.log(data.cookie);
              if(data.status == 'liked') {
                $('#like_span').text(data.likes +' Liked');
                $('#like_icon').css('color', 'red');
                $('#like_icon').attr('class', 'fas fa-heart');
              } else {
                $('#like_span').text(data.likes +' Like');
                $('#like_icon').css('color', '');
                $('#like_icon').attr('class', 'far fa-heart');
              }
          });
        }
    </script>
@endsection