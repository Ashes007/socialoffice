<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OccationPost extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }	

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
}
