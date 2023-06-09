<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
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
         dd('name');
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
                                         ->orderBy('exam_id', 'desc') // DESC, aage exam_id chilo, pore eta priority varsiable diye kora hobe
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
