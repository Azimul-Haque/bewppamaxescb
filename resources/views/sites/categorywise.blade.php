@extends('layouts.app')
@section('title') ড্যাশবোর্ড | {{ $site->name }}-এর খাতওয়ারি ব্যয় @endsection

@section('third_party_stylesheets')

@endsection

@section('content')
	@section('page-header') {{ $site->name }} @endsection
    <div class="container-fluid">
		<div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $site->name }}-এর খাতওয়ারি ব্যয়</h3>

            <div class="card-tools">

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <td align="right">মোট</td>
                  <td align="right"><big>৳ <b>{{ $intotalexpense ? $intotalexpense->totalamount : 0 }}</big></b></td>
                </tr>
              </thead>
              <tbody>
                @foreach($categorywises as $categorywise)
                  @foreach($categories as $category)
                  	@if($categorywise->category_id == $category->id)
                      <tr>
                        <td>
                          {{ $category->name }}
                        </td>
                        <td align="right" width="40%">
                          <b>৳ {{ $categorywise->totalamount }}</b>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
    </div>
@endsection

@section('third_party_scripts')

@endsection