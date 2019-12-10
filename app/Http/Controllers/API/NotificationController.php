<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use App\User_notification;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
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
}
