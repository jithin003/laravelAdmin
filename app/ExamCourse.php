<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamCourse extends Model
{
    //
    protected $table = "exam_courses";
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
}
