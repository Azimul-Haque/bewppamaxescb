<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
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
use Hash;
use Carbon\Carbon;
use DB;
use OneSignal;
use Cache;

class APIController extends Controller
{
    public function test()
    {
         dd('name');
    }

    public function checkUid($softtoken, $phonenumber)
    {
        $user = User::where('mobile', substr($phonenumber, -11))->first();

        if($user && $softtoken == 'Rifat.Admin.2022')
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

        if($user && $softtoken == 'Rifat.Admin.2022')
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

        if($request->softtoken == 'Rifat.Admin.2022')
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

        if($user && $request->softtoken == 'Rifat.Admin.2022')
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
        if($softtoken == 'Rifat.Admin.2022')
        {
            $courses = Cache::remember('courses'.$coursetype, 7 * 24 * 60 * 60, function () use ($coursetype) {
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
        if($softtoken == 'Rifat.Admin.2022')
        {
            $courseexams = Cache::remember('courseexams'.$id, 7 * 24 * 60 * 60, function () use ($id) {
                $courseexams = Courseexam::select('course_id', 'exam_id')
                                     ->where('course_id', $id)
                                     ->get();

                foreach($courseexams as $courseexam) {
                    $courseexam->name = $courseexam->exam->name;
                    $courseexam->start = $courseexam->exam->available_from;
                    $courseexam->questioncount = $courseexam->exam->examquestions->count();
                    $courseexam->syllabus = $courseexam->exam->syllabus ? $courseexam->exam->syllabus : 'N/A';
                    $courseexam->exam->makeHidden('id', 'name', 'examcategory_id', 'price_type', 'available_from', 'available_to', 'syllabus', 'created_at', 'updated_at', 'examquestions');
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
        if($softtoken == 'Rifat.Admin.2022')
        {
            $course = Course::select('id')
                             ->where('status', 1) // take only active courses
                             ->where('type', $coursetype) // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
                             ->first(); 


            $courseexams = Cache::remember('courseexams'.$course->id, 7 * 24 * 60 * 60, function () use ($course) {
                $courseexams = Courseexam::select('course_id', 'exam_id')
                                         ->where('course_id', $course->id)
                                         ->orderBy('id', 'desc')
                                         ->get();

                foreach($courseexams as $courseexam) {
                    $courseexam->name = $courseexam->exam->name;
                    $courseexam->start = $courseexam->exam->available_from;
                    $courseexam->questioncount = $courseexam->exam->examquestions->count();
                    $courseexam->syllabus = $courseexam->exam->syllabus ? $courseexam->exam->syllabus : 'N/A';
                    $courseexam->exam->makeHidden('id', 'name', 'examcategory_id', 'price_type', 'available_from', 'available_to', 'syllabus', 'created_at', 'updated_at', 'examquestions');
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
        if($softtoken == 'Rifat.Admin.2022')
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
        if($softtoken == 'Rifat.Admin.2022')
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
        if($softtoken == 'Rifat.Admin.2022')
        {
            $topics = Cache::remember('topics', 7 * 24 * 60 * 60, function () {
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
        if($softtoken == 'Rifat.Admin.2022')
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
        
        if($request->softtoken == 'Rifat.Admin.2022') {
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

        if($user && $softtoken == 'Rifat.Admin.2022')
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

        if($request->softtoken == 'Rifat.Admin.2022')
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

    public function getMaterials($softtoken)
    {
        if($softtoken == 'Rifat.Admin.2022')
        {
            $materials = Cache::remember('lecturematerials', 7 * 24 * 60 * 60, function () {
                $materials = Material::where('status', 1) // 1 = active, 0 = inactive
                                     ->orderBy('id', 'desc')
                                     ->get();

                foreach($materials as $material) {
                    $material->makeHidden('id', 'status', 'updated_at');
                }
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
