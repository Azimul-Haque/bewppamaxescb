<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Topic;
use App\Tag;
use App\Exam;
use App\Examcategory;
use App\Examquestion;
use App\Question;

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
        
        $exams = Exam::orderBy('id', 'desc')->paginate(10);
        $examcategories = Examcategory::all();

        return view('dashboard.exams.index')
                    ->withExams($exams)
                    ->withExamcategories($examcategories);
    }

    public function storeExamCategory(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
        ));

        $category = new Examcategory;
        $category->name = $request->name;
        $category->save();

        Session::flash('success', 'Category created successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function updateExamCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name' => 'required|string|max:191',
        ));

        $category = Examcategory::find($id);;
        $category->name = $request->name;
        $category->save();

        Session::flash('success', 'Category updated successfully!');
        return redirect()->route('dashboard.exams');
    }

    public function deleteExamCategory($id)
    {
        $category = Examcategory::find($id);
        $category->delete();

        
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
            'price_type'         => 'required|string|max:191',
            'available_from'     => 'required|string|max:191',
            'available_to'       => 'required|string|max:191',
            'syllabus'           => 'required|string',
        ));

        $exam = new Exam;
        $exam->examcategory_id = $request->examcategory_id;
        $exam->name = $request->name;
        $exam->duration = $request->duration;
        $exam->qsweight = $request->qsweight;
        $exam->negativepercentage = $request->negativepercentage;
        $exam->price_type = $request->price_type;
        $exam->available_from = Carbon::parse($request->available_from);
        $exam->available_to = Carbon::parse($request->available_to);
        $exam->syllabus = nl2br($request->syllabus);
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
            'price_type'         => 'required|string|max:191',
            'available_from'     => 'required|string|max:191',
            'available_to'       => 'required|string|max:191',
            'syllabus'           => 'required|string',
        ));

        $exam = Exam::find($id);
        $exam->examcategory_id = $request->examcategory_id;
        $exam->name = $request->name;
        $exam->duration = $request->duration;
        $exam->qsweight = $request->qsweight;
        $exam->negativepercentage = $request->negativepercentage;
        $exam->price_type = $request->price_type;
        $exam->available_from = Carbon::parse($request->available_from);
        $exam->available_to = Carbon::parse($request->available_to);
        $exam->syllabus = nl2br($request->syllabus);
        $exam->save();

        Session::flash('success', 'Exam updated successfully!');
        return redirect()->route('dashboard.exams');
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
        $exam->price_type = $oldexam->price_type;
        $exam->available_from = Carbon::parse($oldexam->available_from);
        $exam->available_to = Carbon::parse($oldexam->available_to);
        $exam->syllabus = $oldexam->syllabus;
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
        $questions = Question::select('id', 'question', 'topic_id')->get()->take(20);
        // $questions = Question::all();
        
        return view('dashboard.exams.addquestion')
                                    ->withExam($exam)
                                    ->withExamquestions($examquestions)
                                    ->withTopics($topics)
                                    ->withTags($tags)
                                    ->withQuestions($questions);
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
}
