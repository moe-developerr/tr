<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
	protected $table = 'lists';

	function board()
	{
		return $this->belongsTo('App\Board');
	}

	function cards()
	{
		return $this->hasMany('App\Card', 'list_id');
	}
}