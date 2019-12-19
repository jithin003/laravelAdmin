<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    Protected $table = 'questions';
    public function answer()
    {
        return $this->hasMany('App\Answer');
    }
}
