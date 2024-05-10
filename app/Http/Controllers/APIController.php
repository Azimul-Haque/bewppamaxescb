<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\userRepository;

use App\User;
use App\Userotp;
use App\Examcategory;
use App\Question;
use App\Course;
use App\Courseexam;
use App\Exam;
use App\Examquestion;
use App\Topic;
use App\Package;
use App\Temppayment;
use App\Message;
use App\Material;
use App\Meritlist;
use App\Reportedquestion;

use Hash;
use Carbon\Carbon;
use DB;
use OneSignal;
use Cache;

class APIController extends Controller
{
    public function test()
    {
        
    } 

    public function generateOTP(Request $request)
    {
        $this->validate($request,array(
            'mobile'         => 'required',
            'softtoken'      => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN')) {

            $pool = '0123456789';
            $otp = substr(str_shuffle(str_repeat($pool, 4)), 0, 4);

            $mobile_number = 0;
            if(strlen($request->mobile) == 11) {
                $mobile_number = $request->mobile;
            } elseif(strlen($request->mobile) > 11) {
                if (strpos($request->mobile, '+') !== false) {
                    $mobile_number = substr($request->mobile, -11);
                }
            }

            // SPAM PREVENTION Layer 1
            $triedlastfivedays = Userotp::where('mobile', $mobile_number)
                                        ->where('created_at', '>=', Carbon::now()->subDays(5)->toDateTimeString())
                                        ->count();

            if($triedlastfivedays < 2) {
                // SPAM PREVENTION Layer 1
                $triedlasttwentyminutes = Userotp::where('mobile', $mobile_number)
                                        ->where('created_at', '>=', Carbon::now()->subMinutes(20)->toDateTimeString())
                                        ->count();

                if($triedlasttwentyminutes < 1) {
                    // FOR PLAY CONSOLE TESTING PURPOSE
                    // FOR PLAY CONSOLE TESTING PURPOSE
                    if($mobile_number == '01751398392') {
                       $otp = env('SMS_GATEWAY_PLAY_CONSOLE_TEST_OTP');
                    }

                    // TEXT MESSAGE OTP
                    // TEXT MESSAGE OTP

                    // NEW PANEL
                    $url = config('sms.url2');
                    $api_key = config('sms.api_key');
                    $senderid = config('sms.senderid');
                    $number = $mobile_number;
                    $message = $otp . ' is your pin for BCS Exam Aid App.';

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
                        // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                    } elseif($jsonresponse->response_code == 1007) {
                        // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                    } else {
                        // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                    }


                    // $url = config('sms.url');
                    // $number = $mobile_number;
                    // $text = $otp . ' is your pin for BCS Exam Aid App.';

                    // $data= array(
                    //    'username'=>config('sms.username'),
                    //    'password'=>config('sms.password'),
                    //    'number'=>"$number",
                    //    'message'=>"$text",
                    // );

                    // initialize send status
                    // $ch = curl_init(); // Initialize cURL
                    // curl_setopt($ch, CURLOPT_URL,$url);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
                    // $smsresult = curl_exec($ch);
                    // $p = explode("|",$smsresult);
                    // $sendstatus = $p[0];
                    // dd($smsresult);
                    // send sms
                    // if($sendstatus == 1101) {
                    //    // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                    // } elseif($sendstatus == 1006) {
                    //    // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                    // } else {
                    //    // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                    // }

                    // Userotp::where('mobile', $number)->delete(); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...

                    $newOTP = new Userotp();
                    $newOTP->mobile = $number;
                    $newOTP->otp = $otp;
                    $newOTP->save();

                    return $otp; 
                } else {
                    return 'Requested within 5 minutes!';
                }
                // SPAM PREVENTION Layer 2
            } else {
                return 'Requested too many times!';
            }
            // SPAM PREVENTION Layer 1
            
        } else {
            return 'Invalid Soft Token';
        }
    }

    public function loginOrCreate(Request $request)
    {    
        $user = User::where('mobile', $request['mobile'])->first();
        $userotp = Userotp::where('mobile', $request['mobile'])
                          ->orderBy('id', 'DESC')
                          ->first(); // latest টা নেওয়া হচ্ছে, এটাকার প্রিভেন্ট করার জন্য OTP ডিলেট ক্রতেসি না...
        if($userotp->otp == $request['otp']) {
            if ($user) {
                // $user->is_verified = 1;
                // $user->save();
                // $this->deleteOTP($request['mobile']); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...
                // $userTokenHandler = new UserTokenHandler();
                // $user = $userTokenHandler->regenerateUserToken($user);
                // $user->load('roles');
                $userdata = [
                    'success' => true,
                    'user' => $user,
                    'message' => 'লগইন সফল হয়েছে!',
                ];
                // if($user && Hash::check($request['password'], $user->password)){
                //     $userTokenHandler = new UserTokenHandler();
                //     $user = $userTokenHandler->regenerateUserToken($user);
                //     $user->load('roles');
                //     return $user;
                // }
            } else {
                $newUser = new User();
                DB::beginTransaction();
                try {
                    $newUser->uid = $request['mobile'];
                    $newUser->mobile = $request['mobile'];
                    $newUser->name = 'No Name';
                    $package_expiry_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';
                    $newUser->package_expiry_date = $package_expiry_date;
                    $newUser->role = 'user';
                    $newUser->password = Hash::make('secret123');
                    $newUser->save();
                } catch (\Exception $e) {
                    DB::rollBack();
                    // throw new \Exception($e->getMessage());
                    $userdata = [
                        'success' => false,
                        'message' => 'দুঃখিত! আবার চেষ্টা করুন।',
                    ];
                }
                DB::commit();
                $user = User::where('mobile', $request['mobile'])->first();
                $user->save();
                // $this->deleteOTP($request['mobile']); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...
                $userdata = [
                    'success' => true,
                    'user' => $user,
                    'message' => 'রেজিস্ট্রেশন সফল হয়েছে!',
                ];
            }
        }  else {
            $userdata = [
                'success' => false,
                'message' => 'সঠিক OTP প্রদান করুন!',
            ];
            // throw new \Exception('Invalid OTP');
        }

        if ($userdata) {
            return response()->json($userdata, 200);
        } else {
            return response()->json(['message' => 'Invalild Credentials'], 401);
        }
        return null;
    }

    public function deleteOTP($mobile)
    {
        Userotp::where('mobile', $mobile)->delete();
    }

    public function checkUid($softtoken, $phonenumber)
    {
        $user = User::where('mobile', substr($phonenumber, -11))->first();

        if($user && $softtoken == env('SOFT_TOKEN'))
        {
            return response()->json([
                'success' => true,
                'uid' => $user->uid,
                'name' => $user->name,
                'mobile' => $user->mobile,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function checkPackageValidity($softtoken, $phonenumber)
    {
        $user = User::where('mobile', substr($phonenumber, -11))->first();

        if($user && $softtoken == env('SOFT_TOKEN'))
        {
            return response()->json([
                'success' => true,
                'package_expiry_date' => date('Y-m-d H:i:s', strtotime($user->package_expiry_date)),
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function addUser(Request $request)
    {
        $this->validate($request,array(
            'uid'         => 'required|max:191|unique:users,uid',
            'name'        => 'required|max:191',
            'mobile'      => 'required|max:191',
            'onesignal_id'      => 'sometimes|max:191',
            'softtoken'   => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN'))
        {
            $user = new User;
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $package_expiry_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';
            // dd($package_expiry_date);
            $user->package_expiry_date = $package_expiry_date;
            $user->name = $request->name;
            $user->role = 'user';
            $user->mobile = substr($request->mobile, -11);
            $user->password = Hash::make('12345678');
            $user->save();
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function addOneSignalData(Request $request)
    {
        $this->validate($request,array(
            'uid'         => 'required',
            'mobile'      => 'required|max:191',
            'onesignal_id'      => 'sometimes|max:191',
            'softtoken'   => 'required|max:191'
        ));

        $user = User::where('mobile', $request->mobile)->first();

        if($user && $request->softtoken == env('SOFT_TOKEN'))
        {
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $user->save();
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function updateUser(Request $request)
    {
        $this->validate($request,array(
            'mobile'         => 'required',
            'uid'         => 'required',
            'onesignal_id'         => 'sometimes',
            'name'        => 'required|max:191',
            'softtoken'   => 'required|max:191'
        ));
        // DB::beginTransaction();
        $user = User::where('mobile', $request->mobile)->first();

        if($user && $request->softtoken == env('SOFT_TOKEN'))
        {

            $user->name = $request->name;
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $user->save();
            // DB::commit();
            return response()->json([
                'success' => true
            ]); 
        } else {
            // DB::commit();
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getCourses($softtoken, $coursetype)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $courses = Cache::remember('courses'.$coursetype, 10 * 24 * 60 * 60, function () use ($coursetype) {
                 $courses = Course::select('id', 'name')
                             ->where('status', 1) // take only active courses
                             ->where('type', $coursetype) // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
                             ->orderBy('priority', 'asc')
                             ->get();
                 foreach($courses as $course) {
                     $course->examcount = $course->courseexams->count();
                     $course->makeHidden('courseexams');
                 }
                 return $courses;
            });
            
            // dd($courses);
            return response()->json([
                'success' => true,
                'courses' => $courses,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function testCache()
    {
        // echo Cache::forget('courseexams');
    }

    public function getCourseExams($softtoken, $id)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $courseexams = Cache::remember('courseexams'.$id, 10 * 24 * 60 * 60, function () use ($id) {
                $courseexams = Courseexam::select('course_id', 'exam_id')
                                     ->where('course_id', $id)
                                     ->orderBy('exam_id', 'desc')
                                     // ->join('exams', 'exams.id', '=', 'courseexams.exam_id')
                                     // ->orderBy('exams.available_from', 'asc')
                                     // ->select('courseexams.*')
                                     ->get();

                foreach($courseexams as $courseexam) {
                    $courseexam->name = $courseexam->exam->name;
                    $courseexam->start = $courseexam->exam->available_from;
                    $courseexam->questioncount = $courseexam->exam->examquestions->count();
                    $courseexam->syllabus = $courseexam->exam->syllabus ? $courseexam->exam->syllabus : 'N/A';
                    $courseexam->alltimeavailability = $courseexam->exam->alltimeavailability;
                    $courseexam->exam->makeHidden('id', 'name', 'examcategory_id', 'price_type', 'available_from', 'available_to', 'syllabus', 'created_at', 'updated_at', 'examquestions', 'alltimeavailability');
                }
                return $courseexams;
            });
            // dd($courseexams);
            // $courseexams = $courseexams->sortByDesc('start');
            // return 'Test';
            return response()->json([
                'success' => true,
                'exams' => $courseexams,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getOtherCourseExams($softtoken, $coursetype)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $course = Course::select('id')
                             ->where('status', 1) // take only active courses
                             ->where('type', $coursetype) // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
                             ->first(); 


            $courseexams = Cache::remember('courseexams'.$course->id, 10 * 24 * 60 * 60, function () use ($course) {
                $courseexams = Courseexam::select('course_id', 'exam_id')
                                         ->where('course_id', $course->id)
                                         ->orderBy('exam_id', 'desc')
                                         ->get();

                foreach($courseexams as $courseexam) {
                    $courseexam->name = $courseexam->exam->name;
                    $courseexam->start = $courseexam->exam->available_from;
                    $courseexam->questioncount = $courseexam->exam->examquestions->count();
                    $courseexam->syllabus = $courseexam->exam->syllabus ? $courseexam->exam->syllabus : 'N/A';
                    $courseexam->alltimeavailability = $courseexam->exam->alltimeavailability;
                    $courseexam->exam->makeHidden('id', 'name', 'examcategory_id', 'price_type', 'available_from', 'available_to', 'syllabus', 'created_at', 'updated_at', 'examquestions', 'alltimeavailability');
                }
                return $courseexams;
            });
            // dd($courseexams);

            return response()->json([
                'success' => true,
                'exams' => $courseexams,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getCourseExamQuestions($softtoken, $id)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $examquestions = Examquestion::select('exam_id', 'question_id')
                                     ->where('exam_id', $id)
                                     ->get();

            foreach($examquestions as $examquestion) {
                $examquestion = $examquestion->makeHidden(['question_id']);
                if($examquestion->question->questionexplanation) {
                    $examquestion->question->explanation = $examquestion->question->questionexplanation->explanation;
                }if($examquestion->question->questionimage) {
                    $examquestion->question->image = $examquestion->question->questionimage->image;
                }
                $examquestion->question = $examquestion->question->makeHidden(['topic_id', 'difficulty', 'created_at', 'updated_at', 'questionexplanation', 'questionimage']);
            }
            $exam = Exam::findOrFail($id);
            $exam->participation++;
            $exam->save();

            return response()->json([
                'success' => true,
                'questions' => $examquestions,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getTopicExamQuestions($softtoken, $id)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $topicquestions = Question::where('topic_id', $id)->orderBy(DB::raw('RAND()'))
                                      ->take(20)
                                      ->get();

            foreach($topicquestions as $topicquestion) {
                // dd($topicquestion);
                if($topicquestion->questionexplanation) {
                    $topicquestion->explanation = $topicquestion->questionexplanation->explanation;
                }if($topicquestion->questionimage) {
                    $topicquestion->image = $topicquestion->questionimage->image;
                }
                $topicquestion = $topicquestion->makeHidden(['topic_id', 'difficulty', 'created_at', 'updated_at', 'questionexplanation', 'questionimage']);
            }
            // dd($topicquestions);

            $topic = Topic::findOrFail($id);
            $topic->participation++;
            $topic->save();

            return response()->json([
                'success' => true,
                'questions' => $topicquestions,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getTopics($softtoken)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $topics = Cache::remember('topics', 10 * 24 * 60 * 60, function () {
                $topics = Topic::all();
                return $topics;
            });
            return response()->json([
                'success' => true,
                'topics' => $topics,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getPackages($softtoken)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $packages = Package::select('id', 'name', 'tagline', 'duration', 'price', 'strike_price', 'suggested')
                               ->where('status', 1)->get();

            return response()->json([
                'success' => true,
                'packages' => $packages,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function paymentProceed(Request $request)
    {
        $this->validate($request,array(
            'user_number'    =>   'required',
            'package_id'     =>   'required',
            'amount'         =>   'required',
            'trx_id'         =>   'required'
        ));

        $user = User::where('mobile', substr($request->user_number, -11))->first();
        $package = Package::findOrFail($request->package_id);
        
        if($request->softtoken == env('SOFT_TOKEN')) {
            if($user) {
                $temppayment = new Temppayment;
                $temppayment->user_id = $user->id;
                $temppayment->package_id = $request->package_id;
                $temppayment->uid = $user->uid;
                $temppayment->trx_id = $request->trx_id;
                $temppayment->amount = $request->amount;
                $temppayment->save();

                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success' => false
                ]);
            }
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function storeMessage(Request $request)
    {
        $this->validate($request,array(
            'mobile'    =>   'required',
            'message'    =>   'required',
        ));

        $user = User::where('mobile', $request->mobile)->first();

        $message = new Message;
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->save();
        
        return response()->json([
            'success' => true
        ]);
    }

    public function getPaymentHistory($softtoken, $phonenumber)
    {
        $user = User::where('mobile', substr($phonenumber, -11))->first();

        if($user && $softtoken == env('SOFT_TOKEN'))
        {
            foreach($user->payments as $payment) {
                $payment->makeHidden(['id', 'user_id', 'package_id', 'uid', 'payment_status', 'card_type', 'store_amount', 'updated_at']);
            }
            // dd($user->payments);
            return response()->json([
                'success' => true,
                'paymenthistory' => $user->payments,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function sendSingleNotification(Request $request)
    {
        $this->validate($request,array(
            'mobile'               => 'required',
            'onesignal_id'         => 'required',
            'headings'             => 'required',
            'message'              => 'required',
            'softtoken'            => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN'))
        {

            // $user = User::where('mobile', substr($request->mobile, -11))->first();
            
            OneSignal::sendNotificationToUser(
                $request->message,
                // ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
                $request->onesignal_id, // user theke na, direct input theke...
                $url = null, 
                $data = null, // array("answer" => $charioteer->answer), // to send some variable
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        }
        return response()->json([
            'success' => true,
            'onesignal_id' => $request->onesignal_id
        ]); 
    }

    // public function getMaterials($softtoken)
    // {
    //     if($softtoken == env('SOFT_TOKEN'))
    //     {
    //         $materials = Cache::remember('lecturematerials', 10 * 24 * 60 * 60, function () {
    //             $materials = Material::where('status', 1) // 1 = active, 0 = inactive
    //                                  ->orderBy('id', 'desc')
    //                                  // ->select('id', 'type', 'title', 'author', 'author_desc')
    //                                  ->get();

    //             foreach($materials as $material) {
    //                 $material->makeHidden('status', 'updated_at'); // 'id', 
    //             }
    //             return $materials;
    //         });
    //         // dd($materials);
    //         $materials = $materials->sortByDesc('start');
    //         // return 'Test';
    //         return response()->json([
    //             'success' => true,
    //             'materials' => $materials,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false
    //         ]);
    //     }
    // }

    // ETA PORE USE KORA HOBE
    // ETA PORE USE KORA HOBE
    // ETA PORE USE KORA HOBE
    public function getMaterials($softtoken)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $materials = Cache::remember('lecturematerials', 10 * 24 * 60 * 60, function () {
                $materials = Material::where('status', 1) // 1 = active, 0 = inactive
                                     ->orderBy('id', 'desc')
                                     ->select('id', 'type', 'title', 'author', 'author_desc')
                                     ->get();

                // foreach($materials as $material) {
                //     $material->makeHidden('id', 'status', 'updated_at');
                // }
                return $materials;
            });
            // dd($materials);
            // $materials = $materials->sortByDesc('start');
            // return 'Test';
            return response()->json([
                'success' => true,
                'materials' => $materials,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getSingleMaterial($softtoken, $id)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $material = Cache::remember('singlelecturematerial' . $id, 10 * 24 * 60 * 60, function () use ($id) {
                $material = Material::where('id', $id)
                                     ->select('id', 'type', 'title', 'author', 'author_desc', 'content', 'url', 'count', 'created_at')
                                     ->first();
                return $material;
            });            
            
            $materialforsave = Material::findOrFail($id);
            $materialforsave->count++;
            $materialforsave->save();

            return response()->json([
                'success' => true,
                'material' => $material,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function addExamResult(Request $request)
    {
        // return $request->all();
        $this->validate($request,array(
            'mobile'      => 'required',
            'course_id'   => 'required',
            'exam_id'     => 'required',
            'marks'       => 'required',
            'softtoken'   => 'required'
        ));

        if($request->softtoken == env('SOFT_TOKEN'))
        {
            $user = User::where('mobile', substr($request->mobile, -11))->first();

            $oldexamresultcheck = Meritlist::where('course_id', $request->course_id)
                                           ->where('exam_id', $request->exam_id)
                                           ->where('user_id', $user->id)
                                           ->first();

            if($oldexamresultcheck) {
                // add korbe na
            } else {
                $examresult = new Meritlist;
                $examresult->course_id = $request->course_id;
                $examresult->exam_id = $request->exam_id;
                $examresult->user_id = $user->id;
                $examresult->marks = $request->marks;
                $examresult->save();

                Cache::forget('meritlist'.$request->course_id.$request->exam_id);
                Cache::forget('exam'.$request->exam_id);
            }

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function getMeritList($softtoken, $course_id, $exam_id)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $meritlists = Cache::remember('meritlist'.$course_id.$exam_id, 10 * 24 * 60 * 60, function () use ($course_id, $exam_id) {
                 $meritlists = Meritlist::where('course_id', $course_id)
                                        ->where('exam_id', $exam_id)
                                        ->get();

                 $rank = 1;
                 $previous = null;
                 foreach ($meritlists->sortByDesc('marks') as $score) {
                     if ($previous && $previous->marks != $score->marks) {
                         $rank++;
                     }
                     $score->rank = $rank;
                     $previous = $score;
                 }
                 foreach($meritlists as $meritlist) {
                     $meritlist->name = $meritlist->user->name;
                     $meritlist->makeHidden('id', 'created_at', 'updated_at', 'user_id', 'user');
                 }
                 return $meritlists;
            });
            $exam = Cache::remember('exam' . $exam_id, 10 * 24 * 60 * 60, function () use ($exam_id) {
                 $exam = Exam::select('name', 'participation', 'cutmark')->where('id', $exam_id)->first();
                 $exam->makeHidden('id', 'examcategory_id', 'duration');
                 return $exam;
            });
            
            return response()->json([
                'success' => true,
                'meritlists' => $meritlists,
                'exam' => $exam,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getExamCategories($softtoken)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            $examcategories = Cache::remember('examcategories', 21 * 24 * 60 * 60, function () {
                $examcategories = Examcategory::orderBy('id', 'asc')->get();
                return $examcategories;
            });
            return response()->json([
                'success' => true,
                'examcategories' => $examcategories,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getQBCatWise($softtoken, $getexamcategory)
    {
        if($softtoken == env('SOFT_TOKEN'))
        {
            // $course = Course::select('id')
            //                  ->where('status', 1) // take only active courses
            //                  ->where('type', $coursetype) // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
            //                  ->first();
            // UPORER TA THEKE ID ASBE 6, SETA HOCCHE QB ER COURSE ID

            $courseexamsreturn = Cache::remember('questionbank'.$getexamcategory, 10 * 24 * 60 * 60, function () use ($getexamcategory) {
                $allcatcourseexams = Courseexam::select('course_id', 'exam_id')
                                         ->where('course_id', 6) // MANUALLY BOSAY DILAM
                                         ->orderBy('id', 'desc') // DESC, aage exam_id chilo, pore eta priority variable diye kora hobe,apatoto id diye kaaj choltese...
                                         ->get();
                $courseexams = collect();
                foreach($allcatcourseexams as $courseexam) {
                    if($courseexam->exam->examcategory_id == $getexamcategory) {
                        $courseexam->name = $courseexam->exam->name;
                        $courseexam->start = $courseexam->exam->available_from;
                        $courseexam->questioncount = $courseexam->exam->examquestions->count();
                        $courseexam->syllabus = $courseexam->exam->syllabus ? $courseexam->exam->syllabus : 'N/A';
                        $courseexam->exam->makeHidden('id', 'name', 'examcategory_id', 'price_type', 'available_from', 'available_to', 'syllabus', 'created_at', 'updated_at', 'examquestions');
                        $courseexams->push($courseexam);
                    }
                }
                // dd($courseexams);
                return $courseexams;
            });
            // dd($courseexams);

            return response()->json([
                'success' => true,
                'exams' => $courseexamsreturn,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }


    public function reportQuestion(Request $request)
    {
        // return $request->all();
        $this->validate($request,array(
            'mobile'      => 'required',
            'question'    => 'sometimes',
            'id'          => 'sometimes',
            'message'     => 'sometimes',
            'softtoken'   => 'required',
        ));


        if($request->softtoken == env('SOFT_TOKEN'))
        {
            $user = User::where('mobile', substr($request->mobile, -11))->first();
            if(isset($request->id)) {
                $reportedquestion = new Reportedquestion;
                $reportedquestion->question_id = $request->id;
                $reportedquestion->user_id = $user->id;
                $reportedquestion->message = $request->message;
                $reportedquestion->status = 0;
                $reportedquestion->save();
            } else {

                $question = Question::where('question', 'LIKE', "%$request->question%")->first();
                if($question) {
                   $reportedquestion = new Reportedquestion;
                   $reportedquestion->question_id = $question->id;
                   $reportedquestion->user_id = $user->id;
                   $reportedquestion->message = $request->message;
                   $reportedquestion->status = 0;
                   $reportedquestion->save();
                }
            }

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }


    public function testNotification()
    {
        OneSignal::sendNotificationToUser(
            'test',
            // ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
            "13cc498f-ebf7-4bb1-9ea6-2c8da09e0b31",
            $url = null, 
            $data = null, // array("answer" => $charioteer->answer), // to send some variable
            $buttons = null, 
            $schedule = null,
            $headings = 'Test',
        ); 

        
    }
}
