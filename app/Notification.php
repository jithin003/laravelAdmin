<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;
class Notification extends Model
{
    protected $table = "notifications";



    public static function getRecordWithSlug($slug)
    {
        return Notification::where('slug', '=', $slug)->first();
    }

    public static function latestNotifications($limit = 5)
    {



        $records = Notification::where('valid_to', '=>', date('Y-m-d'))
            ->limit($limit)
            ->orderBy('valid_to', 'desc');
        return $records->get();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'record_updated_by');
    }
}
