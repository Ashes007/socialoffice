<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
	use Translatable;
	public $translatedAttributes = ['group_name','group_description','group_user_id'];
	protected $fillable = ['group_type_id', 'owner_id'];
	
	public function user(){
        return $this->belongsTo('App\User');
    }
     public function user_group_users(){
        return $this->belongsTo('App\UserGroupUser','id');
    }
	

}
