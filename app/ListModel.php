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

	function users()
	{
		return $this->belongsToMany('App\User', 'list_users', 'list_id')->withTimestamps();
	}

	function cards()
	{
		return $this->hasMany('App\Card', 'list_id');
	}
}