@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পরীক্ষাসমূহ @endsection

@section('content')
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
            @foreach($examcategories as $category)
            <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; transition: transform .2s;">
                    <div class="inner">
                        <h3 class="text-primary">{{ $category->exams_count ?? $category->exams->count() }}</h3>
                        <p class="font-weight-bold" style="font-size: 1.1rem; color: #444;">{{ $category->name }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature" style="color: rgba(0,0,0,0.05);"></i>
                    </div>
                    <a href="{{ route('dashboard.exams', 'id' -> $category->id) }}" class="small-box-footer bg-primary py-2">
                        পরীক্ষাসমূহ দেখুন <i class="fas fa-arrow-circle-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach

            {{-- <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border border-dashed" 
                     style="background-color: #f8f9fa; border: 2px dashed #ddd; border-radius: 10px; cursor: pointer;"
                     data-toggle="modal" data-target="#addTopicModal">
                    <div class="inner text-center" style="padding: 30px 10px;">
                        <i class="fas fa-plus-circle fa-2x text-warning mb-2"></i>
                        <p class="font-weight-bold text-muted">নতুন ক্যাটাগরি যোগ করুন</p>
                    </div>
                    <span class="small-box-footer bg-secondary py-2" style="height: 38px;"></span>
                </div>
            </div> --}}
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