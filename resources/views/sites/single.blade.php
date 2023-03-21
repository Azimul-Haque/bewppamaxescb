@extends('layouts.app')
@section('title') ড্যাশবোর্ড | একক | {{ $site->name }} @endsection

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
	@section('page-header') {{ $site->name }} @endsection
    <div class="container-fluid">
    	<div class="row">
       <div class="col-md-6">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">আজকের মোট ব্যয়</span>
              <span class="info-box-number">৳ {{ $todaytotalcurrent ? $todaytotalcurrent->totalamount : 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
       </div>
       <div class="col-md-6">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ bangla(date('F Y')) }} - এর মোট ব্যয়</span>
              <span class="info-box-number">৳ {{ $monthlyexpensetotalcurrent ? $monthlyexpensetotalcurrent->totalamount : 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
       </div> 
      </div> 
      <div class="row">
       <div class="col-md-6">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">সর্বমোট ব্যয়</span>
              <span class="info-box-number">৳ {{ $intotalexpense ? $intotalexpense->totalamount : 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
       </div>
       {{-- <div class="col-md-6">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ bangla(date('F Y')) }} - এর মোট ব্যয়</span>
              <span class="info-box-number">৳ {{ $monthlyexpensetotalcurrent ? $monthlyexpensetotalcurrent->totalamount : 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
       </div> --}} 
      </div>      
		<div class="card">
          <div class="card-header">
            <h3 class="card-title">ব্যয়ের তালিকা</h3>

            <div class="card-tools">
            	<button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addExpenseModal">
            		<i class="fas fa-hand-holding-usd"></i> নতুন ব্যয়
            	</button>
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
                    <td style="line-height: 1;">
                        <span class="badge bg-primary">৳ {{ $expense->amount }}</span>
                        <span class="badge bg-success">{{ $expense->category->name }}</span>
                        <span class="badge bg-info">{{ $expense->qty }}</span><br/>
                        <small>
                            <span class="text-black-50">ব্যয় করেছেনঃ</span> {{ $expense->user->name }}<br/>
                            <span>{{ date('F d, Y h:i A', strtotime($expense->created_at)) }}</span>, 
                            <span class="text-black-50">বিবরণঃ</span>  {{ $expense->description }}
                        </small> 
                    </td>
                		<td align="right" width="40%">
                      @if($expense->image != null)
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#receiptExpenseModal{{ $expense->id }}">
                            <i class="fas fa-image"></i>
                        </button>
                      @endif
                			@if(Auth::user()->role == 'admin')
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteExpenseModal{{ $expense->id }}">
                              <i class="fas fa-trash-alt"></i>
                          </button>
                      @endif
                		</td>
                        
                        {{-- Expense Receipt Modal Code --}}
                        {{-- Expense Receipt Modal Code --}}
                        <!-- Modal -->
                        <div class="modal fade" id="receiptExpenseModal{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="receiptExpenseModalLabel" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-warning">
                                <h5 class="modal-title" id="receiptExpenseModalLabel">ব্যয় রিসিট</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p style="width: 100%; overflow-y: scroll;">
                                  @if($expense->image != null)
                                    <img src="{{ asset('images/expenses/' . $expense->image) }}">
                                  @endif
                                </p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- Expense Receipt Modal Code --}}
                        {{-- Expense Receipt Modal Code --}}

                        {{-- Delete Expense Modal Code --}}
                        {{-- Delete Expense Modal Code --}}
                        <!-- Modal -->
                        <div class="modal fade" id="deleteExpenseModal{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteExpenseModalLabel" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="deleteExpenseModalLabel">ব্যয় ডিলেট</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                আপনি কি নিশ্চিতভাবে এই ব্যয়টি ডিলেট করতে চান?<br/>
                                <center><big><b>$ {{ $expense->amount }}</b></big><br/>
                                    <small><i class="fas fa-user"></i> {{ $expense->user->name }}, <i class="fas fa-calendar-alt"></i> {{ date('F d, Y', strtotime($expense->created_at)) }}</small>
                                </center>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                <a href="{{ route('dashboard.expense.delete', $expense->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- Delete Expense Modal Code --}}
                        {{-- Delete Expense Modal Code --}}
                	</tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <small>{{ $expenses->onEachSide(1)->links() }}</small>

        @if(Auth::user()->role == 'admin')
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">ব্যয়ের তালিকা (মাসভিত্তিক)</h3>

              <div class="card-tools">
                
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table" {{-- id="example1_wrapper" --}}>
                <thead>
                  <tr>
                    <th>মাস</th>
                    <th>মোট ব্যয়</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($monthlyexpenses as $monthlyexpense)
                    <tr>
                      <td>{{ date('F Y', strtotime($monthlyexpense->created_at)) }}</td>
                      <td align="right">৳ {{ $monthlyexpense->totalamount }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td><b>মোট ব্যয়</b></td>
                    <td align="right"><b>৳ {{ $intotalexpense ? $intotalexpense->totalamount : 0 }}</b></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        @endif

    </div>

    {{-- Add Expense Modal Code --}}
    {{-- Add Expense Modal Code --}}
    <!-- Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title" id="addExpenseModalLabel">ব্যয় যোগ করুন</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{ route('dashboard.expense.store') }}" enctype="multipart/form-data">
	          <div class="modal-body">
	                @csrf

	                <input type="hidden" name="site_data" value="{{ $site->id }},{{ $site->name }}" required>

	                <div class="input-group mb-3">
	                	<select name="category_data" class="form-control" required>
	                		<option selected="" disabled="" value="">খাত নির্ধারণ করুন</option>
	                		@foreach($categories as $category)
	                			<option value="{{ $category->id }},{{ $category->name }}">{{ $category->name }}</option>
	                		@endforeach
	                	</select>
	                    <div class="input-group-append">
	                        <div class="input-group-text"><span class="fas fa-tags"></span></div>
	                    </div>
	                </div>

                  <div class="input-group mb-3">
                      <input type="text"
                             name="qty"
                             class="form-control"
                             value="{{ old('qty') }}"
                             placeholder="সংখ্যা/ পরিমাণ (যেমনঃ ১০ টি, ২০ বস্তা, ৩০ কেজি ইত্যাদি)">
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-archive"></span></div>
                      </div>
                  </div>

                  <div class="input-group mb-3">
                      <input type="text"
                             name="description"
                             class="form-control"
                             value="{{ old('description') }}"
                             placeholder="বিবরণ (ঐচ্ছিক)">
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-file-alt"></span></div>
                      </div>
                  </div>

                  <div class="input-group mb-3">
                      <input type="number"
                             name="amount"
                             class="form-control"
                             value="{{ old('amount') }}"
                             @if(Auth::user()->role != 'admin')
                             max="{{ $totalbalance - $totalexpense }}"
                             @endif
                             min="1" 
                             placeholder="ব্যয়ের পরিমাণ লিখুন" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fas fa-money-check-alt"></span></div>
                      </div>
                  </div>

                  <div class="form-group">
                        <label>ছবি যোগ করুন (ঐচ্ছিক)</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    ছবি আপ্লোড করুন <input type="file" name="image" id="image" accept="image/*">
                                </span>
                            </span>
                            <input type="text" id="imagetext" class="form-control" readonly>
                        </div><br/>
                        <center><img id='img-upload'/></center>
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
    {{-- Add Expense Modal Code --}}
    {{-- Add Expense Modal Code --}}
@endsection

@section('third_party_scripts')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $.noConflict();
    jQuery( document ).ready(function( $ ) {
        $('#example1_wrapper').DataTable({
          "paging": true,
          "pageLength": 5,
          "lengthChange": false,
          "ordering": true,
          "info": true,
          "autoWidth": true,
        });
    });

    var _URL = window.URL || window.webkitURL;
    jQuery(document).ready( function() {
          $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
          
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(){
          readURL(this);
          var file, img;

          if ((file = this.files[0])) {
            img = new Image();
            img.onload = function() {
              filesize = parseInt((file.size / 1024));
              if(filesize > 1500) {
                $("#image").val('');
                $('#imagetext').val('');
                Toast.fire({
                  icon: 'warning',
                  title: 'ফাইলের আকৃতি '+filesize+' কিলোবাইট। ১.৫ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন'
                })
                setTimeout(function() {
                  $("#img-upload").attr('src', '');
                }, 1000);
              }
            };
            img.onerror = function() {
              $("#image").val('');
              $('#imagetext').val('');
              Toast.fire({
                  icon: 'warning',
                  title: 'অনুগ্রহ করে ছবি সিলেক্ট করুন!'
                })
              setTimeout(function() {
                $("#img-upload").attr('src', '');
              }, 1000);
            };
            img.src = _URL.createObjectURL(file);
          }
        });   
      });
  </script>
@endsection