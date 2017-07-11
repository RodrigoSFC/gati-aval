<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\User;
use Hash;
use Redirect;
use Auth;
use DB;
use Session;

class AuthController extends BaseController
{

    public $request = null;

    public function __construct(Request $request) {

        $this->request = $request;
		
        parent::__construct();
		
        $this->setApp();

        // page level styles
        $this->css['pages'] = [
            'bower_components/font-awesome/css/font-awesome.min.css',
            'bower_components/animate.css/animate.min.css'
        ];
    }

    public function login(){
		if  (!Auth::user()){
			$this->css['themes'] = [
				'admin/css/reset.css',
				'admin/css/layout.css',
				'admin/css/components.css',
				'admin/css/plugins.css',
				'admin/css/themes/laravel.theme.css' => ['id' => 'theme'],
				'admin/css/pages/sign.css',
				'admin/css/custom.css',
			];

			$this->js['plugins'][] = 'bower_components/jquery-validation/dist/jquery.validate.min.js';
			$this->js['scripts'] = ['js/auth.js'];

			$css = $this->css;
			$js = $this->js;
			$title = 'Gati - Aval';

			return view('login.auth',compact('css','js','title'));
		} else {
			$this->toastrMessage('danger', 'Você já está logado!');
			return redirect('dashboard');
		}
    }

    public function doLogin(){
        $erro = "Erro ao logar";
        $requestedUser = $this->request->get('username');
        $requestedPassword = $this->request->get('password');
        $usuario = User::where('email', '=', $requestedUser)->first();
        if ($usuario) {
            if (Hash::check($requestedPassword, $usuario->password)) {
                if (!$usuario->userValidation) {
					$returnLogin = Auth::loginUsingId($usuario->id);
					if  ($returnLogin){
						return redirect('dashboard');
					} else {
						$erro = "Erro ao fazer login";
					}
                } else {
                    $erro = "Acesse o seu e-mail para autenticar sua conta";
                }
            } else {
                $erro = "Senha incorreta";
            }
        } else {
            $erro = "Usuário não encontrado";
        }
        $this->toastrMessage('danger', $erro);
        return Redirect::back()->withInput();
    }

    public function getLogout(){
		Auth::logout();
		return redirect('/login');
    } 
}