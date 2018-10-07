<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','address','phone','province'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /* relation to role model */
    public function roles(){
        return $this->belongsToMany(Role::class);
    }


    /*start roles */

    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn('name',$roles)->first();
    }


    public function hasRole($role){
        return null !== $this->where('name', $role )->first();
    }



    public function authorizeRoles($roles){
        if(is_array($roles)){
            return $this->hasAnyRole($roles) ||  abort(401 , "this action is not authorize");
        } 
         return $this->hasRole($roles) ||  abort(401,"this action is not authorize");
    }
}