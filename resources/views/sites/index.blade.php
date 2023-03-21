@extends('layouts.app')
@section('title') ড্যাশবোর্ড | সাইটসমূহ @endsection

@section('third_party_stylesheets')

@endsection

@section('content')
	@section('page-header') সাইটসমূহ @endsection
    <div class="container-fluid">
		  <div class="card">
          <div class="card-header">
            <h3 class="card-title">সাইটসমূহ</h3>

            <div class="card-tools">
            	@if(Auth::user()->role == 'admin')
                <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addSiteModal">
            		<i class="fas fa-folder-plus"></i> সাইট যোগ
            	</button>
                @endif
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
                @foreach($sites as $site)
                  @if(in_array($site->id, explode(',', Auth::user()->sites)) || Auth::user()->role == 'admin')
                    <tr>
                      <td>
                          <a href="{{ route('dashboard.sites.single', $site->id) }}">
                            {{ $site->name }}
                            <br/>
                            <small class="text-black-50">{{ $site->address }} (অগ্রগতিঃ {{ $site->progress }}%)</small>
                            <br/>
                            <div class="progress progress-xs progress-striped active">
                              <div class="progress-bar bg-success " style="width: {{ $site->progress }}%"></div>
                            </div>
                            @if(Auth::user()->role == 'admin')
                              <a href="{{ route('dashboard.sites.categorywise', $site->id) }}">খাতওয়ারি ব্যয় তালিকা</a>
                            @endif
                          </a>
                      </td>
                      <td align="right" width="40%">
                      @if(Auth::user()->role == 'admin')
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editSiteModal{{ $site->id }}">
                          <i class="fas fa-edit"></i>
                        </button>
                        {{-- Edit Site Modal Code --}}
                        {{-- Edit Site Modal Code --}}
                        <!-- Modal -->
                        <div class="modal fade" id="editSiteModal{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="editSiteModalLabel" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-primary">
                                <h5 class="modal-title" id="editSiteModalLabel">সাইট সম্পাদনা করুন</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form method="post" action="{{ route('dashboard.sites.update', $site->id) }}">
                                <div class="modal-body">
                                  
                                      @csrf

                                      <div class="input-group mb-3">
                                        <input type="text"
                                               name="name"
                                               class="form-control"
                                               value="{{ $site->name }}"
                                               placeholder="সাইটের নাম" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                                        </div>
                                      </div>

                                      <div class="input-group mb-3">
                                        <input type="text"
                                               name="address"
                                               class="form-control"
                                               value="{{ $site->address }}"
                                               placeholder="ঠিকানা" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
                                        </div>
                                      </div> 

                                      <div class="input-group mb-3">
                                        <input type="text"
                                               name="progress"
                                               class="form-control"
                                               value="{{ $site->progress }}"
                                               placeholder="অগ্রগতি (%)" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-hourglass-start"></span></div>
                                        </div>
                                      </div>                                
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                  <button type="submit" class="btn btn-primary">হালনাগাদ করুন</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        {{-- Edit Site Modal Code --}}
                        {{-- Edit Site Modal Code --}}

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal{{ $site->id }}">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      @endif
                      </td>
                          {{-- Delete Site Modal Code --}}
                          {{-- Delete Site Modal Code --}}
                          <!-- Modal -->
                          <div class="modal fade" id="deleteUserModal{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-danger">
                                  <h5 class="modal-title" id="deleteUserModalLabel">সাইট ডিলেট</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                {!! Form::model($site, ['route' => ['dashboard.sites.delete', $site->id], 'method' => 'DELETE']) !!}
                                  <div class="modal-body">
                                    আপনি কি নিশ্চিতভাবে এই সাইটটি ডিলেট করতে চান?<br/>
                                    <center>
                                        <big><b>{{ $site->name }}</b></big><br/>
                                        <small><i class="fas fa-map-marker-alt"></i> {{ $site->address }}</small>
                                    </center>
                                    <br/><br/>
                                    নিশ্চায়ন প্রক্রিয়া সম্পন্ন করতে নিচের যোগফলটি ফাঁকা ঘরে ইংরেজি অংকে বসানঃ<br/>
                                    @php
                                      $contact_num1 = rand(1,20);
                                      $contact_num2 = rand(1,20);
                                      $contact_sum_result_hidden = $contact_num1 + $contact_num2;
                                    @endphp
                                    <input type="hidden" name="contact_sum_result_hidden" value="{{ $contact_sum_result_hidden }}">
                                    <center>
                                      <div class="col-xs-2">
                                        <input type="text" name="contact_sum_result" id="" class="form-control w-50" placeholder="{{ $contact_num1 }} + {{ $contact_num2 }} = ?" required="">
                                      </div>
                                    </center>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                    <button type="submit" class="btn btn-danger">ডিলেট করুন</button>
                                  </div>
                                {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                          {{-- Delete Site Modal Code --}}
                          {{-- Delete Site Modal Code --}}
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <small>{{ $sites->onEachSide(1)->links() }}</small>
    </div>


    @if(Auth::user()->role == 'admin')
    {{-- Add Site Modal Code --}}
    {{-- Add Site Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addSiteModal" tabindex="-1" role="dialog" aria-labelledby="addSiteModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addSiteModalLabel">নতুন সাইট যোগ করুন</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.sites.store') }}">
	          <div class="modal-body">
	            
	                @csrf

	                <div class="input-group mb-3">
	                    <input type="text"
	                           name="name"
	                           class="form-control"
	                           value="{{ old('name') }}"
	                           placeholder="সাইটের নাম" required>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-user"></span></div>
	                    </div>
	                </div>

                  <div class="input-group mb-3">
                      <input type="text"
                             name="address"
                             class="form-control"
                             value="{{ old('address') }}"
                             placeholder="ঠিকানা" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
                      </div>
                  </div>  

                  <div class="input-group mb-3">
                      <input type="number"
                             min=0
                             max=100
                             name="progress"
                             class="form-control"
                             value="{{ old('progress') }}"
                             placeholder="অগ্রগতি (%)" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-hourglass-start"></span></div>
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
    {{-- Add Site Modal Code --}}
    {{-- Add Site Modal Code --}}
    @endif
@endsection

@section('third_party_scripts')

@endsection