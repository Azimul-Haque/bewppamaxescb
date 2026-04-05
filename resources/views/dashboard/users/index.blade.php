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
            <table class="table table-hover align-middle">
                <style>
                    .user-card-info { line-height: 1.4; }
                    .ref-code-badge {
                        background: #f1f3f9;
                        border: 1px dashed #4e73df;
                        color: #4e73df;
                        padding: 2px 8px;
                        border-radius: 4px;
                        font-family: 'monospace';
                        font-weight: bold;
                        font-size: 12px;
                    }
                    .stat-badge { font-size: 11px; padding: 4px 8px; border-radius: 50px; background: #f8f9fa; border: 1px solid #eee; }
                    .table td { vertical-align: middle !important; border-top: 1px solid #f2f2f2; padding: 15px 10px; }
                </style>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-card-info">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="mb-0 mr-2 font-weight-bold">
                                                <a href="{{ route('dashboard.users.single', $user->id) }}" class="text-primary">{{ $user->name }}</a>
                                            </h6>
                                            <span class="badge @if($user->role == 'admin') badge-success @else badge-info @endif badge-pill" style="font-size: 10px;">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>

                                        <div class="mb-2">
                                            <span class="text-muted small mr-2"><i class="fas fa-phone-alt fa-xs"></i> {{ $user->mobile }}</span>
                                            <span class="ref-code-badge" title="Referral Code">
                                                <i class="fas fa-ticket-alt"></i> {{ $user->referral_code ?? 'N/A' }}
                                            </span>
                                        </div>

                                        <div class="d-flex mb-2">
                                            <div class="stat-badge mr-2">
                                                <i class="fas fa-shopping-bag text-success"></i> প্যাকেজ: <b>{{ bangla($user->payments->count()) }} বার</b>
                                            </div>
                                            <div class="stat-badge">
                                                <i class="fas fa-pen-nib text-warning"></i> পরীক্ষা: <b>{{ bangla($user->meritlists->count()) }} টি</b>
                                            </div>
                                        </div>

                                        <div class="small text-muted">
                                            <span class="mr-3"><i class="far fa-calendar-alt"></i> যোগদান: {{ date('d M, Y', strtotime($user->created_at)) }}</span>
                                            <span><i class="far fa-clock"></i> মেয়াদ: <b class="text-danger">{{ date('d M, Y', strtotime($user->package_expiry_date)) }}</b></span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-right" width="25%">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#smsModal{{ $user->id }}" title="SMS">
                                        <i class="fas fa-envelope text-info"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#notifModal{{ $user->id }}" title="Notification">
                                        <i class="fas fa-bell text-warning"></i>
                                    </button>

                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}" title="Edit">
                                        <i class="fas fa-user-edit text-primary"></i>
                                    </button>

                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deleteUserModal{{ $user->id }}" title="Delete">
                                        <i class="fas fa-user-minus text-danger"></i>
                                    </button>
                                </div>

                                {{-- --- ALL MODALS START (NO LOGIC CHANGED) --- --}}
                                
                                <div class="modal fade text-left" id="smsModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title"><i class="fas fa-envelope"></i> এসএমএস পাঠান - {{ $user->name }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form method="post" action="{{ route('dashboard.users.singlesms', $user->id) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <textarea class="form-control" placeholder="মেসেজ লিখুন" name="message" style="min-height: 150px; resize: none;" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">ফিরে যান</button>
                                                    <button type="submit" class="btn btn-info">মেসেজ পাঠান</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade text-left" id="notifModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title"><i class="fas fa-bell"></i> নোটিফিকেশন পাঠান</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form method="post" action="{{ route('dashboard.users.singlenotification', $user->id) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>হেডিংস</label>
                                                        <input type="text" name="headings" class="form-control" placeholder="যেমন: নতুন পরীক্ষা শুরু হয়েছে" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>মেসেজ</label>
                                                        <input type="text" name="message" class="form-control" placeholder="আপনার বার্তাটি লিখুন" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">ফিরে যান</button>
                                                    <button type="submit" class="btn btn-warning text-white">দাখিল করুন</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade text-left" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="fas fa-user-edit"></i> তথ্য হালনাগাদ</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form method="post" action="{{ route('dashboard.users.update', $user->id) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>নাম</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>মোবাইল</label>
                                                        <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Firebase UID</label>
                                                        <input type="text" name="uid" class="form-control" value="{{ $user->uid }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Onesignal Player ID</label>
                                                        <input type="text" name="onesignal_id" class="form-control" value="{{ $user->onesignal_id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>ধরন (Role)</label>
                                                        <select name="role" class="form-control" required>
                                                            <option value="admin" @if($user->role == 'admin') selected @endif>এডমিন</option>
                                                            <option value="manager" @if($user->role == 'manager') selected @endif>ম্যানেজার</option>
                                                            <option value="volunteer" @if($user->role == 'volunteer') selected @endif>ভলান্টিয়ার</option>
                                                            <option value="user" @if($user->role == 'user') selected @endif>ব্যবহারকারী</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>প্যাকেজের মেয়াদ</label>
                                                        <input type="text" name="packageexpirydate" id="packageexpirydate{{ $user->id }}" class="form-control" value="{{ date('F d, Y', strtotime($user->package_expiry_date)) }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>পাসওয়ার্ড (ঐচ্ছিক)</label>
                                                        <input type="password" name="password" class="form-control" placeholder="পরিবর্তন করতে চাইলে লিখুন">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">ফিরে যান</button>
                                                    <button type="submit" class="btn btn-primary">দাখিল করুন</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade text-left" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">ব্যবহারকারী ডিলেট</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                                <p>আপনি কি নিশ্চিতভাবে এই ব্যবহারকারীকে ডিলেট করতে চান?</p>
                                                <h4 class="font-weight-bold">{{ $user->name }}</h4>
                                                <span class="text-muted">{{ $user->mobile }}</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">ফিরে যান</button>
                                                <a href="{{ route('dashboard.users.delete', $user->id) }}" class="btn btn-danger px-4">হ্যাঁ, ডিলেট করুন</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- --- ALL MODALS END --- --}}

                            </td>
                        </tr>

                        <script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
                        <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
                        <script>
                            $("#packageexpirydate{{ $user->id }}").datepicker({
                                format: 'MM dd, yyyy',
                                todayHighlight: true,
                                autoclose: true,
                            });
                        </script>
                    @endforeach
                </tbody>
            </table>
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