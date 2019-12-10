<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        $results=DB::select("SELECT u.id,s.admission_no,u.name,u.image,u.house_name,u.street,u.post_office,u.state,u.pin,u.phone,u.mothers_name,u.fathers_name,ast.attendance_date,sa.attendance_date as absent_date FROM students s JOIN users u ON u.id=s.user_id LEFT JOIN attendance ast ON ast.course_id=s.course_id  AND  date(ast.attendance_date)=$date LEFT JOIN student_attendance sa ON sa.user_id=s.user_id AND date(sa.attendance_date)=$date WHERE  s.course_id=$course");
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

}
