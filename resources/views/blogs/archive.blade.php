@extends('layouts.blog')
@section('title-secondary') {{ $archivedate }} | ব্লগ-Blog | BCS Exam Aid - বিসিএস ও সরকারি চাকরির সেরা প্ল্যাটফর্ম @endsection

@section('meta-data')
    <meta name="description" content="BCS Exam Aid বাংলাদেশ সিভিল সার্ভিস (BCS) পরীক্ষা এবং অন্যান্য সরকারি চাকরি (NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ) পরীক্ষার প্রস্তুতির জন্য সেরা ডেডিকেটেড অনলাইন প্ল্যাটফর্ম। Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="BCS, Bangladesh Civil Service, NSI, দুদক, বাংলাদেশ ব্যাংক, অন্যান্য ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ, Primary Exam, Job Circular, Bank Job Circular, Bank Job Exam, BCS Circular, বিসিএস পরীক্ষা, বার কাউন্সিল পরীক্ষা, জুডিশিয়াল পরীক্ষা, Judicial Exam, bcs book list, bcs book suggestion, BCS Preparation Books, বিসিএস প্রিলিমিনারি বই তালিকা, বিসিএস বই তালিকা, বিসিএস লিখিত বই তালিকা, bcs preliminary book list, bcs written book list, বিসিএস প্রিলিমিনারি পরীক্ষার সিলেবাস, বিসিএস পরীক্ষার সিলেবাস">

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Website",
        "headline": "বিসিএস এক্সাম এইড - ব্লগ - {{ $archivedate }}",
        "description": "{{ $archivedate }}-সময়সীমায় লিখিত বিসিএস এক্সাম এইডের সকল ব্লগ পাচ্ছেন এই পাতায়। বিসিএস ও সরকারি চাকরির পূর্ণান্নগ প্রস্তুতি হোক এখানেই!",
        "image": "{{ asset('images/bcs-exam-aid-banner.png') }}",
        "url": "{{ url()->current() }}",
        "author": {
              "@type": "Person",
              "name": "{{  'এ. এইচ. এম. আজিমুল হক' }}"
            }
        }
    </script>
@endsection

@section('third_party_stylesheets-s')
    <style>
        .blog-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
        }
        .blog-card:hover {
            transform: translateY(-5px);
        }
        .blog-image-wrapper img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .blog-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .blog-meta {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }
        .blog-card-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 15px;
        }
        .blog-card-title a {
            color: #333;
            text-decoration: none;
        }
        .blog-card-title a:hover {
            color: #0062cc;
        }
        .blog-excerpt {
            font-size: 14px;
            color: #555;
            text-align: justify;
            margin-bottom: 20px;
        }
        .blog-footer {
            padding-top: 15px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        .read-more-btn {
            background: #0062cc;
            color: #fff !important;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            text-decoration: none;
        }
    </style>
@endsection

@section('header-s')
    {{ bangla('$archivedate') }}
@endsection

@section('content-s')
    <section style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                @foreach ($blogs as $blog)
                <div class="col-md-6 col-sm-12" style="padding-bottom: 25px;">
                    <div class="blog-card wow fadeIn">
                        <div class="blog-image-wrapper">
                            <a href="{{ route('blog.single', $blog->slug) }}">
                                @if($blog->featured_image != null)
                                    <img src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="{{ $blog->title }}" />
                                @else
                                    <img src="{{ asset('images/default-blog.png') }}" alt="Default Image" />
                                @endif
                            </a>
                        </div>
                        
                        <div class="blog-content">
                            <div class="blog-meta">
                                <i class="far fa-user"></i> <a href="{{ route('blogger.profile', $blog->user->id) }}">{{ $blog->user->name }}</a> &nbsp;|&nbsp; 
                                <i class="far fa-calendar-alt"></i> {{ bangla(date('M d, Y', strtotime($blog->created_at))) }}
                            </div>
                            
                            <h3 class="blog-card-title">
                                <a href="{{ route('blog.single', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>
                            
                            <div class="blog-excerpt">
                                @if($blog->description != '')
                                  {{ $blog->description }}
                                @else
                                  @if(strlen(strip_tags($blog->body))>200)
                                      {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+200))."... " }}
                                  @else
                                      {{ strip_tags($blog->body) }}
                                  @endif
                                @endif
                            </div>
                            
                            <div class="mt-auto">
                                <div class="blog-footer">
                                    <div>
                                        <span class="text-danger"><i class="far fa-heart"></i> {{ $blog->likes }}</span>
                                        <span class="ms-2 text-primary"><i class="far fa-folder"></i> <a href="{{ route('blog.categorywise', $blog->blogcategory->name) }}" title="">{{ $blog->blogcategory->name }}</a></span>
                                    </div>
                                    <a class="read-more-btn" href="{{ route('blog.single', $blog->slug) }}">আরও পড়ুন »</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-12 text-center mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('third_party_scripts-s')

@endsection