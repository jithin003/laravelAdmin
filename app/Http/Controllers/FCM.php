<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCM extends Controller
{
    const API_ACCESS_KEY = 'AAAAQzwtnQA:APA91bG3wABpxDNMxnibP55sMh5tS762X9XOoGFVnANJPE0_XPqfO6sUdaAgWSeew93DXG9wb6FDk2fkphuZETfm0KIxAH9-XOeUdEzC9asNsU48MCJ7KgABO_7COxtG7EW-PElOCs4Z';

    public static function notify($id, $message)
    {
        $data = array(
            'message' => $message,
            'vibrate' => 1,
            'soundname'=> 'default',
            'image'=>'www/assets/imgs/logo.png',
            'notId'=>mt_rand(),
            'target'=>'MyblogPage',
            
            'style'=> 'inbox',
    	    'summaryText'=> 'There are %n% notifications',
            /*'style'=>'picture',
    	    'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
            'summaryText'=> 'The internet is built on cat pictures',*/
            'content-available'=>1,
            
        );
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public static function notifyAll($fcmArray, $message)
    {
        $data = array(
            'message' => $message,
            'vibrate' => 1,
            'soundname'=> 'default',
            'image'=>'www/assets/imgs/logo.png',
            'notId'=>mt_rand(),
            'target'=>'GalleryPage',
            'style'=> 'inbox',
    	    'summaryText'=> 'There are %n% notifications',
            /*'style'=>'picture',
    	    'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
            'summaryText'=> 'The internet is built on cat pictures',*/
            'content-available'=>1,
            
        );
        $fields = array(
            'registration_ids' => $fcmArray,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    // public static function sendNotification($fcmArray, $message)
    // {
    //     $data = array(
    //         'message' => $message['message'],
    //         'vibrate' => 1,
    //         'soundname'=> 'default',
    //         'image'=>'www/assets/imgs/logo.png',
    //         'notId'=>mt_rand(),
    //         'target'=>'NotificationsPage',
    //         //'style'=> 'inbox',
    // 	    'summaryText'=> 'There are %n% notifications',
    //         'style'=>'picture',
    // 	    'picture'=> $message['picture'],
    //         'summaryText'=> $message['body'],
    //         'content-available'=>1,
            
    //     );
    //     $fields = array(
    //         'registration_ids' => $fcmArray,
    //         'data' => $data,
    //     );
    //     $headers = array(
    //         'Authorization: key =' . self::API_ACCESS_KEY,
    //         'Content-Type: application/json',
    //     );

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     return $result;
    // }
    public static function sendNotification($id, $message)
    {
        
            $data = array(
                'message' => $message,
                'vibrate' => 1,
                'soundname'=> 'default',
                'image'=>'www/assets/imgs/logo.png',
                'notId'=>mt_rand(),
                'target'=>'NotificationsPage',
                
                
                'picture'=> $message['picture'],
                'summaryText'=> $message['body'],
    
                'style'=> 'picture',
                
                /*'style'=>'picture',
                'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
                'summaryText'=> 'The internet is built on cat pictures',*/
                'content-available'=>1,
                
            );
        
        
        
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public static function notifyText($id, $message)
    {
        $data = array(
            'message' => $message,
            'vibrate' => 1,
            'soundname'=> 'default',
            'image'=>'www/assets/imgs/logo.png',
            'notId'=>mt_rand(),
            'target'=>'NotificationsPage',
            
            'style'=> 'inbox',
    	    'summaryText'=> 'There are %n% notifications',
            /*'style'=>'picture',
    	    'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
            'summaryText'=> 'The internet is built on cat pictures',*/
            'content-available'=>1,
            
        );
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public static function sendHomework($id, $message)
    {
        
            $data = array(
                'message' => $message,
                'vibrate' => 1,
                'soundname'=> 'default',
                'image'=>'www/assets/imgs/logo.png',
                'notId'=>mt_rand(),
                'target'=>'StudentHomeworkPage',
                
                
                'picture'=> $message['picture'],
                'summaryText'=> $message['body'],
    
                'style'=> 'picture',
                
                /*'style'=>'picture',
                'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
                'summaryText'=> 'The internet is built on cat pictures',*/
                'content-available'=>1,
                
            );
        
        
        
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public static function sendText($id, $message)
    {
        $data = array(
            'message' => $message,
            'vibrate' => 1,
            'soundname'=> 'default',
            'image'=>'www/assets/imgs/logo.png',
            'notId'=>mt_rand(),
            'target'=>'StudentHomeworkPage',
            
            'style'=> 'inbox',
    	    'summaryText'=> $message['body'],
            /*'style'=>'picture',
    	    'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
            'summaryText'=> 'The internet is built on cat pictures',*/
            'content-available'=>1,
            
        );
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public static function sendNote($id, $message)
    {
        $data = array(
            'message' => $message,
            'vibrate' => 1,
            'soundname'=> 'default',
            'image'=>'www/assets/imgs/logo.png',
            'notId'=>mt_rand(),
            'target'=>'SubjectsPage',
            
            'style'=> 'inbox',
    	    'summaryText'=> $message['body'],
            /*'style'=>'picture',
    	    'picture'=> 'https://i2.wp.com/beebom.com/wp-content/uploads/2016/01/Reverse-Image-Search-Engines-Apps-And-Its-Uses-2016.jpg?w=640&ssl=1',
            'summaryText'=> 'The internet is built on cat pictures',*/
            'content-available'=>1,
            
        );
        $fields = array(
            'to' => $id,
            'data' => $data,
        );
        $headers = array(
            'Authorization: key =' . self::API_ACCESS_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
