<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    //
     /**
     * Display a listing of the users
     *
     * @param  \App\Course  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $subjects = Category::all();
        
    }
     /**
     * Display a listing of the users
     *
     * @param  \App\Course  $model
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $subjects = Category::all();
        return view('subjects.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       return view('subjects.create');
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
       
        $subject = new Category;
  
        $subject->title = $request->name;
        $subject->code = $request->code;
        
        $subject->save();
     
     
     
        return redirect()->route('subject')->withStatus(__('Subject successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $subject = Category::find($id);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Course   public function store(ourseRequest $request) $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$subject)
    {
        $cobj = Category::find($subject);
        $cobj->title = $request->name;
        $cobj->code = $request->code;
        $cobj->save();
        return redirect()->route('subject')->withStatus(__('Subject successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($subject)
    {
        $cobj = Category::find($subject);
        $cobj->delete();

        return redirect()->route('subject')->withStatus(__('Subject successfully deleted.'));
    }

}
