@extends('layouts.app')
@section('title') ড্যাশবোর্ড | টপিক পরিবর্তন | প্রশ্নব্যাংক @endsection

@section('third_party_stylesheets')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<style type="text/css">
  .select2-selection__choice{
      background-color: rgba(0, 123, 255) !important;
  }
  .smtext {
    font-size: 11px;
  }
</style>
@endsection

@section('content')
    @section('page-header') টপিক পরিবর্তন | প্রশ্নব্যাংক @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">টপিক পরিবর্তন | প্রশ্নব্যাংক </h3><span style="margin-left: 5px;">(মোটঃ {{ $totalquestions }} টি প্রশ্ন)</span>
          
                      <div class="card-tools">
                          <form class="form-inline form-group-lg" action="">
                            <div class="form-group">
                              <input type="search-param" class="form-control form-control-sm" placeholder="প্রশ্ন খুঁজুন" id="search-param" required>
                            </div>
                            <button type="button" id="search-button" class="btn btn-success btn-sm" style="margin-left: 5px;">
                              <i class="fas fa-search"></i> খুঁজুন
                            </button>
                          </form>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Question</th>
                                  <th>Answer</th>
                                  <th>Options</th>
                                  <th width="10%">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($questions as $question)
                            <form method="post" action="{{ route('dashboard.questions.updatechangetopicbased', $question->id) }}">
                              <tr>
                                  <td>
                                      {!! $question->question !!}<br/>
                                      <span class="badge bg-success smtext">{{ $question->topic->name }}</span>
                                      {{-- <span class="badge bg-info smtext">{{ $question->difficulty == 1 ? 'সহজ' : ($question->difficulty == 2 ? 'মধ্যম' : 'কঠিন') }}</span> --}}
                                      {{-- @foreach($question->tags as $tag)
                                        <span class="badge bg-primary smtext">{{ $tag->name }}</span>
                                      @endforeach --}}
                                  </td>
                                  
                                  <td>
                                    <small>
                                      @if($question->answer == 1)
                                          <big><b>{{ $question->option1 }}</b></big>, 
                                      @else
                                          {{ $question->option1 }}, 
                                      @endif
                                      @if($question->answer == 2)
                                          <big><b>{{ $question->option2 }}</b></big>, 
                                      @else
                                          {{ $question->option2 }},
                                      @endif<br/> 
                                      @if($question->answer == 3)
                                          <big><b>{{ $question->option3 }}</b></big>, 
                                      @else
                                          {{ $question->option3 }}, 
                                      @endif
                                      @if($question->answer == 4)
                                          <big><b>{{ $question->option4 }}</b></big>
                                      @else
                                          {{ $question->option4 }}
                                      @endif
                                    </small>
                                  </td>                              
                                  <td>
                                    <select class="form-control form-control-sm" name="topicchangeid" id="topicchangeid{{ $question->id }}">
                                      <option selected disabled>টপিক সিলেক্ট করুন</option>
                                      @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" @if($topic->id == $question->topic_id) selected @endif>{{ $topic->name }}</option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updateTopicQuestionModal{{ $question->id }}">
                                        দাখিল করুন
                                    </button>
                                    {{-- Update Topic Modal Code --}}
                                    {{-- Update Topic Modal Code --}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateTopicQuestionModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="updateTopicQuestionModalLabel" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-success">
                                            <h5 class="modal-title" id="updateTopicQuestionModalLabel">প্রশ্ন টপিক হালনাগাদ</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                                @csrf
                                                <b>প্রশ্ন:</b> {!! $question->question !!}<br/><br/>
                                                নির্ধারিত নতুন টপিক - 
                                                <u>
                                                  <span style="font-weight: bold;" id="newtopic{{ $question->id }}">
                                                    {{ $question->topic->name }}
                                                  </span>
                                                </u>
                                                <br/><br/>
                                                আপনি কি নিশ্চিতভাবে এই প্রশ্নটির 'টপিক' হালনাগাদ করতে চান?
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                            <button type="submit" class="btn btn-success">দাখিল করুন</button>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Update Topic Modal Code --}}
                                  {{-- Update Topic Modal Code --}}
                                </td>
                              </tr>
                            </form>
                            <script type="text/javascript">
                              $("#topicchangeid{{ $question->id }}").change(function (){

                                $("#newtopic{{ $question->id }}").text($("#topicchangeid{{ $question->id }} :selected").text());
                              });
                            </script>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  {{ $questions->links() }}
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">টপিকসমূহ</h3>
          
                      <div class="card-tools">
                         
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Topic</th>
                                  {{-- <th>Action</th> --}}
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($topics as $topic)
                              <tr>
                                  <td>
                                    <a href="{{ route('dashboard.questions.changetopicbased', $topic->id) }}">
                                      {{ $topic->name }} <small>({{ $topic->questions->count() }} টি প্রশ্ন)</small>
                                      <span class="badge bg-primary"><i class="fas fa-bolt"></i> {{ $topic->participation }}</span>
                                    </a>
                                  </td>
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
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

    $('#questionsummernote').summernote({
      // callbacks: {
      //   onChange: function(contents, $editable) {
      //     $("textarea#question").html(contents);
      //   }
      // },
      dialogsInBody: true,
      placeholder: 'প্রশ্নটি লিখুন',
      tabsize: 1,
      height: 100,
      width: 1000,
      toolbar: [
        ['font', ['bold', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
        ['insert', ['link', 'picture']],
        ['view', ['codeview']]
      ]
    });
</script>
<script type="text/javascript">
    $(document).ready( function() {
      $(document).on('click', '#search-button', function() {
        if($('#search-param').val() != '') {
          var urltocall = '{{ route('dashboard.questions.changetopic') }}' +  '/' + $('#search-param').val().replace(/\\|\//g, '%');
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
            var urltocall = '{{ route('dashboard.questions.changetopic') }}' +  '/' + $('#search-param').val().replace(/\\|\//g, '%');
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