<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class EventAttend extends Model
{
	public function user(){
        return $this->belongsTo('App\User');
    }
}
