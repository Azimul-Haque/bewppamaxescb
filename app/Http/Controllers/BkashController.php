<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Package;
use App\Payment;

use Carbon\Carbon;
use DB;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;

    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');
        // bKash Merchant API Information

        // You can import it from your Database
        $bkash_app_key = env('BKASH_APP_KEY');
        $bkash_app_secret = env('BKASH_APP_SECRET');
        $bkash_username = env('BKASH_USERNAME');
        $bkash_password = env('BKASH_PASSWORD');
        $bkash_base_url = env('BKASH_BASE_URL');

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
    }

    public function prodTest() {
        return view('bkash.bkash-payment');
    }

    public function prodPaymentTest(Request $request) {
        return view('bkash.final-payment')->withAmount($request->amount);
    }

    public function prodPayment($amount, $mobile, $package_id) {
        return view('bkash.final-payment')
                            ->withAmount($amount)
                            ->withMobile($mobile)
                            ->withPackageid($package_id);
    }

    public function getToken(Request $request)
    {
        session()->forget('bkash_token');

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        $url = curl_init("$this->base_url/checkout/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);

        if (array_key_exists('msg', $response)) {
            return $response;
        }

        session()->put('bkash_token', $response['id_token']);

        return response()->json(['success', true]);
    }

    public function createPayment(Request $request)
    {
        // if (((string) $request->amount != (string) session()->get('bkash')['invoice_amount'])) {
        //     return response()->json([
        //         'errorMessage' => 'Amount Mismatch',
        //         'errorCode' => 2006
        //     ], 422);
        // }

        $token = session()->get('bkash_token');

        // $request['amount'] = '1.00';
        $request['intent'] = 'sale';
        $request['currency'] = 'BDT';
        $request['merchantInvoiceNumber'] = 'BCS' . random_string(10) . date('Ymd');

        $url = curl_init("$this->base_url/checkout/payment/create");
        $request_data_json = json_encode($request->all());
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function executePayment(Request $request)
    {
        $token = session()->get('bkash_token');

        $paymentID = $request->paymentID;
        $url = curl_init("$this->base_url/checkout/payment/execute/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function queryPayment(Request $request)
    {
        $token = session()->get('bkash_token');
        $paymentID = $request->payment_info['payment_id'];

        $url = curl_init("$this->base_url/checkout/payment/query/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function bkashSuccess(Request $request)
    {
        
        $user = User::where('mobile', $request->mobile)->first();
        
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->package_id = $request->package_id;
        $payment->uid = $user->uid;
        $payment->payment_status = 1;
        $payment->card_type = 'bKash';
        $payment->trx_id = $request->payment_info['trxID'];
        $payment->amount = $request->payment_info['amount'];
        $payment->store_amount = $request->payment_info['amount'] - ($request->payment_info['amount'] * 0.02);
        $payment->save();

        
        $current_package_date = Carbon::parse($user->package_expiry_date);
        $package = Package::findOrFail($request->package_id);
        if($current_package_date->greaterThanOrEqualTo(Carbon::now())) {
            $package_expiry_date = $current_package_date->addDays($package->numeric_duration)->format('Y-m-d') . ' 23:59:59';
        } else {
            $package_expiry_date = Carbon::now()->addDays($package->numeric_duration)->format('Y-m-d') . ' 23:59:59';
        }
        // dd($package_expiry_date);
        $user->package_expiry_date = $package_expiry_date;
        $user->save();
        return response()->json(['status' => true]);
        
    }

    public function bkashCancelPage()
    {
        return view('bkash.bkash-payment-cancel');
    }

    public function bkashSuccessPage()
    {
        return view('bkash.bkash-payment-success');
    }

    public function bkashFailedPage()
    {
        return view('bkash.bkash-payment-failed');
    }

    public function bkashCancelPageWeb()
    {
        Session::flash('info','পেমেন্টটি ক্যানসেল করা হয়েছে!');
        return redirect()->route('index.index');
    }

    public function bkashSuccessPageWeb()
    {
        Session::flash('swalsuccess', 'পেমেন্ট সফল হয়েছে। অ্যাপটি ব্যবহার করুন। ধন্যবাদ!');
            return redirect()->route('index.index');
    }

    public function bkashFailedPageWeb()
    {
        Session::flash('info','পেমেন্টটি ব্যর্থ হয়েছে! অনুগ্রহ করে যোগাযোগ করুন।');
        return redirect()->route('index.index');
    }
}