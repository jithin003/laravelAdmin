<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
    protected $fillable = ['name','description'];

	public static function getRoles()
	{
		return Role::all();		
	}

	 /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
    

    public static function getRoleId($role_name)
    {
    	return Role::where('name', '=', $role_name)->get()->first();
    }
}
