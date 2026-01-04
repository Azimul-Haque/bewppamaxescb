<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\Topic;
use App\Models\Tag;
use App\Models\Exam;
use App\Models\Examcategory;
use App\Models\Examquestion;
use App\Models\Question;
use App\Models\Meritlist;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
use OneSignal;
use Cache;

class ExamController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth')->except('clear');
        $this->middleware(['admin'])->only('getQuestions');
    }

    public function getExams()
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalexams = Exam::count();
        $exams = Exam::orderBy('id', 'desc')->paginate(10);
        $examcategories = Examcategory::all();

        return view('dashboard.exams.index')
                    ->withExams($exams)
                    ->withExamcategories($examcategories)
                    ->withTotalexams($totalexams);
    }

    public function getExamsSearch($search)
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalexams = Exam::where('name', 'LIKE', "%$search%")->count();
        $exams = Exam::where('name', 'LIKE', "%$search%")->paginate(10); 
        $examcategories = Examcategory::all();

        Session::flash('success', $totalexams . ' টি পরীক্ষা পাওয়া গিয়েছে!');
        return view('dashboard.exams.index')
                    ->withExams($exams)
                    ->withExamcategories($examcategories)
                    ->withTotalexams($totalexams);
    }

    public function getExamMeritList($exam_id)
    {  
        $exam = Exam::findOrFail($exam_id);

        $rank = 1;
        $previous = null;
        foreach ($exam->meritlists->sortByDesc('marks') as $score) {
            if ($previous && $previous->marks != $score->marks) {
                $rank++;
            }
            $score->rank = $rank;
            $previous = $score;
        }
        return view('dashboard.exams.meritlist')
                    ->withExam($exam);
    }

    public function storeExamCategory(Request $request)
    {
        $this->validate($request,array(
            'name'          => 'required|string|max:191',
            'thumbnail'     => 'required|string|max:191',
        ));

        $category = new Examcategory;
        $category->name = $request->name;
        $category->thumbnail = $request->thumbnail;
        $category->save();

        Cache::forget('examcategories');
        Session::flash('success', 'Category created successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function updateExamCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name'          => 'required|string|max:191',
            'thumbnail'     => 'required|string|max:191',
        ));

        $category = Examcategory::find($id);;
        $category->name = $request->name;
        $category->thumbnail = $request->thumbnail;
        $category->save();

        Cache::forget('examcategories');
        Session::flash('success', 'Category updated successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function deleteExamCategory($id)
    {
        $category = Examcategory::find($id);
        $category->delete();

        Cache::forget('examcategories');
        Session::flash('success', 'Category deleted successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function storeExam(Request $request)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'examcategory_id'    => 'required|string|max:191',
            'name'               => 'required|string|max:191',
            'duration'           => 'required|string|max:191',
            'qsweight'           => 'required|string|max:191',
            'negativepercentage' => 'required|string|max:191',
            // 'price_type'         => 'required|string|max:191',
            'cutmark'            => 'required|string|max:191',
            'available_from'     => 'required|string|max:191',
            'available_to'       => 'required|string|max:191',
            'syllabus'           => 'required|string',
            'alltimeavailability'           => 'sometimes',
        ));

        $exam = new Exam;
        $exam->examcategory_id = $request->examcategory_id;
        $exam->name = $request->name;
        $exam->duration = $request->duration;
        $exam->qsweight = $request->qsweight;
        $exam->negativepercentage = $request->negativepercentage;
        $exam->price_type = 1; // paid
        $exam->cutmark = $request->cutmark;
        $exam->available_from = Carbon::parse($request->available_from);
        $exam->available_to = Carbon::parse($request->available_to);
        $exam->syllabus = nl2br($request->syllabus);
        if($request->alltimeavailability) {
            $exam->alltimeavailability = 1;
        }else {
            $exam->alltimeavailability = 0;
        }
        $exam->save();
        
        Session::flash('success', 'Exam created successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function updateExam(Request $request, $id)
    {
        // dd($request->file('image'));
        // dd($request->file('image'));
        $this->validate($request,array(
            'examcategory_id'    => 'required|string|max:191',
            'name'               => 'required|string|max:191',
            'duration'           => 'required|string|max:191',
            'qsweight'           => 'required|string|max:191',
            'negativepercentage' => 'required|string|max:191',
            // 'price_type'         => 'required|string|max:191',
            'cutmark'            => 'required|string|max:191',
            'available_from'     => 'required|string|max:191',
            'available_to'       => 'required|string|max:191',
            'syllabus'           => 'required|string',
            'alltimeavailability'           => 'sometimes',
        ));

        $exam = Exam::find($id);
        $exam->examcategory_id = $request->examcategory_id;
        $exam->name = $request->name;
        $exam->duration = $request->duration;
        $exam->qsweight = $request->qsweight;
        $exam->negativepercentage = $request->negativepercentage;
        $exam->price_type = 1;
        $exam->cutmark = $request->cutmark;
        $exam->available_from = Carbon::parse($request->available_from);
        $exam->available_to = Carbon::parse($request->available_to);
        $exam->syllabus = nl2br($request->syllabus);
        if($request->alltimeavailability) {
            $exam->alltimeavailability = 1;
        } else {
            $exam->alltimeavailability = 0;
        }
        $exam->save();

        Cache::forget('exam' . $id);
        foreach($exam->courseexams as $examdata) {
            Cache::forget('courseexams' . $examdata->course_id);
        }
        Session::flash('success', 'Exam updated successfully!');
        // return redirect()->route('dashboard.exams');
        return redirect()->back();
    }
    
    public function copyExam(Request $request, $id)
    {
        // dd($request->file('image'));
        // dd($request->file('image'));
        $this->validate($request,array(
            'name'               => 'required|string|max:191',
        ));

        $oldexam = Exam::findOrFail($id);
        $exam = new Exam();
        $exam->examcategory_id = $oldexam->examcategory_id;
        $exam->name = $request->name;
        $exam->duration = $oldexam->duration;
        $exam->qsweight = $oldexam->qsweight;
        $exam->negativepercentage = $oldexam->negativepercentage;
        $exam->price_type = 1;
        $exam->cutmark = $oldexam->cutmark;
        $exam->available_from = Carbon::parse($oldexam->available_from);
        $exam->available_to = Carbon::parse($oldexam->available_to);
        $exam->syllabus = $oldexam->syllabus;
        $exam->alltimeavailability = $oldexam->alltimeavailability;
        $exam->save();

        foreach($oldexam->examquestions as $oldexamquestion) {
            $examquestion = new Examquestion;
            $examquestion->exam_id = $exam->id;
            $examquestion->question_id = $oldexamquestion->question_id;
            $examquestion->save();
        }

        Session::flash('success', 'Exam copied successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function deleteExam($id)
    {
        $exam = Exam::findOrFail($id);
        foreach($exam->examquestions as $examquestion) {
            $examquestion->delete();
        }
        $exam->delete();

        Session::flash('success', 'Exam deleted successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function addQuestionToExam($id)
    {
        $exam = Exam::findOrFail($id);
        $examquestions = Examquestion::where('exam_id', $exam->id)
                                     ->orderBy('question_id', 'asc')
                                     ->get();
        $topics = Topic::all();
        $tags = Tag::all();


        $mainTopics = Topic::whereNull('parent_id')
                                    ->orWhere('parent_id', 0)
                                    ->get();

        $questions = Question::select('id', 'question', 'topic_id')->get()->take(20);
        // $questions = Question::all();
        
        return view('dashboard.exams.addquestion')
                                    ->withExam($exam)
                                    ->withExamquestions($examquestions)
                                    ->withTopics($topics)
                                    ->withTags($tags)
                                    ->withQuestions($questions)
                                    ->withMainTopics($mainTopics);
    }

    public function addQuestionToExamAll($id)
    {
        $exam = Exam::findOrFail($id);
        $examquestions = Examquestion::where('exam_id', $exam->id)
                                     ->orderBy('question_id', 'asc')
                                     ->get();

        $totalquestions = Question::count();
        $questions = Question::orderBy('id', 'desc')->paginate(15);
        $topics = Topic::orderBy('id', 'asc')->get();
        // $questions = Question::all();
        
        return view('dashboard.exams.addquestionbankall')
                                    ->withExam($exam)
                                    ->withExamquestions($examquestions)
                                    ->withTopics($topics)
                                    ->withQuestions($questions)
                                    ->withTotalquestions($totalquestions);
    }

    public function addQuestionFromOthers($id)
    {
        $exam = Exam::findOrFail($id);
        $examquestions = Examquestion::where('exam_id', $exam->id)
                                     ->orderBy('question_id', 'asc')
                                     ->get();
        $exams = Exam::all();
        
        return view('dashboard.exams.addquestionfrotmothers')
                                    ->withExam($exam)
                                    ->withExams($exams)
                                    ->withExamquestions($examquestions);
    }

    public function storeQuestionFromOthers(Request $request, $id)
    {
        $this->validate($request,array(
            'otherexamids'    => 'required',
        ));

        $exam = Exam::findOrFail($id);
        $otherexamids = explode(',', $request->otherexamids);

        foreach($otherexamids as $examid) {
            $nameofthevariable = 'questionamount' . $examid;
            // dd($request->$nameofthevariable);
            $selectedexamquestions = Examquestion::where('exam_id', $examid)
                                        ->inRandomOrder()
                                        ->limit($request->$nameofthevariable)
                                        ->get();

            // dd($selectedexamquestions);
            foreach($selectedexamquestions as $selectedexamquestion) {
                $examquestion = new Examquestion;
                $examquestion->exam_id = $id;
                $examquestion->question_id = $selectedexamquestion->question_id;
                $examquestion->save();
            }
        }
        // dd($request->all());
        Session::flash('success', 'প্রশ্ন হালনাগাদ করা হয়েছে!');
        return redirect()->back();
    }

    public function getSubtopics(Request $request)
    {
        // যদি target_id না থাকে তবে মেইন সিলেক্টর থেকে আইডি নেবে
        $parentId = $request->target_id ?? $request->main_topic_id;
        
        $topics = Topic::where('parent_id', $parentId)
                        ->where('total_questions_sum', '>', 0)
                        ->withCount('questions')
                        ->get()
                        ->mapWithKeys(function($topic) {
                            return [$topic->name => [
                                'id' => $topic->id,
                                'direct_q' => $topic->questions_count, // নিজস্ব প্রশ্ন
                                'total_q' => $topic->total_questions_sum,
                                'has_children' => $topic->children()->count() > 0,
                                'all_ids' => $topic->descendant_ids // সব লিফ আইডি
                            ]];
                        });

        return response()->json($topics);
    }

    public function storeAutoQuestions(Request $request) {
        $allQuestionIds = [];

        // GENERATING SYLLABUS
        // GENERATING SYLLABUS
        $syllabusParts = [];

        // -- শুধুমাত্র নিজস্ব প্রশ্ন (Only Own) প্রসেস করা --
        // if ($request->has('only_own')) {
        //     $onlyOwnIds = array_keys(array_filter($request->only_own, fn($count) => (int)$count > 0));
        //     if (!empty($onlyOwnIds)) {
        //         $onlyOwnNames = Topic::whereIn('id', $onlyOwnIds)->pluck('name')->toArray();
        //         $syllabusParts[] = "🎯 মূল বিষয় (সরাসরি):\n  • " . implode(', ', $onlyOwnNames);
        //     }
        // }

        // // -- সাবটপিক গ্রুপ (Topic Groups) প্রসেস করা --
        // if ($request->has('topic_groups')) {
        //     $groupMainIds = [];
        //     foreach ($request->topic_groups as $idsCommaString => $count) {
        //         if ((int)$count > 0) {
        //             $ids = explode(',', $idsCommaString);
        //             // প্রথম আইডিটি সাধারণত সেই লেভেলের মূল নাম রিপ্রেজেন্ট করে
        //             $groupMainIds[] = $ids[0]; 
        //         }
        //     }
            
        //     if (!empty($groupMainIds)) {
        //         $groupNames = Topic::whereIn('id', $groupMainIds)->pluck('name')->toArray();
        //         $syllabusParts[] = "📂 বিস্তারিত বিভাগ (সাব-টপিকসহ):\n  • " . implode(', ', $groupNames);
        //     }
        // }

        // // ৩. চূড়ান্ত সিলেবাস ফরম্যাটিং
        // if (!empty($syllabusParts)) {
        //     $finalSyllabus = "📝 পরীক্ষার সিলেবাস\n" . "━━━━━━━━━━━━━━\n" . implode("\n\n", $syllabusParts);
        // } else {
        //     $finalSyllabus = "সিলেবাস নির্ধারিত নেই।";
        // }

        dd($finalSyllabus);

        // ডাটাবেসে সেভ
        $exam = Exam::find($request->exam_id);
        $exam->update(['syllabus' => $finalSyllabus]);
        // GENERATING SYLLABUS
        // GENERATING SYLLABUS

        // dd($request->all());
        // ১. শুধুমাত্র নিজস্ব প্রশ্ন প্রসেস করা (only_own)
        if ($request->has('only_own')) {
            foreach ($request->only_own as $topicId => $count) {
                $count = (int)$count;
                if ($count > 0) {
                    $questions = Question::where('topic_id', $topicId)
                                    ->inRandomOrder()
                                    ->limit($count)
                                    ->pluck('id')
                                    ->toArray();
                    $allQuestionIds = array_merge($allQuestionIds, $questions);
                }
            }
        }

        // ২. সাবটপিকসহ প্রশ্ন প্রসেস করা (topic_groups)
        if ($request->has('topic_groups')) {
            foreach ($request->topic_groups as $idsCommaString => $count) {
                $count = (int)$count;
                if ($count > 0) {
                    // আইডিগুলো কমা দিয়ে আলাদা করা (স্ট্রিং থেকে অ্যারে)
                    $ids = explode(',', $idsCommaString);

                    if (empty($ids)) continue;

                    $query = Question::whereIn('topic_id', $ids);

                    // যদি ইতিমধ্যে কিছু প্রশ্ন সিলেক্ট হয়ে থাকে তবে সেগুলো বাদ দেওয়া
                    if (!empty($allQuestionIds)) {
                        $query->whereNotIn('id', $allQuestionIds);
                    }

                    $questions = $query->inRandomOrder()
                                    ->limit($count)
                                    ->pluck('id')
                                    ->toArray();
                                    
                    $allQuestionIds = array_merge($allQuestionIds, $questions);
                }
            }
        }

        // dd($allQuestionIds);

        // ৩. এক্সাম পেপারে প্রশ্নগুলো সেভ করা
        $examId = $request->exam_id;
        if (!empty($allQuestionIds)) {
            $insertData = [];
            $now = now();

            foreach (array_unique($allQuestionIds) as $qId) {
                $insertData[] = [
                    'exam_id'     => $examId,
                    'question_id' => $qId,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }

            // ২. ডাটাবেসে একবারে ইনসার্ট করা (Performance Optimization)
            // insertOrIgnore ব্যবহার করলে যদি প্রশ্নটি আগে থেকেই থাকে তবে সেটি এরর দিবে না, স্কিপ করবে।
            DB::table('examquestions')->insertOrIgnore($insertData);

            // return response()->json([
            //     'status'  => 'success',
            //     'message' => count($insertData) . 'টি প্রশ্ন এক্সামে যোগ করা হয়েছে।',
            //     'total'   => count($insertData)
            // ]);
            return back()->with('success', 'টি প্রশ্ন এক্সামে যোগ করা হয়েছে।');
        }

        return back()->with('error', 'কোনো প্রশ্ন সিলেক্ট করা হয়নি।');
    }

    public function fastCleanup()
    {
        // ১. একটি টেম্পোরারি টেবিল তৈরি করুন যেখানে ডুপ্লিকেট ছাড়া ইউনিক আইডিগুলো থাকবে
        DB::statement("CREATE TABLE temp_ids AS 
                       SELECT MIN(id) as id 
                       FROM examquestions 
                       GROUP BY exam_id, question_id");

        // ২. এবার মেইন টেবিল থেকে সেই সব ডাটা ডিলিট করুন যে আইডিগুলো টেম্পোরারি টেবিলে নেই
        DB::statement("DELETE FROM examquestions 
                       WHERE id NOT IN (SELECT id FROM temp_ids)");

        // ৩. টেম্পোরারি টেবিলটি ড্রপ করে দিন
        DB::statement("DROP TABLE temp_ids");

        return "সফলভাবে ডুপ্লিকেট ক্লিন হয়েছে!";
    }

    public function addQuestionToExamTopic($topic_id, $id)
    {
        $exam = Exam::findOrFail($id);
        $examquestions = Examquestion::where('exam_id', $exam->id)
                                     ->orderBy('question_id', 'asc')
                                     ->get();

        $totalquestions = Question::where('topic_id', $topic_id)->count();
        $questions = Question::where('topic_id', $topic_id)
                             ->orderBy('id', 'desc')
                             ->paginate(15);
        $topics = Topic::orderBy('id', 'asc')->get();
        // $questions = Question::all();
        
        return view('dashboard.exams.addquestionbankall')
                                    ->withExam($exam)
                                    ->withExamquestions($examquestions)
                                    ->withTopics($topics)
                                    ->withQuestions($questions)
                                    ->withTotalquestions($totalquestions);
    }

    public function addQuestionToExamSearch($id, $search)
    {
        $exam = Exam::findOrFail($id);
        $examquestions = Examquestion::where('exam_id', $exam->id)
                                     ->orderBy('question_id', 'asc')
                                     ->get();

        $totalquestions = Question::where('question', 'LIKE', "%$search%")->count();
        $questions = Question::where('question', 'LIKE', "%$search%")
                             ->orWhere('option1', 'LIKE', "%$search%")
                             ->orWhere('option2', 'LIKE', "%$search%")
                             ->orWhere('option3', 'LIKE', "%$search%")
                             ->orWhere('option4', 'LIKE', "%$search%")
                             ->orderBy('id', 'desc')
                             ->paginate(15);
        $topics = Topic::orderBy('id', 'asc')->get();
        // $questions = Question::all();
        
        return view('dashboard.exams.addquestionbankall')
                                    ->withExam($exam)
                                    ->withExamquestions($examquestions)
                                    ->withTopics($topics)
                                    ->withQuestions($questions)
                                    ->withTotalquestions($totalquestions);
    }

    public function clearExamQuestions(Request $request)
    {
        $this->validate($request,array(
            'exam_id'          => 'required'
        ));

        $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)->get();
        if(count($oldexamquestions) > 0) {
            foreach($oldexamquestions as $oldexamquestion) {
                $oldexamquestion->delete();
            }
        }

        Session::flash('success', 'Questions have been cleared!');
        return redirect()->route('dashboard.exams.add.question', $request->exam_id);
    }

    public function storeExamQuestion(Request $request)
    {
        $this->validate($request,array(
            'exam_id'          => 'required',
            'hiddencheckarray' => 'sometimes',
            'currentchecktext' => 'sometimes',
        ));

        if($request->hiddencheckarray == '') {
            if($request->currentchecktext != '') {
                $oldexamquestionsids = explode(',', $request->currentchecktext);
                $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)
                                                ->whereIn('question_id', $oldexamquestionsids)
                                                ->get();
                // dd($oldexamquestions);
                if(count($oldexamquestions) > 0) {
                    foreach($oldexamquestions as $oldexamquestion) {
                        $oldexamquestion->delete();
                    }
                }
                Session::flash('success', 'Question updated successfully!');
            } else {
                Session::flash('warning', 'কিছুতো সিলেক্ট করুন');
            }
        } else {
            $oldexamquestionsids = explode(',', $request->currentchecktext);
            $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)
                                                ->whereIn('question_id', $oldexamquestionsids)
                                                ->get();
            if(count($oldexamquestions) > 0) {
                foreach($oldexamquestions as $oldexamquestion) {
                    $oldexamquestion->delete();
                }
            }
            $hiddencheckarray = explode(',', $request->hiddencheckarray);
            // sort($hiddencheckarray);
            // dd($hiddencheckarray);
            foreach($hiddencheckarray as $question_id) {
                $examquestion = new Examquestion;
                $examquestion->exam_id = $request->exam_id;
                $examquestion->question_id = $question_id;
                $examquestion->save();
            }
            Session::flash('success', 'Question updated successfully!!');
        }
        
        // $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)->get();
        // if(count($oldexamquestions) > 0) {
        //     foreach($oldexamquestions as $oldexamquestion) {
        //         $oldexamquestion->delete();
        //     }
        // }
        // $hiddencheckarray = explode(',', $request->hiddencheckarray);
        // // sort($hiddencheckarray);
        // // dd($hiddencheckarray);
        // foreach($hiddencheckarray as $question_id) {
        //     $examquestion = new Examquestion;
        //     $examquestion->exam_id = $request->exam_id;
        //     $examquestion->question_id = $question_id;
        //     $examquestion->save();
        // }

        
        return redirect()->back();
    }

    public function removeExamQuestion($exam_id, $question_id)
    {
        $examquestion = Examquestion::where('exam_id', $exam_id)
                                    ->where('question_id', $question_id)
                                    ->first();
        // dd($examquestion);
        $examquestion->delete();

        Session::flash('success', 'Question removed successfully!');
        return redirect()->route('dashboard.exams.add.question', $exam_id);
    }
    
    public function storeTagExamQuestion(Request $request)
    {
        $this->validate($request,array(
            'exam_id'           => 'required',
            'tags_ids'          => 'required',
        ));

        // dd($request->all());
        $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)->get();
        if(count($oldexamquestions) > 0) {
            foreach($oldexamquestions as $oldexamquestion) {
                $oldexamquestion->delete();
            }
        }

        $selectedtags = Tag::whereIn('id', $request->tags_ids)->get();
        // dd($selectedtags);
        $temptagquestions = [];
        $quantitycheck = 0;
        foreach($selectedtags as $tag) {
            foreach($tag->questions as $question) {
                $temptagquestions[] = $question->id;
            }
        }
        $temptagquestions = array_values(array_unique($temptagquestions, SORT_REGULAR));
        
        foreach($temptagquestions as $questionid) { 
            $examquestion = new Examquestion;
            $examquestion->exam_id = $request->exam_id;
            $examquestion->question_id = $questionid;
            $examquestion->save();
        }
        Session::flash('success', 'Question updated successfully!');
        return redirect()->route('dashboard.exams.add.question', $request->exam_id);
    }
    
    public function automaticeExamQuestionSet(Request $request)
    {
        $this->validate($request,array(
            'exam_id'          => 'required',
        ));

        // dd($request->all());
        $oldexamquestions = Examquestion::where('exam_id', $request->exam_id)->get();
        if(count($oldexamquestions) > 0) {
            foreach($oldexamquestions as $oldexamquestion) {
                $oldexamquestion->delete();
            }
        }

        $topics = Topic::all();
        $quantitycheck = 0;
        foreach($topics as $topic) {
            $topicname = 'topic' . $topic->id;
            $quantity = 'quantity' . $topic->id;
            if($request[$topicname] == $topic->id && $request[$quantity] > 0) {
                $topicquestions = Question::where('topic_id', $request[$topicname])->inRandomOrder()->limit($request[$quantity])->get();
                // dd($topicquestions);
                foreach($topicquestions as $topicquestion) {
                    $examquestion = new Examquestion;
                    $examquestion->exam_id = $request->exam_id;
                    $examquestion->question_id = $topicquestion->id;
                    $examquestion->save();
                }
            }
            $quantitycheck = $quantitycheck + $request[$quantity];
            // dd($quantitycheck);
        }
        if($quantitycheck == 0) {
            Session::flash('info', 'At least one topic is required!');
        } else {
            Session::flash('success', 'Question updated successfully!');
        }
        return redirect()->route('dashboard.exams.add.question', $request->exam_id);
    }
    
    public function getMeritList($course_id, $exam_id)
    {
        // OBSOLETE, USE KORTESI NA
        // OBSOLETE, USE KORTESI NA
        // OBSOLETE, USE KORTESI NA
        $meritlists = Meritlist::where('course_id', $course_id)
                               ->where('exam_id', $exam_id)
                               ->orderBy('marks', 'desc')
                               ->get();
        foreach($meritlists as $meritlist) {
            $meritlist->name = $meritlist->user->name;
        }
        $meritlists->makeHidden('user', 'created_at', 'updated_at');
        $newmeritlists = $this->rankandScore($meritlists->toArray());
        $finalmeritlist = collect($newmeritlists);
        // foreach($finalmeritlist as $meritlist) {
        //     echo $meritlist->user->name . '-' . $meritlist->marks . '<br>';
        // }
        dd($finalmeritlist);
    }

    public function rankandScore($scores){
        // OBSOLETE, USE KORTESI NA
        // OBSOLETE, USE KORTESI NA
        // OBSOLETE, USE KORTESI NA
        return collect($scores)
            ->sortByDesc('marks')
            ->zip(range(1, count($scores)))
            ->map(function ($scoreAndRank){
                list($marks, $rank) = $scoreAndRank;
                return array_merge($marks, [
                    'rank' => $rank
                ]);
            })
            ->groupBy('marks')
            ->map(function ($tiedScores){
                $lowestRank = $tiedScores->pluck('rank')->min();
                return $tiedScores->map(function ($rankedScore) use ($lowestRank){
                    return array_merge($rankedScore, [
                        'rank' => $lowestRank,
                    ]);
                });

            })
            ->collapse()
            ->sortBy('rank');
    }
}
