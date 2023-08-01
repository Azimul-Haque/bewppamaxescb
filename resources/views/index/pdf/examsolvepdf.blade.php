<html>
<head>
  <title>Report | Download | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }

  table {
      border-collapse: collapse;
      width: 100%;
  }
  table, td, th {
      border: 1px solid black;
  }
  th, td{
    padding: 4px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  @page {
    header: page-header;
    footer: page-footer;
    background-image: url({{ public_path('images/logo-background.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }
  .graybackground {
    background: rgba(192,192,192, 0.7);
  }
  </style>
</head>
<body>
  <h2 align="center">
    <img src="{{ public_path('images/logo.png') }}" style="height: 70px; width: auto;">
  </h2>
  <p align="center" style="padding-top: -20px;">
    <span style="font-size: 20px;">{{ $exam['name'] }}</span><br/>
  </p>
  
  <div class="" style="padding-top: 0px;">
    {{-- <table class="">
      <tr>
        <th class="graybackground" width="35%">দপ্তরের নাম</th>
        <th class="graybackground">সদস্য সংখ্যা</th>
        <th class="graybackground">মোট সদস্যপদ বাবদ পরিশোধ</th>
        <th class="graybackground">মোট মাসিক কিস্তি পরিশোধ<br/>({{ bangla(date('F, Y')) }} পর্যন্ত)</th>
        <th class="graybackground">মোট মাসিক কিস্তি বকেয়া<br/>({{ bangla(date('F, Y')) }} পর্যন্ত)</th>
      </tr>

      @php
        $intotalmembers = 0;
        $intotalmontlypaid = 0;
        $intotalmontlydues = 0;
      @endphp
      @foreach($branch_array as $branch)
        <tr>
          <td>{{ $branch['name'] }}</td>
          <td align="center">{{ bangla($branch['totalmembers']) }} জন</td>
          <td align="center">৳ {{ bangla($branch['totalmembers'] * 2000) }}</td>
          <td align="center">৳ {{ bangla($branch['totalmontlypaid']) }}</td>
          <td align="center">৳ {{ bangla($branch['totalmontlydues']) }}</td>
        </tr>
        @php
          $intotalmembers = $intotalmembers + $branch['totalmembers'];
          $intotalmontlypaid = $intotalmontlypaid + $branch['totalmontlypaid'];
          $intotalmontlydues = $intotalmontlydues + $branch['totalmontlydues'];
        @endphp
      @endforeach

      <tr>
        <th class="graybackground" align="right">মোট</th>
        <th class="graybackground">{{ bangla($intotalmembers) }} জন</th>
        <th class="graybackground">৳ {{ bangla($intotalmembers * 2000) }}</th>
        <th class="graybackground">৳ {{ bangla($totalapproved->totalamount) }}</th>
        <th class="graybackground">৳ {{ bangla($intotalmontlydues) }}</th>
      </tr>
    </table> --}}
    {{-- {{ bangla($intotalmontlypaid) }} --}}
  </div>
 
  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://bcsexamaid.com | Download Android App: BCS Exam Aid – </small>
    <small>বিসিএস এক্সাম</small>
  </htmlpagefooter>
</body>
</html>