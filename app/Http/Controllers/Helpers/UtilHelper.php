<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilHelper extends Controller
{

	public function __construct(){
	
	}

	public static function daysDiff($date1,$date2){
		$days=date_diff(date_create($date1),date_create($date2));
		return $days->days;
	}

}