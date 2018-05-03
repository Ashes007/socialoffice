<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
      
    // public function notificationable()
    // {       
    //     return $this->morphTo();
    // } 
    
    public function tickets(){
        return $this->belongsTo('App\Ticket','notificationable_id');
    }

    public function events(){
        return $this->belongsTo('App\Event','notificationable_id');
    }
    public function groups(){
        return $this->belongsTo('App\GroupUser','notificationable_id');
    }

    public function readNotification(){
        return $this->hasMany('App\ReadNotification');
    }    



}
