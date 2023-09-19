@extends('layouts.index')
@section('title') {{ $blogger->name }} | ব্লগ-Blog | BCS Exam AID | বিসিএস-সহ সরকারি চাকরির পরীক্ষার প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

@section('third_party_stylesheets')

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
    <section style="background-color: #FAFAFA;">
    <div class="container">
	    <div class="row">
	      <div class="col-md-12 col-12">
			
	      </div>
	  	</div>
  	</div>
</section>
@endsection

@section('third_party_scripts')

@endsection