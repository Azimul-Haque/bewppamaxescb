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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">প্রশ্নপত্র থেকে এড করুন</h3>
                      <div class="card-tools">
                          <form method="post" action="{{ route('dashboard.exams.question.from.others.store') }}">
                              <select name="examids" class="form-control select2" data-placeholder="পরীক্ষার নাম">
                                @php
                                  $tag_array = [];
                                  foreach($question->tags as $tag) {
                                    $tag_array[] = $tag->id;
                                  } 
                                @endphp
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" @if(in_array($tag->id, $tag_array)) selected @endif>{{ $tag->name }}</option>
                                @endforeach
                              </select>
                          </form>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                    
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
            <div class="col-md-4">
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
    $('.select2').select2({
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
    
</script>
@endsection