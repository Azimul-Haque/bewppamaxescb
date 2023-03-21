<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Balance;
use App\Site;
use App\Category;
use App\Expense;
use App\Creditor;
use App\Due;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
// use Redirect;
use OneSignal;

class ExpenseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth')->except('clear');
        $this->middleware('admin')->only('getTodaysExpenseList', 'getTodaysDepositList');
    }

    public function getTodaysExpenseList($transactiondate, $selecteduser)
    {
    	// DD(date('Y-m-d', strtotime($transactiondate)));

        $users = User::all();
        
        if($selecteduser == 'All') {
            $todaystotalexpense = DB::table('expenses')
                                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))
                                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                ->first();

            $expenses = Expense::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", $transactiondate)->get(); // paginate(10);
        } else {
            $todaystotalexpense = DB::table('expenses')
                                ->where('user_id', $selecteduser)
                                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))
                                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                ->first();

            $expenses = Expense::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", $transactiondate)
                               ->where('user_id', $selecteduser)
                               ->get(); // paginate(10);
        }
    	

        return view('expenses.todaystotalexpense')
                    ->withExpenses($expenses)
                    ->withTodaystotalexpense($todaystotalexpense)
                    ->withTransactiondate($transactiondate)
                    ->withUsers($users)
                    ->withSelecteduser($selecteduser);
    }

    public function getTodaysDepositList($transactiondate, $selecteduser)
    {
        // DD(date('Y-m-d', strtotime($transactiondate)));

        $users = User::all();
        
        if($selecteduser == 'All') {
            $todaystotaldeposit = DB::table('balances')
                                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))
                                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                ->first();

            $deposits = Balance::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))->get(); // paginate(10);
        } else {
            $todaystotaldeposit = DB::table('balances')
                                ->where('receiver_id', $selecteduser)
                                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))
                                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                ->first();

            $deposits = Balance::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", date('Y-m-d', strtotime($transactiondate)))
                               ->where('receiver_id', $selecteduser)
                               ->get(); // paginate(10);
        }
        

        return view('balances.todaystotaldeposit')
                    ->withDeposits($deposits)
                    ->withTodaystotaldeposit($todaystotaldeposit)
                    ->withTransactiondate($transactiondate)
                    ->withUsers($users)
                    ->withSelecteduser($selecteduser);
    }
}
