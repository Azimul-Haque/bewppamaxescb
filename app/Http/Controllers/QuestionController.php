<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Question;
use App\Questionimage;
use App\Questionexplanation;
use App\Topic;
use App\Tag;
use App\Reportedquestion;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
use OneSignal;
use Purifier;

class QuestionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware(['admin'])->only('storeQuestionsTopic', 'storeQuestionsTag', 'deleteQuestion');
        // $this->middleware(['manager'])->only();
    }

    public function getQuestions()
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::count();
        $questions = Question::orderBy('id', 'desc')->paginate(10);
        // $questions = Question::orderBy('id', 'desc')->get()->chunk(200, function($questions){
        //     //do whatever you would normally be doing with the rows you receive
        //     // $domain stuff
        // });
        // dd($questions);
        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();

        // dd($questions);
        return view('dashboard.questions.index')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getQuestionsSearch($search)
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::where('question', 'LIKE', "%$search%")->count();
        $questions = Question::where('question', 'LIKE', "%$search%")
                             ->orWhere('option1', 'LIKE', "%$search%")
                             ->orWhere('option2', 'LIKE', "%$search%")
                             ->orWhere('option3', 'LIKE', "%$search%")
                             ->orWhere('option4', 'LIKE', "%$search%")
                             ->orderBy('id', 'desc')
                             ->paginate(10);
        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();

        Session::flash('success', $totalquestions . ' টি প্রশ্ন পাওয়া গিয়েছে!');
        return view('dashboard.questions.index')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getQuestionsTopicBased($id)
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::where('topic_id', $id)->count();
        $questions = Question::where('topic_id', $id)
                             ->orderBy('id', 'desc')
                             ->paginate(10);

        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();

        return view('dashboard.questions.index')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getQuestionsTagBased($id)
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Tag::find($id)->questions()->orderBy('id', 'desc')->count();
        $questions = Tag::find($id)->questions()->orderBy('id', 'desc')->paginate(10);

         // Question::where('topic_id', $id)
         //                     ->orderBy('id', 'desc')
         //                     ->paginate(10);

        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();

        return view('dashboard.questions.index')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getChangeTopicQuestions()
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::count();
        $questions = Question::orderBy('id', 'desc')->paginate(10);
        // $questions = Question::orderBy('id', 'desc')->get()->chunk(200, function($questions){
        //     //do whatever you would normally be doing with the rows you receive
        //     // $domain stuff
        // });
        // dd($questions);
        $topics = Topic::orderBy('id', 'asc')->get();
        // $tags = Tag::orderBy('id', 'asc')->get();

        // dd($questions);
        return view('dashboard.questions.changetopic')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    // ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getChangeTopicQuestionsSearch($search)
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::where('question', 'LIKE', "%$search%")->count();
        $questions = Question::where('question', 'LIKE', "%$search%")
                             ->orWhere('option1', 'LIKE', "%$search%")
                             ->orWhere('option2', 'LIKE', "%$search%")
                             ->orWhere('option3', 'LIKE', "%$search%")
                             ->orWhere('option4', 'LIKE', "%$search%")
                             ->orderBy('id', 'desc')
                             ->paginate(10);

        $topics = Topic::orderBy('id', 'asc')->get();
        // $tags = Tag::orderBy('id', 'asc')->get();

        // dd($questions);
        return view('dashboard.questions.changetopic')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    // ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function postChangeTopicQuestions(Request $request, $id)
    {
        $this->validate($request,array(
            'topicchangeid' => 'required',
        ));

        $question             = Question::findOrFail($id);
        $question->topic_id   = $request->topicchangeid;
        $question->save();

        Session::flash('success', 'সফলভাবে আপডেট করা হয়েছে, যাচাই করে দেখুন!');
        return redirect()->back();
    }


    public function getChangeTopicQuestionsTopicBased($id)
    {
        ini_set('memory_limit', '-1');
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::where('topic_id', $id)->count();
        $questions = Question::where('topic_id', $id)
                             ->orderBy('id', 'desc')
                             ->paginate(10);

        $topics = Topic::orderBy('id', 'asc')->get();
        // $tags = Tag::orderBy('id', 'asc')->get();

        return view('dashboard.questions.changetopic')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    // ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function storeQuestionsTopic(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
        ));

        $topic = new Topic;
        $topic->name = $request->name;
        $topic->save();

        Cache::forget('topics');
        Session::flash('success', 'Topic created successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function updateQuestionsTopic(Request $request, $id)
    {
        $this->validate($request,array(
            'name' => 'required|string|max:191',
        ));

        $topic = Topic::find($id);;
        $topic->name = $request->name;
        $topic->save();

        Cache::forget('topics');
        Session::flash('success', 'Topic updated successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function deleteQuestionsTopic($id)
    {
        $topic = Topic::find($id);
        $topic->delete();

        Cache::forget('topics');
        Session::flash('success', 'Topic deleted successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function storeQuestionsTag(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191|unique:tags,name',
        ));

        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();

        Session::flash('success', 'Tag created successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function updateQuestionsTag(Request $request, $id)
    {
        $this->validate($request,array(
            'name' => 'required|string|max:191|unique:tags,name,' . $id,
        ));

        $tag = Tag::find($id);;
        $tag->name = $request->name;
        $tag->save();

        Session::flash('success', 'Tag updated successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function deleteQuestionsTag($id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        Session::flash('success', 'Tag deleted successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function storeQuestion(Request $request)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'topic_id'    => 'required|string|max:191',
            'question'    => 'required',
            'option1'     => 'required|string|max:191',
            'option2'     => 'required|string|max:191',
            'option3'     => 'required|string|max:191',
            'option4'     => 'required|string|max:191',
            'answer'      => 'required',
            'difficulty'  => 'required|string|max:191',
            'image'       => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3000',
            'explanation' => 'sometimes|max:2048',
        ));

        $question             = new Question;
        $question->topic_id   = $request->topic_id;
        $question->question   = Purifier::clean($request->question, 'youtube');
        $question->option1    = $request->option1;
        $question->option2    = $request->option2;
        $question->option3    = $request->option3;
        $question->option4    = $request->option4;
        $question->answer     = $request->answer;
        $question->difficulty = $request->difficulty;
        $question->save();

        
        if(isset($request->tags_ids)){
            $question->tags()->sync($request->tags_ids, false);
        }

        // image upload
        if($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = random_string(5) . time() .'.' . "webp";
            $location = public_path('images/questions/'. $filename);
            Image::make($image)->resize(350, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $questionimage              = new Questionimage;
            $questionimage->question_id = $question->id;
            $questionimage->image       = $filename;
            $questionimage->save();
        }

        if($request->explanation) {
            $questionexplanation              = new Questionexplanation;
            $questionexplanation->question_id = $question->id;
            $questionexplanation->explanation = $request->explanation;
            $questionexplanation->save();
        }

        Session::flash('success', 'Question created successfully!');
        return redirect()->back();
        // if(request()->routeIs('dashboard.questionstopicbased')) {
        //     return redirect()->route('dashboard.questionstopicbased', $request->topic_id);
        // } else {
        //     return redirect()->route('dashboard.questions');
        // }
        
    }

    public function storeExcelQuestion(Request $request)
    {
        // dd($request->file('file'));
        ini_set('memory_limit', '512000000');
        try {
            $collections = (new FastExcel)->import($request->file('file'));
        } catch (\Exception $exception) {
            Session::flash('error', 'You have uploaded a wrong format file, please upload the right file.');
            return back();
        }

        // dd($collections);
        DB::beginTransaction();
        foreach ($collections as $collection) {
            try {
                $question             = new Question;
                $question->topic_id   = $collection['topic_id'];
                $question->question   = $collection['question'];
                $question->option1    = $collection['option1'];
                $question->option2    = $collection['option2'];
                $question->option3    = $collection['option3'];
                $question->option4    = $collection['option4'];
                $question->answer     = $collection['answer'];
                $question->difficulty = 1;
                $question->save();

                // APATOT KORA HOCCHE NA...
                // if(isset($request->tags_ids)){
                //     $question->tags()->sync($request->tags_ids, false);
                // }

                // APATOT KORA HOCCHE NA...
                // if($request->hasFile('image')) {
                //     $image    = $request->file('image');
                //     $filename = random_string(5) . time() .'.' . "webp";
                //     $location = public_path('images/questions/'. $filename);
                //     Image::make($image)->resize(350, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
                //     $questionimage              = new Questionimage;
                //     $questionimage->question_id = $question->id;
                //     $questionimage->image       = $filename;
                //     $questionimage->save();
                // }

                if($collection['explanation'] != null) {
                    $questionexplanation              = new Questionexplanation;
                    $questionexplanation->question_id = $question->id;
                    $questionexplanation->explanation = $collection['explanation'];
                    $questionexplanation->save();
                }

                if($collection['tag'] != null) {
                    $tagarray = explode(',', $collection['tag']);

                    // dd($tagarray);
                    $newquestiontags = [];
                    for ($i=0; $i < count($tagarray); $i++) { 
                        $checktag = Tag::where('name', $tagarray[$i])->first();
                        if($checktag) {
                            $newquestiontags[] = $checktag->id;
                        } else {
                            $tag = new Tag;
                            $tag->name = $tagarray[$i];
                            $tag->save();
                            $newquestiontags[] = $tag->id;
                            // dd($newquestiontags);
                        }
                    }

                    $question->tags()->sync($newquestiontags, false);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
        }
        
        Session::flash('success', 'Question uploaded successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function updateQuestion(Request $request, $id)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'topic_id'    => 'required|string|max:191',
            'question'    => 'required',
            'option1'     => 'required|string|max:191',
            'option2'     => 'required|string|max:191',
            'option3'     => 'required|string|max:191',
            'option4'     => 'required|string|max:191',
            'answer'      => 'required',
            'difficulty'  => 'required|string|max:191',
            'image'       => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3000',
            'explanation' => 'sometimes|max:2048',
        ));

        // dd($request->tags_ids);

        $question             = Question::findOrFail($id);
        $question->topic_id   = $request->topic_id;
        $question->question   = $request->question;
        $question->option1    = $request->option1;
        $question->option2    = $request->option2;
        $question->option3    = $request->option3;
        $question->option4    = $request->option4;
        $question->answer     = $request->answer;
        $question->difficulty = $request->difficulty;
        $question->save();

        if(isset($request->tags_ids)){
            $question->tags()->sync($request->tags_ids, true);
        }

        // image upload
        if($request->hasFile('image')) {
            if($question->questionimage) {
                $image_path = public_path('images/questions/'. $question->questionimage->image);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
                $question->questionimage->delete();
            }
            $image      = $request->file('image');
            $filename   = random_string(5) . time() .'.' . "webp";
            $location   = public_path('images/questions/'. $filename);
            Image::make($image)->resize(350, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $questionimage = new Questionimage;
            $questionimage->question_id = $question->id;
            $questionimage->image = $filename;
            $questionimage->save();
        }

        if($request->explanation) {
            if($question->questionexplanation) {
                $question->questionexplanation->explanation = $request->explanation;
                $question->questionexplanation->save();
            } else {
                $questionexplanation = new Questionexplanation;
                $questionexplanation->question_id = $question->id;
                $questionexplanation->explanation = $request->explanation;
                $questionexplanation->save();
            }
        }

        Session::flash('success', 'Question updated successfully!');
        // return redirect()->route('dashboard.questions');
        return redirect()->back();
        // dd(url()->previous());
        // if(request()->routeIs('dashboard.questionstopicbased')) {
        //     return redirect()->route('dashboard.questionstopicbased', $request->topic_id);
        // } else {
        //     return redirect()->route('dashboard.questions');
        // }
    }

    public function deleteQuestion($id)
    {
        $question = Question::find($id);
        if($question->questionimage) {
            $image_path = public_path('images/questions/'. $question->questionimage->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $question->questionimage->delete();
        }
        if($question->questionexplanation) {
            $question->questionexplanation->delete();
        }
        $question->delete();

        Session::flash('success', 'Question deleted successfully!');
        return redirect()->route('dashboard.questions');
    }

    public function sendNotificationQuestion($id)
    {
        $question = Question::findOrFail($id);
        $answertext = $question['option' . $question->answer];
        // LIVE HOILE ETA DEOA HOBE
        // LIVE HOILE ETA DEOA HOBE
        $strippedquestion = strip_tags($question->question) != "" ? strip_tags($question->question) : 'ছবিতে প্রশ্নটি দেখুন ও উত্তর করুন!';
        OneSignal::sendNotificationToAll(
            "উত্তর দেখতে নোটিফিকেশনে ক্লিক করুন",
            $url = null, 
            $data = array("a" => 'answer', "b" => $answertext, 'c' => $question->questionexplanation ? $question->questionexplanation->explanation : '', "d" => $question->question),
            $buttons = null, 
            $schedule = null,
            $headings = $strippedquestion,
        );

        // $strippedquestion = strip_tags($question->question) != "" ? strip_tags($question->question) : 'ছবিতে প্রশ্নটি দেখুন ও উত্তর করুন!';
        // OneSignal::sendNotificationToUser(
        //     "উত্তর দেখতে নোটিফিকেশনে ক্লিক করুন",
        //     ['94c77039-3ea3-453f-9bc3-027138785563'], // 716ffeb3-f6c2-4a4a-a253-710f339aa863
        //     $url = null, 
        //     $data = array("a" => 'answer', "b" => $answertext, 'c' => $question->questionexplanation ? $question->questionexplanation->explanation : '', "d" => $question->question),
        //     $buttons = null, 
        //     $schedule = null,
        //     $headings = $strippedquestion,
        // );

        Session::flash('success', 'Question sent in Notification successfully!');
        return redirect()->back();
    }

    public function getReportedQuestions()
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }

        $reportedquestions = Reportedquestion::orderBy('created_at', 'desc')->where('status', 0)->paginate(10);

        $totalreportedquestions  = Reportedquestion::where('status', 0)->count();
        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();
        
        return view('dashboard.questions.reported')
                    ->withReportedquestions($reportedquestions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalreportedquestions($totalreportedquestions);
    }

    public function getReportedQuestionsSearch($search)
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }

        $reportedquestions = Reportedquestion::whereHas('Question', function($q) use ($search){
                        $q->where('question', 'LIKE', "%$search%");
                        $q->orWhere('option1', 'LIKE', "%$search%");
                        $q->orWhere('option2', 'LIKE', "%$search%");
                        $q->orWhere('option3', 'LIKE', "%$search%");
                        $q->orWhere('option4', 'LIKE', "%$search%");
                        $q->orderBy('id', 'desc');
                    })->where('status', 0)->paginate(10);

        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();
        
        Session::flash('success', $reportedquestions->count() . ' টি রিপোর্টেড প্রশ্ন পাওয়া গিয়েছে!');
        return view('dashboard.questions.reported')
                    ->withReportedquestions($reportedquestions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalreportedquestions($reportedquestions->count());
    }

    public function deleteReportedQuestionsSearch($id)
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')) {
            abort(403, 'Access Denied');
        }

        $reportedquestion = Reportedquestion::findOrFail($id);
        $reportedquestion->status = 1;
        $reportedquestion->save();
        
        Session::flash('success', 'প্রশনটি সমাধান করা হয়েছে!');
        return redirect()->back();
    }
}
