@extends('layouts.index')
@section('title') {{ $blogger->name }} | ব্লগ-Blog | BCS Exam AID | বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

@section('third_party_stylesheets')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
	      integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
	      crossorigin="anonymous"/>
@endsection

@section('content')
<section style="padding-top: 150px; padding-bottom: 60px;background-color: #FFFFFF; height: 100px; border-bottom: 1px solid #F4F4F4;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $blogger->name }}</h4>
            </div>
        </div>
    </div>
</section>
<section style="background-color: #FAFAFA; padding-top: 20px; padding-bottom: 50px;">
    <div class="container">
	    <div class="row">
	    	@foreach($blogger->blogs as $blog)
		     	<div class="col-md-4">
					<div class="blog-listing blog-listing-classic no-margin-top wow fadeIn">
			            <!-- post image -->
			            @if($blog->featured_image != null)
			                <div><a class="blog-image" href="{{ route('blog.single', $blog->slug) }}"><img class="img-responsive" src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="" style="width: 100%;" /></a></div><br/>
			            @endif
			            <!-- end post image -->
			            <div class="blog-details">
			                <small class="blog-date"><a href="{{ route('blogger.profile', $blog->user->id) }}"><b>{{ $blog->user->name }}</b></a> | {{ date('F d, Y', strtotime($blog->created_at)) }} | <a href="{{ route('blog.categorywise', str_replace(" ", "-", $blog->blogcategory->name)) }}">{{ $blog->blogcategory->name }}</a> </small>
			                <h5>
			                    <a href="{{ route('blog.single', $blog->slug) }}" style="color: #000000;">
			                        {{ $blog->title }}
			                    </a>
			                </h5>
			                <div style="text-align: justify;">
			                    @if(strlen(strip_tags($blog->body))>200)
			                        {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+150))."... " }} <a class="highlight-button xs-no-margin-bottom" href="{{ route('blog.single', $blog->slug) }}">Read More »</a>
			                    @else
			                        {{ strip_tags($blog->body) }} <a class="highlight-button xs-no-margin-bottom" href="{{ route('blog.single', $blog->slug) }}">Read More »</a>
			                    @endif
			                </div>
			                <small style="margin-bottom: 10px;">
			                    <a href="#!" class="blog-like"><i class="far fa-heart"></i> {{ $blog->likes }} Like(s)</a>
			                    <a href="#!" class="comment"><i class="far fa-comment"></i>
			                    <span id="comment_count{{ $blog->id }}"></span>
			                     comment(s)</a>
			                </small>
			                </br>
			                </br>
			            </div>
			        </div>
			        {{-- <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
			        <script type="text/javascript">
			            // $.ajax({
			            //     url: "https://graph.facebook.com/v2.2/?fields=share{comment_count}&id={{ url('/blog/'.$blog->slug) }}",
			            //     dataType: "jsonp",
			            //     success: function(data) {
			            //         $('#comment_count{{ $blog->id }}').text(data.share.comment_count);
			            //     }
			            // });
			        </script> --}}
		    	</div>
	    	@endforeach
	    	{{ $blogger->blogs->links() }}
	  	</div>
  	</div>
</section>
@endsection

@section('third_party_scripts')

@endsection