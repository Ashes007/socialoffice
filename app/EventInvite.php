<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventInvite extends Model
{
   public function InviteRequests(){
        return $this->hasMany('App\EventAttend','user_id','user_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
