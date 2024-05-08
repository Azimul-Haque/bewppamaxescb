<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Exam;
use App\Course;
use App\Courseexam;

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
        ));

        $course = new Course;
        $course->name = $request->name;
        $course->status = $request->status;
        $course->type = $request->type; // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
        $course->priority = $request->priority;
        $course->save();

        Cache::forget('courses' . $request->type);
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
        ));

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->status = $request->status;
        $course->type = $request->type; // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT, 5 = QB
        $course->priority = $request->priority;
        $course->save();

        Cache::forget('courses' . $request->type);
        Session::flash('success', 'Course updated successfully!');
        return redirect()->route('dashboard.courses');
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
        $exams = Exam::all();
        return view('dashboard.courses.addexams')
                                    ->withCourse($course)
                                    ->withCourseexams($courseexams)
                                    ->withExams($exams);
    }

    public function storeCourseExam(Request $request)
    {
        $this->validate($request,array(
            'course_id'          => 'required',
            'hiddencheckarray' => 'required',
            'examcheck'    => 'required',
        ));
        
        $oldcourseexams = Courseexam::where('course_id', $request->course_id)->get();
        if(count($oldcourseexams) > 0) {
            foreach($oldcourseexams as $oldcourseexam) {
                $oldcourseexam->delete();
            }
        }
        $hiddencheckarray = explode(',', $request->hiddencheckarray);
        // sort($hiddencheckarray);
        // dd($hiddencheckarray);
        
        foreach($hiddencheckarray as $exam_id) {
            $courseexam = new Courseexam();
            $courseexam->course_id = $request->course_id;
            $courseexam->exam_id = $exam_id;
            $courseexam->save();
        }

        Cache::forget('courseexams' . $request->course_id);
        Cache::forget('courses1');
        Cache::forget('questionbank1');
        Cache::forget('questionbank2');
        Cache::forget('questionbank3');
        Cache::forget('questionbank4');
        Cache::forget('questionbank5');
        Session::flash('success', 'Exams updated successfully!');
        return redirect()->route('dashboard.courses.add.exam', $request->course_id);
    }
}
