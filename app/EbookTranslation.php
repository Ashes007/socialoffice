<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbookTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['ebook_id', 'title','description', 'locale'];
}
