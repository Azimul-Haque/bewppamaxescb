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
    
@endsection

@section('header-s')
    {{ $archivedate }}
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
                                <i class="far fa-user"></i> {{ $blog->user->name }} &nbsp;|&nbsp; 
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