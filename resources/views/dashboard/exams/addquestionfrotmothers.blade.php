@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পরীক্ষা | {{ $exam->name }} @endsection

@section('third_party_stylesheets')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<style type="text/css">
  .select2-selection__choice{
      background-color: rgba(0, 123, 255) !important;
  }
</style>
@endsection

@section('content')
    @section('page-header') <b><a href="{{ route('dashboard.exams.add.question', $exam->id) }}">{{ $exam->name }} <small>({{ $examquestions->count() }} টি প্রশ্ন)</small></a></b> / প্রশ্নব্যাংক থেকে বাছাই করুন
    @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">প্রশ্নপত্র থেকে এড করুন</h3>
                      <div class="card-tools">
                          
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                    
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">প্রশ্নের হিসাব</h3>
          
                      <div class="card-tools">
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
@endsection

@section('third_party_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/underscore@1.13.4/underscore-umd-min.js"></script>
<script>
    $('.multiple-select').select2({
      // theme: 'bootstrap4',
    });
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
      $(document).on('click', '#search-button', function() {
        if($('#search-param').val() != '') {
          var urltocall = '{{ route('dashboard.index') }}' +  '/exams/add/question/bank/search/{{ $exam->id }}/' + $('#search-param').val();
          location.href= urltocall;
        } else {
          $('#search-param').css({ "border": '#FF0000 2px solid'});
          Toast.fire({
              icon: 'warning',
              title: 'কিছু লিখে খুঁজুন!'
          })
        }
      });
      $("#search-param").keyup(function(e) {
        if(e.which == 13) {
          if($('#search-param').val() != '') {
            var urltocall = '{{ route('dashboard.index') }}' +  '/exams/add/question/bank/search/{{ $exam->id }}/' + $('#search-param').val();
            location.href= urltocall;
          } else {
            $('#search-param').css({ "border": '#FF0000 2px solid'});
            Toast.fire({
                icon: 'warning',
                title: 'কিছু লিখে খুঁজুন!'
            })
          }
        }
      });
    });

    $('#hiddencheckarray').val('{{ $currentchecktext }}');
    console.log($('#hiddencheckarray').val());

    function checkboxquestion(id) {
        if($('#check' + id)[0].checked){
            var hiddencheckarray = $('#hiddencheckarray').val();
            // console.log(hiddencheckarray);
            var updatedvalue = hiddencheckarray + (!hiddencheckarray ? '' : ',') + id;
            $('#hiddencheckarray').val(updatedvalue);
            console.log(updatedvalue);
            var array = updatedvalue.split(',');
            // $('#questionupdatingnumber').text('প্রশ্ন সংখ্যাঃ ' + array.length.toString());
            // $('#questionupdatingnumbertag').text('প্রশ্ন সংখ্যাঃ ' + array.length.toString());
            // $('#questionupdatingnumberauto').text('প্রশ্ন সংখ্যাঃ ' + array.length.toString());
            Toast.fire({
                icon: 'warning',
                title: 'প্রশ্ন সংখ্যাঃ ' + array.length.toString()
            })
            // console.log(array.length);
        } else {
            var hiddencheckarray = $('#hiddencheckarray').val();
            var uncheckedarray = hiddencheckarray.split(',');
            var updatedarray = _.without(uncheckedarray, id.toString());
            // console.log(updatedarray);
            var newupdatedvalue = '';
            for(var i=0; i<updatedarray.length; i++) {
                newupdatedvalue = newupdatedvalue + (!newupdatedvalue ? '' : ',') + updatedarray[i];
            };
            $('#hiddencheckarray').val(newupdatedvalue);
            console.log(newupdatedvalue);
            Toast.fire({
                icon: 'warning',
                title: 'প্রশ্ন সংখ্যাঃ ' + updatedarray.length.toString()
            })
            // $('#questionupdatingnumber').text('প্রশ্ন সংখ্যাঃ ' + updatedarray.length);
            // $('#questionupdatingnumbertag').text('প্রশ্ন সংখ্যাঃ ' + updatedarray.length);
            // $('#questionupdatingnumberauto').text('প্রশ্ন সংখ্যাঃ ' + updatedarray.length);
        }
    }
</script>
@endsection