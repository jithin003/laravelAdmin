<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    //
    protected $table = 'user_answers';
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
}
