<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function department()
    {
    	return $this->belongsTo('App\Department');
    } 

    public function attachments()
    {
    	return $this->hasMany('App\TicketAttachment');
    }

    public function replies()
    {
        return $this->hasMany('App\Ticket', 'parent_id')->orderBy('id');
    }  

    // public function notifications()
    // {
    //     return $this->morphMany('App\Notification', 'notificationable');
    // }



                
}
