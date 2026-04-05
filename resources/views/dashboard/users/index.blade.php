@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ব্যবহারকারীগণ @endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
	@section('page-header') ব্যবহারকারীগণ (মোট {{ bangla($userscount) }} জন) @endsection
    <div class="container-fluid">
		<div class="card">
          <div class="card-header">
            <h3 class="card-title">ব্যবহারকারীগণ</h3>
            <small><a href="{{ route('dashboard.userssort')  }}" style="margin-left: 5px;">সর্বোচ্চ পরীক্ষার্থী</a></small>
            <small><a href="{{ route('dashboard.expiredusers')  }}" style="margin-left: 5px;">মেয়াদোত্তীর্ণ পরীক্ষার্থী</a></small>

            <div class="card-tools">
              <form class="form-inline form-group-lg" action="">
                <div class="form-group">
                  <input type="search-param" class="form-control form-control-sm" placeholder="ব্যবহারকারী খুঁজুন" id="search-param" required>
                </div>
                <button type="button" id="search-button" class="btn btn-default btn-sm" style="margin-left: 5px;">
                  <i class="fas fa-search"></i> খুঁজুন
                </button>
                <button type="button" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#addBulkDate" style="margin-left: 5px;">
                  <i class="fas fa-calendar-alt"></i> বাল্ক মেয়াদ বাড়ান
                </button>
                <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addUserModal" style="margin-left: 5px;">
                  <i class="fas fa-user-plus"></i> নতুন
                </button>
              </form>
            	
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            
          </div>
          <!-- /.card-body -->
        </div>
        {{ $users->links() }}
    </div>

    {{-- Add User Modal Code --}}
    {{-- Add User Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addUserModalLabel">নতুন ব্যবহারকারী যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.users.store') }}">
	          <div class="modal-body">
	            
	                @csrf

	                <div class="input-group mb-3">
	                    <input type="text"
	                           name="name"
	                           class="form-control"
	                           value="{{ old('name') }}"
	                           placeholder="নাম" required>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-user"></span></div>
	                    </div>
	                </div>

	                <div class="input-group mb-3">
	                    <input type="text"
	                           name="mobile"
	                           value="{{ old('mobile') }}"
	                           autocomplete="off"
	                           class="form-control"
	                           placeholder="মোবাইল নম্বর (১১ ডিজিট)" required>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-phone"></span></div>
	                    </div>
	                </div>

	                <div class="input-group mb-3">
	                	<select name="role" id="adduserrole" class="form-control" required>
	                		<option selected="" disabled="" value="">ধরন</option>
	                		<option value="admin">এডমিন</option>
							       <option value="manager">ম্যানেজার</option>
                     <option value="volunteer">ভলান্টিয়ার</option>
	                		<option value="user">ব্যবহারকারী</option>
							{{-- <option value="accountant">একাউন্টেন্ট</option> --}}
	                	</select>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-user-secret"></span></div>
	                    </div>
	                </div>


	                <div class="input-group mb-3">
	                    <input type="password"
	                           name="password"
	                           class="form-control"
	                           autocomplete="off"
	                           placeholder="পাসওয়ার্ড" required>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
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
    {{-- Add User Modal Code --}}
    {{-- Add User Modal Code --}}

    {{-- Add Bulk Date Modal Code --}}
    {{-- Add Bulk Date Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addBulkDate" tabindex="-1" role="dialog" aria-labelledby="addBulkDateLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title" id="addBulkDateLabel">নতুন ব্যবহারকারী যোগ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.users.bulk.package.update') }}">
            <div class="modal-body">
              
                  @csrf

                  <div class="input-group mb-3">
                      <textarea type="text"
                             name="numbers"
                             class="form-control"
                             placeholder="নাম্বারসমূহ দিন (কমা সেপারেটেড)" required></textarea>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-user"></span></div>
                      </div>
                  </div>

                  <div class="input-group mb-3">
                      <input type="text"
                             name="packageexpirydatebulk"
                             id="packageexpirydatebulk" 
                             autocomplete="off"
                             class="form-control"
                             placeholder="প্যাকেজের মেয়াদ বৃদ্ধি" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-calendar-check"></span></div>
                      </div>
                  </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
              <button type="submit" class="btn btn-info">দাখিল করুন</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Add Bulk Date Modal Code --}}
    {{-- Add Bulk Date Modal Code --}}

    <script>
      $("#packageexpirydatebulk").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    </script>
@endsection

@section('third_party_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $('#adduserrole').change(function () {
            if($('#adduserrole').val() == 'accountant') {
                $('#ifaccountant').hide();
            } else {
                $('#ifaccountant').show();
            }
        });


        $(document).on('click', '#search-button', function() {
          if($('#search-param').val() != '') {
            var urltocall = '{{ route('dashboard.users') }}' +  '/' + $('#search-param').val();
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
              var urltocall = '{{ route('dashboard.users') }}' +  '/' + $('#search-param').val();
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
    </script>
@endsection