<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use App\Student;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
class UserController extends BaseController
{
    public $successStatus = 200;
            //
            /** 
             * login api 
             * 
             * @return \Illuminate\Http\Response 
             */ 
            public function login(){ 
                if(Auth::attempt(['phone' => request('mobile'), 'password' => request('password')])){ 
                    $user = Auth::user(); 
                    $success =  $user->createToken('Examapp'); 
                    //$user->apitoken = $success;
                    
                   return response()->json(['success' => $success,'user'=> $user], $this-> successStatus); 
           
                    //return $this->sendResponse($success, 'Login Successfully.');
                } 
                else{ 
                   // return response()->json(['error'=>'Unauthorised'], 401); 
                    return $this->sendError('Unauthorised.', '');    
                } 
            }
        /** 
             * Register api 
             * 
             * @return \Illuminate\Http\Response 
             */ 
            public function register(Request $request) 
            { 
                $validator = Validator::make($request->all(), [ 
                    'name' => 'required', 
                    'email' => 'required|email', 
                    'password' => 'required', 
                    'c_password' => 'required|same:password', 
                    'mobile' => 'required'
                  
                ]);
                if ($validator->fails()) { 
        
                    return $this->sendError('Validation Error.', $validator->errors());            
                }
               
                $input = $request->all(); 
                $user=User::where('phone',$request->mobile)->get();
                $user=$user[0];
                //return response()->json($user);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->get('password'));
                $user->phone = $request->mobile;
                $user->is_verified = 1;
            //$user->slug = $user->makeSlug($name);
            //$user->first_name = $request->first_name;
            //$user->middle_name = $request->middle_name;
            //$user->last_name = $request->last_name;
            
                $user->save();
                        // $input['password'] = bcrypt($input['password']); 
                        // $input->merge(['role_id' => 3]);
                        //$user = User::create($input); 
                        $success =  $user->createToken('Examapp'); 
                       // $success['name'] =  $user->name;
                //return response()->json(['success'=>$success], $this-> successStatus); 
                return $this->sendResponse($success, 'User Registered successfully.');
            }
        /** 
             * details api 
             * 
             * @return \Illuminate\Http\Response 
             */ 
            public function details() 
            { 
                $authuser = Auth::user(); 
                //return $authuser;
                if($authuser->role_id==3)
                {
                    $user = DB::table('users')
                            ->leftjoin('students', 'users.id', '=', 'students.user_id')
                            ->where('users.id', '=',$authuser->id )
                            ->select('users.*', 'students.admission_no', 'students.date_of_join')
                            ->get();
                            //return $user;
                            return $this->sendResponse($user, 'User Registered successfully.');
                }
                elseif($authuser->role_id==2)
                {
                    $user = DB::table('users')
                            ->join('staff', 'users.id', '=', 'staff.user_id')
                            ->where('users.id', '=',$authuser->id )
                            ->select('users.*', 'staff.job_title','staff.date_of_join','staff.qualification')
                            ->get();
                            return $this->sendResponse($user, 'User Registered successfully.');
                }
                else
                {
                    return $this->sendResponse($authuser, 'User Registered successfully.');
                }
                
                // return response()->json(['success' => $user], $this-> successStatus); 
                
            } 


            /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        //return $input = $request->all(); 
        // $hasPassword = $request->get('password');
        // $user->update(
        //     $request->merge(['password' => Hash::make($request->get('password'))])
        //         ->except([$hasPassword ? '' : 'password']
        // ));
        $user = Auth::user(); 
         //$user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $request->image;
        $user->dob = $request->dob;
        $user->fathers_name = $request->fathers_name;
        $user->mothers_name = $request->mothers_name;
        $user->house_name = $request->house_name;
        $user->street = $request->street;
        $user->post_office = $request->post_office;
        $user->district = $request->district;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->pin = $request->pin;
        $user->save();
        // if($request->role_id==3)
        // {
        //     $student = new Student;
        //     $student->admission_no = $request->admission;
        //     //$student->roll_no = $request->roll_no;
        //     $student->course_id = (int)$request->course;
    
        //     //$student->academic_id = (int)$request->academic_id;
        // //   $student->course_parent_id = (int)$request->course_parent_id;
            
    
            
        //     $student->date_of_join = $request->date_of_join;
        
        //     //$student->current_year = $current_year;
        //     //$student->current_semister = $current_semister;
        //     $student->user_id = $user->id;
    
        //     $student->save();
    
        // }
        // elseif($request->role_id==2)
        // {
        //     $staff = new Staff;
        //     $staff->job_title = $request->job;
        //     $staff->qualification = $request->qualification;
        //     //$student->academic_id = (int)$request->academic_id;
        // //   $student->course_parent_id = (int)$request->course_parent_id;
        //     $staff->date_of_join = $request->dateofjoin;;
        //     //$staff->total_experience = $request->experience;
        
        //     //$student->current_year = $current_year;
        //     //$student->current_semister = $current_semister;
        //     $staff->user_id = $user->id;
    
        //     $staff->save();
    
    
        // }
        // else
        // {

        // }
        // $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus);
        

       
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->delete();

       
    }
}
