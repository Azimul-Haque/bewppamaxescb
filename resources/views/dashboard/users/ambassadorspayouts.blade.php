@extends('layouts.app')

@section('title', 'অ্যাম্বাসেডর ফিন্যান্সিয়াল ড্যাশবোর্ড')

@section('third_party_stylesheets')
<style>
    /* ১. স্টেবল স্ট্যাটাস কার্ডস */
    .info-box-v2 { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; align-items: center; margin-bottom: 20px; border-left: 5px solid; }
    .border-primary-v2 { border-left-color: #007bff; }
    .border-success-v2 { border-left-color: #28a745; }
    .border-warning-v2 { border-left-color: #ffc107; }
    .info-box-v2 .icon-box { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 24px; }
    
    /* ২. টপ ৫ লিডারবোর্ড - ক্লিন গ্রিড */
    .top-earner-card { background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; padding: 15px; text-align: center; height: 100%; transition: 0.2s; }
    .top-earner-card:hover { border-color: #007bff; background: #fff; }
    .earner-avatar { width: 60px; height: 60px; border-radius: 50%; margin-bottom: 10px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    
    /* ৩. মডার্ন ও স্টেবল টেবিল */
    .table-payouts { background: #fff !important; border-radius: 10px; overflow: hidden; }
    .table-payouts thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; color: #444; text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; }
    .table-payouts tbody td { vertical-align: middle !important; border-top: 1px solid #f1f1f1; padding: 15px 12px; }
    .user-link { color: #333; font-weight: 600; transition: 0.2s; }
    .user-link:hover { color: #007bff; text-decoration: none; }
    
    /* ফন্ট সাইজ কন্ট্রোল */
    .text-bangla-amount { font-family: 'SolaimanLipi', sans-serif; font-size: 1.1rem; font-weight: bold; }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h3 class="font-weight-bold"><i class="fas fa-university text-primary mr-2"></i> ফিন্যান্সিয়াল ওভারভিউ</h3>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="info-box-v2 border-primary-v2">
                <div class="icon-box bg-light text-primary"><i class="fas fa-hand-holding-usd"></i></div>
                <div>
                    <small class="text-muted d-block text-uppercase">মোট পে-আউট</small>
                    <span class="h4 font-weight-bold text-bangla-amount">৳ {{ bangla(number_format($stats['total_payout_amount'], 0)) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box-v2 border-success-v2">
                <div class="icon-box bg-light text-success"><i class="fas fa-users"></i></div>
                <div>
                    <small class="text-muted d-block text-uppercase">মোট অ্যাম্বাসেডর</small>
                    <span class="h4 font-weight-bold">{{ bangla($stats['total_ambassadors']) }} জন</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box-v2 border-warning-v2">
                <div class="icon-box bg-light text-warning"><i class="fas fa-crown"></i></div>
                <div>
                    <small class="text-muted d-block text-uppercase">সেরা অ্যাম্বাসেডর</small>
                    <span class="h5 font-weight-bold d-block">{{ $stats['top_earners']->first()->user->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom-0 pt-3">
            <h5 class="card-title font-weight-bold"><i class="fas fa-trophy text-warning mr-2"></i> সেরা ৫ উপার্জনকারী (Top 5)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($stats['top_earners'] as $index => $earner)
                <div class="col-md-2-4 col-6 mb-3">
                    <div class="top-earner-card">
                        <div class="mb-2">
                            <span class="badge @if($index == 0) badge-warning @else badge-light border @endif badge-pill px-3">Rank #{{ $index + 1 }}</span>
                        </div>
                        <a href="{{ route('dashboard.users.single', $earner->user_id) }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($earner->user->name) }}&background=random" class="earner-avatar">
                            <div class="user-link text-truncate px-2">{{ $earner->user->name }}</div>
                        </a>
                        <div class="text-success font-weight-bold mt-1">৳ {{ bangla(number_format($earner->total_earned, 0)) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 table-payouts">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0">সাম্প্রতিক পে-আউট হিস্ট্রি</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="30%">অ্যাম্বাসেডর</th>
                                    <th>পেমেন্ট তথ্য</th>
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
                                            <a href="{{ route('dashboard.users.single', $payout->user_id) }}">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($payout->user->name) }}&background=random" class="rounded-circle mr-3" width="40">
                                            </a>
                                            <div>
                                                <a href="{{ route('dashboard.users.single', $payout->user_id) }}" class="user-link d-block">
                                                    {{ $payout->user->name }}
                                                </a>
                                                <small class="text-muted">{{ $payout->user->mobile }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $payout->payment_method }}</div>
                                        <div class="small text-muted">{{ $payout->payment_number }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-bangla-amount text-success">৳ {{ bangla(number_format($payout->amount, 0)) }}</span>
                                    </td>
                                    <td>
                                        <code class="px-2 py-1 bg-light border rounded small">{{ $payout->transaction_id ?? 'N/A' }}</code>
                                    </td>
                                    <td class="text-right small text-muted">
                                        <div class="font-weight-bold">{{ date('d M, Y', strtotime($payout->created_at)) }}</div>
                                        <div>{{ date('h:i A', strtotime($payout->created_at)) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">কোন পেমেন্ট রেকর্ড পাওয়া যায়নি।</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="float-right">
                        {{ $payouts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ৫ কলাম গ্রিড সাপোর্ট */
    @media (min-width: 768px) {
        .col-md-2-4 { flex: 0 0 20%; max-width: 20%; }
    }
</style>
@endsection