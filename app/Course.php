<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
    


    public function exams()
    {
        return $this->belongsToMany('App\Exam', 'course_exam');
    }


    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public static function getCourses($parentId = 0)
    {
        return Course::where('parent_id', '=', $parentId)->get();
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'course_notification');
    }
}
