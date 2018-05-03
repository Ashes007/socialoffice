<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function accessType()
    {
    	return $this->hasMany('App\AccessType','menu_id','id');
    }
}
