<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttempt extends Model
{
    //
    protected $table = 'user_attempt';
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
}
