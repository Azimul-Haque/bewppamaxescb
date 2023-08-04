<!DOCTYPE html>
<html lang="en">
<head>
  <title>প্রশ্ন-উত্তর-ব্যাখ্যা | {{ $exam->name }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>{{ $exam->name }}</h1>
  <p>পূর্ণমান - {{ bangla($exam->examquestions->count() * $exam->qsweight) }}, কাটমার্ক - {{ bangla($exam->cutmark) }}, সময় - {{ bangla($exam->duration) }} মিনিট</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-md-12">
    	@foreach($exam->examquestions as $question)
    		<h4>{{ $question->question->question }}</h4>
    		<table>
    			<tr>
    				<td style="padding-left: 20px;">(ক)</td>
    				<td>(খ)</td>
    			</tr>
    			<tr>
    				<td>(গ)</td>
    				<td>(ঘ)</td>
    			</tr>
    		</table>
    		<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    	@endforeach
    </div>
  </div>
</div>

</body>
</html>
