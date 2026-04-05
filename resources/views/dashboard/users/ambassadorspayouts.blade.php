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
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title font-weight-bold"><i class="fas fa-history mr-2 text-primary"></i> সাম্প্রতিক পে-আউট হিস্ট্রি</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vivid table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">অ্যাম্বাসেডর</th>
                                    <th>মেথড ও নম্বর</th>
                                    <th>টাকার পরিমাণ</th>
                                    <th>ট্রানজেকশন আইডি</th>
                                    <th>তারিখ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($payout->user->name) }}&background=random" class="avatar-sm">
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $payout->user->name }}</div>
                                                <small class="text-muted">{{ $payout->user->mobile }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-info bg-light border text-primary">
                                            <i class="fas fa-wallet mr-1"></i> {{ $payout->payment_method }}
                                        </span>
                                        <div class="small mt-1 font-weight-bold text-muted">{{ $payout->payment_number }}</div>
                                    </td>
                                    <td>
                                        <h6 class="text-success font-weight-bold mb-0">+ ৳ {{ bangla(number_format($payout->amount, 0)) }}</h6>
                                    </td>
                                    <td>
                                        <code class="text-primary font-weight-bold">{{ $payout->transaction_id ?? 'N/A' }}</code>
                                    </td>
                                    <td>
                                        <div class="small text-muted">{{ date('d M, Y', strtotime($payout->created_at)) }}</div>
                                        <div class="small text-muted opacity-7">{{ date('h:i A', strtotime($payout->created_at)) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">কোন পে-আউট রেকর্ড পাওয়া যায়নি।</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="float-right">
                        {{ $payouts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection