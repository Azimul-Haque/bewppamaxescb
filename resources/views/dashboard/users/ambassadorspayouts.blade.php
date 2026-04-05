@extends('layouts.app')

@section('title') অম্বাসেডর ফিন্যান্সিয়াল ড্যাশবোর্ড @endsection

@section('third_party_stylesheets')
<style>
    /* ১. মডার্ন গ্রাডিয়েন্ট কার্ড */
    .vivid-card { border: none; border-radius: 16px; transition: 0.3s; color: #fff; position: relative; overflow: hidden; }
    .vivid-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .bg-grad-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .bg-grad-green { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); }
    .bg-grad-orange { background: linear-gradient(135deg, #f68084 0%, #a12024 100%); }
    
    /* ২. লিডারবোর্ড ডিজাইন (Top 5 Earners) */
    .hall-of-fame-card { background: #fff; border-radius: 16px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .leader-item { border-right: 1px solid #f1f1f1; padding: 20px 10px; }
    .leader-item:last-child { border-right: none; }
    .rank-badge { position: absolute; top: 10px; left: 10px; font-size: 10px; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .top-1 { background: #ffd700; color: #000; box-shadow: 0 0 10px rgba(255,215,0,0.5); }
    
    /* ৩. আধুনিক টেবিল */
    .table-vivid { border-collapse: separate; border-spacing: 0 8px; }
    .table-vivid tr { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.02); transition: 0.3s; }
    .table-vivid tr:hover { transform: scale(1.01); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .table-vivid td, .table-vivid th { vertical-align: middle !important; border: none; padding: 15px; }
    .table-vivid thead th { background: transparent; color: #888; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
    .table-vivid td:first-child { border-radius: 12px 0 0 12px; }
    .table-vivid td:last-child { border-radius: 0 12px 12px 0; }
    
    .avatar-circle { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .method-badge { background: #f8f9fa; border: 1px solid #eee; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: bold; }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-wallet text-primary"></i> অম্বাসেডর পেমেন্ট ড্যাশবোর্ড</h1>
            <div class="text-muted small">আজকের তারিখ: {{ bangla(date('d F, Y')) }}</div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card vivid-card bg-grad-blue shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">মোট পে-আউট প্রদান</p>
                            <h2 class="font-weight-bold mb-0">৳ {{ bangla(number_format($stats['total_payout_amount'], 0)) }}</h2>
                        </div>
                        <div class="p-3"><i class="fas fa-hand-holding-usd fa-3x opacity-5"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card vivid-card bg-grad-green shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">সক্রিয় অম্বাসেডর সংখ্যা</p>
                            <h2 class="font-weight-bold mb-0">{{ bangla($stats['total_ambassadors']) }} জন</h2>
                        </div>
                        <div class="p-3"><i class="fas fa-user-tie fa-3x opacity-5"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card vivid-card bg-grad-orange shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">সেরা উপার্জনকারী (Top 1)</p>
                            @if($stats['top_earners']->first())
                                <h4 class="font-weight-bold mb-0">{{ $stats['top_earners']->first()->user->name }}</h4>
                                <small>আয়: ৳ {{ bangla(number_format($stats['top_earners']->first()->total_earned, 0)) }}</small>
                            @endif
                        </div>
                        <div class="p-3"><i class="fas fa-crown fa-3x opacity-5"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card hall-of-fame-card mt-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title font-weight-bold mb-0 text-primary">
                <i class="fas fa-star text-warning"></i> সেরা ৫ অম্বাসেডর (Leaderboard)
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="row no-gutters text-center">
                @foreach($stats['top_earners'] as $index => $earner)
                <div class="col-md-2-4 col-sm-6 leader-item position-relative">
                    @if($index == 0)
                        <div class="rank-badge top-1"><i class="fas fa-crown"></i></div>
                    @else
                        <div class="rank-badge bg-light border text-muted">{{ $index + 1 }}</div>
                    @endif
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($earner->user->name) }}&background=random" class="rounded-circle mb-2" style="width: 55px; border: 2px solid #eee;">
                    <div class="font-weight-bold text-dark text-truncate px-2">{{ $earner->user->name }}</div>
                    <div class="text-success font-weight-bold">৳ {{ bangla(number_format($earner->total_earned, 0)) }}</div>
                    <div class="progress mt-2 mx-auto" style="height: 3px; width: 60%; background: #eee;">
                        <div class="progress-bar bg-success" style="width: {{ ($earner->total_earned / ($stats['top_earners']->first()->total_earned ?? 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-transparent">
                <div class="card-header bg-transparent border-0 px-0">
                    <h5 class="font-weight-bold mb-0"><i class="fas fa-history text-muted"></i> সাম্প্রতিক পে-আউট রেকর্ডসমূহ</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vivid">
                            <thead>
                                <tr>
                                    <th>অ্যাম্বাসেডর</th>
                                    <th>পেমেন্ট ডিটেইলস</th>
                                    <th class="text-center">পরিমাণ</th>
                                    <th>ট্রানজেকশন আইডি</th>
                                    <th class="text-right">তারিখ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($payout->user->name) }}&background=random" class="avatar-circle mr-3">
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $payout->user->name }}</div>
                                                <small class="text-muted"><i class="fas fa-phone-alt fa-xs"></i> {{ $payout->user->mobile }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="method-badge">{{ $payout->payment_method }}</span>
                                        <div class="small mt-1 font-weight-bold text-primary">{{ $payout->payment_number }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success font-weight-bold" style="font-size: 1.1rem;">
                                            ৳ {{ bangla(number_format($payout->amount, 0)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <code class="px-2 py-1 bg-light text-secondary rounded" style="font-size: 12px;">{{ $payout->transaction_id ?? 'N/A' }}</code>
                                    </td>
                                    <td class="text-right text-muted small">
                                        <div class="font-weight-bold">{{ date('d M, Y', strtotime($payout->created_at)) }}</div>
                                        <div>{{ date('h:i A', strtotime($payout->created_at)) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/no-data.svg" style="width: 150px;" class="mb-3">
                                        <p class="text-muted font-italic">এখনো কোনো পে-আউট রেকর্ড নেই।</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex justify-content-center">
                    {{ $payouts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ৫ কলামের কাস্টম গ্রিড সাপোর্ট */
    @media (min-width: 768px) {
        .col-md-2-4 { flex: 0 0 20%; max-width: 20%; }
    }
    .opacity-5 { opacity: 0.2; }
    .opacity-8 { opacity: 0.8; }
</style>
@endsection