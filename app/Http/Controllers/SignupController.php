<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Http\Controllers\Handle\UserHandle;
use App\Models\User;
use Auth;

class SignupController extends BaseController {
	public $request;

    public function __construct(Request $request) {
        $this->request = $request;
        parent::__construct();
        $this->setApp();
        $this->css['pages'] = [
            'bower_components/font-awesome/css/font-awesome.min.css',
            'bower_components/animate.css/animate.min.css'
        ];
    }

    public function index(){
		if  (!Auth::user()){
			$this->css['themes'] = [
				'admin/css/reset.css',
				'admin/css/themes/laravel.theme.css' => ['id' => 'theme'],
				'admin/css/pages/sign.css'
			];

			$this->js['scripts'][] = 'bower_components/bootbox.js/bootbox.js';
			$this->js['plugins'][] = 'bower_components/jquery-validation/dist/jquery.validate.min.js';

			$css = $this->css;
			$js = $this->js;
			$title = 'Gati - Cadastre-se';

			return view('login.signup',compact('css','js','title'));
		} else {
			$this->toastrMessage('danger', 'Você não pode criar uma nova conta logado. Desconecte-se do sistema!');
			return redirect('dashboard');
		}
    }

    public function save(){		
		$this->toastrMessage('danger', 'Erro ao salvar Usuário');
		$userHandle = new UserHandle(new User());
		$userHandle->user->tipo = 3;
		$user = $userHandle->newUser($this->request);
        if ($user) {
			$this->toastrMessage('success', 'Usuário Salvo');
			return redirect('/login');
        } else {
            $this->toastrMessage('danger', $userHandle->log->message);
            return redirect()->back()->withInput();
        }
    }
}