<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    function lists()
    {
    	return $this->hasMany('App\ListModel');
    }

    function users()
    {
    	return $this->belongsToMany('App\User', 'board_users')->withPivot('is_favorite', 'can_create', 'can_update', 'can_delete', 'can_change_settings')->withTimestamps();
    }
}
