@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ব্যয় যোগ করুন @endsection

@section('third_party_stylesheets')
	<style type="text/css">
		#img-upload{
		    width: 200px;
		    height: auto;
		}
	</style>
@endsection

@section('content')
	@section('page-header') ব্যয় যোগ করুন @endsection
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="card card-success">
		          <div class="card-header">
		            <h3 class="card-title">ব্যয় যোগ করুন</h3>

		            <div class="card-tools">
		            	{{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addExpenseModal">
		            		<i class="fas fa-hand-holding-usd"></i> Add
		            	</button> --}}
		            </div>
		          </div>
		          <!-- /.card-header -->
		          <div class="card-body">
	      	          <form method="post" action="{{ route('dashboard.expense.store') }}" enctype="multipart/form-data">
				          @csrf

				          <div class="input-group mb-3">
				          	<select name="site_data" class="form-control" required>
				          		<option selected="" disabled="" value="">সাইট নির্ধারণ করুন</option>
				          		@foreach($sites as $site)
				          			@if(in_array($site->id, explode(',', Auth::user()->sites)) || Auth::user()->role == 'admin')
				          				<option value="{{ $site->id }},{{ $site->name }}">{{ $site->name }}</option>
				          			@endif
				          		@endforeach
				          	</select>
				              <div class="input-group-append">
				                  <div class="input-group-text"><span class="fas fa-briefcase"></span></div>
				              </div>
				          </div>

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
				                     placeholder="পরিমাণ (যেমনঃ ১০ টি, ২০ বস্তা, ৩০ কেজি ইত্যাদি)">
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
				          <button type="submit" class="btn btn-success">দাখিল করুন</button>
			          </form>
		          </div>
		          <!-- /.card-body -->
		        </div>
			</div>
		</div>
    </div>
@endsection

@section('third_party_scripts')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
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
		          // if(filesize > 1500) {
		          //   $("#image").val('');
		          //   $('#imagetext').val('');
		          //   Toast.fire({
		          //     icon: 'warning',
		          //     title: 'ফাইলের আকৃতি '+filesize+' কিলোবাইট। ১.৫ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন'
		          //   })
		          //   setTimeout(function() {
		          //     $("#img-upload").attr('src', '');
		          //   }, 1000);
		          // }
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