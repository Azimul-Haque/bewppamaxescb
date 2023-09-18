@extends('layouts.app')
@section('title') ড্যাশবোর্ড | প্রশ্নব্যাংক @endsection

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
</style>
@endsection

@section('content')
    @section('page-header') প্রশ্নব্যাংক @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">প্রশ্নব্যাংক </h3><span style="margin-left: 5px;">(মোটঃ {{ $totalquestions }} টি প্রশ্ন)</span>
          
                      <div class="card-tools">
                          <form class="form-inline form-group-lg" action="">
                            <div class="form-group">
                              <input type="search-param" class="form-control form-control-sm" placeholder="প্রশ্ন খুঁজুন" id="search-param" required>
                            </div>
                            <button type="button" id="search-button" class="btn btn-default btn-sm" style="margin-left: 5px;">
                              <i class="fas fa-search"></i> খুঁজুন
                            </button>
                            <button type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#addExcelQuesitonModal" style="margin-left: 5px;">
                                <i class="fas fa-file-excel"></i> এক্সেল ফাইল আপলোড করুন
                            </button>
                            <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addQuesitonModal" style="margin-left: 5px;">
                                <i class="fas fa-plus-circle"></i> নতুন প্রশ্ন যোগ
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
                              <tr>
                                  <td>
                                      {!! $question->question !!}<br/>
                                      <span class="badge bg-success">{{ $question->topic->name }}</span>
                                      <span class="badge bg-info">{{ $question->difficulty == 1 ? 'সহজ' : ($question->difficulty == 2 ? 'মধ্যম' : 'কঠিন') }}</span>
                                      @foreach($question->tags as $tag)
                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                      @endforeach
                                  </td>
                                  <td>{{ $question->answer }}</td>
                                  <td>{{ $question->option1 }}, {{ $question->option2 }}, {{ $question->option3 }}, {{ $question->option4 }}</td>
                                  {{-- <td>
                                      <div class="progress progress-xs">
                                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                      </div>
                                  </td> --}}
                              
                                  <td>
                                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editQuestionModal{{ $question->id }}">
                                          <i class="far fa-edit"></i>
                                      </button>
                                      {{-- Edit Question Modal Code --}}
                                      {{-- Edit Question Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="editQuestionModalLabel" aria-hidden="true" data-backdrop="static">
                                          <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header bg-success">
                                                <h5 class="modal-title" id="editQuestionModalLabel">প্রশ্ন হালনাগাদ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form method="post" action="{{ route('dashboard.questions.update', $question->id) }}" enctype='multipart/form-data'>
                                                <div class="modal-body">
                                                      @csrf
                                                      <textarea id="question{{ $question->id }}" name="question">{!! $question->question !!}</textarea><br/>
                                                      {{-- <div class="input-group mb-3">
                                                          <input type="text" name="question" class="form-control" value="{{ $question->question }}" placeholder="প্রশ্ন" required>
                                                          <div class="input-group-append">
                                                              <div class="input-group-text"><span class="far fa-question-circle"></span></div>
                                                          </div>
                                                      </div> --}}
                                                      <div class="row">
                                                          <div class="col-md-6">
                                                              <input type="text" name="option1" value="{{ $question->option1 }}" class="form-control mb-3" placeholder="অপশন ১" required>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <input type="text" name="option2" value="{{ $question->option2 }}" class="form-control mb-3" placeholder="অপশন ২" required>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <input type="text" name="option3" value="{{ $question->option3 }}" class="form-control mb-3" placeholder="অপশন ৩" required>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <input type="text" name="option4" value="{{ $question->option4 }}" class="form-control mb-3" placeholder="অপশন ৪" required>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="input-group mb-3">
                                                              <select name="answer" class="form-control" required>
                                                                  <option selected="" disabled="" value="">সঠিক উত্তর</option>
                                                                  <option value="1" @if($question->answer == 1) selected @endif>অপশন ১</option>
                                                                  <option value="2" @if($question->answer == 2) selected @endif>অপশন ২</option>
                                                                  <option value="3" @if($question->answer == 3) selected @endif>অপশন ৩</option>
                                                                  <option value="4" @if($question->answer == 4) selected @endif>অপশন ৪</option>
                                                              </select>
                                                              <div class="input-group-append">
                                                                  <div class="input-group-text"><span class="far fa-check-circle"></span></div>
                                                              </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <select name="tags_ids[]" class="form-control multiple-select" multiple="multiple" data-placeholder="ট্যাগ">
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
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-6">
                                                              <div class="input-group mb-3">
                                                                  <select name="difficulty" class="form-control" required>
                                                                      <option selected="" disabled="" value="">ডিফিকাল্টি লেভেল</option>
                                                                      <option value="1" @if($question->difficulty == 1) selected @endif>সহজ</option>
                                                                      <option value="2" @if($question->difficulty == 2) selected @endif>মধ্যম</option>
                                                                      <option value="3" @if($question->difficulty == 3) selected @endif>কঠিন</option>
                                                                  </select>
                                                                  <div class="input-group-append">
                                                                      <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="input-group mb-3">
                                                                  <select name="topic_id" class="form-control" required>
                                                                      <option selected="" disabled="" value="">টপিক (বিষয়)</option>
                                                                      @foreach ($topics as $topic)
                                                                          <option value="{{ $topic->id }}" @if($question->topic_id == $topic->id) selected @endif>{{ $topic->name }}</option>
                                                                      @endforeach
                                                                  </select>
                                                                  <div class="input-group-append">
                                                                      <div class="input-group-text"><span class="fas fa-bookmark"></span></div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group ">
                                                                  <label for="image">ছবি (প্রয়োজনে)</label>
                                                                  <input type="file" id="image{{ $question->id }}" name="image" accept="image/*">
                                                              </div>
                                                              <center>
                                                                  <?php
                                                                    if($question->questionimage) {
                                                                        $currentimage = asset('images/questions/' . $question->questionimage->image);
                                                                    } else {
                                                                        $currentimage = asset('images/placeholder.png');
                                                                    }
                                                                  ?>
                                                                  <img src="{{ $currentimage }}" id='img-upload{{ $question->id }}' style="width: 250px; height: auto;" class="img-responsive" />
                                                              </center>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <label for="explanation">ব্যাখ্যা (প্রয়োজনে)</label><br/>
                                                              <textarea class="form-control summernote" name="explanation" id="explanation" placeholder="ব্যাখ্যা" style="width: 100%; height: 220px;">{{ $question->questionexplanation ? $question->questionexplanation->explanation : '' }}</textarea>
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

                                      <script>
                                          $('#question{{ $question->id }}').summernote({
                                            // callbacks: {
                                            //   onChange: function(contents, $editable) {
                                            //     $("textarea#content").html(contents);
                                            //   }
                                            // },
                                            dialogsInBody: true,
                                            placeholder: 'কন্টেন্ট লিখুন...',
                                            tabsize: 3,
                                            height: 150,
                                            toolbar: [
                                              ['style', ['style']],
                                              ['font', ['bold', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
                                              ['color', ['color']],
                                              ['para', ['ul', 'ol', 'paragraph']],
                                              ['table', ['table']],
                                              ['insert', ['link', 'picture', 'video']],
                                              ['view', ['fullscreen', 'codeview', 'help']]
                                            ]
                                          });
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
                  $('#img-upload{{ $question->id }}').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image{{ $question->id }}").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 10000) {
            $("#image{{ $question->id }}").val('');
            // toastr.warning('File size is: '+filesize+' Kb. try uploading less than 300Kb', 'WARNING').css('width', '400px;');
            Toast.fire({
                icon: 'warning',
                title: 'File size is: '+filesize+' Kb. try uploading less than 300Kb'
            })
            setTimeout(function() {
            $("#img-upload{{ $question->id }}").attr('src', '{{ asset('images/placeholder.png') }}');
            }, 1000);
          }
      });

    });
</script>
                                      {{-- Edit Question Modal Code --}}
                                      {{-- Edit Question Modal Code --}}
          
                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuestionModal{{ $question->id }}" disabled>
                                          <i class="far fa-trash-alt"></i>
                                      </button>
                                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#notifModal{{ $question->id }}">
                                        <i class="fas fa-bell"></i>
                                      </button>
                                  </td>
                                  {{-- Delete Question Modal Code --}}
                                  {{-- Delete Question Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="deleteQuestionModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionModalLabel" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                          <h5 class="modal-title" id="deleteQuestionModalLabel">প্রশ্ন ডিলেট</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                            আপনি কি নিশ্চিতভাবে এই প্রশ্নটি ডিলেট করতে চান?<br/><br/>
                                            <center>
                                                <big><b>{{ $question->question }}</b></big>
                                            </center>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                          <a href="{{ route('dashboard.questions.delete', $question->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Delete Question Modal Code --}}
                                  {{-- Delete Question Modal Code --}}

                                  
                                  {{-- Notif Modal Code --}}
                                  {{-- Notif Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="notifModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                          <h5 class="modal-title" id="notifModalLabel">নোটিফিকেশন পাঠান</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        
                                          <div class="modal-body">
                                            আপনি কি নিশ্চিতভাবে এই প্রশ্নটি নোটিফিকেশনে পাঠাতে চান?<br/><br/>
                                            <center>
                                                <big><b>{!! $question->question !!}</b></big>
                                            </center>
                                            {{-- @csrf
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                       name="headings"
                                                       class="form-control"
                                                       placeholder="হেডিংস" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><span class="fas fa-file-alt"></span></div>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                       name="message"
                                                       class="form-control"
                                                       placeholder="মেসেজ" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><span class="fas fa-spa"></span></div>
                                                </div>
                                            </div> --}}
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                            <a href="{{ route('dashboard.questions.sendnotification', $question->id) }}" class="btn btn-warning">নোটিফিকেশন পাঠান</a>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  {{-- Notif Modal Code --}}
                                  {{-- Notif Modal Code --}}
                              </tr>
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
                          <button type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#addTopicModal">
                              <i class="fas fa-plus-circle"></i> নতুন টপিক
                          </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Topic</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($topics as $topic)
                              <tr>
                                  <td>
                                    <a href="{{ route('dashboard.questionstopicbased', $topic->id) }}">
                                      {{ $topic->name }} <small>({{ $topic->questions->count() }} টি প্রশ্ন)</small>
                                      <span class="badge bg-primary"><i class="fas fa-bolt"></i> {{ $topic->participation }}</span>
                                    </a>
                                  </td>
                              
                                  <td align="right" width="40%">
                                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTopicModal{{ $topic->id }}">
                                          <i class="far fa-edit"></i>
                                      </button>
                                      {{-- Edit Topic Modal Code --}}
                                      {{-- Edit Topic Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="editTopicModal{{ $topic->id }}" tabindex="-1" role="dialog" aria-labelledby="editTopicModalLabel" aria-hidden="true" data-backdrop="static">
                                          <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header bg-warning">
                                              <h5 class="modal-title" id="editTopicModalLabel">টপিক হালনাগাদ</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                              </div>
                                              <form method="post" action="{{ route('dashboard.questions.topic.update', $topic->id) }}">
                                                  <div class="modal-body">
                                                      @csrf
                                                      <div class="input-group mb-3">
                                                          <input type="text"
                                                                  name="name"
                                                                  class="form-control"
                                                                  value="{{ $topic->name }}"
                                                                  placeholder="নাম" required>
                                                          <div class="input-group-append">
                                                              <div class="input-group-text"><span class="far fa-bookmark"></span></div>
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
                                      {{-- Edit Topic Modal Code --}}
                                      {{-- Edit Topic Modal Code --}}
          
                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTopicModal{{ $topic->id }}" disabled>
                                          <i class="far fa-trash-alt"></i>
                                      </button>
                                  </td>
                                  {{-- Delete Topic Modal Code --}}
                                  {{-- Delete Topic Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="deleteTopicModal{{ $topic->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteTopicModalLabel" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                          <h5 class="modal-title" id="deleteTopicModalLabel">টপিক ডিলেট</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                          আপনি কি নিশ্চিতভাবে এই টপিকটি ডিলেট করতে চান?<br/>
                                          <center>
                                              <big><b>{{ $topic->name }}</b></big><br/>
                                          </center>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                          <a href="{{ route('dashboard.questions.topic.delete', $topic->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Delete Topic Modal Code --}}
                                  {{-- Delete Topic Modal Code --}}
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>

                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">ট্যাগসমূহ</h3>
          
                      <div class="card-tools">
                          <button type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#addTagModal">
                              <i class="fas fa-plus-circle"></i> নতুন ট্যাগ
                          </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Tag</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($tags as $tag)
                              <tr>
                                  <td>
                                    <a href="{{ route('dashboard.questionstagbased', $tag->id) }}">
                                      {{ $tag->name }} <small>({{ $tag->questions->count() }} টি প্রশ্ন)</small><br/>
                                    </a>
                                      
                                  </td>
                              
                                  <td align="right" width="40%">
                                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTagModal{{ $tag->id }}">
                                          <i class="far fa-edit"></i>
                                      </button>
                                      {{-- Edit Tag Modal Code --}}
                                      {{-- Edit Tag Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="editTagModal{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="editTagModalLabel" aria-hidden="true" data-backdrop="static">
                                          <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header bg-warning">
                                              <h5 class="modal-title" id="editTagModalLabel">টপিক হালনাগাদ</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                              </div>
                                              <form method="post" action="{{ route('dashboard.questions.tag.update', $tag->id) }}">
                                                  <div class="modal-body">
                                                      @csrf
                                                      <div class="input-group mb-3">
                                                          <input type="text"
                                                                  name="name"
                                                                  class="form-control"
                                                                  value="{{ $tag->name }}"
                                                                  placeholder="নাম" required>
                                                          <div class="input-group-append">
                                                              <div class="input-group-text"><span class="far fa-bookmark"></span></div>
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
                                      {{-- Edit Tag Modal Code --}}
                                      {{-- Edit Tag Modal Code --}}
          
                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTagModal{{ $tag->id }}" disabled>
                                          <i class="far fa-trash-alt"></i>
                                      </button>
                                  </td>
                                  {{-- Delete Tag Modal Code --}}
                                  {{-- Delete Tag Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="deleteTagModal{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteTagModalLabel" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                          <h5 class="modal-title" id="deleteTagModalLabel">ট্যাগ ডিলেট</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                          আপনি কি নিশ্চিতভাবে এই ট্যাগটি ডিলেট করতে চান?<br/>
                                          <center>
                                              <big><b>{{ $tag->name }}</b></big><br/>
                                          </center>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                          <a href="{{ route('dashboard.questions.tag.delete', $tag->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Delete Tag Modal Code --}}
                                  {{-- Delete Tag Modal Code --}}
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>

    {{-- Upload Excel Modal Code --}}
    {{-- Upload Excel Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addExcelQuesitonModal" tabindex="-1" role="dialog" aria-labelledby="addExcelQuesitonModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title" id="addExcelQuesitonModalLabel">Excel আপলোড</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.questions.excel.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <label for="file">Excel ফাইল</label>
                    <input type="file" id="file" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                <button type="submit" class="btn btn-warning">দাখিল করুন</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Upload Excel Modal Code --}}
    {{-- Upload Excel Modal Code --}}

    {{-- Add Question Modal Code --}}
    {{-- Add Question Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addQuesitonModal" tabindex="-1" role="dialog" aria-labelledby="addQuesitonModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addQuesitonModalLabel">নতুন প্রশ্ন যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.questions.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <textarea id="questionsummernote" name="question"></textarea>
                    <div class="input-group mb-3">
                        {{-- <div id="questionsummernote" style="width100%"></div>
                        <textarea id="question" name="question" style="display: none;"></textarea> --}}
                        {{-- <input type="text" id="question" name="question" class="form-control" value="{{ old('question') }}" placeholder="প্রশ্ন" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="far fa-question-circle"></span></div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="option1" value="{{ old('option1') }}" class="form-control mb-3" placeholder="অপশন ১" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="option2" value="{{ old('option2') }}" class="form-control mb-3" placeholder="অপশন ২" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="option3" value="{{ old('option3') }}" class="form-control mb-3" placeholder="অপশন ৩" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="option4" value="{{ old('option4') }}" class="form-control mb-3" placeholder="অপশন ৪" required>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group mb-3">
                            <select name="answer" class="form-control" required>
                                <option selected="" disabled="" value="">সঠিক উত্তর</option>
                                <option value="1">অপশন ১</option>
                                <option value="2">অপশন ২</option>
                                <option value="3">অপশন ৩</option>
                                <option value="4">অপশন ৪</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="far fa-check-circle"></span></div>
                            </div>
                        </div>    
                      </div>
                      <div class="col-md-6">
                          <select name="tags_ids[]" class="form-control multiple-select" multiple="multiple" data-placeholder="ট্যাগ">
                              @foreach ($tags as $tag)
                                  <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select name="difficulty" class="form-control" required>
                                    <option selected="" disabled="" value="">ডিফিকাল্টি লেভেল</option>
                                    <option value="1" selected>সহজ</option>
                                    <option value="2">মধ্যম</option>
                                    <option value="3">কঠিন</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select name="topic_id" class="form-control" required>
                                    <option selected="" disabled="" value="">টপিক (বিষয়)</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-bookmark"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="image">ছবি (প্রয়োজনে)</label>
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>
                            <center>
                                <img src="{{ asset('images/placeholder.png')}}" id='img-upload' style="width: 250px; height: auto;" class="img-responsive" />
                            </center>
                        </div>
                        <div class="col-md-6">
                            <label for="explanation">ব্যাখ্যা (প্রয়োজনে)</label><br/>
                            <textarea class="form-control summernote" name="explanation" id="explanation" placeholder="ব্যাখ্যা" style="width: 100%; height: 220px;"></textarea>
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
    {{-- Add Question Modal Code --}}
    {{-- Add Question Modal Code --}}

{{-- Add Topic Modal Code --}}
{{-- Add Topic Modal Code --}}
<!-- Modal -->
<div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="addQuesitonModalLabel">নতুন টপিক যোগ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('dashboard.questions.topic.store') }}">
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
              <button type="submit" class="btn btn-warning">দাখিল করুন</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Add Topic Modal Code --}}
  {{-- Add Topic Modal Code --}}

{{-- Add Tag Modal Code --}}
{{-- Add Tag Modal Code --}}
<!-- Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="addQuesitonModalLabel">নতুন ট্যাগ যোগ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('dashboard.questions.tag.store') }}">
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
              <button type="submit" class="btn btn-warning">দাখিল করুন</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Add Tag Modal Code --}}
  {{-- Add Tag Modal Code --}}
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
          var urltocall = '{{ route('dashboard.questions') }}' +  '/' + $('#search-param').val().replace(/\\|\//g, '%');
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
            var urltocall = '{{ route('dashboard.questions') }}' +  '/' + $('#search-param').val().replace(/\\|\//g, '%');
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