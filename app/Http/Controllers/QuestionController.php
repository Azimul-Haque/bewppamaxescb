<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Question;
use App\Questionimage;
use App\Questionexplanation;
use App\Topic;
use App\Tag;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
use OneSignal;

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
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalquestions = Question::count();
        $questions = Question::orderBy('id', 'desc')->paginate(10);
        $topics = Topic::orderBy('id', 'asc')->get();
        $tags = Tag::orderBy('id', 'asc')->get();

        return view('dashboard.questions.index')
                    ->withQuestions($questions)
                    ->withTopics($topics)
                    ->withTags($tags)
                    ->withTotalquestions($totalquestions);
    }

    public function getQuestionsSearch($search)
    {
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
            'question'    => 'required|string|max:255',
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
        $question->question   = $request->question;
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
            'question'    => 'required|string|max:255',
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
}
