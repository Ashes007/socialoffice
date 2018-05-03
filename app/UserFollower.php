<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollower extends Model
{
    //public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User','follower_id');
    }    
}
