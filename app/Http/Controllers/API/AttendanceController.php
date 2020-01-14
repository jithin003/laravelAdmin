<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\StudentAttendance;
use App\Attendance;
use App\User;
use App\Student;
Use \Carbon\Carbon;
use DateTime;
use App\Http\Controllers\API\BaseController as BaseController;
class AttendanceController extends BaseController
{
    //

    public function getStudents(Request $request,$course,$date)
    { 
        $authuser = Auth::user(); 
        //return $course;
        //return $authuser;
        if($authuser)
        {
           
                
        //sql='SELECT  * FROM students s JOIN users u ON u.id=s.user_id LEFT JOIN attendance_status ast ON ast.course_id=s.course_id   AND  date(ast.attendance_date)=date(?)  LEFT JOIN student_attendance sa ON sa.user_id=s.user_id AND sa.status=0 AND date(sa.attendance_date)=date(?) WHERE  s.course_id=?';
        //return $result=DB::select("SELECT  * FROM students s JOIN users u ON u.id=s.user_id LEFT JOIN attendance ast ON ast.course_id=s.course_id   AND  date(ast.attendance_date)=".$date." LEFT JOIN student_attendance sa ON sa.user_id=s.user_id AND date(sa.attendance_date)=".$date." WHERE  s.course_id=".$course);
        $results=DB::select("SELECT u.id,s.admission_no,u.name,u.image,u.house_name,u.street,u.post_office,u.state,u.pin,u.phone,u.mothers_name,u.fathers_name,ast.attendance_date,sa.attendance_date as absent_date FROM students s JOIN users u ON u.id=s.user_id LEFT JOIN attendance ast ON ast.course_id=s.course_id  AND  date(ast.attendance_date)=:dat LEFT JOIN student_attendance sa ON sa.user_id=s.user_id AND date(sa.attendance_date)=:dat1 WHERE  s.course_id=:id ORDER BY u.name",['id' => $course,'dat'=>$date,'dat1'=>$date]);
        // DB::table('students')
        // ->join('users', 'users.id', '=', 'students.user_id')
        // ->leftjoin('attendance_status', 'attendance_status.course_id', '=', 'students.course_id')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        // ->get();         
        //return $results;
        $students=[];
       
        foreach($results as $user)
        {
            $account['name'] = $user->name;
            $account['id'] = $user->id;
            $account['user_id'] = $user->id;
            $account['admission_no'] = $user->admission_no;
            //$account['image'] = public_path()."/uploadedimages/".$user->image;
            $account['house_name'] = $user->house_name;
            $account['street'] = $user->street;
            $account['post_office'] = $user->post_office;
            $account['state'] = $user->state;
            $account['pin'] = $user->pin;
            $account['phone'] = $user->phone;
            $account['mothers_name'] = $user->mothers_name;
            $account['fathers_name'] = $user->fathers_name;
            $account['dayStatus'] = $user->attendance_date?true:false;
            $account['status'] = !$user->absent_date && $user->attendance_date?true:false;
            // if ($user->student) {
            //     $account['class'] = $user->student->course ? $user->student->course->course_title : 'no class found';
            //     $account['course_id'] = $user->student->course ? $user->student->course->id : null;
            // } else if ($user->staff) {
            //     $account['class'] = $user->staff->course ? $user->staff->course->course_title : 'Subject Teacher';
            //     $account['course_id'] = $user->staff->course ? $user->staff->course->id : null;
            // }
            $account['image'] = url('uploadedimages/') . '/' . $user->image;
           //return $account;
           array_push($students, $account);
        }
        //return $students;
                    return $this->sendResponse($students, 'Students.');
        }
    }

    public function setAttendance(Request $request,$course,$date)
    {
        
        $authuser = Auth::user(); 
        //$sql=DB::select("select * from attendance where date(attendance_date)=date($date) and course_id=$course");
        $sq = Attendance::where('attendance_date',$date)
                        ->where('course_id',$course)
                        ->get();
               $query=Attendance::whereRaw('attendance_date = ? and course_id = ?', [$date,$course])->get();
        //return $query;
        if($sq->count()>0)
        {
            $students=$request->json()->get('data');;
            $deletedRows = StudentAttendance::where('attendance_date', $date)
                                            ->where('course_id',$course)
                                            ->delete();
                foreach($students as $student)
                {
                    if($student['status']==false)
                    {
                        //$result = $this->insertAbsent($student,$course,$date);
                        $studentAttendance = new StudentAttendance;
                        $studentAttendance->user_id = $student['user_id'];
                        $studentAttendance->course_id = $course;
                        $studentAttendance->attendance_date = $date;
                        $studentAttendance->save();
                    }
                    
                }
            return $this->sendResponse($students, 'Attendance Updated Successfully.');
            
        }
        else
        {
            $students=$request->json()->get('data');
            $data=[];
            $attendance = new Attendance;
            $attendance->course_id = $course;
            $attendance->attendance_date = $date;
            $attendance->updated_by = $authuser->id; 
            $attendance->save();
            //return $attendance->id;
          
            if($attendance)
            { 
                 //$students = $request->data;
                 $students=$request->json()->get('data');
                $count=0;
               //return $students;
                foreach($students as $student)
                {
                    
                    if($student['status']==false)
                    {
                    //      $data = User::where('id', $student['user_id'])->first();
                    // return $data;
                       // $result = $this->insertAbsent($student,$course,$date);
                       $studentAttendance = new StudentAttendance;
                       $studentAttendance->user_id = $student['user_id'];
                       $studentAttendance->course_id = $course;
                       $studentAttendance->attendance_date = $date;
                       $studentAttendance->save();
                       $count++;
                        
                    }
                    
                }
                return $this->sendResponse($count, 'Attendance Inserted Successfully.');
            }
            return $this->sendResponse($students, 'Error.');

        }
    }
    public function insertAbsent($student,$course,$date)
    {
       //$sql='select * from attendance_status where date(attendance_date)=date(?) and course_id=? ';
       
       //**total working days= SELECT COUNT(ast.course_id) as cnt FROM attendance_status ast WHERE ast.course_id=? AND ast.attendance_date BETWEEN date(?) AND date(?)*/
         //**absentdays=SELECT sa.attendance_date as date FROM student_attendance sa WHERE  sa.user_id=? AND sa.attendance_date BETWEEN date(?) AND date(?) */               
                        $studentAttendance = new StudentAttendance;
                        $studentAttendance->user_id = $student->user_id;
                        $studentAttendance->course_id = $course;
                        $studentAttendance->attendance_date = date($date);
                        $studentAttendance->save();
                        return $studentAttendance;
       
    }

    public function userAttendance($id)
    {
        $startData = Attendance::first();
        $startDate = $startData->attendance_date;
        $today = date("Y-m-d");
        $datetime1 = date_create($today); 
        $authuser = Auth::user();
        $student = Student::where('user_id',$authuser->id)->get();
        $student = $student[0];
         $totalworkingDays = Attendance::where('course_id',$student->course_id)
                                      ->whereBetween('attendance_date',[$startData,$datetime1])
                                      ->count('course_id');
         $absentDays = StudentAttendance::select('attendance_date')->where('user_id',$authuser->id)
                                        ->whereBetween('attendance_date',[$startData,$datetime1])
                                        ->get();
         $totalAbsentDays = count($absentDays);
         $response = [

            'totalWorkingDays' => $totalworkingDays,

            'totalAbsentDays' => $totalAbsentDays,
            'AbsentDates'=> $absentDays

        ];
        return $this->sendResponse($response, 'Absent report.');

    }

}
