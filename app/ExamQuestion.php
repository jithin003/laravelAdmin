<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    //
    protected $table = "exam_questions";
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
}
