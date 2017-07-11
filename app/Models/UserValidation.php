<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserValidation extends Model
{
	protected $table = 'user_validation';
    protected $guarded = [];

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
