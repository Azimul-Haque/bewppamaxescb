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
    	@php
    		$counter = 1;
    	@endphp
    	@foreach($exam->examquestions as $question)
    		<h4><b>{{ bangla($counter) }}. {!! $question->question->question !!}</b></h4>
    		<table>
    			<tr>
    				<td style="padding-right: 20px;">(ক) {{ $question->question->option1 }}</td>
    				<td>(খ) {{ $question->question->option2 }}</td>
    				<td></td>
    			</tr>
    			<tr>
    				<td style="padding-right: 20px;">(গ) {{ $question->question->option3 }}</td>
    				<td style="padding-right: 20px;">(ঘ) {{ $question->question->option4 }}</td>
    				<td >
    					@if($question->question->answer == 1)
    						<b>উত্তর:</b> {{ $question->question->option1 }}
    					@elseif($question->question->answer == 2)
    						<b>উত্তর:</b> {{ $question->question->option2 }}
    					@elseif($question->question->answer == 3)
    						<b>উত্তর:</b> {{ $question->question->option3 }}
    					@elseif($question->question->answer == 4)
    						<b>উত্তর:</b> {{ $question->question->option4 }}
    					@endif
    				</td>
    			</tr>
    		</table><br/>
    		<p><b>ব্যাখ্যা:</b> {{ $question->question->questionexplanation ? $question->question->questionexplanation->explanation : '' }}</p>
    		@if($question->question->questionimage)
    		<img class="img-responsive" src="{{ asset('/images/questions/' . $question->question->questionimage->image) }}"><br/>
    		@endif
    		<br/>

    		@php
    			$counter++;
    		@endphp
    	@endforeach
    </div>
  </div>
</div>

</body>
</html>
