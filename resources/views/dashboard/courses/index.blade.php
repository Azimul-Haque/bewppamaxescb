@extends('layouts.app')
@section('title') ড্যাশবোর্ড | কোর্সসমূহ @endsection

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<style>
    .nav-tabs .nav-link.active { color: #007bff; font-weight: bold; border-top: 3px solid #007bff; }
    .table td, .table th { vertical-align: middle !important; }
</style>
@endsection

@section('content')
    @section('page-header') কোর্সসমূহ @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">কোর্সসমূহ (মোটঃ {{ $totalcourses }})</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addCourseModal">
                                <i class="fas fa-plus-circle"></i> নতুন কোর্স যোগ
                            </button>
                        </div>
                    </div>
                    
                    @php
                        $categoryNames = [
                            1 => 'বিসিএস',
                            2 => 'প্রাইমারি',
                            3 => 'ব্যাংক',
                            4 => 'NTRCA',
                            5 => 'অন্যান্য',
                            6 => 'প্রশ্ন ব্যাংক'
                        ];
                        // কোর্সগুলোকে ক্যাটাগরি অনুযায়ী গ্রুপ করা
                        $groupedCourses = $courses->groupBy('category');
                    @endphp

                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="courseTab" role="tablist">
                            @foreach($categoryNames as $id => $name)
                                @if(isset($groupedCourses[$id]))
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $id }}" data-toggle="pill" href="#content-{{ $id }}" role="tab">
                                        {{ $name }} <span class="badge badge-secondary ml-1">{{ $groupedCourses[$id]->count() }}</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($groupedCourses as $catId => $courseGroup)
                                <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="content-{{ $catId }}" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover border">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Course Name</th>
                                                    <th>Status</th>
                                                    <th>Type</th>
                                                    <th>Exams</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($courseGroup as $course)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="font-weight-bold">{{ $course->name }}</a>
                                                        <br><small class="text-muted">Serial: {{ $course->serial }} | Priority: {{ $course->priority }}</small>
                                                    </td>
                                                    <td>
                                                        @if($course->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-secondary">In-active</span>
                                                        @endif
                                                        @if($course->live == 1)
                                                            <span class="badge badge-warning ml-1">Live</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($course->type == 1) সাধারণ @elseif($course->type == 2) বিজেএস @elseif($course->type == 3) বার @elseif($course->type == 4) ফ্রি @elseif($course->type == 5) প্রশ্ন ব্যাংক @endif
                                                    </td>
                                                    <td>{{ $course->courseexams->count() }} টি</td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="btn btn-warning btn-sm" title="প্রশ্ন যোগ"><i class="fas fa-folder-plus"></i></a>
                                                            <a href="{{ route('dashboard.courses.exam.serial.edit', $course->id) }}" class="btn btn-success btn-sm" title="সিরিয়াল"><i class="fas fa-sort-amount-up-alt"></i></a>
                                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCourseModal{{ $course->id }}"><i class="far fa-edit"></i></button>
                                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#changeExamDatesModal{{ $course->id }}"><i class="far fa-calendar-check"></i></button>
                                                            <button type="button" class="btn btn-danger btn-sm" disabled><i class="far fa-trash-alt"></i></button>
                                                        </div>

                                                        <div class="modal fade text-left" id="editCourseModal{{ $course->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title">কোর্স হালনাগাদ: {{ $course->name }}</h5>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form method="post" action="{{ route('dashboard.courses.update', $course->id) }}" enctype='multipart/form-data'>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-3">
                                                                                    <label>কোর্সের নাম</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
                                                                                        <div class="input-group-append"><div class="input-group-text"><span class="fas fa-layer-group"></span></div></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label>স্ট্যাটাস</label>
                                                                                    <select name="status" class="form-control" required>
                                                                                        <option value="1" @if($course->status == 1) selected @endif>Active - হ্যাঁ</option>
                                                                                        <option value="0" @if($course->status == 0) selected @endif>In-active - না</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label>আপডেটেড ধরন</label>
                                                                                    <select name="category" class="form-control" required>
                                                                                        @foreach($categoryNames as $cid => $cname)
                                                                                            <option value="{{ $cid }}" @if($course->category == $cid) selected @endif>{{ $cname }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label>সিরিয়াল</label>
                                                                                    <input type="number" name="serial" class="form-control" value="{{ $course->serial }}" required>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label>লাইভ স্ট্যাটাস</label>
                                                                                    <select name="live" class="form-control" required>
                                                                                        <option value="1" @if($course->live == 1) selected @endif>Live - হ্যাঁ</option>
                                                                                        <option value="0" @if($course->live == 0) selected @endif>Expired - না</option>
                                                                                    </select>
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

                                                        <div class="modal fade text-left" id="changeExamDatesModal{{ $course->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-info text-white">
                                                                        <h5 class="modal-title">পরীক্ষার তথ্য পরিবর্তন</h5>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form method="post" action="{{ route('dashboard.courses.exam.dates.update', $course->id) }}">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>প্রথম পরীক্ষা চালু হবে</label>
                                                                                <input type="text" name="available_from" id="available_from{{ $course->id }}" class="form-control" autocomplete="off" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>প্রতি দুই পরীক্ষায় গ্যাপ (দিন)</label>
                                                                                <input type="number" name="gapbetween" class="form-control" required>
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
                                                            $("#available_from{{ $course->id }}").datepicker({ format: 'MM dd, yyyy', todayHighlight: true, autoclose: true, container:'#changeExamDatesModal{{ $course->id }}' });
                                                        </script>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{ $courses->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">নতুন কোর্স যোগ</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="post" action="{{ route('dashboard.courses.store') }}" enctype='multipart/form-data'>
              @csrf
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="কোর্সের নাম" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select name="status" class="form-control" required>
                            <option selected disabled>স্ট্যাটাস</option>
                            <option value="1">Active</option>
                            <option value="0">In-active</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select name="category" class="form-control" required>
                            <option selected disabled>আপডেটেড ধরন</option>
                            @foreach($categoryNames as $id => $name) <option value="{{ $id }}">{{ $name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="number" name="priority" class="form-control" placeholder="প্রায়োরিটি" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="number" name="serial" class="form-control" placeholder="সিরিয়াল" required>
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
@endsection

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $(document).ready( function() {
        // ইমেজ হ্যান্ডলিং এবং অন্যান্য জেএস লজিক (আপনার বিদ্যমান কোড)
        $("#image").change(function(){
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 10000) {
                Swal.fire({ icon: 'warning', title: 'File size is too large!' });
                $(this).val('');
            }
        });
    });
</script>
@endsection