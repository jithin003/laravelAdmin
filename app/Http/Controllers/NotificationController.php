<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Auth; 
use App\User_notification;
use App\User;
use DB;
class NotificationController extends Controller
{
    //

    public function index($type)
    {
        // if($type=='all')
        // {
        //     $notifications = Notification::all();
        // }
        $notifications = Notification::all();
        
        return view('notification.index',compact('notifications'));
    }



    public function store(Request $request)
    {
       
        //return $request;
        $notification = new Notification;
        $authuser = Auth::user(); 
        $notification->title = $request->title;
        $notification->message = $request->message;
        $notification->created_by = $authuser->id;
        if($request->file('image'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploadedimages'), $imageName);
            //$image = base64_encode(file_get_contents($request->file('image')));
            $notification->image = url('/').'/uploadedimages/'.$imageName;
        }
        
      //$user->slug = $user->makeSlug($name);
      //$user->first_name = $request->first_name;
      //$user->middle_name = $request->middle_name;
      //$user->last_name = $request->last_name;
     
        $result=$notification->save();
       
        if($result)
        { 
            if($request->type=="all")
            {
                $users = User::all();
                //return $users;
                foreach ($users as $user) 
                {
        
                    $user_notification = new User_notification;
                    $notification_id = $notification->id;
                    $user_id = $user->id;
                    $user_notification->notification_id = $notification->id;
                    $user_notification->user_id = $user_id;
                    $user_notification->last_read =date('Y-m-d H:i:s');
                    // DB::table('user_notifications')->insert(
                    //     ['notification_id' => $notification_id, 'user_id' => $user_id]
                    // );
                    $user_notification->save();

                    if($user->fcmtoken){
                        array_push($fcm_ids,$user->fcmtoken);
                        array_push($userName,$user->name);
                    }
                    
                
                
                //  $message['message'] = "test";
                    if($notification->image)
                    {
                        $message['message'] = $notification->title;
                        $message['picture'] = $notification->image;
                        $message['body'] = $notification->description;
                        $id = FCM::sendNotification($user->fcmtoken, $message);
                    }
                    else{
                        $message['message'] = $notification->title;
                        $message['body'] = $notification->description;
                        $id = FCM::notifyText($user->fcmtoken, $message);
                    }
                
                }     
            }
            elseif($request->type=="staff")
            {
                $users = User::where('role_id',2)->get();
                //return $users;
                foreach ($users as $user) 
                {
        
                    $user_notification = new User_notification;
                    $notification_id = $notification->id;
                    $user_id = $user->id;
                    $user_notification->notification_id = $notification->id;
                    $user_notification->user_id = $user_id;
                    $user_notification->last_read =date('Y-m-d H:i:s');
                    // DB::table('user_notifications')->insert(
                    //     ['notification_id' => $notification_id, 'user_id' => $user_id]
                    // );
                    $user_notification->save();

                    if($user->fcmtoken){
                        array_push($fcm_ids,$user->fcmtoken);
                        array_push($userName,$user->name);
                    }
                    
                
                
                //  $message['message'] = "test";
                    if($notification->image)
                    {
                        $message['message'] = $notification->title;
                        $message['picture'] = $notification->image;
                        $message['body'] = $notification->description;
                        $id = FCM::sendNotification($user->fcmtoken, $message);
                    }
                    else{
                        $message['message'] = $notification->title;
                        $message['body'] = $notification->description;
                        $id = FCM::notifyText($user->fcmtoken, $message);
                    }
                
                }     
            }
            else
            {
                foreach( $request->course as $course)
                {
                    $users = User::join('students','users.id','students.user_id')
                        ->where('students.course_id',$course)
                        ->select('users.id','users.name','users.role_id','users.image','users.phone','users.fcmtoken')
                        ->get();
                        //return $users;
                    foreach ($users as $user) 
                    {
            
                        $user_notification = new User_notification;
                        $notification_id = $notification->id;
                        $user_id = $user->id;
                        $user_notification->notification_id = $notification->id;
                        $user_notification->user_id = $user_id;
                        $user_notification->last_read =date('Y-m-d H:i:s');
                        // DB::table('user_notifications')->insert(
                        //     ['notification_id' => $notification_id, 'user_id' => $user_id]
                        // );
                        $user_notification->save();
    
                        if($user->fcmtoken){
                            array_push($fcm_ids,$user->fcmtoken);
                            array_push($userName,$user->name);
                        }
                        
                    
                    
                    //  $message['message'] = "test";
                        if($notification->image)
                        {
                            $message['message'] = $notification->title;
                            $message['picture'] = $notification->image;
                            $message['body'] = $notification->description;
                            $id = FCM::sendNotification($user->fcmtoken, $message);
                        }
                        else{
                            $message['message'] = $notification->title;
                            $message['body'] = $notification->description;
                            $id = FCM::notifyText($user->fcmtoken, $message);
                        }
                    
                    }
                }

            }
            
        }
        

        return redirect()->route('notifications')->withStatus(__('Notification Successfully Delivered.'));
    }

    
    public function edit(Request $request,$id)
    {
        $course = Course::find($id);
        return view('courses.edit', compact('course'));
    }

   
    public function update(Request $request,$course)
    {
        $cobj = Course::find($course);
        $cobj->course_title = $request->name;
        $cobj->course_code = $request->code;
        $cobj->save();
        return redirect()->route('course')->withStatus(__('Course successfully updated.'));
    }


    public function destroy($course)
    {
        $cobj = Course::find($course);
        $cobj->delete();

        return redirect()->route('course')->withStatus(__('Course successfully deleted.'));
    }

}
