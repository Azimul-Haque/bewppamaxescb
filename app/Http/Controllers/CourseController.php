<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Topic;
use App\Models\Exam;
use App\Models\Examcategory;
use App\Models\Course;
use App\Models\Courseexam;

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

class CourseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware(['admin'])->only('getExams');
    }

    public function getCourses()
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $courses = Course::orderBy('id', 'desc')->paginate(10);
        $totalcourses = Course::count();
        // $examcategories = Examcategory::all();
        // dd($courses);
        return view('dashboard.courses.index')
                    ->withCourses($courses)
                    ->withTotalcourses($totalcourses);
    }

    public function storeCourse(Request $request)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'name'   => 'required|string|max:191',
            'status' => 'required',
            'type' => 'required',
            'category' => 'required',
            'live' => 'required',
            'serial' => 'required',
        ));

        $course = new Course;
        $course->name = $request->name;
        $course->status = $request->status;
        $course->type = $request->type; // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
        $course->priority = $request->priority;
        $course->category = $request->category; // 1 = BCS, 2 = Primary, 3 = Bank, 4 = NTRCA, 5 = NSI/DGFI and Others, 6 = QB
        $course->live = $request->live; // live থাকলে কোর্স ক্যাটাগরির ভেতরে শো করবে
        $course->serial = $request->serial; // priority ব্যবহৃত হবে চলমান কোর্সসমূহ বার এ, serial ব্যবহৃত হবে কোর্স্ ক্যাটাগরিতে
        $course->save();

        Cache::forget('courses' . $request->type);
        Cache::forget('categorywisecourses' . $request->category);
        Session::flash('success', 'Course created successfully!');
        return redirect()->route('dashboard.courses');
    }
    
    public function updateCourse(Request $request, $id)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'name'   => 'required|string|max:191',
            'status' => 'required',
            'type' => 'required',
            'category' => 'required',
            'live' => 'required',
            'serial' => 'required',
        ));

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->status = $request->status;
        $course->type = $request->type; // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
        $course->priority = $request->priority;
        $course->category = $request->category; // 1 = BCS, 2 = Primary, 3 = Bank, 4 = NTRCS, 5 = NSI/DGFI and Others
        $course->live = $request->live; // live থাকলে কোর্স ক্যাটাগরির ভেতরে শো করবে
        $course->serial = $request->serial; // priority ব্যবহৃত হবে চলমান কোর্সসমূহ বার এ, serial ব্যবহৃত হবে কোর্স্ ক্যাটাগরিতে
        $course->save();

        Cache::forget('courses' . $request->type);
        Cache::forget('categorywisecourses' . $request->category);
        Session::flash('success', 'Course updated successfully!');
        return redirect()->back();
    }
    
    public function updateExamDatesCourse(Request $request, $id)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'available_from'     => 'required',
            'gapbetween'         => 'required',
            'oldwordtoreplace'   => 'sometimes',
            'newwordtoreplace'   => 'sometimes',
        ));

        $course = Course::findOrFail($id);
        // dd($course->courseexams);
        $newdate = Carbon::parse($request->available_from);
        foreach($course->courseexams as $courseexam) {
            $courseexam->exam->available_from = $newdate;
            $courseexam->exam->available_to = $newdate;
    
            if($request->oldwordtoreplace != '' && $request->newwordtoreplace != '' || $request->oldwordtoreplace != null && $request->newwordtoreplace != null) {
                // dd($courseexam->exam->name);
                $courseexam->exam->name = str_replace($request->oldwordtoreplace, $request->newwordtoreplace, $courseexam->exam->name);
            }
            $courseexam->exam->save();
            $newdate = $newdate->addDays($request->gapbetween);
        }

        Cache::forget('courseexams' . $id);
        Session::flash('success', 'Course updated successfully!');
        return redirect()->back();
    }

    public function editExamSerialCourse($id)
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $course = Course::findOrFail($id);

        $courseexams = Courseexam::where('course_id', $id)
                    ->with(['exam' => function ($query) {
                        // Ensure we select the columns we need, including 'serial'
                        $query->select('id', 'name', 'created_at', 'serial');
                    }])
                    // We use the secondary key for sorting since the serial management page 
                    // implies a specific order (e.g., newest exams first by exam_id)
                    ->orderBy('exam_id', 'desc') 
                    ->paginate(20); // Paginate with 20 items per page

        return view('dashboard.courses.editserial')
                    ->withCourse($course)
                    ->withCourseexams($courseexams);
    }
    
    public function updateExamSerialCourse(Request $request, $id)
    {
        $request->validate([
            'serial' => 'nullable|integer|min:0',
        ]);

        // Find the Exam record
        $exam = Exam::findOrFail($id);
        
        // Update the serial column
        $exam->serial = $request->serial ?? 0; // Default to 0 if null/empty
        $exam->save();

        Cache::forget('courseexams' . $id);
        return redirect()->back()->with('success', 'Exam serial updated successfully!');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        foreach($course->courseexams as $exams) {
            $exams->delete();
        }
        Cache::forget('courses' . $course->type);
        $course->delete();
        
        Session::flash('success', 'Course deleted successfully!');
        return redirect()->route('dashboard.courses');
    }
    
    public function addExamToCourse($id)
    {
        $course = Course::findOrFail($id);
        $courseexams = Courseexam::where('course_id', $course->id)
                                     ->orderBy('exam_id', 'desc')
                                     ->get();
        // $exams = Exam::all();

        $existingExamIds = Courseexam::where('course_id', $course->id)->pluck('exam_id')->toArray();
            
        // সব এক্সাম লোড করুন (Pagination সহ)
        // $exams = Exam::orderBy('id', 'desc')->paginate(30);

        $exams = Exam::select('id', 'name')
                ->where('examcategory_id', $course->category)
                // ->orderByRaw(DB::raw("CASE WHEN id IN (" . (empty($existingExamIds) ? '0' : implode(',', $existingExamIds)) . ") THEN 0 ELSE 1 END"))
                ->orderBy('id', 'desc')
                ->paginate(30); // প্রতি পেজে ৫০টি করে ডাটা

        return view('dashboard.courses.addexams')
                                    ->withCourse($course)
                                    ->withCourseexams($courseexams)
                                    ->withExistingExamIds($existingExamIds)
                                    ->withExams($exams);
    }

    public function storeCourseExam(Request $request)
    {
        $request->validate([
            'exam_ids' => 'nullable|array'
        ]);

        $course_id = $request->course_id;
        $selected_exam_ids = $request->exam_ids ?? [];
        
        // ৩. সেভ করার সময় হুবহু আগের মতো existingExamIds বের করতে হবে সর্টিং ঠিক রাখতে
        $existingExamIdsForSorting = Courseexam::where('course_id', $course_id)->pluck('exam_id')->toArray();

        // ৪. হুবহু একই সর্টিং ব্যবহার করে বর্তমান পেজের আইডিগুলো বের করা
        $current_page_exam_ids = Exam::select('id')
            ->orderByRaw(DB::raw("CASE WHEN id IN (" . (empty($existingExamIdsForSorting) ? '0' : implode(',', $existingExamIdsForSorting)) . ") THEN 0 ELSE 1 END"))
            ->orderBy('name', 'asc')
            ->paginate(50, ['*'], 'page', $request->page) // হিডেন ইনপুট থেকে আসা পেজ নম্বর
            ->pluck('id')
            ->toArray();

        try {
            // ২. ট্রানজ্যাকশন শুরু করা (যাতে কোনো এরর হলে ডেটাবেস উল্টাপাল্টা না হয়)
            DB::beginTransaction();

            DB::table('courseexams')
                ->where('course_id', $course_id)
                ->whereIn('exam_id', $current_page_exam_ids)
                ->delete();

            // ৬. নতুনগুলো ইনসার্ট করুন
            if (!empty($selected_exam_ids)) {
                $insertData = [];
                foreach ($selected_exam_ids as $exam_id) {
                    $insertData[] = [
                        'course_id' => $course_id,
                        'exam_id'   => $exam_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('courseexams')->insert($insertData);
            }

            DB::commit();
            return back()->with('success', 'সফলভাবে আপডেট করা হয়েছে!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'কিছু একটা সমস্যা হয়েছে: ' . $e->getMessage());
        }

        //////////
        //////////
        // $this->validate($request,array(
        //     'course_id'          => 'required',
        //     // 'hiddencheckarray' => 'required',
        //     // 'examcheck'    => 'required',
        // ));
        
        // $oldcourseexams = Courseexam::where('course_id', $request->course_id)->get();
        // if(count($oldcourseexams) > 0) {
        //     foreach($oldcourseexams as $oldcourseexam) {
        //         $oldcourseexam->delete();
        //     }
        // }
        // $hiddencheckarray = explode(',', $request->hiddencheckarray);
        // // sort($hiddencheckarray);
        // // dd($hiddencheckarray);
        
        // foreach($hiddencheckarray as $exam_id) {
        //     $courseexam = new Courseexam();
        //     $courseexam->course_id = $request->course_id;
        //     $courseexam->exam_id = $exam_id;
        //     $courseexam->save();
        // }

        // Cache::forget('courseexams' . $request->course_id);
        // Cache::forget('courses1');
        // Cache::forget('questionbank1');
        // Cache::forget('questionbank2');
        // Cache::forget('questionbank3');
        // Cache::forget('questionbank4');
        // Cache::forget('questionbank5');
        // Session::flash('success', 'Exams updated successfully!');
        // return redirect()->route('dashboard.courses.add.exam', $request->course_id);
    }

    public function deleteCourseExams(Request $request, $id)
    {
        DB::table('courseexams')->where('course_id', $id)->delete();
        return redirect()->back()->with('success', 'পরীক্ষাসমূহ সফলভাবে মুছে দেওয়া হয়েছে।');
    }
}
