@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পরীক্ষাসমূহ @endsection

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
@endsection

@section('content')
    @section('page-header') পরীক্ষাসমূহ @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">পরীক্ষাসমূহ</h3>
          
                      <div class="card-tools">
                          <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addExamModal">
                              <i class="fas fa-plus-circle"></i> নতুন পরীক্ষা যোগ
                          </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>পরীক্ষা</th>
                                  <th>সময়কাল</th>
                                  <th>প্রশ্ন ও প্রশ্নের মান</th>
                                  <th>শুরু-শেষ</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($exams as $exam)
                              <tr>
                                  <td>
                                    @php
                                        $currentDate = date('Y-m-d');  
                                        $startDate = date('Y-m-d', strtotime($exam->available_from));
                                        $endDate = date('Y-m-d', strtotime($exam->available_to));
                                        $isCurrent = false;
                                        if (($currentDate >= $startDate) && ($currentDate <= $endDate)) {   
                                            $isCurrent = true;
                                        }
                                    @endphp
                                    @if($isCurrent == true)
                                        <i class="fas fa-calendar-check" style="color: green;" rel="tooltip" title="চলতি"></i>
                                    @endif
                                    <a href="{{ route('dashboard.exams.add.question', $exam->id) }}" rel="tooltip" title="প্রশ্ন যোগ করুন">{{ $exam->name }}</a>
                                    <br/>
                                    <span class="badge bg-success">{{ $exam->examcategory->name }}</span>
                                    <span class="badge bg-info">{{ $exam->price_type == 0 ? 'ফ্রি' : 'পেইড' }}</span>
                                    <span class="badge bg-primary"><i class="fas fa-bolt"></i> {{ $exam->participation }}</span>
                                  </td>
                                  <td><span class="fas fa-stopwatch"></span> {{ $exam->duration }} মিনিট</td>
                                  <td>
                                    <span class="badge bg-primary">{{ $exam->examquestions->count() }} টি প্রশ্ন</span><br/>
                                    মানঃ {{ $exam->qsweight }} (-{{ $exam->negativepercentage / 100 }} প্রতি ভুলের জন্য)
                                  </td>
                                  <td>{{ date('F d, Y', strtotime($exam->available_from)) }} থেকে {{ date('F d, Y', strtotime($exam->available_to)) }}</td>
                                  {{-- <td>
                                      <div class="progress progress-xs">
                                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                      </div>
                                  </td> --}}
                              
                                  <td>
                                      <a href="{{ route('dashboard.exams.add.question', $exam->id) }}" class="btn btn-warning btn-sm" rel="tooltip" title="প্রশ্ন যোগ/ হালনাগাদ করুন">
                                          <i class="fas fa-folder-plus"></i>
                                      </a>
                                      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#copyExamModal{{ $exam->id }}" rel="tooltip" title="কপি তৈরি করুন">
                                          <i class="far fa-copy"></i>
                                      </button>
                                      {{-- Copy Exam Modal Code --}}
                                      {{-- Copy Exam Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="copyExamModal{{ $exam->id }}" tabindex="-1" role="dialog" aria-labelledby="copyExamModalLabel{{ $exam->id }}" aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                              <h5 class="modal-title" id="copyExamModalLabel{{ $exam->id }}">পরীক্ষা কপি করুন</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form method="post" action="{{ route('dashboard.exams.copy', $exam->id) }}">
                                              <div class="modal-body">
                                                  @csrf
                                                  <div class="input-group mb-3">
                                                    <input type="text" name="name" class="form-control" value="{{ $exam->name }} - Copy" placeholder="পরীক্ষার নাম" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><span class="far fa-clipboard"></span></div>
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
                                      {{-- Copy Exam Modal Code --}}
                                      {{-- Copy Exam Modal Code --}}

                                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editExamModal{{ $exam->id }}">
                                          <i class="far fa-edit"></i>
                                      </button>
                                      {{-- Edit Exam Modal Code --}}
                                      {{-- Edit Exam Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="editExamModal{{ $exam->id }}" tabindex="-1" role="dialog" aria-labelledby="editExamModalLabel{{ $exam->id }}" aria-hidden="true" data-backdrop="static">
                                          <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header bg-success">
                                                <h5 class="modal-title" id="editExamModalLabel{{ $exam->id }}">পরীক্ষা হালনাগাদ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form method="post" action="{{ route('dashboard.exams.update', $exam->id) }}" enctype='multipart/form-data'>
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="examcategory_id" class="form-control" required>
                                                                    <option selected="" disabled="" value="">পরীক্ষার ক্যাটাগরি</option>
                                                                    @foreach ($examcategories as $category)
                                                                        <option value="{{ $category->id }}" @if($exam->examcategory_id == $category->id) selected @endif>{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-bookmark"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="name" class="form-control" value="{{ $exam->name }}" placeholder="পরীক্ষার নাম" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="far fa-clipboard"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="duration" value="{{ $exam->duration }}" min="1" class="form-control" placeholder="সময়কাল (মিনিটে)" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-stopwatch"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="total_questions" value="{{ old('total_questions') }}" min="1" class="form-control" placeholder="মোট প্রশ্ন সংখ্যা" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-sort-amount-up-alt"></span></div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="qsweight" value="{{ $exam->qsweight }}" min="1" class="form-control" placeholder="প্রতি প্রশ্নের মান" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-sort-amount-up-alt"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="negativepercentage" value="{{ $exam->negativepercentage }}" min="0" max="50" class="form-control" placeholder="নেগেটিভ মার্ক পারসেন্টেজ" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-percent"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="price_type" class="form-control" required>
                                                                    <option selected="" disabled="" value="">মূল্য</option>
                                                                    <option value="0" @if($exam->price_type == 0) selected @endif>ফ্রি</option>
                                                                    <option value="1" @if($exam->price_type == 1) selected @endif>পেইড</option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-hand-holding-usd"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="available_from" id="available_from{{ $exam->id }}" value="{{ date('F d, Y', strtotime($exam->available_from)) }}" class="form-control" autocomplete="off" placeholder="চালু হবে" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-calendar-check"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="available_to" id="available_to{{ $exam->id }}" value="{{ date('F d, Y', strtotime($exam->available_to)) }}" class="form-control" autocomplete="off" placeholder="চালু থাকবে (পর্যন্ত)" required>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span class="fas fa-calendar-minus"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="input-group mb-3">
                                                                <textarea class="form-control" name="syllabus" style="height: 150px;" placeholder="সিলেবাস লিখুন (যদি থাকে)" required>{!! str_replace('<br />', "", $exam->syllabus) !!}</textarea>
                                                            </div>
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
    $("#available_from{{ $exam->id }}").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      container:'#editExamModal{{ $exam->id }}',
    });
    $("#available_to{{ $exam->id }}").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      container:'#editExamModal{{ $exam->id }}',
    });
</script>
                                      {{-- Edit Exam Modal Code --}}
                                      {{-- Edit Exam Modal Code --}}
          
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuestionModal{{ $exam->id }}" disabled>
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                  </td>
                                  {{-- Delete Exam Modal Code --}}
                                  {{-- Delete Exam Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="deleteQuestionModal{{ $exam->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionModalLabel{{ $exam->id }}" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                          <h5 class="modal-title" id="deleteQuestionModalLabel{{ $exam->id }}">পরীক্ষা ডিলেট</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                            আপনি কি নিশ্চিতভাবে এই পরীক্ষাটি ডিলেট করতে চান?<br/><br/>
                                            <center>
                                                <big><b>{{ $exam->name }}</b></big>
                                            </center>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                          <a href="{{ route('dashboard.exams.delete', $exam->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Delete Exam Modal Code --}}
                                  {{-- Delete Exam Modal Code --}}
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  {{ $exams->links() }}
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">পরীক্ষার ক্যাটাগরি</h3>
          
                      <div class="card-tools">
                          <button type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#addTopicModal">
                              <i class="fas fa-plus-circle"></i> নতুন ক্যাটাগরি
                          </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Category</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($examcategories as $category)
                              <tr>
                                  <td>
                                      {{ $category->name }}
                                  </td>
                              
                                  <td align="right" width="40%">
                                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}">
                                          <i class="far fa-edit"></i>
                                      </button>
                                      {{-- Edit Category Modal Code --}}
                                      {{-- Edit Category Modal Code --}}
                                      <!-- Modal -->
                                      <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true" data-backdrop="static">
                                          <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header bg-warning">
                                              <h5 class="modal-title" id="editCategoryModalLabel">ক্যাটাগরি হালনাগাদ</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                              </div>
                                              <form method="post" action="{{ route('dashboard.exams.category.update', $category->id) }}">
                                                  <div class="modal-body">
                                                      @csrf
                                                      <div class="input-group mb-3">
                                                          <input type="text"
                                                                  name="name"
                                                                  class="form-control"
                                                                  value="{{ $category->name }}"
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
                                      {{-- Edit Category Modal Code --}}
                                      {{-- Edit Category Modal Code --}}
          
                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCategoryModal{{ $category->id }}" disabled>
                                          <i class="far fa-trash-alt"></i>
                                      </button>
                                  </td>
                                  {{-- Delete Category Modal Code --}}
                                  {{-- Delete Category Modal Code --}}
                                  <!-- Modal -->
                                  <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true" data-backdrop="static">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                          <h5 class="modal-title" id="deleteCategoryModalLabel">ক্যাটাগরি ডিলেট</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                          আপনি কি নিশ্চিতভাবে এই ক্যাটাগরিটি ডিলেট করতে চান?<br/>
                                          <center>
                                              <big><b>{{ $category->name }}</b></big><br/>
                                          </center>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                          <a href="{{ route('dashboard.exams.category.delete', $category->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- Delete Category Modal Code --}}
                                  {{-- Delete Category Modal Code --}}
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>

    {{-- Add Exam Modal Code --}}
    {{-- Add Exam Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addExamModalLabel">নতুন পরীক্ষা যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.exams.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select name="examcategory_id" class="form-control" required>
                                    <option selected="" disabled="" value="">পরীক্ষার ক্যাটাগরি</option>
                                    @foreach ($examcategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-bookmark"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="পরীক্ষার নাম" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="far fa-clipboard"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" name="duration" value="{{ old('duration') }}" min="1" class="form-control" placeholder="সময়কাল (মিনিটে)" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-stopwatch"></span></div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" name="total_questions" value="{{ old('total_questions') }}" min="1" class="form-control" placeholder="মোট প্রশ্ন সংখ্যা" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-sort-amount-up-alt"></span></div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" name="qsweight" value="1" min="1" class="form-control" placeholder="প্রতি প্রশ্নের মান" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-sort-amount-up-alt"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="number" name="negativepercentage" value="25" min="0" max="50" class="form-control" placeholder="নেগেটিভ মার্ক পারসেন্টেজ" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-percent"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select name="price_type" class="form-control" required>
                                    <option selected="" disabled="" value="">মূল্য</option>
                                    <option value="0">ফ্রি</option>
                                    <option value="1" selected>পেইড</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-hand-holding-usd"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="available_from" id="available_from" value="{{ old('available_from') }}" class="form-control" autocomplete="off" placeholder="চালু হবে" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-calendar-check"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="available_to" id="available_to" value="{{ date('F d, Y') }}" class="form-control" autocomplete="off" placeholder="চালু থাকবে (পর্যন্ত)" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-calendar-minus"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="syllabus" style="height: 150px;" placeholder="সিলেবাস লিখুন (যদি থাকে)" required>N/A</textarea>
                            </div>
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
    {{-- Add Exam Modal Code --}}
    {{-- Add Exam Modal Code --}}

{{-- Add Category Modal Code --}}
{{-- Add Category Modal Code --}}
<!-- Modal -->
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
              <button type="submit" class="btn btn-warning">দাখিল করুন</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Add Category Modal Code --}}
  {{-- Add Category Modal Code --}}
@endsection

@section('third_party_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

{{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $("#available_from").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      container:'#addExamModal',
    });
    $("#available_to").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      container:'#addExamModal',
    });
</script>
@endsection