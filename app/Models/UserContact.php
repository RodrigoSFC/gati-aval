<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class UserContact extends Model
{
    protected $table = 'users_contacts';
    protected $guarded = [];
	
	public function user(){
    	return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }
}
