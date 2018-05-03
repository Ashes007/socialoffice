<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

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

    public function setPasswordAttribute($password){
        if(isset($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }   
    
    public function roleuser(){
       return $this->hasMany('App\RoleUser','user_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function designation()
    {
        return $this->belongsTo('App\Designation','designation_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function roles(){
       return $this->belongsToMany('App\Role','role_user');
    }

    public function follows()
    {
        return $this->hasOne('App\UserFollower','follower_id');
    }

    public function followers(){
        return $this->hasMany('App\UserFollower');
    }      

    public function userTickets(){
        return $this->hasMany('App\Ticket','department_id','department_id')->where('user_id','<>', $this->id);
    }

    public function tickets(){
        return $this->hasMany('App\Ticket','user_id')->where('department_id', $this->department_id);
    }     
 
    public function events(){
        return $this->hasMany('App\Event');
    }

    public function eventInvites(){
        return $this->hasMany('App\EventInvite');
    }  
    public function groupUsers(){
        return $this->hasMany('App\GroupUser');
    } 
        
}
