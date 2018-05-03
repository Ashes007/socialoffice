<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function post(){
        return $this->belongsTo('App\Post','feedable_id');
    }

    public function event(){
        return $this->belongsTo('App\Event','feedable_id');
    }
     public function group(){
        return $this->belongsTo('App\GroupUser','feedable_id');
    }
    public function occasion(){
        return $this->belongsTo('App\OccationPost','feedable_id');
    }
    
}
