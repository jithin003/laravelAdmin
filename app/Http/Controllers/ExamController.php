<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use App\User;
use App\Course;
use App\Exam;
use App\ExamCourse;
use App\Category;
use DB;
class ExamController extends Controller
{
    
    public function index()
    {
        // if($type=='all')
        // {
        //     $notifications = Notification::all();
        // }
        $exams = Exam::join('exam_courses','exams.id','exam_courses.exam_id')
                     ->join('courses','courses.id','exam_courses.course_id')
                     ->get();
        
        return view('exam.index',compact('exams'));
    }
    public function storeExam(Request $request)
    {
        //return $request;
        $exam = new Exam;
        $authuser = Auth::user(); 
        $exam->title = $request->name;
        $exam->duration = $request->duration;
        $exam->question_count = $request->count;
        $exam->correct_mark = $request->correct_mark;
        $exam->negative_mark = $request->incorrect_mark;
        $exam->cutoff = $request->cuttoff;
        
      //$user->slug = $user->makeSlug($name);
      //$user->first_name = $request->first_name;
      //$user->middle_name = $request->middle_name;
      //$user->last_name = $request->last_name;
     
        $result=$exam->save();
        if($result)
        {
            foreach( $request->course as $course)
            {
                $exam_course = new ExamCourse;
                $exam_course->exam_id = $exam->id;
                $exam_course->course_id = $course;
                $exam_course->live_on = $request->start_date;
                $exam_course->validity = 7;
                $exam_course->status = 1;
                $exam_course->save();
            }
        }
        return redirect()->back()->withStatus(__('Notification Successfully Delivered.'));
       
    }

    public function createExam(Request $request)
    {
        //$exams = Exam::all();
        $exams = Exam::join('exam_courses','exams.id','exam_courses.exam_id')
                     ->join('courses','courses.id','exam_courses.course_id')
                     ->get();
        $courses  = Course::all();
        return view('exam.create',compact('exams','courses'));
    }
    public function createQuestion(Request $request)
    {
        $categories  = Category::all();
        return view('exam.addquestion',compact('categories'));
    }


}
