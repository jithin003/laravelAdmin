<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $table = "answers";
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
}
