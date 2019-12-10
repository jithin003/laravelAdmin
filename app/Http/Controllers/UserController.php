<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use App\Staff;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
       
    //     $request->merge(['password' => Hash::make($request->get('password'))]);
    //     $request->merge(['role_id' => (int)($request->get('role_id'))]);
    //     //')),'role_id' => $request->get('role')
    // dd($request->file('image'));
        //return $request->all();
    //     $model->create($request->all());
        $user = new User;
  
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->get('password'));
      $user->role_id = $request->role_id;
      $user->phone = $request->mobile;
      if($request->file('image'))
      {
          $imageName = time().'.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('/uploadedimages'), $imageName);
          $user->image = $imageName;
      }
      
      //$user->slug = $user->makeSlug($name);
      //$user->first_name = $request->first_name;
      //$user->middle_name = $request->middle_name;
      //$user->last_name = $request->last_name;
     
      $user->save();
      if($request->role_id==3)
      {
        $student = new Student;
        $student->admission_no = $request->admission;
        //$student->roll_no = $request->roll_no;
        $student->course_id = (int)$request->course;
  
        //$student->academic_id = (int)$request->academic_id;
      //   $student->course_parent_id = (int)$request->course_parent_id;
        
  
        
        $student->date_of_join = $request->date_of_join;
     
        //$student->current_year = $current_year;
        //$student->current_semister = $current_semister;
        $student->user_id = $user->id;
  
        $student->save();
  
      }
      elseif($request->role_id==2)
      {
        $staff = new Staff;
        $staff->job_title = $request->job;
        $staff->qualification = $request->qualification;
        //$student->academic_id = (int)$request->academic_id;
      //   $student->course_parent_id = (int)$request->course_parent_id;
        $staff->date_of_join = $request->dateofjoin;;
        //$staff->total_experience = $request->experience;
     
        //$student->current_year = $current_year;
        //$student->current_semister = $current_semister;
        $staff->user_id = $user->id;
  
        $staff->save();
  
  
      }
      else
      {

      }
     
     
        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $hasPassword = $request->get('password');
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
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

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

        /**

    * @return \Illuminate\Support\Collection

    */

    public function importExportView()

    {

       return view('users.importuser');

    }

   

    /**

    * @return \Illuminate\Support\Collection

    */

    public function export() 

    {

        return Excel::download(new UsersExport, 'users.xlsx');

    }

   

    /**

    * @return \Illuminate\Support\Collection

    */

    public function import() 

    {

        Excel::import(new UsersImport,request()->file('file'));
        return back();

    }
}
