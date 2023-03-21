@extends('layouts.app')
@section('title') ড্যাশবোর্ড | খাতের তারিখভিত্তিক খরচের হিসাব @endsection

@section('third_party_stylesheets')

@endsection

@section('content')
	@section('page-header')<a href="{{ route('dashboard.categories') }}"><big><i class="fas fa-arrow-alt-circle-left"></i></big></a> খাতের তারিখভিত্তিক হিসাব @endsection
    <div class="container-fluid">
		<div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $category->name }}  - এর তারিখভিত্তিক হিসাব</h3>

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
                @foreach($expenses as $expense)
                	<tr>
                		<td>
                      <a href="{{ route('dashboard.categories.singledate', [$category->id, $expense->created_at]) }}"><b>{{ bangla(date('F d, Y', strtotime($expense->created_at))) }}</b> <small><i class="fas fa-search-plus"></i></small></a>
                		</td>
                    <td>
                      {{-- <a href="{{ route('dashboard.categories.single', $category->id) }}">{{ $category->name }}</a> --}}
                      <b>৳ {{ $expense->totalamount }}</b>
                    </td>
                		
                	</tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <small>{{ $expenses->onEachSide(1)->links() }}</small>
    </div>

@endsection

@section('third_party_scripts')

@endsection