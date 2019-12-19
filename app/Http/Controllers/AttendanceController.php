<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\User;
use App\Course;
use DB;
class AttendanceController extends Controller
{
    //
    public function index()
    {
        // if($type=='all')
        // {
        //     $notifications = Notification::all();
        // }
        $courses = Course::all();
        
        return view('attendance.index',compact('courses'));
    }


}
