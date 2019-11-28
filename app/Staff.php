<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam');
    }

    public function prepareStaffID($userid)
    {
        return (new Settings())->getStaffIDPrefix() . $userid;
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'subjectpreferences');
    }

 
}
