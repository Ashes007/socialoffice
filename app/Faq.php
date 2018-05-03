<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
	use Translatable;
	public $translatedAttributes = ['question','answer'];
	protected $fillable = ['faq_category','status', 'faq_id', 'question', 'answer', 'locale'];

	public function category(){
		return $this->belongsTo('App\FaqCategory','faq_category_id');
	}
	
}

