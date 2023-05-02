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
                                    <a href="{{ route('dashboard.exams.getmeritlist', $exam->id) }}" class="badge bg-primary" rel="tooltip" title="" data-original-title="মেধাতালিকা দেখুন"><i class="fas fa-bolt"></i> {{ $exam->participation }}</a>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
</script> --}}
@endsection