@extends('layouts.app')
@section('title') ড্যাশবোর্ড | কোর্সসমূহ @endsection

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<style>
    .category-btn {
        text-decoration: none !important;
        color: #333 !important;
        font-weight: 600;
        display: block;
        width: 100%;
        text-align: left;
        padding: 10px 15px;
    }
    .card-category {
        margin-bottom: 10px;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
    }
    .btn-group .btn { margin-right: 2px; }
</style>
@endsection

@section('content')
    @section('page-header') কোর্সসমূহ @endsection
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-list-ul mr-2"></i> কোর্সসমূহ (মোটঃ {{ $totalcourses }})
                        </h5>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCourseModal">
                            <i class="fas fa-plus-circle"></i> নতুন কোর্স যোগ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @php
            $categoryNames = [
                1 => 'বিসিএস (BCS)',
                2 => 'প্রাইমারি',
                3 => 'ব্যাংক',
                4 => 'NTRCA',
                5 => 'NSI, DGFI ও অন্যান্য',
                6 => 'প্রশ্ন ব্যাংক'
            ];
            $groupedCourses = $courses->groupBy('category');
        @endphp

        <div id="accordion">
            @foreach($groupedCourses as $catId => $courseGroup)
                <div class="card card-category shadow-sm">
                    <div class="card-header bg-white p-0" id="heading{{ $catId }}">
                        <button class="btn category-btn collapsed" data-toggle="collapse" data-target="#collapse{{ $catId }}" aria-expanded="false">
                            <i class="fas fa-chevron-right mr-2 text-primary"></i> 
                            {{ $categoryNames[$catId] ?? 'অন্যান্য বিভাগ' }} 
                            <span class="badge badge-info float-right mt-1">{{ $courseGroup->count() }} টি কোর্স</span>
                        </button>
                    </div>

                    <div id="collapse{{ $catId }}" class="collapse {{ $loop->first ? 'show' : '' }}" data-parent="#accordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Status</th>
                                            <th class="text-center">Serial</th>
                                            <th>Exams</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courseGroup as $course)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="text-dark font-weight-bold">
                                                        {{ $course->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($course->status == 1)
                                                        <span class="badge badge-primary">Active</span>
                                                    @else
                                                        <span class="badge badge-default">In-active</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $course->serial }}</td>
                                                <td>{{ $course->courseexams->count() }} টি</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <a href="{{ route('dashboard.courses.add.exam', $course->id) }}" class="btn btn-warning btn-sm" title="কোর্স হালনাগাদ"><i class="fas fa-folder-plus"></i></a>
                                                        <a href="{{ route('dashboard.courses.exam.serial.edit', $course->id) }}" class="btn btn-success btn-sm" title="সিরিয়াল"><i class="fas fa-sort-amount-up-alt"></i></a>
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCourseModal{{ $course->id }}"><i class="far fa-edit"></i></button>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#changeExamDatesModal{{ $course->id }}"><i class="far fa-calendar-check"></i></button>
                                                        <button type="button" class="btn btn-danger btn-sm" disabled><i class="far fa-trash-alt"></i></button>
                                                    </div>

                                                    {{-- আপনার মূল এডিট মোডাল কোড --}}
                                                    <div class="modal fade text-left" id="editCourseModal{{ $course->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success">
                                                                    <h5 class="modal-title">কোর্স হালনাগাদ</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                </div>
                                                                <form method="post" action="{{ route('dashboard.courses.update', $course->id) }}" enctype='multipart/form-data'>
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <div class="input-group mb-3"><input type="text" name="name" class="form-control" value="{{ $course->name }}" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-layer-group"></span></div></div></div>
                                                                        <div class="input-group mb-3">
                                                                            <select name="status" class="form-control" required>
                                                                                <option value="1" @if($course->status == 1) selected @endif>Active - হ্যাঁ</option>
                                                                                <option value="0" @if($course->status == 0) selected @endif>In-active - না</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <select name="type" class="form-control" required>
                                                                                <option value="1" @if($course->type == 1) selected @endif>সাধারণ কোর্স</option>
                                                                                <option value="4" @if($course->type == 4) selected @endif>ফ্রি মডেল টেস্ট</option>
                                                                                <option value="5" @if($course->type == 5) selected @endif>প্রশ্ন ব্যাংক</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group mb-3"><input type="number" name="priority" class="form-control" value="{{ $course->priority }}" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div></div>
                                                                        <div class="input-group mb-3">
                                                                            <select name="category" class="form-control" required>
                                                                                @foreach($categoryNames as $cid => $cname)
                                                                                    <option value="{{ $cid }}" @if($course->category == $cid) selected @endif>{{ $cname }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <select name="live" class="form-control" required>
                                                                                <option value="1" @if($course->live == 1) selected @endif>Live - হ্যাঁ</option>
                                                                                <option value="0" @if($course->live == 0) selected @endif>Expired - না</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group mb-3"><input type="number" name="serial" class="form-control" value="{{ $course->serial }}" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div></div>
                                                                    </div>
                                                                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button><button type="submit" class="btn btn-success">দাখিল করুন</button></div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- আপনার মূল তারিখ পরিবর্তন মোডাল কোড --}}
                                                    <div class="modal fade text-left" id="changeExamDatesModal{{ $course->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info"><h5 class="modal-title">পরীক্ষার তথ্য পরিবর্তন</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
                                                                <form method="post" action="{{ route('dashboard.courses.exam.dates.update', $course->id) }}">
                                                                    <div class="modal-body text-left">
                                                                        @csrf
                                                                        <div class="input-group mb-3"><input type="text" name="available_from" id="available_from{{ $course->id }}" class="form-control" autocomplete="off" placeholder="চালু হবে" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-calendar-check"></span></div></div></div>
                                                                        <div class="input-group mb-3"><input type="number" name="gapbetween" class="form-control" placeholder="গ্যাপ (দিন)" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div></div>
                                                                    </div>
                                                                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button><button type="submit" class="btn btn-success">দাখিল করুন</button></div>
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
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $courses->links() }}</div>
    </div>

    {{-- অ্যাড কোর্স মোডাল --}}
    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">নতুন কোর্স যোগ</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <form method="post" action="{{ route('dashboard.courses.store') }}" enctype='multipart/form-data'>
              <div class="modal-body">
                    @csrf
                    <div class="input-group mb-3"><input type="text" name="name" class="form-control" placeholder="কোর্সের নাম" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-layer-group"></span></div></div></div>
                    <div class="input-group mb-3"><select name="status" class="form-control" required><option value="1">Active</option><option value="0">In-active</option></select></div>
                    <div class="input-group mb-3"><select name="type" class="form-control" required><option value="1">সাধারণ কোর্স</option><option value="4">ফ্রি মডেল টেস্ট</option><option value="5">প্রশ্ন ব্যাংক</option></select></div>
                    <div class="input-group mb-3"><input type="number" name="priority" class="form-control" placeholder="প্রায়োরিটি" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div></div>
                    <div class="input-group mb-3"><select name="category" class="form-control" required>@foreach($categoryNames as $id => $name) <option value="{{ $id }}">{{ $name }}</option> @endforeach</select></div>
                    <div class="input-group mb-3"><select name="live" class="form-control" required><option value="1">Live</option><option value="0">Expired</option></select></div>
                    <div class="input-group mb-3"><input type="number" name="serial" class="form-control" placeholder="সিরিয়াল" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-sort-amount-up"></span></div></div></div>
              </div>
              <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button><button type="submit" class="btn btn-success">দাখিল করুন</button></div>
          </form>
        </div>
      </div>
    </div>
@endsection

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $(document).ready( function() {
        // আইকন পরিবর্তন লজিক
        $('#accordion').on('shown.bs.collapse', function (e) {
            $(e.target).prev('.card-header').find('.fas').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });
        $('#accordion').on('hidden.bs.collapse', function (e) {
            $(e.target).prev('.card-header').find('.fas').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        });
    });
</script>
@endsection