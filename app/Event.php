<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use Translatable;
	public $translatedAttributes = ['name','description','short_description'];
	protected $fillable = ['type_id', 'event_date', 'status', 'name', 'locale'];
	
    public function eventtype()
    {
    	return $this->belongsTo('App\EventType','type_id','id');
    }

    public function eventImage()
    {
    	return $this->hasMany('App\EventImage');
    } 

    public function invites()
    {
        return $this->hasMany('App\EventInvite');
    } 

    // public function notifications()
    // {
    //     return $this->morphMany('App\Notification', 'notificationable');
    // }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getStatus($eventId)
    {
        $userId = \Auth::guard('user')->user()->id;
        $attand = EventAttend::where('user_id','=',$userId)->where('event_id','=',$eventId)->first();
        if($attand)
            return $attand->attend_status;
        else
            return 0;
    }
    public function getStatusUser($user_id,$eventId)
    {
        $userId = $user_id;
        $attand = EventAttend::where('user_id','=',$userId)->where('event_id','=',$eventId)->first();
        if($attand)
            return $attand->attend_status;
        else
            return 0;
    }
  
}
