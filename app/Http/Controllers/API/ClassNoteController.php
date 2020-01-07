<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Student;
use App\Notes;
use App\NotesContent;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\FCM;
use Validator;
class ClassNoteController extends BaseController
{
    //

    public function getClassNotes($subject)
    { 
        $authuser = Auth::user(); 
        //return $authuser;
        if($authuser)
        {
            
            if($authuser->role_id==3)
            {
                $student = Student::where('user_id','=',$authuser->id)->get();
                $student = $student[0];
                $classnotes = Notes::join('category','notes.category_id','category.id')
                                    ->join('courses','courses.id','notes.course_id')
                                    ->where('notes.category_id','=',$subject)
                                    ->where('notes.course_id','=',$student->course_id)
                                    ->select('notes.*', 'category.title as category','courses.course_title')
                                    ->get();
            }
            else
            {
                $classnotes = Notes::join('category','notes.category_id','category.id')
                                    ->join('courses','courses.id','notes.course_id')
                                    ->where('notes.category_id','=',$subject)
                                    ->where('notes.created_by','=',$authuser->id)
                                    ->select('notes.*', 'category.title as category','courses.course_title')
                                    ->get();
            }
            
                
         
                    //return $user;
                    $class_notes=[];
                    if(empty($classnotes))
                    {
                        
                        $message = "Notes Not Found or Empty";
                    }
                    else
                    {
                        
                        foreach($classnotes as $classnote)
                        {
                            $data['id'] = $classnote->id;
                            $data['title'] = $classnote->title;
                            $data['image'] = $classnote->image;
                            $data['description'] = $classnote->description;
                            $data['category_id'] = $classnote->category_id;
                            $data['category_title'] = $classnote->category;
                            $data['course_id'] = $classnote->course_id;
                            $data['course_title'] = $classnote->course_title;
                            $data['created_by'] = $classnote->created_by;
                            $obj = Notes::find($classnote->id);
                            $data['content'] = $obj->getContent($classnote->id);
                            array_push($class_notes, $data);
                        
                        }
                        
                        $message = "User Notes";
                    }
                    return $this->sendResponse($class_notes, $message);
                    
        }
    }

    public function deleteClassNotes(Request $request,$id)
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
    
    public function store(Request $request)
    {
        //return $request;
        
        $authuser = Auth::user(); 
        if($authuser->role_id != 3)
        {
            foreach( $request->json()->get('courses') as $course)
            {
                $new_note = new Notes;
                $new_note->title = $request->json()->get('title');
                $new_note->description = $request->json()->get('description');
                $new_note->course_id = $course;
                $new_note->category_id = $request->json()->get('category_id');
                $new_note->created_by = $authuser->id;
                $new_note->save();
                foreach( $request->json()->get('content') as $content)
                {
                    //return $content['url'];
                    $new_content = new NotesContent;
                    $new_content->notes_id = $new_note->id;
                    $new_content->url =  $content['url'];
                    $new_content->save();
                }
            }
            
        }
       
       
     
       
       
       
        
        return $this->sendResponse('', 'Class Notes Created .');
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
}
