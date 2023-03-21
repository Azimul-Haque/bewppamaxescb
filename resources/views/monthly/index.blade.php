@extends('layouts.app')
@section('title') ড্যাশবোর্ড | মাসভিত্তিক জমা-খরচ @endsection

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
	@section('page-header') মাসভিত্তিক জমা-খরচ @endsection
    <div class="container-fluid">    
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
      <small>{{ $monthlyexpenses->onEachSide(1)->links() }}</small>
    </div>
@endsection

@section('third_party_scripts')
  {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
  </script> --}}
@endsection