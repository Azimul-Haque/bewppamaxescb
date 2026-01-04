@extends('layouts.app')
@section('title') ড্যাশবোর্ড | কোর্সসমূহ @endsection

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<style>
    .course-card { transition: all 0.3s; border-radius: 15px; }
    .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .category-header { border-left: 5px solid #007bff; padding-left: 10px; margin: 30px 0 20px 0; font-weight: bold; color: #333; }
</style>
@endsection

@section('content')
    @section('page-header') কোর্সসমূহ @endsection
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center bg-white p-3 shadow-sm rounded">
                    <h5 class="mb-0">মোট কোর্স সংখ্যাঃ <span class="badge badge-primary">{{ $totalcourses }}</span></h5>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCourseModal">
                        <i class="fas fa-plus-circle"></i> নতুন কোর্স যোগ
                    </button>
                </div>
            </div>
        </div>

        @php
            $categoryNames = [
                1 => 'বিসিএস',
                2 => 'প্রাইমারি',
                3 => 'ব্যাংক',
                4 => 'NTRCA',
                5 => 'NSI, DGFI ও অন্যান্য',
                6 => 'প্রশ্ন ব্যাংক'
            ];
            $groupedCourses = $courses->groupBy('category');
        @endphp

        @foreach($groupedCourses as $catId => $courseGroup)
            <h4 class="category-header">{{ $categoryNames[$catId] ?? 'অন্যান্য বিভাগ' }}</h4>
            <div class="row">
                @foreach($courseGroup as $course)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm course-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title font-weight-bold">
                                        <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="text-dark">{{ $course->name }}</a>
                                    </h5>
                                    @if($course->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                                <p class="card-text text-muted mb-2">
                                    <small>
                                        <i class="fas fa-tag mr-1"></i> 
                                        @if($course->type == 1) সাধারণ @elseif($course->type == 2) বিজেএস @elseif($course->type == 3) বার @elseif($course->type == 4) ফ্রি @elseif($course->type == 5) প্রশ্ন ব্যাংক @endif
                                    </small>
                                </p>
                                <div class="bg-light p-2 rounded text-center mb-3">
                                    <span class="font-weight-bold">মোট পরীক্ষাঃ {{ $course->courseexams->count() }} টি</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 pb-3">
                                <div class="d-flex justify-content-around">
                                    <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="btn btn-warning btn-sm" title="কোর্স হালনাগাদ">
                                        <i class="fas fa-folder-plus"></i>
                                    </a>
                                    <a href="{{ route('dashboard.courses.exam.serial.edit', $course->id) }}" class="btn btn-success btn-sm" title="সিরিয়াল">
                                        <i class="fas fa-sort-amount-up-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCourseModal{{ $course->id }}" title="এডিট">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#changeExamDatesModal{{ $course->id }}" title="তারিখ">
                                        <i class="far fa-calendar-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCourseModal{{ $course->id }}" disabled>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- আপনার মূল এডিট মোডাল কোড --}}
                        <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content text-left">
                                <div class="modal-header bg-success">
                                    <h5 class="modal-title" id="editCourseModalLabel">কোর্স হালনাগাদ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('dashboard.courses.update', $course->id) }}" enctype='multipart/form-data'>
                                    <div class="modal-body text-left">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="name" class="form-control" value="{{ $course->name }}" placeholder="কোর্সের নাম" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-layer-group"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select name="status" class="form-control" required>
                                                <option selected="" disabled="" value="">স্ট্যাটাস (চলমান কোর্সসমূহতে দেখাবে কি না)</option>
                                                <option value="1" @if($course->status == 1) selected @endif>Active - হ্যাঁ</option>
                                                <option value="0" @if($course->status == 0) selected @endif>In-active - না</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select name="type" class="form-control" required>
                                                <option selected="" disabled="" value="">ক্লাসিকাল ধরন</option>
                                                <option value="1" @if($course->type == 1) selected @endif>সাধারণ কোর্স</option>
                                                <option value="4" @if($course->type == 4) selected @endif>ফ্রি মডেল টেস্ট</option>
                                                <option value="5" @if($course->type == 5) selected @endif>প্রশ্ন ব্যাংক</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-tag"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="number" name="priority" class="form-control" value="{{ $course->priority }}" placeholder="প্রায়োরিটি" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select name="category" class="form-control" required>
                                                <option selected="" disabled="" value="">আপডেটেড ধরন</option>
                                                <option value="1" @if($course->category == 1) selected @endif>বিসিএস</option>
                                                <option value="2" @if($course->category == 2) selected @endif>প্রাইমারি</option>
                                                <option value="3" @if($course->category == 3) selected @endif>ব্যাংক</option>
                                                <option value="4" @if($course->category == 4) selected @endif>NTRCA</option>
                                                <option value="5" @if($course->category == 5) selected @endif>NSI, DGFI ও অন্যান্য</option>
                                                <option value="6" @if($course->category == 6) selected @endif>প্রশ্ন ব্যাংক</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-tag"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select name="live" class="form-control" required>
                                                <option selected="" disabled="" value="{{ $course->live }}">লাইভ স্যাটাস</option>
                                                <option value="1" @if($course->live == 1) selected @endif>Live - হ্যাঁ</option>
                                                <option value="0" @if($course->live == 0) selected @endif>Expired - না</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-star-half-alt"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="number" name="serial" class="form-control" value="{{ $course->serial }}" placeholder="সিরিয়াল" required>
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

                        {{-- আপনার তারিখ পরিবর্তন মোডাল কোড --}}
                        <div class="modal fade text-left" id="changeExamDatesModal{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="changeExamDatesModalLabel" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="changeExamDatesModalLabel">পরীক্ষার তথ্য পরিবর্তন</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('dashboard.courses.exam.dates.update', $course->id) }}" enctype='multipart/form-data'>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="available_from" id="available_from{{ $course->id }}" class="form-control" autocomplete="off" placeholder="প্রথম পরীক্ষাটি চালু হবে" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-calendar-check"></span></div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="number" name="gapbetween" class="form-control" placeholder="প্রতি দুই পরীক্ষায় যতদিন গ্যাপ থাকবে" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-left">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                        <button type="submit" class="btn btn-success">দাখিল করুন</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        <script>
                            $("#available_from{{ $course->id }}").datepicker({
                                format: 'MM dd, yyyy',
                                todayHighlight: true,
                                autoclose: true,
                                container:'#changeExamDatesModal{{ $course->id }}',
                            });
                        </script>

                        {{-- ডিলেট মোডাল কোড --}}
                        <div class="modal fade text-left" id="deleteCourseModal{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title" id="deleteCourseModalLabel">কোর্স ডিলেট</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        আপনি কি নিশ্চিতভাবে এই কোর্সটি ডিলেট করতে চান?<br/><br/>
                                        <center><big><b>{{ $course->name }}</b></big></center>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                        <a href="{{ route('dashboard.courses.delete', $course->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        {{ $courses->links() }}
    </div>

    {{-- অ্যাড কোর্স মোডাল --}}
    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="addCourseModalLabel">নতুন কোর্স যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="post" action="{{ route('dashboard.courses.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="কোর্সের নাম" required>
                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-layer-group"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="status" class="form-control" required>
                            <option selected disabled value="">স্ট্যাটাস</option>
                            <option value="1">Active - হ্যাঁ</option>
                            <option value="0">In-active - না</option>
                        </select>
                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-star-half-alt"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                      <select name="type" class="form-control" required>
                          <option selected disabled value="">ক্লাসিকাল ধরন</option>
                          <option value="1">সাধারণ কোর্স</option>
                          <option value="4">ফ্রি মডেল টেস্ট</option>
                          <option value="5">প্রশ্ন ব্যাংক</option>
                      </select>
                      <div class="input-group-append"><div class="input-group-text"><span class="fas fa-tag"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="priority" class="form-control" placeholder="প্রায়োরিটি" required>
                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                      <select name="category" class="form-control" required>
                          <option selected disabled value="">আপডেটেড ধরন</option>
                          @foreach($categoryNames as $id => $name) <option value="{{ $id }}">{{ $name }}</option> @endforeach
                      </select>
                      <div class="input-group-append"><div class="input-group-text"><span class="fas fa-tag"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="live" class="form-control" required>
                            <option selected disabled value="">লাইভ স্যাটাস</option>
                            <option value="1">Live - হ্যাঁ</option>
                            <option value="0">Expired - না</option>
                        </select>
                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-star-half-alt"></span></div></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="serial" class="form-control" placeholder="সিরিয়াল" required>
                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div>
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
@endsection

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
          }
      });
      // ... image readURL logic (remaining same)
    });
</script>
@endsection