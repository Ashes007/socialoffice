<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class GroupInvite extends Model
{	
	protected $fillable = ['group_id','sender_id', 'user_id'];	

}
