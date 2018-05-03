<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
	use Translatable;
	public $translatedAttributes = ['email_content'];
	protected $fillable = ['email_template_id', 'email_content', 'locale'];


    // public function getCreatedAtAttribute($datetime){
    //     if(isset($datetime)) {
    //         return convertTimeToUSERzone($datetime,'Asia/Kolkata');
    //     }
    // } 	
	
}
