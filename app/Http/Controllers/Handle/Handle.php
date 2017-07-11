<?php

namespace App\Http\Controllers\Handle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Handle extends Controller
{

	public $log = null;

    public function __construct(){
    	$this->log = (object)[
    		'message' => 'Erro ao executar função'
    	];
    }
}
