<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use App\User_notification;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\FCM;
use Validator;
class NotificationController extends BaseController
{
    //
    public function getNotification()
    { 
        $authuser = Auth::user(); 
        //return $authuser;
        if($authuser)
        {
            $notification = Notification::join('user_notifications','notifications.id','user_notifications.notification_id')
                                          ->where('user_notifications.user_id',$authuser->id)
                                          ->orderBy('notifications.created_at', 'DESC')
                                          ->get();
                
         
                    //return $user;
                    return $this->sendResponse($notification, 'User Notifications.');
        }
    }

    public function deleteUserNotification(Request $request,$id)
    {
        $authuser = Auth::user(); 
        //return $id;
        if($authuser)
        {
                $userNotification = User_notification::where('user_id', $authuser->id)
                                                     ->where('notification_id',$id)
                                                     ->delete();
         
                    //return $user;
                    return $this->sendResponse($userNotification, 'User Notification Deleted.');
        }
        else
        {
            return $this->sendResponse($request, 'Not Valid.');
        }
    }
    public function deleteAllNotification(Request $request,$id)
    {
        $authuser = Auth::user(); 
        //return $id;
        if($authuser)
        {
                $userNotification = User_notification::where('notification_id',$id)
                                                     ->delete();
         
                    //return $user;
                    return $this->sendResponse($userNotification, 'User Notification Deleted.');
        }
        else
        {
            return $this->sendResponse($request, 'Not Valid.');
        }
    }
    public function store(Request $request)
    {
        //return $request;
        $notification = new Notification;
        $authuser = Auth::user(); 
        $notification->title = $request->json()->get('title');
        $notification->message = $request->json()->get('message');
        $notification->created_by = $authuser->id;
        $notification->image = $request->json()->get('image');
        $type = $request->json()->get('type');
        // if($request->file('image'))
        // {
        //     $imageName = time().'.'.$request->image->getClientOriginalExtension();
        //     $request->image->move(public_path('/uploadedimages'), $imageName);
        //     $notification->image = $imageName;
        // }
        
      //$user->slug = $user->makeSlug($name);
      //$user->first_name = $request->first_name;
      //$user->middle_name = $request->middle_name;
      //$user->last_name = $request->last_name;
     
        $result=$notification->save();
       
        if($result)
        { 
            if($type=="all")
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
            elseif($type=="staff")
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
                foreach( $request->json()->get('courses') as $course)
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
        
        return $this->sendResponse($notification, 'Notification Successfully Delivered.');
        //return redirect()->route('notifications')->withStatus(__('Notification Successfully Delivered.'));

    }
    public function file_store(Request $request)
    {
      return $request;
      // print_r($request);
      //$payLoad = json_decode(request()->getContent(), true);

      //dd($payLoad['name']);
      $request1 = json_decode(request()->getContent(), true);
      //return $payLoad;
        if($request->image)
        {
            //return $request->image->getClientOriginalExtension();
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploads/notification'), $imageName);
            $imgpath = $request->root().'/uploads/notification/'.$imageName;
            $response = [
                'status' => 'success',
                'details' => $imgpath
            ];       
        }    
     else {
      $response = [
            'status' => 'error',
            'message' => $request
        ];
      
    }
    return $response;

    }

    public function updateReadStatus()
    {
        $authuser = Auth::user(); 
        $notificationUpdate =  DB::table('user_notifications')->where('user_id', $authuser->id)->update(array('is_read' => 1,'last_read' => date('Y-m-d H:i:s')));
        return $notificationUpdate;
    }

    public function getReadStatus()
    {
        $authuser = Auth::user(); 
        $notificationUpdate =  User_notification::where('user_id','=',$authuser->id)
                                                ->where('is_read','=',0)
                                                ->get();
        $unread = count($notificationUpdate);
        return $this->sendResponse($unread, 'Notification Uread Count');
    }
}
