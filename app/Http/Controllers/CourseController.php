<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
     /**
     * Display a listing of the users
     *
     * @param  \App\Course  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $courses = Course::all();
        
    }
     /**
     * Display a listing of the users
     *
     * @param  \App\Course  $model
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $courses = Course::all();
        return view('courses.index',compact('courses'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       return view('courses.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\CourseRequest  $request
     * @param  \App\Course  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       
    //     $request->merge(['password' => Hash::make($request->get('password'))]);
    //     $request->merge(['role_id' => (int)($request->get('role_id'))]);
    //     //')),'role_id' => $request->get('role')
    // dd($request->file('image'));
        //return $request->all();
    //     $model->create($request->all());
        $course = new Course;
  
      $course->course_title = $request->name;
      $course->course_code = $request->code;
      $course->active = 1;
      
      //$user->slug = $user->makeSlug($name);
      //$user->first_name = $request->first_name;
      //$user->middle_name = $request->middle_name;
      //$user->last_name = $request->last_name;
     
      $course->save();
     
     
     
        return redirect()->route('course')->withStatus(__('Course successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $course = Course::find($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Course   public function store(ourseRequest $request) $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$course)
    {
        $cobj = Course::find($course);
        $cobj->course_title = $request->name;
        $cobj->course_code = $request->code;
        $cobj->save();
        return redirect()->route('course')->withStatus(__('Course successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($course)
    {
        $cobj = Course::find($course);
        $cobj->delete();

        return redirect()->route('course')->withStatus(__('Course successfully deleted.'));
    }


}
