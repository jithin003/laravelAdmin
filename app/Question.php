<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use DB;
class Question extends Model
{
    //
    Protected $table = 'questions';
   
    public function getUpdatedAtColumn() {
        return null;
    }
    public function setUpdatedAt($value)

    {

      return NULL;

    }
    public function answer()
    {
        return $this->hasMany('App\Answer');
       
    }
    public function getAnswer($quiestion_id){
        //return $answers = Answer::where('question_id',$quiestion_id)->get();
        return $answer = DB::select('select * from  answers where question_id = :id AND is_correct=1', ['id' => $quiestion_id]);
    }
    public function getChoices($quiestion_id){
        return $answers = Answer::where('question_id',$quiestion_id)->get();
        //return $quiestion_id;
    }
}
