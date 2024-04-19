<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Package;
use App\Payment;
use App\Message;
use App\Notification;
use App\Exam;
use App\Blog;
use App\Blogcategory;
use App\Meritlist;

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
use Purifier;
use Cache;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth')->except('clear');
        $this->middleware(['admin'])->only('getUsers', 'storeUser', 'updateUser', 'deleteUser', 'getUser', 'deleteBalance', 'getCreditors', 'getSingleCreditor', 'getAddDuePage', 'deleteCreditorDue', 'getSiteCategorywise', 'getPackages', 'storePackage', 'updatePackage', 'deletePackage', 'getPayments', 'getMessages', 'updateMessage', 'getNotifications', 'sendSingleNotification', 'sendSingleSMS', 'getExamSolvePDF');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if user is a manager, redirect him to his profile
        // if user is a manager, redirect him to his profile
        if(Auth::user()->role == 'user') {
            abort(403, 'Access Denied');
        } elseif(Auth::user()->role == 'volunteer') {
            // echo 'ase';
            return redirect()->route('dashboard.questions.reported');
        }

        // $totalsites = Site::count();
        $totalusers = User::count();

        $totalexamsattendedtoday = Meritlist::whereDate('created_at', Carbon::today())->count();

        

        $totalpayment = Payment::sum('amount');
        // $totalbalance = Balance::sum('amount');
        // $totalexpense = Expense::sum('amount');

        $totalmonthlypayment = DB::table('payments')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                ->first();
        $last14daysusersdaily = DB::table('users')
                                    ->select('created_at', DB::raw('COUNT(*) as totalusers'))
                                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                    ->orderBy('created_at', 'DESC')
                                    ->take(14)
                                    ->get();
        $daysforchartc = [];
        foreach ($last14daysusersdaily as $key => $days) {
            $daysforchartc[] = date_format(date_create($days->created_at), "M d");
        }
        $daysforchartc = json_encode(array_reverse($daysforchartc));

        $totalusersforchartc = [];
        foreach ($last14daysusersdaily as $key => $days) {
            $totalusersforchartc[] = $days->totalusers;
        }
        $originalforcumulitive = array_reverse($totalusersforchartc);
        $totalusersforchartc = json_encode(array_reverse($totalusersforchartc));

        $totaluserscumulitiveforchartc = [];
        $cumulitiveusersprimary = 0;
        foreach ($originalforcumulitive as $totalusersforc) {
            $cumulitiveusersprimary += $totalusersforc;
            $totaluserscumulitiveforchartc[] = $cumulitiveusersprimary;
        }
        $totaluserscumulitiveforchartc = json_encode($totaluserscumulitiveforchartc);
        // dd($totaluserscumulitiveforchartc);

        return view('dashboard.index')->withTotalusers($totalusers)
                                      ->withTotalpayment($totalpayment)
                                      ->withTotalmonthlypayment($totalmonthlypayment)
                                      ->withTotalexamsattendedtoday($totalexamsattendedtoday)
                                      ->withDaysforchartc($daysforchartc)
                                      ->withTotalusersforchartc($totalusersforchartc)
                                      ->withTotaluserscumulitiveforchartc($totaluserscumulitiveforchartc);
                                    // ->withTotalbalance($totalbalance)
                                    // ->withTotalexpense($totalexpense)
                                    // ->withTodaystotalexpense($todaystotalexpense)
                                    // ->withTodaystotaldeposit($todaystotaldeposit);
    }

    public function clearQueryCache()
    {
        Cache::flush();
        Session::flash('success', 'সকল কোয়েরি ক্যাশ মুছে দেওয়া হয়েছে!');
        return redirect()->route('dashboard.index');
    }

    public function getUsers()
    {
        $userscount = User::count();
        $users = User::where('name', '!=', null)->orderBy('id', 'asc')->paginate(10);
        return view('dashboard.users.index')
                    ->withUsers($users)
                    ->withUserscount($userscount);
    }

    public function getUsersSort()
    {
        // $users = User::where('name', '!=', null)->orderBy('id', 'asc')->get(10);
        $userscount = User::count();
        $users = User::withCount('meritlists')
                     ->orderBy('meritlists_count', 'desc')
                     ->paginate(10);

        // dd($users);
        // $users = $users->join('meritlists', function ($join) {
        //                 $join->on('meritlists.user_id', '=', 'users.id');
        //             })
        //             ->groupBy('users.id')
        //             ->orderBy('count', $order)
        //             ->select((['users.*', DB::raw('COUNT(meritlists.user_id) as count')]))->paginate(10);

        return view('dashboard.users.index')
                    ->withUsers($users)
                    ->withUserscount($userscount);
    }

    public function getExpiredUsers()
    {
        $paidusersids = DB::table('payments')->select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
        // dd($paidusersids);
        $userscount = User::where('package_expiry_date', '<', Carbon::now())
                          ->whereIn('id', $paidusersids)
                          ->count();
        $users = User::where('package_expiry_date', '<', Carbon::now())
                     ->whereIn('id', $paidusersids)
                     ->orderBy('package_expiry_date', 'asc')
                     ->paginate(10);
                     // ->get();
        
        // dd($users);
        // $usermobiles = $users->pluck('mobile')->toArray();
        // dd(implode(', ', $usermobiles));
        return view('dashboard.users.expiredusers')
                    ->withUsers($users)
                    ->withUserscount($userscount);
    }

    public function sendExpiredSMS(Request $request)
    {
        $this->validate($request,array(
            'randtotalhidden'         => 'required',
            'randtotalvisible'        => 'required|string|max:191',
            'sms'                     => 'required|string',
        ));
        if($request->randtotalhidden == $request->randtotalvisible) {
            $paidusersids = DB::table('payments')->select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
            $users = User::select('name', 'mobile')
                         ->where('package_expiry_date', '<', Carbon::now())
                         ->whereIn('id', $paidusersids)
                         ->orderBy('package_expiry_date', 'asc')
                         ->get();
            
            foreach ($users as $user) {
                $mobile_number = 0;
                if(strlen($user->mobile) == 11) {
                    $mobile_number = $user->mobile;
                } elseif(strlen($user->mobile) > 11) {
                    if (strpos($user->mobile, '+') !== false) {
                        $mobile_number = substr($user->mobile, -11);
                    }
                }
                $numbersarray[] = $mobile_number;
            }
            $numbersstr = implode (",", $numbersarray);
            // dd($numbersstr);
            
            $url = config('sms.url');
            $number = $mobile_number;
            $text = $request->sms; // . ' Customs and VAT Co-operative Society (CVCS).';
            $data= array(
                'username'=>config('sms.username'),
                'password'=>config('sms.password'),
                'number'=>"$numbersstr",
                'message'=>"$text",
            );
            // initialize send status
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
            $smsresult = curl_exec($ch);

            // $sendstatus = $result = substr($smsresult, 0, 3);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];
            // send sms
            if($sendstatus == 1101) {
                Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
            } elseif($sendstatus == 1006) {
                Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
            } else {
                Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
            }
        } else {
            Session::flash('warning', 'অংক মেলেনি!');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function getUsersSearch($search)
    {
        $userscount = User::where('name', 'LIKE', "%$search%")
                          ->orWhere('email', 'LIKE', "%$search%")
                          ->orWhere('mobile', 'LIKE', "%$search%")
                          ->orWhere('uid', 'LIKE', "%$search%")
                          ->orWhere('onesignal_id', 'LIKE', "%$search%")
                          ->orderBy('id', 'desc')
                          ->count();
        $users = User::where('name', 'LIKE', "%$search%")
                     ->orWhere('email', 'LIKE', "%$search%")
                     ->orWhere('mobile', 'LIKE', "%$search%")
                     ->orWhere('uid', 'LIKE', "%$search%")
                     ->orWhere('onesignal_id', 'LIKE', "%$search%")
                     ->orderBy('id', 'desc')
                     ->paginate(10);

        // $sites = Site::all();
        return view('dashboard.users.index')
                    ->withUsers($users)
                    ->withUserscount($userscount);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        
        // dd($totaldeposit);

        return view('dashboard.users.single')
                    ->withUser($user);
    }

    public function getUserWithOtherPage($id)
    {
        $user = User::find($id);

        // dd($totalexpense);

        return view('dashboard.users.singleother')
                    ->withUser($user);
    }

    public function storeUser(Request $request)
    {
        // dd(serialize($request->sitecheck));
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
            'mobile'      => 'required|string|max:191|unique:users,mobile',
            'role'        => 'required',
            // 'sitecheck'   => 'sometimes',
            'password'    => 'required|string|min:8|max:191',
        ));

        $user = new User;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->role = $request->role;
        // if(!empty($request->sitecheck)) {
        //     $user->sites = implode(',', $request->sitecheck);
        // }
        $user->password = Hash::make($request->password);
        $user->save();

        Session::flash('success', 'User created successfully!');
        return redirect()->route('dashboard.users');
    }

    public function updateUser(Request $request, $id)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
            'mobile'      => 'required|string|max:191|unique:users,mobile,'.$id,
            'role'        => 'required',
            'packageexpirydate'        => 'required',
            'uid'        => 'sometimes',
            'onesignal_id'        => 'sometimes',
            // 'sitecheck'   => 'sometimes',
            'password'    => 'nullable|string|min:8|max:191',
        ));

        $user = User::find($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->role = $request->role;
        $user->package_expiry_date = date('Y-m-d', strtotime($request->packageexpirydate)) . ' 23:59:59';
        // if(!empty($request->sitecheck)) {
        //     $user->sites = implode(',', $request->sitecheck);
        // }
        $user->uid = $request->uid;
        $user->onesignal_id = $request->onesignal_id;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        Session::flash('success', 'User updated successfully!');
        return redirect()->route('dashboard.users');
    }

    public function updateBulkPackageDate(Request $request)
    {
        $this->validate($request,array(
            'numbers'                      => 'required',
            'packageexpirydatebulk'        => 'required',
        ));

        $numbersarray = explode(',', $request->numbers);

        $counter = 0;
        foreach($numbersarray as $number) {
            $user = User::where('mobile', 'LIKE', '%' . $number . '%')->first();
            if($user) {
                $user->package_expiry_date = date('Y-m-d', strtotime($request->packageexpirydatebulk)) . ' 23:59:59';
                $user->save();
                $counter++;
            }
        }

        Session::flash('success', $counter . ' Users updated successfully!');
        return redirect()->route('dashboard.users');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        Session::flash('success', 'User deleted successfully!');
        return redirect()->route('dashboard.users');
    }

    public function getPackages()
    {
        $packages = Package::all();
        
        return view('dashboard.packages.index')->withPackages($packages);
    }

    public function getPayments()
    {
        $payments = Payment::orderBy('id', 'desc')->paginate(15);
        
        return view('dashboard.payments.index')->withPayments($payments);
    }

    public function getPaymentsSearch($search)
    {
        $payments = Payment::where('trx_id', 'LIKE', "%$search%")->orWhereHas('User', function($q) use ($search){
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere('mobile', 'like', '%' . $search . '%');
                        $q->orWhere('amount', 'like', '%' . $search . '%');
                        $q->orWhere('store_amount', 'like', '%' . $search . '%');
                        $q->orWhere('trx_id', 'like', '%' . $search . '%');
                    })->paginate(15);

        return view('dashboard.payments.index')->withPayments($payments);
    }

    public function storePackage(Request $request)
    {
        $this->validate($request,array(
            'name'                    => 'required|string|max:191',
            'tagline'                 => 'required|string|max:191',
            'duration'                => 'required|string|max:191',
            'numeric_duration'        => 'required|integer',
            'price'                   => 'required|integer',
            'strike_price'            => 'required|integer',
            'status'                  => 'required',
            'suggested'               => 'required',
        ));

        $package = new Package;
        $package->name = $request->name;
        $package->tagline = $request->tagline;
        $package->duration = $request->duration;
        $package->numeric_duration = $request->numeric_duration;
        $package->price = $request->price;
        $package->strike_price = $request->strike_price;
        $package->status = $request->status;
        $package->suggested = $request->suggested;
        $package->save();

        Session::flash('success', 'Package added successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function updatePackage(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                    => 'required|string|max:191',
            'tagline'                 => 'required|string|max:191',
            'duration'                => 'required|string|max:191',
            'numeric_duration'        => 'required|integer',
            'price'                   => 'required|integer',
            'strike_price'            => 'required|integer',
            'status'                  => 'required',
            'suggested'               => 'required',
        ));

        $package = Package::findOrFail($id);
        $package->name = $request->name;
        $package->tagline = $request->tagline;
        $package->duration = $request->duration;
        $package->numeric_duration = $request->numeric_duration;
        $package->price = $request->price;
        $package->strike_price = $request->strike_price;
        $package->status = $request->status;
        $package->suggested = $request->suggested;
        $package->save();

        Session::flash('success', 'Package updated successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function deletePackage($id)
    {
        $package = Package::find($id);
        $package->delete();

        Session::flash('success', 'Package deleted successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function getBalance()
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')) {
            abort(403, 'Access Denied');
        }
        $users = User::whereNotIn('mobile', ['01751398392', '01837409842'])->get();
        $totalbalance = Balance::sum('amount');
        $totalexpense = Expense::sum('amount');

        $balances = Balance::where('amount', '>', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(5);

        return view('balances.index')
                    ->withUsers($users)
                    ->withBalances($balances)
                    ->withTotalbalance($totalbalance)
                    ->withTotalexpense($totalexpense);
    }

    public function storeBalance(Request $request)
    {
        $this->validate($request,array(
            'amount'         => 'required|integer',
            'medium'         => 'sometimes|max:50',
            'description'    => 'sometimes|max:50'
        ));

        $balance = new Balance;
        $balance->user_id = Auth::user()->id;
        $balance->receiver_id = $request->receiver_id;
        $balance->amount = $request->amount;
        $balance->medium = $request->medium;
        $balance->description = $request->description;
        $balance->save();

        $receiver = User::findOrFail($request->receiver_id);

        if(Auth::user()->role == 'accountant') {
            OneSignal::sendNotificationToUser(
                "অর্থ প্রদানকারীঃ একাউন্টেন্ট, গ্রহণকারীঃ " . $receiver->name,
                ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
                $url = null, 
                $data = null, // array("answer" => $charioteer->answer), // to send some variable
                $buttons = null, 
                $schedule = null,
                $headings = "অর্থ প্রদান করা হয়েছে। পরিমাণঃ ৳ " . bangla($request->amount)
            );
        }

        // OneSignal::sendNotificationToAll(
        //     "অর্থ যোগ করেছেনঃ " . Auth::user()->name,
        //     $url = null, 
        //     $data = null, // array("answer" => $charioteer->answer), // to send some variable
        //     $buttons = null, 
        //     $schedule = null,
        //     $headings = "৳ " . bangla($request->amount) . " যোগ করা হয়েছে!"
        // );

        Session::flash('success', 'Amount added successfully!');
        return redirect()->route('dashboard.balance');
    }

    public function deleteBalance($id)
    {
        $balance = Balance::find($id);
        $balance->delete();

        Session::flash('success', 'Amount deleted successfully!');
        return redirect()->route('dashboard.balance');
    }

    public function getSites()
    {
        $sites = Site::where('name', '!=', null)
                     ->orderBy('progress', 'asc')
                     ->paginate(5);

        return view('sites.index')->withSites($sites);
    }

    public function storeSite(Request $request)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191',
            'address'      => 'required|string|max:191',
            'progress'     => 'required|integer'
        ));

        $site = new Site;
        $site->name = $request->name;
        $site->address = $request->address;
        $site->progress = $request->progress;
        $site->save();

        Session::flash('success', 'Site created successfully!');
        return redirect()->route('dashboard.sites');
    }

    public function updateSite(Request $request, $id)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191',
            'address'      => 'required|string|max:191',
            'progress'     => 'required|integer'
        ));

        $site = Site::find($id);
        $site->name = $request->name;
        $site->address = $request->address;
        $site->progress = $request->progress;
        $site->save();

        Session::flash('success', 'Site updated successfully!');
        return redirect()->route('dashboard.sites');
    }

    public function deleteSite(Request $request, $id)
    {
        $this->validate($request,array(
            'contact_sum_result_hidden'   => 'required',
            'contact_sum_result'   => 'required'
        ));

        if($request->contact_sum_result_hidden == $request->contact_sum_result) {
            $site = Site::find($id);

            foreach ($site->expenses as $expense) {
                $expense->delete();
            }
            $site->delete();

            Session::flash('success', 'Site deleted successfully!');
            return redirect()->route('dashboard.sites');
        } else {
            Session::flash('warning', 'যোগফল সঠিক নয়, আবার চেষ্টা করুন।');
            return redirect()->route('dashboard.sites');
        }
    }

    public function getSingleSite($id)
    {
        if(Auth::user()->role == 'manager') {
            $sitesarray = explode(',', Auth::user()->sites);
            // dd($sitesarray);
            if(!in_array($id, $sitesarray)) {
                abort(403);
            } 
        }
        $site = Site::find($id);
        $expenses = Expense::where('site_id', $id)->orderBy('id', 'desc')->paginate(10);
        $categories = Category::orderBy('id', 'desc')->get();
        $todaytotalcurrent = DB::table('expenses')
                               ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                               ->where('site_id', $id)
                               ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), "=", Carbon::now()->format('Y-m-d'))
                               ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                               ->first();
        $monthlyexpensetotalcurrent = DB::table('expenses')
                                        ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as created_at"), DB::raw('SUM(amount) as totalamount'))
                                        ->where('site_id', $id)
                                        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                        ->first();

        $monthlyexpenses = DB::table('expenses')
                             ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as created_at"), DB::raw('SUM(amount) as totalamount'))
                             ->where('site_id', $id)
                             ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                             ->orderBy('created_at', 'DESC')
                             ->get();

        $intotalexpense = DB::table('expenses')
                             ->select(DB::raw('SUM(amount) as totalamount'))
                             ->where('site_id', $id)
                             ->orderBy('created_at', 'DESC')
                             ->first();

        $totalbalance = Balance::where('receiver_id', Auth::user()->id)->sum('amount'); // to calculate user balance
        $totalexpense = Expense::where('user_id', Auth::user()->id)->sum('amount'); // to calculate user balance

        // dd($monthlyexpensetotal);
        return view('sites.single')
                    ->withSite($site)
                    ->withExpenses($expenses)
                    ->withCategories($categories)
                    ->withTodaytotalcurrent($todaytotalcurrent)
                    ->withMonthlyexpensetotalcurrent($monthlyexpensetotalcurrent)
                    ->withMonthlyexpenses($monthlyexpenses)
                    ->withTotalbalance($totalbalance)
                    ->withTotalexpense($totalexpense)
                    ->withIntotalexpense($intotalexpense);
    }

    public function getSiteCategorywise($id)
    {
        $site = Site::find($id);
        $categories = Category::orderBy('id', 'desc')->get();
        $categorywises = DB::table('expenses')
                          ->select('category_id', DB::raw('SUM(amount) as totalamount'))
                          ->where('site_id', $id)
                          ->groupBy('category_id')
                          ->get();
        $intotalexpense = DB::table('expenses')
                             ->select(DB::raw('SUM(amount) as totalamount'))
                             ->where('site_id', $id)
                             ->orderBy('created_at', 'DESC')
                             ->first();
        // dd($categorywise);
        return view('sites.categorywise')
                    ->withSite($site)
                    ->withCategories($categories)
                    ->withCategorywises($categorywises)
                    ->withIntotalexpense($intotalexpense);
    }

    public function getExpensePage()
    {
        $sites = Site::orderBy('id', 'desc')->get();
        $categories = Category::orderBy('id', 'desc')->get();
        
        $totalbalance = Balance::where('receiver_id', Auth::user()->id)->sum('amount');
        $totalexpense = Expense::where('user_id', Auth::user()->id)->sum('amount');

        return view('sites.expense')
                    ->withSites($sites)
                    ->withCategories($categories)
                    ->withTotalbalance($totalbalance)
                    ->withTotalexpense($totalexpense);
    }

    public function storeExpense(Request $request)
    {
        $this->validate($request,array(
            'site_data'       => 'required',
            'category_data'   => 'required',
            'amount'          => 'required|integer',
            'qty'             => 'sometimes',
            'description'     => 'sometimes',
            'image'           => 'sometimes|image|mimes:jpeg,bmp,png'
        ));

        // dd($request->all());
        // parse data
        $site_data = explode(',', $request->site_data);
        $category_data = explode(',', $request->category_data);

        $expense = new Expense;
        $expense->user_id = Auth::user()->id;
        $expense->site_id = $site_data[0];
        $expense->category_id = $category_data[0];
        $expense->amount = $request->amount;
        $expense->qty = $request->qty;
        $expense->description = $request->description;

        // upload image
        if($request->hasFile('image')) {
            $receipt      = $request->file('image');
            $filename   = Auth::user()->id.'_receipt_' . time() .'.' . $receipt->getClientOriginalExtension();
            $location   = public_path('/images/expenses/'. $filename);
            Image::make($receipt)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $expense->image = $filename;
        }
        // upload image

        $expense->save();

        OneSignal::sendNotificationToUser(
            "ব্যয় করেছেনঃ " . Auth::user()->name . ', খাতঃ ' . $category_data[1],
            ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
            $url = null, 
            $data = null, // array("answer" => $charioteer->answer), // to send some variable
            $buttons = null, 
            $schedule = null,
            $headings = $site_data[1] ."-এ ৳ " . bangla($request->amount) . " ব্যয় করা হয়েছে!"
        );

        // OneSignal::sendNotificationToUser(
        //     "Test",
        //     ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
        //     $url = null, 
        //     $data = null, // array("answer" => $charioteer->answer), // to send some variable
        //     $buttons = null, 
        //     $schedule = null,
        //     $headings = "Test 2"
        // );

        Session::flash('success', 'Expense added successfully!');
        return redirect()->route('dashboard.sites.single', $site_data[0]);
    }

    public function deleteExpense($id)
    {
        $expense = Expense::find($id);
        $image_path = public_path('images/expenses/'. $expense->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $expense->delete();

        Session::flash('success', 'Expense deleted successfully!');
        return redirect()->route('dashboard.sites.single', $expense->site_id);
    }

    public function getCategories()
    {
        $categories = Category::where('name', '!=', null)
                              ->orderBy('id', 'desc')
                              ->paginate(10);
        return view('sites.categories')->withCategories($categories);
    }

    public function getSingleCategory($id)
    {
        $category = Category::findOrFail($id);

        $expenses = DB::table('expenses')
                      ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('SUM(amount) as totalamount'))
                      ->where('category_id', $id)
                      ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        // dd($expenses);

        return view('sites.singlecategory')
                            ->withExpenses($expenses)
                            ->withCategory($category);
    }

    public function getSingleCategoryDate($id, $selecteddate)
    {
        $category = Category::findOrFail($id);

        $expenses = Expense::select('site_id', DB::raw('SUM(amount) as totalamount'))
                      ->where('category_id', $id)
                      ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), $selecteddate)
                      ->groupBy('site_id')
                      ->get();
        // dd($expenses);

        return view('sites.singlecategorydate')
                            ->withExpenses($expenses)
                            ->withCategory($category)
                            ->withSelecteddate($selecteddate);
    }    

    public function getSingleCategoryDateSite($id, $selecteddate, $site_id)
    {
        $category = Category::findOrFail($id);
        $site = Site::findOrFail($site_id);

        $expenses = Expense::where('category_id', $id)
                           ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), $selecteddate)
                           ->where('site_id', $site_id)
                           ->get();
        // dd($expenses);

        return view('sites.singlecategorydatesite')
                            ->withExpenses($expenses)
                            ->withCategory($category)
                            ->withSite($site)
                            ->withSelecteddate($selecteddate);
    }

    public function storeCategory(Request $request)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191'
        ));

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        Session::flash('success', 'Category created successfully!');
        return redirect()->route('dashboard.categories');
    }

    public function updateCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191'
        ));

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        Session::flash('success', 'Category updated successfully!');
        return redirect()->route('dashboard.categories');
    }

    public function getMonthly()
    {
        $monthlyexpenses = DB::table('expenses')
                             ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as created_at"), DB::raw('SUM(amount) as totalamount'))
                             ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                             ->orderBy('created_at', 'DESC')
                             ->paginate(10);
        $intotalexpense = DB::table('expenses')
                             ->select(DB::raw('SUM(amount) as totalamount'))
                             ->orderBy('created_at', 'DESC')
                             ->first();

        return view('monthly.index')
                        ->withMonthlyexpenses($monthlyexpenses)
                        ->withIntotalexpense($intotalexpense);
    }

    public function getCreditors()
    {
        $creditors = Creditor::orderBy('id', 'desc')->paginate(10);

        return view('creditors.index')->withCreditors($creditors);
    }

    public function getSingleCreditor($id)
    {
        $creditor = Creditor::find($id);
        $dues = Due::where('creditor_id', $id)
                   ->orderBy('id', 'desc')
                   ->paginate(10);
        return view('creditors.single')
                    ->withCreditor($creditor)
                    ->withDues($dues);
    }

    public function storeCreditor(Request $request)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191'
        ));

        $creditor = new Creditor;
        $creditor->name = $request->name;
        $creditor->save();

        Session::flash('success', 'Creditor created successfully!');
        return redirect()->route('dashboard.creditors');
    }

    public function updateCreditor(Request $request, $id)
    {
        $this->validate($request,array(
            'name'         => 'required|string|max:191'
        ));

        $creditor = Creditor::find($id);
        $creditor->name = $request->name;
        $creditor->save();

        Session::flash('success', 'Creditor updated successfully!');
        return redirect()->route('dashboard.creditors');
    }

    public function getAddDuePage()
    {
        $creditors = Creditor::orderBy('id', 'desc')->get();

        return view('creditors.adddue')->withCreditors($creditors);
    }

    public function storeCreditorDue(Request $request)
    {
        $this->validate($request,array(
            'creditor_id'           => 'required',
            'description'           => 'sometimes',
            'amount'                => 'required|integer'
        ));

        $due = new Due;
        $due->creditor_id = $request->creditor_id;
        $due->description = $request->description;
        $due->amount = $request->amount;
        $due->save();

        Session::flash('success', 'Due added successfully!');
        return redirect()->route('dashboard.creditors.single', $request->creditor_id);
    }

    public function updateCreditorDue(Request $request, $id)
    {
        $this->validate($request,array(
            'description'           => 'sometimes',
            'amount'                => 'required|integer'
        ));

        $due = Due::find($id);
        $due->description = $request->description;
        $due->amount = $request->amount;
        $due->save();

        Session::flash('success', 'Due updated successfully!');
        return redirect()->route('dashboard.creditors.single', $due->creditor_id);
    }

    public function deleteCreditorDue($id)
    {
        $due = Due::find($id);
        $due->delete();

        Session::flash('success', 'Due deleted successfully!');
        return redirect()->route('dashboard.creditors.single', $due->creditor_id);
    }

    public function getMessages()
    {
        $messages = Message::orderBy('id', 'desc')->paginate(12);

        return view('dashboard.messages.index')->withMessages($messages);
    }

    public function updateMessage(Request $request, $id)
    {
        $message = Message::find($id);
        $message->status = 1;
        $message->save();

        Session::flash('success', 'Message updated successfully!');
        return redirect()->route('dashboard.messages');
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);
        $message->delete();

        Session::flash('success', 'Message deleted successfully!');
        return redirect()->route('dashboard.messages');
    }

    public function sendSingleNotification(Request $request, $id)
    {
        $user = User::find($id);
        if($user->onesignal_id !=null) {
            OneSignal::sendNotificationToUser(
                $request->message,
                $user->onesignal_id,
                $url = null, 
                $data = null,
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );  

            Session::flash('success', 'Notification sent successfully!');
            return redirect()->route('dashboard.users');
        } else {
            Session::flash('warning', 'OneSignal ID নেই');
            return redirect()->route('dashboard.users');
        }
    }

    public function sendSingleSMS(Request $request, $id)
    {
        $this->validate($request,array(
            'message'           => 'required',
        ));

        $user = User::find($id);

        // send sms
        $mobile_number = 0;
        if(strlen($user->mobile) == 11) {
            $mobile_number = $user->mobile;
        } elseif(strlen($user->mobile) > 11) {
            if (strpos($user->mobile, '+') !== false) {
                $mobile_number = substr($user->mobile, -11);
            }
        }

        // $url = config('sms.url');
        // $number = $mobile_number;
        // $text = $request->message;

        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $request->message;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL
        
        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     'number'=>"$number",
        //     'message'=>"$text",
        // );

        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // $smsresult = curl_exec($ch);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];
        // // dd($smsresult);
        // // send sms
        // if($sendstatus == 1101) {
        //     Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        // }

        return redirect()->back();
    }

    public function getNotifications()
    {
        $notifications = Notification::orderBy('id', 'desc')->paginate(12);

        return view('dashboard.notifications.index')->withNotifications($notifications);
    }

    public function sendNotification(Request $request)
    {
        $this->validate($request,array(
            'type'         => 'required',
            'headings'     => 'required',
            'message'      => 'required',
        ));

        if($request->type == 'premium') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'equal', 'value' => 'Premium']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'free') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'not_exists']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'all') {
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'update') {
            // LIVE HOILE ETA DEOA HOBE
            // LIVE HOILE ETA DEOA HOBE
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = array("a" => 'update'),
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );

            // OneSignal::sendNotificationToUser(
            //     $request->message,
            //     ['716ffeb3-f6c2-4a4a-a253-710f339aa863'],
            //     $url = null, 
            //     $data = array("a" => 'update'),
            //     $buttons = null, 
            //     $schedule = null,
            //     $headings = $request->headings,
            // );
        }

        $notification = new Notification;
        $notification->type = $request->type;
        $notification->headings = $request->headings;
        $notification->message = $request->message;
        $notification->save();

        Session::flash('success', 'নোটিফিকেশন সফলভাবে পাঠানো হয়েছে!');
        return redirect()->route('dashboard.notifications');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        $notification->delete();

        Session::flash('success', 'Notification deleted successfully!');
        return redirect()->route('dashboard.notifications');
    }

    public function sendAgainNotification(Request $request)
    {
        $this->validate($request,array(
            'type'         => 'required',
            'headings'     => 'required',
            'message'      => 'required',
        ));

        if($request->type == 'premium') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'equal', 'value' => 'Premium']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'free') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'not_exists']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'all') {
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'update') {
            // LIVE HOILE ETA DEOA HOBE
            // LIVE HOILE ETA DEOA HOBE
            // OneSignal::sendNotificationToAll(
            //     $request->message,
            //     $url = null, 
            //     $data = array("a" => 'update'),
            //     $buttons = null, 
            //     $schedule = null,
            //     $headings = $request->headings,
            // );
            
            OneSignal::sendNotificationToUser(
                $request->message,
                ['716ffeb3-f6c2-4a4a-a253-710f339aa863'],
                $url = null, 
                $data = array("a" => 'update'),
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        }

        $notification = new Notification;
        $notification->type = $request->type;
        $notification->headings = $request->headings;
        $notification->message = $request->message;
        $notification->save();

        Session::flash('success', 'নোটিফিকেশন সফলভাবে পাঠানো হয়েছে!');
        return redirect()->route('dashboard.notifications');
    }

    // test html question data
    // public function getExamSolvePDF($softtoken, $examid)
    // {
    //     if($softtoken == env('SOFT_TOKEN'))
    //     {
    //         $exam = Exam::findOrFail($examid);

    //         return view('index.pdf.test')->withExam($exam);

    //         $pdf = PDF::loadView('index.pdf.examsolvepdf', ['exam' => $exam]);
    //         $fileName = 'Single-Exam-Solve-Sheet-' . $exam->id . '.pdf';
    //         return $pdf->stream($fileName); // download/stream
    //     } else {
    //         return response()->json([
    //             'success' => false
    //         ]);
    //     }
    // }


    public function getBlogs()
    {
        $totalblogs = Blog::count();
        $blogs = Blog::orderBy('id', 'desc')->paginate(10);
        $blogcategories = Blogcategory::orderBy('id', 'asc')->get();

        // dd($questions);
        return view('dashboard.blogs.index')
                    ->withBlogs($blogs)
                    ->withBlogcategories($blogcategories)
                    ->withTotalblogs($totalblogs);
    }

    public function getBlogsSearch($search)
    {
        
        $totalblogs = Blog::where('title', 'LIKE', "%$search%")->count();
        $blogs = Blog::where('title', 'LIKE', "%$search%")
                             ->orWhere('body', 'LIKE', "%$search%")
                             ->orWhere('slug', 'LIKE', "%$search%")
                             ->orderBy('id', 'desc')
                             ->paginate(10);
        $blogcategories = Blogcategory::orderBy('id', 'asc')->get();

        Session::flash('success', $totalblogs . ' টি ব্লগ পাওয়া গিয়েছে!');
        return view('dashboard.blogs.index')
                    ->withBlogs($blogs)
                    ->withBlogcategories($blogcategories)
                    ->withTotalblogs($totalblogs);
    }

    

    public function storeBlog(Request $request)
    {
        $this->validate($request,array(
            'title'          => 'required|max:255|unique:blogs,title',
            'slug'           => 'sometimes|max:255|unique:blogs,slug',
            'body'           => 'required',
            'blogcategory_id'    => 'required|integer',
            'featured_image'  => 'sometimes|image|max:300'
        ));

        //store to DB
        $blog              = new Blog();
        $blog->title       = $request->title;
        $blog->user_id     = Auth::user()->id;
        // dd($request->slug);
        if(isset($request->slug)) {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        } else {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->title)) . '-' .time();
        }
        $blog->blogcategory_id = $request->blogcategory_id;
        $blog->body        = Purifier::clean($request->body, 'youtube');
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '_',$request->slug).time() .'.' . "webp";
            $location   = public_path('images/blogs/'. $filename);
            Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $blog->featured_image = $filename;
        }

        $blog->save();

        Session::flash('success', 'Blog created successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $this->validate($request,array(
            'title'          => 'required|max:255',
            'slug'           => 'required|max:255|unique:blogs,slug,'.$blog->id,
            'body'           => 'required',
            'blogcategory_id'    => 'required|integer',
            'featured_image' => 'sometimes|image|max:300'
        ));

        //update to DB
        $blog->title       = $request->title;
        // $blog->user_id     = Auth::user()->id;
        if($blog->slug == $request->slug) {

        } else {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        }
        $blog->blogcategory_id = $request->blogcategory_id;
        // $blog->body        = Purifier::clean($request->body, 'youtube');
        $blog->body        = $request->body;
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image_path = public_path('images/blogs/'. $blog->featured_image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug)) . '-' .time() . '.' . "webp";
            $location   = public_path('images/blogs/'. $filename);
            // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($image)->fit(600, 315)->save($location);
            $blog->featured_image = $filename;
        }

        $blog->save();

        Session::flash('success', 'Article updated successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);

        $image_path = public_path('images/blogs/'. $blog->featured_image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $blog->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function storeBlogCategory(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
        ));

        $blogcategory = new Blogcategory;
        $blogcategory->name = $request->name;
        $blogcategory->save();

        Session::flash('success', 'Blog Category created successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function updateBlogCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name' => 'required|string|max:191',
        ));

        $blogcategory = Blogcategory::find($id);;
        $blogcategory->name = $request->name;
        $blogcategory->save();

        Session::flash('success', 'Blog Category updated successfully!');
        return redirect()->route('dashboard.blogs');
    }


    

    public function getComponents()
    {
        return view('components');
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('route:clear');
        // Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Artisan::call('config:clear');
        Session::flush();
        return 'Config and Route Cached. All Cache Cleared';
    }
}
