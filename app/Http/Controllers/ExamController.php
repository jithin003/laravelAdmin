<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use App\User;
use App\Course;
use App\Exam;
use App\ExamCourse;
use App\ExamQuestion;
use App\Category;
use App\Question;
use App\Answer;
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
                     ->select('exams.id','exams.title','exam_courses.live_on','courses.course_title')
                     ->get();
        $allexams = Exam::all();
        return view('exam.index',compact('exams','allexams'));
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
        $exam->created_by = $authuser->id;
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
        $subjects  = Category::all();
        return view('exam.addquestion',compact('subjects'));
    }
    
    public function addquestion($request)
    {
        $subjects  = Category::all();
        $exam = Exam::find($request);
        $examquestions = Question::join('exam_questions','exam_questions.question_id','questions.id')
                                 ->join('category','category.id','questions.category_id')
                                 ->select('questions.id','questions.question','questions.description','category.title')
                                 ->where('exam_questions.exam_id',$request)
                                 ->get();
        return view('exam.addexamquestion',compact('exam','subjects','examquestions'));
    }

    public function storeQuestion(Request $request)
    {
        $this->validate($request, [
            'question' => 'required', 
            'correct_answer1' => 'required', 
            'correct_answer2' => 'required', 
            'correct_answer' => 'required',
            'subject' => 'required',   
                                 
        ]);
        if($request->correct_answer=="correct_answer1")
        {
            if($request->correct_answer1==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
                
            }
           
        }
        elseif($request->correct_answer=="correct_answer2")
        {
            if($request->correct_answer2==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        elseif($request->correct_answer=="correct_answer3")
        {
            if($request->correct_answer3==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        elseif($request->correct_answer=="correct_answer4")
        {
            if($request->correct_answer4==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        else
        {
            if($request->correct_answer5==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        $question = new Question;
        $question->question = $request->question;
        $question->description = $request->description?$request->description:"";
        $question->category_id = $request->subject;
        if($request->file('photo'))
        {
            $imageName = time().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('/uploadedimages'), $imageName);
            //$image = base64_encode(file_get_contents($request->file('image')));
            $question->image = url('/').'/uploadedimages/'.$imageName;
        }
        $result=$question->save();
        if($result)
        {
            if($request->correct_answer1)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer1;
                if($request->correct_answer=="correct_answer1")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer2)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer2;
                if($request->correct_answer=="correct_answer2")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer3)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer3;
                if($request->correct_answer=="correct_answer3")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer4)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer4;
                if($request->correct_answer=="correct_answer4")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer5)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer5;
                if($request->correct_answer=="correct_answer5")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }

        }

        return $question;
    }

    public function storeExamQuestion(Request $request)
    {
        //return $request;
        $this->validate($request, [
            'question' => 'required', 
            'correct_answer1' => 'required', 
            'correct_answer2' => 'required', 
            'correct_answer' => 'required',
            'subject' => 'required',   
                                 
        ]);
        if($request->correct_answer=="correct_answer1")
        {
            if($request->correct_answer1==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
                
            }
           
        }
        elseif($request->correct_answer=="correct_answer2")
        {
            if($request->correct_answer2==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        elseif($request->correct_answer=="correct_answer3")
        {
            if($request->correct_answer3==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        elseif($request->correct_answer=="correct_answer4")
        {
            if($request->correct_answer4==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        else
        {
            if($request->correct_answer5==null)
            {
                return redirect()->back()->withErrors(['message' => 'Invalid answer']);
            }
        }
        $question = new Question;
        $question->question = $request->question;
        $question->description = $request->description?$request->description:"";
        $question->category_id = $request->subject;
        if($request->file('photo'))
        {
            $imageName = time().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('/uploadedimages'), $imageName);
            //$image = base64_encode(file_get_contents($request->file('image')));
            $question->image = url('/').'/uploadedimages/'.$imageName;
        }
        $result=$question->save();
        if($result)
        {
            if($request->correct_answer1)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer1;
                if($request->correct_answer=="correct_answer1")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer2)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer2;
                if($request->correct_answer=="correct_answer2")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer3)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer3;
                if($request->correct_answer=="correct_answer3")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer4)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer4;
                if($request->correct_answer=="correct_answer4")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }
            if($request->correct_answer5)
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->choice = $request->correct_answer5;
                if($request->correct_answer=="correct_answer5")
                {
                    $answer->is_correct = 1;
                }
                else
                {
                    $answer->is_correct = 0;
                }
                $answer->save();
            }

            $exam_question = new ExamQuestion;
            $exam_question->exam_id = $request->examId;
            $exam_question->question_id = $question->id;
            $exam_question->question_duration = $request->duration;
            $exam_question->save();

        }

        //return $question;
        $exanname = Exam::find($request->examId);
        return redirect()->back()->withStatus(__('Question successfully added to "'.$exanname->title.'"'));
    }
    public function questionIndex()
    {
        $questions = Question::join('category','questions.category_id','category.id')
                            ->select('questions.id','questions.question','questions.description','category.title')
                            ->get();
                            //return $questions;
                        return view('exam.indexQuestion',compact('questions'));

    }

    public function viewExam($id)
    {
        $exam = Exam::find($id);
        $examquestions = Question::join('exam_questions','exam_questions.question_id','questions.id')
                                 ->join('category','category.id','questions.category_id')
                                 ->select('questions.id','questions.question','questions.description','category.title')
                                 ->where('exam_questions.exam_id',$id)
                                 ->get();
        return view('exam.viewExam',compact('exam','examquestions'));
    }

    public function getExamCourse()
    {
        $exams = Exam::all();
        $courses = Course::all();
       
        return view('exam.addexamcourse',compact('exams','courses'));
    }

    public function setExamCourse(Request $request)
    {
       // return $request;
       foreach($request->course as $course)
        {
            $examcourse = ExamCourse::where('course_id',$course)
                                    ->where('exam_id',$request->examid)
                                    ->get();
            if(count($examcourse)>0)
            {
                //return $examcourse;
            }
            else
            {
                //return $request;
                $newexamcourse = new ExamCourse;
                $newexamcourse->exam_id = $request->examid;
                $newexamcourse->course_id = $course;
                $newexamcourse->validity = 7;
                $newexamcourse->live_on = $request->start_date;
                $newexamcourse->status = 1;
                $newexamcourse->save();
            }
        }
        return redirect()->back()->withStatus(__('Exam allocated to course.'));
        
    }

    public function destroy($id)
    {
        
        $eamcourse = ExamCourse::where('exam_id',$id)
                                ->delete();
                                //return $eamcourse;
        $cobj = Exam::find($id);
        $cobj->delete();

        return redirect()->route('exam')->withStatus(__('Exam successfully deleted.'));
    }
}
