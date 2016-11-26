<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    function lists()
    {
    	return $this->hasMany('App\ListModel');
    }
}
