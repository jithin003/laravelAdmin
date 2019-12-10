<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_notification extends Model
{
    protected $table = 'user_notifications';
    public $timestamps = false;
    protected $fillable = [
        'notification_id','user_id',''
    ];
    
}
