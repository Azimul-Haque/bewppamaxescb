@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পরীক্ষাসমূহ @endsection

@section('content')+

@section('page-header') পরীক্ষার বিভাগসমূহ @endsection

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="callout callout-info shadow-sm">
                <h5><i class="fas fa-info-circle text-info"></i> স্বাগতম!</h5>
                <p>নিচের যেকোনো একটি বিভাগ নির্বাচন করে ওই বিভাগের পরীক্ষাসমূহ পরিচালনা বা নতুন পরীক্ষা যোগ করুন।</p>
            </div>
        </div>
    </div>

    <div class="row">
        একঘেয়েমি কাটাতে আমরা লুপের ভেতর একটি Color Array ব্যবহার করে প্রতিটি কার্ডকে আলাদা আলাদা প্রফেশনাল কালার দিতে পারি। AdminLTE-এর ডিফল্ট কালার ক্লাসগুলো (যেমন: bg-info, bg-success, bg-warning, bg-danger) ব্যবহার করলে এটি দেখতে অনেক বেশি প্রাণবন্ত লাগবে।

        নিচে আপনার জন্য আপডেট করা কোডটি দেওয়া হলো:

        Blade

        @php
            // প্রফেশনাল কালার ক্লাসের একটি অ্যারে তৈরি করুন
            $colors = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-teal', 'bg-purple'];
        @endphp

        @foreach($examcategories as $index => $category)
            @php
                // লুপের ইনডেক্স অনুযায়ী কালার সিলেক্ট করুন
                $currentColor = $colors[$index % count($colors)];
            @endphp

            <div class="col-lg-3 col-6">
                <div class="small-box {{ $currentColor }} shadow border-0" style="border-radius: 12px; overflow: hidden; transition: transform .3s ease;">
                    <div class="inner p-3">
                        <h3 class="mb-0">{{ $category->exams_count ?? $category->exams->count() }}</h3>
                        <p class="font-weight-bold" style="font-size: 1.2rem; opacity: 0.9;">{{ $category->name }}</p>
                    </div>
                    
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    
                    <a href="{{ route('dashboard.exams', ['id' => $category->id]) }}" class="small-box-footer" style="background: rgba(0,0,0,0.1); border-top: 1px solid rgba(255,255,255,0.1); padding: 8px 0;">
                        পরীক্ষাসমূহ দেখুন <i class="fas fa-arrow-circle-right ml-1"></i>
                    </a>
                </div>
            </div>
        @endforeach

        <style>
            .small-box:hover {
                transform: translateY(-8px);
            }
            .small-box .icon {
                color: rgba(255,255,255,0.3);
                top: 10px;
                right: 15px;
            }
            /* টেক্সট কালার হোয়াইট করার জন্য নিশ্চিত করা */
            .small-box h3, .small-box p, .small-box .small-box-footer {
                color: #fff !important;
            }
        </style>

        <div class="col-lg-3 col-6">
            <div class="small-box shadow-sm border border-dashed" 
                 style="background-color: #f8f9fa; border: 2px dashed #ddd; border-radius: 10px; cursor: pointer; transition: transform .2s;"
                 data-toggle="modal" data-target="#addTopicModal">
                <div class="inner text-center" style="padding: 30px 10px;">
                    <i class="fas fa-plus-circle fa-2x text-warning mb-2"></i>
                    <p class="font-weight-bold text-muted">নতুন ক্যাটাগরি যোগ করুন</p>
                </div>
                {{-- <span class="small-box-footer bg-secondary py-2" style="height: 38px;"></span> --}}
            </div>
        </div>
    </div>

    {{-- <hr class="my-4">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="পরীক্ষার নাম লিখে খুঁজুন..." id="search-param">
                        <div class="input-group-append">
                            <button class="btn btn-warning px-4" type="button" id="search-button">
                                <i class="fas fa-search mr-1"></i> খুঁজুন
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="addTopicModalLabel">নতুন ক্যাটাগরি যোগ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('dashboard.exams.category.store') }}">
            <div class="modal-body">
                  @csrf
                  <div class="input-group mb-3">
                      <input type="text"
                             name="name"
                             class="form-control"
                             value="{{ old('name') }}"
                             placeholder="নাম" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="far fa-bookmark"></span></div>
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <input type="text"
                             name="thumbnail"
                             class="form-control"
                             value="{{ old('thumbnail') }}"
                             placeholder="থাম্বনেইল" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="far fa-image"></span></div>
                      </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
              <button type="submit" class="btn btn-warning">দাখিল করুন</button>
            </div>
        </form>
      </div>
    </div>
</div>

@endsection

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // আপনার বিদ্যমান সার্চ স্ক্রিপ্ট এখানে থাকবে
    $(document).on('click', '#search-button', function() {
      if($('#search-param').val() != '') {
        var urltocall = '{{ route('dashboard.exams') }}' +  '/' + $('#search-param').val().replace(/\\|\//g, '%');
        location.href= urltocall;
      } else {
        $('#search-param').css({ "border": '#FF0000 2px solid'});
        Swal.fire({
            icon: 'warning',
            title: 'কিছু লিখে খুঁজুন!'
        })
      }
    });

    // Enter key search
    $("#search-param").keyup(function(e) {
      if(e.which == 13) {
        $("#search-button").click();
      }
    });
</script>

<style>
    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .border-dashed {
        border-style: dashed !important;
    }
</style>
@endsection