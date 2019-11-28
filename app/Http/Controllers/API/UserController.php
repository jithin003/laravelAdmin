<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use App\Student;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
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
                if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                    $user = Auth::user(); 
                    $success =  $user->createToken('Examapp'); 
                   // return response()->json(['success' => $success], $this-> successStatus); 
           
                    return $this->sendResponse($success, 'Login Successfully.');
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
                $user = Auth::user(); 
                // return response()->json(['success' => $user], $this-> successStatus); 
                return $this->sendResponse($user, 'User Registered successfully.');
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
        // $hasPassword = $request->get('password');
        // $user->update(
        //     $request->merge(['password' => Hash::make($request->get('password'))])
        //         ->except([$hasPassword ? '' : 'password']
        // ));

        // $student = Student::find($request->id);
        $user = Auth::user(); 
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
