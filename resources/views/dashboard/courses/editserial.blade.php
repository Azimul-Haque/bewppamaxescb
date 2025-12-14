@extends('layouts.app')
@section('title') ড্যাশবোর্ড | কোর্সসমূহ @endsection

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
@endsection

@section('content')
    @section('page-header') কোর্সসমূহ @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">কোর্সসমূহ (মোটঃ {{ $totalcourses }})</h3>
          
                      <div class="card-tools">
                          <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addCourseModal">
                              <i class="fas fa-plus-circle"></i> নতুন কোর্স যোগ
                          </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      
                    </div>
                    <!-- /.card-body -->
                  </div>
                  {{ $courses->links() }}
            </div>
        </div>

    {{-- Add Course Modal Code --}}
    {{-- Add Course Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addCourseModalLabel">নতুন কোর্স যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.courses.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="কোর্সের নাম" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-layer-group"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="status" class="form-control" required>
                            <option selected="" disabled="" value="">স্ট্যাটাস (চলমান কোর্সসমূহতে দেখাবে কি না)</option>
                            <option value="1">Active - হ্যাঁ</option>
                            <option value="0">In-active - না</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                      <select name="type" class="form-control" required>
                          <option selected="" disabled="" value="">ক্লাসিকাল ধরন</option>
                          <option value="1">সাধারণ কোর্স</option>
                          {{-- <option value="2">বিজেএস মডেল টেস্ট</option>
                          <option value="3">বার মডেল টেস্ট</option> --}}
                          <option value="4">ফ্রি মডেল টেস্ট</option>
                          <option value="5">প্রশ্ন ব্যাংক</option>
                      </select>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-tag"></span></div>
                      </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="priority" class="form-control" value="{{ old('priority') }}" placeholder="প্রায়োরিটি (চলমান কোর্সসমূহতে যে সিরিয়ালে অ্যাপে দেখাবে)" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                      <select name="category" class="form-control" required>
                          <option selected="" disabled="" value="">আপডেটেড ধরন</option>
                          <option value="1">বিসিএস</option>
                          <option value="2">প্রাইমারি</option>
                          <option value="3">ব্যাংক</option>
                          <option value="4">NTRCA</option>
                          <option value="5">NSI, DGFI ও অন্যান্য</option>
                          <option value="6">প্রশ্ন ব্যাংক</option>
                      </select>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-tag"></span></div>
                      </div>
                    </div>

                    <div class="input-group mb-3">
                        <select name="live" class="form-control" required>
                            <option selected="" disabled="" value="">লাইভ স্যাটাস (ক্যাটাগরিভিত্তিক এর ভেতরে দেখাবে কি না)</option>
                            <option value="1">Live - হ্যাঁ</option>
                            <option value="0">Expired - না</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" name="serial" class="form-control" value="{{ old('serial') }}" placeholder="সিরিয়াল (ক্যাটাগরিভিত্তিক এর ভেতরে যে সিরিয়ালে অ্যাপে দেখাবে)" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                <button type="submit" class="btn btn-success">দাখিল করুন</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Add Course Modal Code --}}
    {{-- Add Course Modal Code --}}
@endsection

@section('third_party_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // ClassicEditor
    //     .create( document.querySelector( '.summernote' ) )
    //     .then( editor => {
    //             console.log( editor );
    //     } )
    //     .catch( error => {
    //             console.error( error );
    //     } );
</script>
<script type="text/javascript">
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 10000) {
            $("#image").val('');
            // toastr.warning('File size is: '+filesize+' Kb. try uploading less than 300Kb', 'WARNING').css('width', '400px;');
            Toast.fire({
                icon: 'warning',
                title: 'File size is: '+filesize+' Kb. try uploading less than 300Kb'
            })
            setTimeout(function() {
            $("#img-upload").attr('src', '{{ asset('images/placeholder.png') }}');
            }, 1000);
          }
      });

    });
</script>
@endsection