@extends('layouts.app')
@section('title') ড্যাশবোর্ড | খাতের তারিখভিত্তিক খরচের হিসাব @endsection

@section('third_party_stylesheets')

@endsection

@section('content')
	@section('page-header')<a href="{{ route('dashboard.categories.singledate', [$category->id, $selecteddate]) }}"><big><i class="fas fa-arrow-alt-circle-left"></i></big> </a> {{ $category->name }} - {{ bangla(date('F d, Y', strtotime($selecteddate))) }} @endsection
    <div class="container-fluid">
		<div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $site->name }}</h3>

            <div class="card-tools">
        	    {{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addCategoryModal">
          			<i class="fas fa-plus-square"></i> খাত যোগ
          		</button> --}}
              {{-- <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link" href="#">«</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
              </ul> --}}
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <tbody>
                {{-- <tr>
                  <td>1.</td>
                  <td>Update software</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-danger">55%</span></td>
                </tr> --}}
                @php
                  $totalamounttoday = 0;
                @endphp
                @foreach($expenses as $expense)
                	<tr>
                    <td style="line-height: 1;">
                      <span class="badge bg-primary">ব্যয়ঃ ৳ {{ $expense->amount }}</span>
                      <span class="badge bg-success">খাতঃ {{ $expense->category->name }}</span>
                      <span class="badge bg-info">পরিমাণঃ {{ $expense->qty }}</span><br/>
                      <small>
                          <span class="text-black-50">ব্যয় করেছেনঃ</span> {{ $expense->user->name }},
                          <span class="badge bg-warning"><big>সাইটঃ {{ $expense->site->name }}</big></span><br/>
                          <span>{{ date('F d, Y h:i A', strtotime($expense->created_at)) }}</span>, 
                          <span class="text-black-50">বিবরণঃ </span> {{ $expense->description }}
                      </small> 
                    </td>
                	</tr>
                  @php
                    $totalamounttoday = $totalamounttoday + $expense->amount;
                  @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td align="right">মোটঃ <b>৳ {{ $totalamounttoday }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
    </div>

@endsection

@section('third_party_scripts')

@endsection