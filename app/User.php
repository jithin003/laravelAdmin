<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    public function staff()
    {
        return $this->hasOne('App\Staff');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsTo('App\Role','role_id');
    }

    /**
     * Returns the student record from students table based on the relationship
     * @return [type]        [Student Record]
     */
    public function student()
    {
        return $this->hasOne('App\Student', 'user_id');
    }

    public static function getRecordWithSlug($slug)
    {
        return User::where('slug', '=', $slug)->first();
    }

    public function isChildBelongsToThisParent($child_id, $parent_id)
    {
        return User::where('id', '=', $child_id)
            ->where('parent_id', '=', $parent_id)
            ->get()
            ->count();
    }

    public function getLatestUsers($limit = 5)
    {
        return User::where('role_id', '=', getRoleData('student'))
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * This method accepts the user object from social login methods
     * Registers the user with the db
     * Sends Email with credentials list
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function registerWithSocialLogin($receivedData = '')
    {
        $user = new User();
        $password = str_random(8);
        $user->password = bcrypt($password);
        $slug = $user->makeSlug($receivedData->name);
        $user->username = $slug;
        $user->slug = $slug;

        $role_id = getRoleData('student');

        $user->name = $receivedData->name;
        $user->email = $receivedData->email;
        $user->role_id = $role_id;
        $user->login_enabled = 1;

        $user->save();
        $user->roles()->attach($user->role_id);
        sendEmail('registration', array('user_name' => $user->name, 'username' => $user->slug, 'to_email' => $user->email, 'password' => $password));
        return $user;
    }

    public function preferredSubjects()
    {

        $subjects = User::join('subjectpreferences', 'subjectpreferences.user_id', '=', 'users.id')
            ->join('subjects', 'subjectpreferences.subject_id', '=', 'subjects.id')
            ->where('users.id', '=', $this->id)
            ->select(['subjects.id as id', 'subject_title', 'is_lab', 'is_elective_type'])
            ->get();
        return $subjects;
    }

    public static function getLatestUsersDashboard($type = 'student', $limit = 8)
    {
        return $latest_users = User::where('role_id', '=', getRoleData($type))
            ->select(['name', 'image', 'slug', 'created_at'])
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function leaveLetters()
    {
        return $this->hasMany('App\LeaveLetter');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification', 'record_updated_by');
    }
    public function medicalInfo(){
    	return $this->hasOne('App\StudentMedicalInfo');
    }
     public function results()
    {
        return $this->hasMany('App\Result');
    }
    // public function createToken()
    // {
    //     return  $token = Str::random(60);
    // }
}
