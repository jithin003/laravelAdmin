<?php

namespace App;
use App\NotesContent;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    //
    protected $table = "notes";
    public function getContent($note_id){
        return $contents = NotesContent::where('notes_id',$note_id)->get();
        //return $answer = DB::select('select * from  answers where question_id = :id AND is_correct=1', ['id' => $quiestion_id]);
    }
}
