<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Course;
use App\Exam;
use App\ExamCourse;
use App\ExamQuestion;
use App\Category;
use App\Question;
use App\Answer;
use App\UserAttempt;
use App\UserAnswer;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\FCM;
use Validator;
Use \Carbon\Carbon;
use DateTime;
class ExamController extends BaseController
{
    //
    public function index($course)
    {
        // if($type=='all')
        // {
        //     $notifications = Notification::all();
        // }
        $today = date("Y-m-d");
       
        $datetime1 = date_create($today);
        $exams = Exam::join('exam_courses','exams.id','exam_courses.exam_id')
                     ->join('courses','courses.id','exam_courses.course_id')
                     ->join('users','users.id','exams.created_by')
                     ->where('exam_courses.course_id','=',$course)
                     ->where('exam_courses.live_on','<=',$datetime1)
                     ->select('exams.id','exams.title','exam_courses.live_on','courses.course_title','exams.duration','exams.question_count','exams.correct_mark','exams.negative_mark','exams.cutoff','users.name as created_by')
                     ->get();
        
                     return $this->sendResponse($exams, 'User Exams.');
    }

    public function teacherExam()
    {
        $authuser = Auth::user();
        $exams = Exam::join('users','users.id','exams.created_by')
                    ->select('exams.id','exams.title','exams.duration','exams.question_count','exams.correct_mark','exams.negative_mark','exams.cutoff','users.name as created_by')
                    ->get();
        // $exams = Exam::join('exam_courses','exams.id','exam_courses.exam_id')
        //              ->join('courses','courses.id','exam_courses.course_id')
        //              ->join('users','users.id','exams.created_by')
        //              ->select('exams.id','exams.title','exam_courses.live_on','courses.course_title','exams.duration','exams.question_count','exams.correct_mark','exams.negative_mark','exams.cutoff','users.name as created_by')
        //              ->get();
        
                     return $this->sendResponse($exams, 'User Exams.');
    }

    public function examCourses($id)
    {
        $courses = Exam::join('exam_courses','exams.id','exam_courses.exam_id')
                        ->join('courses','courses.id','exam_courses.course_id')
                        ->where('exams.id','=',$id)
                        ->select('courses.id','courses.course_title')
                        ->get();
                        return $this->sendResponse($courses, 'User Exams.');

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

    public function questionIndex($exam)
    {
        $authuser = Auth::user();
        $userid = $authuser->id;
        $examstatus=0;
        $userstatus=0;
       // $userid = 17;
        $attemptstatus = DB::select('SELECT e.id,e.title,ec.live_on,ec.validity,MAX(ua.created_at) as user_last_attempt,ua.score,ua.is_complete,ua.id as user_attemptId FROM exams e JOIN user_attempt ua ON e.id=ua.exam_id JOIN students s ON ua.user_id=s.user_id JOIN exam_courses ec ON ec.course_id=s.course_id AND ec.exam_id=ua.exam_id WHERE ua.user_id = :userid AND ua.exam_id = :examid GROUP BY ua.exam_id', ['userid' => $userid,'examid' => $exam]);
        //SELECT e.id,e.title,ec.live_on,ec.validity,MAX(ua.created_at) as user_last_attempt,ua.score FROM exams e JOIN user_attempt ua ON e.id=ua.exam_id JOIN students s ON ua.user_id=s.user_id JOIN exam_courses ec ON ec.course_id=s.course_id AND ec.exam_id=ua.exam_id WHERE ua.user_id=? AND ua.exam_id=? AND ua.is_complete=1 GROUP BY ua.exam_id
        if(count($attemptstatus)>0)
        {

            if( $attemptstatus[0]->is_complete==0)
            {
                $userAttempt = UserAttempt::find($attemptstatus[0]->user_attemptId);
                $newDate = date('Y-m-d', strtotime($attemptstatus[0]->live_on. " + {$attemptstatus[0]->validity} days"));
                $userstatus=0;
                $examstatus=1;
            }
            else
            {
               
                $newDate = date('Y-m-d', strtotime($attemptstatus[0]->live_on. " + {$attemptstatus[0]->validity} days"));
                $today = date("Y-m-d");
                $now = new DateTime();
                $newDate1 = new DateTime($newDate);
                $datetime1 = date_create($today); 
                $datetime2 = date_create($newDate); 
                
                // Calculates the difference between DateTime objects 
                $interval = date_diff($datetime1, $datetime2); 
                $diff=$interval->format('%R%a');
                //$difference=date_diff($now,$newDate1);
                //return $diff=$difference->format('%a');
                if($diff<1)
                {
                    $examstatus=1;
                    $userstatus=1;
                }
                else
                {
                    $examstatus=0;
                    $userstatus=0;
                }
            }
           
        }
        else
        {
            $userAttempt = new UserAttempt;
            $userAttempt->exam_id = $exam;
            $userAttempt->user_id = $userid;
            $userAttempt->save();
            $examstatus=1;
        }
        if($examstatus==1 && $userstatus==1)
        {
            //after time period
            
            $userAttempt = new UserAttempt;
            $userAttempt->exam_id = $exam;
            $userAttempt->user_id = $userid;
            $userAttempt->save();
            $examstatus=1;
            $questions = DB::select('SELECT  q.id,q.question,q.image,q.description,eq.question_duration,(SELECT a.id FROM answers a  WHERE a.is_correct=1 AND a.question_id=eq.question_id ) as correct_choice_id FROM exam_questions eq JOIN questions q ON eq.question_id=q.id  JOIN exams e ON e.id=eq.exam_id WHERE eq.exam_id = :examid ', ['examid' => $exam]);
            $exam_questions=[];
            foreach($questions as $question)
            {
                $data['exam_status'] = $examstatus;
                $data['userCode'] = 102;
                $data['id'] = $question->id;
                $data['question'] = $question->question;
                $data['image'] = $question->image;
                $data['description'] = $question->description;
                $data['duration'] = $question->question_duration;
                $data['attemptId'] = $userAttempt->id;
                $data['correct_id'] = $question->correct_choice_id;
                $obj = Question::find($question->id);
                $data['choices'] = $obj->getChoices($question->id);
                array_push($exam_questions, $data);
             
            }
            return $this->sendResponse($exam_questions, 'User Questions.');
        }
        elseif($examstatus==1)
        {
           
            //new entry
             $questions = DB::select('SELECT  q.id,q.question,q.image,q.description,eq.question_duration,(SELECT a.id FROM answers a  WHERE a.is_correct=1 AND a.question_id=eq.question_id ) as correct_choice_id FROM exam_questions eq JOIN questions q ON eq.question_id=q.id  JOIN exams e ON e.id=eq.exam_id WHERE eq.exam_id = :examid ', ['examid' => $exam]);
            $exam_questions=[];
            foreach($questions as $question)
            {
                $data['exam_status'] = $examstatus;
                $data['id'] = $question->id;
                $data['userCode'] = 101;
                $data['question'] = $question->question;
                $data['image'] = $question->image;
                $data['description'] = $question->description;
                $data['duration'] = $question->question_duration;
                $data['attemptId'] = $userAttempt->id;
                $data['correct_id'] = $question->correct_choice_id;
                $obj = Question::find($question->id);
                $data['choices'] = $obj->getChoices($question->id);
                array_push($exam_questions, $data);
            }
            return $this->sendResponse($exam_questions, 'User Questions.');
        }
        else
        {
            $exam_questions=[];
            $data['exam_status'] = $examstatus;
            $data['userCode'] = 103;
            array_push($exam_questions, $data);
            return $this->sendResponse($exam_questions, 'You have already attended the exam.');
        }   

       
       
       
                            
                        //return view('exam.indexQuestion',compact('questions'));

    }

    public function storeUserAnswer($exam,Request $request)
    {
        $authuser = Auth::user();
        $attemptId=$request->attemptId;
        $examId = $request->examId;
        $examObj = Exam::find($examId);
        $score = 0;
        $correctMark = $examObj->correct_mark;
        $negativeMark = $examObj->negative_mark;
        $cutoff = $examObj->cutoff;
        foreach( $request->json()->get('answers') as $answer){
            //return $answer['choiceId'];
            $qstnObj = new Question;
            $correctAnswer = $qstnObj->getAnswer($answer['questionId']);
            $correctAnswer = $correctAnswer[0];
            //return $correctAnswer->id;
            if($correctAnswer->id == $answer['choiceId'])
            {
                $score = $score + $correctMark;
            }
            else
            {
                $score = $score - $negativeMark;
            }
            $userAnswer = new UserAnswer;
            $userAnswer->user_id = $authuser->id;
            $userAnswer->exam_id = $examId;
            $userAnswer->attempt_id = $attemptId;
            $userAnswer->question_id = $answer['questionId'];
            $userAnswer->choice_id = $answer['choiceId'];
            $userAnswer->save();
            

        }

        $userAttempt = UserAttempt::find($attemptId);
        $userAttempt->score = $score;
        $totalMark = $examObj->question_count * $examObj->correct_mark;
        $message = "";
        if($score<$cutoff)
        {
            $userAttempt->is_pass = 0;
            $message = "Soryy....! Your attempt for exam -'".$examObj->title."' is failed.You Obtained ".$score."/".$totalMark.".Continue Your Studies and Improve Your Skills...";
        }
        else
        {
            $userAttempt->is_pass = 1;
            $message = "Congatulations....! You Have Successfully Completed The Exam-'".$examObj->title."'.You Obtained ".$score."/".$totalMark.".";
        }
        $userAttempt->is_complete = 1;
        $userAttempt->save();
        return $this->sendResponse($userAttempt, $message);
    }
    public function examToppers($exam)
    {
         $toppers = DB::select('SELECT u.id,u.name,u.image,ua.score,DATE_ADD(ec.live_on,INTERVAL ec.validity DAY) AS validity,ua.created_at,c.course_title FROM user_attempt ua JOIN users u ON u.id=ua.user_id JOIN students s ON ua.user_id=s.user_id JOIN courses c ON c.id=s.course_id JOIN exam_courses ec ON ec.exam_id=ua.exam_id JOIN (SELECT MIN(id) as id FROM user_attempt WHERE exam_id= :examid GROUP BY user_id) AS fa ON ua.id=fa.id JOIN user_answers uan ON uan.attempt_id=fa.id  JOIN exams e ON ua.exam_id=e.id WHERE ua.exam_id= :exam AND unix_timestamp(ua.created_at) <= unix_timestamp(DATE_ADD(ec.live_on,INTERVAL ec.validity DAY))  GROUP BY fa.id ORDER BY ua.score DESC,ua.created_at DESC LIMIT 10', ['examid' => $exam,'exam' => $exam]);
        return $this->sendResponse($toppers,'Toppers List');
    }

    public function examReport($exam)
    {
        $authuser= Auth::user();
        $questions = DB::select('SELECT  q.id,q.question,q.image,q.description,eq.question_duration,(SELECT a.id FROM answers a  WHERE a.is_correct=1 AND a.question_id=eq.question_id ) as correct_choice_id FROM exam_questions eq JOIN questions q ON eq.question_id=q.id  JOIN exams e ON e.id=eq.exam_id WHERE eq.exam_id = :examid ', ['examid' => $exam]);
        $userChoices = DB::select('SELECT uan.attempt_id,uan.question_id,uan.is_opt,uan.choice_id FROM user_attempt ua JOIN students s ON ua.user_id=s.user_id JOIN exam_courses ec ON ec.exam_id=ua.exam_id AND ec.course_id=s.course_id JOIN (SELECT MIN(id) as id FROM user_attempt WHERE exam_id =:exam AND user_id=:userid GROUP BY user_id) AS fa ON ua.id=fa.id JOIN user_answers uan ON uan.attempt_id=fa.id   WHERE ua.exam_id= :examid AND unix_timestamp(ua.created_at) <= unix_timestamp(DATE_ADD(ec.live_on,INTERVAL ec.validity DAY)) ', ['exam' => $exam,'userid' => 18,'examid' => $exam]);   
        $exam_questions=[];
            foreach($questions as $question)
            {
               
                $data['userCode'] = 102;
                $data['id'] = $question->id;
                $data['question'] = $question->question;
                $data['image'] = $question->image;
                $data['description'] = $question->description;
                $data['duration'] = $question->question_duration;
                
                $data['correct_id'] = $question->correct_choice_id;
                $obj = Question::find($question->id);
                $data['choices'] = [];
                //$data['choices'] = $obj->getChoices($question->id);
                foreach($obj->getChoices($question->id) as $choice)
                {
                    $answer['id'] = $choice->id;
                    $answer['choice'] = $choice->choice;
                    $answer['question_id'] = $choice->question_id;
                    $answer['is_correct'] = $choice->is_correct;
                    $answer['user_choice'] = 0;
                    
                    foreach($userChoices as $userChoice)
                    {
                        
                        if($choice->id==$userChoice->choice_id)
                        {
                            $answer['user_choice'] = 1;
                        }
                       
                    }
                   array_push($data['choices'], $answer);
                }
                array_push($exam_questions, $data);
             
            }
            $score = UserAttempt::join('exams','exams.id','user_attempt.exam_id')
                                        ->where('user_attempt.id','=',$userChoices[0]->attempt_id)
                                        ->get();
            $result['report']=$exam_questions;
            $result['score']=$score;
            return $this->sendResponse($result,'User Exam Report');
    }

    public function getReportByCourse($exam,$course)
    {
        $reports = DB::select('SELECT ua.user_id,ua.score,ua.is_pass,ua.is_complete FROM user_attempt ua JOIN students s ON ua.user_id=s.user_id AND s.course_id=:course JOIN exam_courses ec ON ec.exam_id=ua.exam_id AND ec.course_id=s.course_id JOIN (SELECT MIN(id) as id FROM user_attempt WHERE exam_id= :exam  GROUP BY user_id) AS fa ON ua.id=fa.id WHERE ua.exam_id=:examid AND unix_timestamp(ua.created_at) <= unix_timestamp(DATE_ADD(ec.live_on,INTERVAL ec.validity DAY)) ', ['course' => $course,'exam' => $exam,'examid' => $exam]);
        
        $exam_report=[];
        foreach($reports as $report)
        {
                $data['user_id'] = $report->user_id;
                $data['score'] = $report->score;
                $data['is_pass'] = $report->is_pass?'Pass':'Fail';
                $user = User::find($report->user_id);
                $data['name'] = $user->name;
                $data['is_complete'] = $report->is_complete;
               
                array_push($exam_report, $data);
        }
        //return $exam_report;
        return $this->sendResponse($exam_report,'User Exam Report');

    }

}
