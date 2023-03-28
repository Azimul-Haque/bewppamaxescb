@extends('layouts.app')
@section('title') ড্যাশবোর্ড | একক | {{ $user->name }} @endsection

@section('third_party_stylesheets')
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
  <style type="text/css">
    #img-upload{
        width: 200px;
        height: auto;
    }
  </style>
@endsection

@section('content')
	@section('page-header') {{ $user->name }} @endsection
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

            <div class="info-box-content">
                <big><b>{{ $user->name }}</b></big>
                <span class="info-box-text">যোগদান: {{ bangla(date('d, F Y', strtotime($user->created_at))) }}</span>
                <span class="info-box-text">মোবাইল: {{ $user->mobile }}</span>
                <span class="info-box-text">মোট ক্রয় সংখ্যা: {{ $user->payments->count() }}</span>
            </div>
          </div>
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Firebase UID: <u><i>{{ $user->uid }}</i></u></span>
                <span class="info-box-text">Onesignal Player ID: <u><i>{{ $user->onesignal_id }}</i></u></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list-ul"></i></span>
            <div class="info-box-content">
              <small>
                <big><b>পরীক্ষা তথ্য</b></big>
                <span class="info-box-text"></span>
                </small>
              {{-- <span class="info-box-number"></span> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('third_party_scripts')
  
@endsection