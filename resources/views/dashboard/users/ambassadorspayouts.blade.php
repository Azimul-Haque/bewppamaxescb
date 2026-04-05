@extends('layouts.app')

@section('title', 'অ্যাম্বাসেডর পে-আউট ড্যাশবোর্ড')

@section('third_party_stylesheets')
<style>
    /* Vivid Stats Cards */
    .stat-card { border: none; border-radius: 15px; transition: transform 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
    
    .glass-icon { background: rgba(255,255,255,0.2); padding: 15px; border-radius: 12px; }
    .table-vivid thead th { background: #f8f9fe; border-top: none; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: #8898aa; }
    .avatar-sm { width: 35px; height: 35px; border-radius: 50%; margin-right: 10px; }
    .badge-pill { padding: 0.4em 0.8em; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0 font-weight-bold"><i class="fas fa-chart-line text-primary"></i> অম্বাসেডর ফিন্যান্সিয়াল ড্যাশবোর্ড</h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="card stat-card bg-gradient-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-8">মোট পে-আউট</p>
                            <h3 class="font-weight-bold mb-0">৳ {{ bangla(number_format($stats['total_payout_amount'], 0)) }}</h3>
                        </div>
                        <div class="glass-icon"><i class="fas fa-hand-holding-usd fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card stat-card bg-gradient-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-8">মোট অ্যাম্বাসেডর</p>
                            <h3 class="font-weight-bold mb-0">{{ bangla($stats['total_ambassadors']) }} জন</h3>
                        </div>
                        <div class="glass-icon"><i class="fas fa-users fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card stat-card bg-gradient-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        @if($stats['top_ambassador'])
                        <div>
                            <p class="mb-1 opacity-8">সেরা পারফর্মার (Top Earner)</p>
                            <h4 class="font-weight-bold mb-0">{{ $stats['top_ambassador']->user->name }}</h4>
                            <small>আজীবন আয়: <b>৳ {{ bangla(number_format($stats['top_ambassador']->total_earned, 0)) }}</b></small>
                        </div>
                        <div class="glass-icon"><i class="fas fa-trophy fa-2x text-warning"></i></div>
                        @else
                        <p class="mb-0">কোন ডেটা নেই</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-medal text-warning mr-2"></i> সেরা ৫ পারফর্মার (Top Earners)
                    </h5>
                    <span class="badge badge-soft-primary px-3 py-2">Hall of Fame</span>
                </div>
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        @foreach($stats['top_earners'] as $index => $earner)
                        <div class="col-md-2-4 col-sm-6 border-right"> <div class="text-center p-4">
                                <div class="mb-3">
                                    @if($index == 0)
                                        <span class="badge bg-gradient-warning shadow-sm p-2" style="border-radius: 50%; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border: 2px solid #fff;">
                                            <i class="fas fa-crown text-white"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-light border text-dark p-2" style="border-radius: 50%; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                </div>

                                <img src="https://ui-avatars.com/api/?name={{ urlencode($earner->user->name) }}&background=random&color=fff&size=100" 
                                     class="rounded-circle shadow-sm mb-3" 
                                     style="width: 65px; border: 3px solid #f8f9fa;">

                                <h6 class="font-weight-bold text-dark mb-1 text-truncate" title="{{ $earner->user->name }}">
                                    {{ $earner->user->name }}
                                </div>
                                <div class="text-success font-weight-bold" style="font-size: 16px;">
                                    ৳ {{ bangla(number_format($earner->total_earned, 0)) }}
                                </div>
                                <small class="text-muted">আজীবন আয়</small>
                                
                                <div class="progress mt-3" style="height: 4px; border-radius: 10px; background: #eee;">
                                    <div class="progress-bar bg-primary" 
                                         role="progressbar" 
                                         style="width: {{ ($earner->total_earned / $stats['top_earners'][0]->total_earned) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ৫ কলামের জন্য কাস্টম গ্রিড (Bootstrap 4 এ ৫ কলামের ডিফল্ট নেই) */
        @media (min-width: 768px) {
            .col-md-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
        .bg-gradient-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
        .badge-soft-primary { background-color: #e7f1ff; color: #007bff; border-radius: 50px; font-size: 11px; font-weight: bold; }
    </style>
</div>
@endsection