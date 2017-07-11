<?php

namespace App\Http\Controllers\Handle;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ValidationEmail;
use App\Models\UserValidation;
use Hash;
use Mail;

class UserHandle extends Handle
{

	public $user;

	public $log;

	public function __construct(User $user){
        parent::__construct();
        $this->user = $user;
	}

	public function user(User $user = null){
		if ($user != null) {
			$this->user = $user;
		}
		return $this->user;
	}

	public function newUser($request){
		$email = $request->get('User')['email'];
		if (User::where('email', '=', $email)->first()) {
			$this->log->message = 'E-mail já cadastrado';
			return false;
		}
        if ($this->saveUser($request)) {
        	if($this->sendUserValidationEmail()){
        		return $this->user;
        	}
        }
        return 0;
	}

	public function editUser($request){
		if ($this->saveUser($request)) {
			return $this->user;
		}
		return 0;
	}

	public function saveUser($request){
		if ($this->validUser() && $this->validRequest($request)) {
			$this->user->name = $request->get('User')['username'];
	        $this->user->email = $request->get('User')['email'];
	        $this->user->password = Hash::make($request->get('User')['password']);
	        if ($this->user->save()) {
	        	return $this->user;
	        }else{
	        	$this->log->message = 'Erro ao salvar usuário';
	        }
	    }
        return 0;
	}

	public function sendUserValidationEmail(){
		if ($this->validUser() && $this->validEmail()) {
			$userValidation = $this->flushUserValidation();
			Mail::to($this->user->email)->send(new ValidationEmail($userValidation));
			return 1;
		}else{
			$this->log->message = 'E-mail inválido';
		}
		return 0;
	}

    private function flushUserValidation(){
        if ($this->validUser() && $this->validEmail()) {
            UserValidation::where('user_id', '=', $this->user->id)->delete();
            $userValid = UserValidation::create([
                'user_id'   => $this->user->id,
                'hash'      => Hash::make($this->user->email)
            ]);
            return $userValid;
        }
        return null;
    }

    private function validUser(){
    	if (isset($this->user) && $this->user != null) {
    		return 1;
    	}
    	$this->log->message = 'Usuário inválido';
    	return 0;
    }

    private function validEmail(){
    	return isset($this->user) && $this->user->email;
    }

    private function findUser(string $email){
    	$user = User::where('email', '=', $email)->first();
    	return $user;
    }

    private function validRequest($request){
		if(!$request->get('User')['username']){
			$this->log->message = 'Nome inválido';
			return 0;
		}
		if(!$request->get('User')['email']){
			$this->log->message = 'E-mail inválido';
			return 0;
		}
		if(!$request->get('User')['password']){
			$this->log->message = 'Senha inválida';
			return 0;
		}
		return 1;
    }

}
