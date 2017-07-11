<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserValidation;
use App\Models\User;
use Hash;
use App\Http\Controllers\Handle\UserHandle;
use Auth;
use Session;

class ValidateUserController extends BaseController
{

	public $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

    public function validateHash(){
		$hash = $this->request->get('hash');
		$this->toastrMessage("danger", 'Link inválido');
		if ($hash) {
			$userValid = UserValidation::where('hash', '=', $hash)->first();
			if ($userValid) {
				$user = User::find($userValid->user_id);
				$userValid->delete();
				Auth::loginUsingId($user->id);
				$this->toastrMessage("success", 'Usuário Ativado!');
				return redirect('dashboard');
			}
		}
		return redirect('login');
    }

    public function resendEmail(){
        $this->toastrMessage('danger', 'Erro ao reenviar e-mail');
        $email = $this->request->get('email');
        if ($email) {
            $user = User::where('email', '=', $email)->first();
            $userHandle = new UserHandle($user);
            $userHandle->user($user);
            if ($user) {
                return $this->resendEmailPrivate($user);
            }else{
                $this->toastrMessage('danger', 'E-mail não encontrado');
            }
        }else{
            $this->toastrMessage('danger', 'E-mail inválido');
        }
        return redirect('login');
    }

    private function resendEmailPrivate($user){
        $this->toastrMessage('danger', 'Erro ao reenviar e-mail!');
        $userHandle = new UserHandle($user);
        if($userHandle->sendUserValidationEmail()){
            $this->toastrMessage('success', 'E-mail reenviado!');
        }
        return redirect('login');
    }
}