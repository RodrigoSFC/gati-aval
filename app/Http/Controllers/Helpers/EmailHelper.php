<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Teste;
use Mail;

class EmailHelper extends Controller
{
    public $emails;

	public $message;

	public function __construct($emails = null, $message = null){
		$this->emails = (array) $emails;
		$this->message = (string) $message;
	}

	public function send(){
		if (!$this->emails) {
			return false;
		}
		if (!$this->message) {
			return false;
		}
		foreach ($this->emails as $val) {
			Mail::to($val)->send(new Teste($this->message));
			return "Yeah! Email sended!";
		}
		return true;
	}
}
