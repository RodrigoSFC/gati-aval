<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
          'username'=>'required|min:5|max:255',
          'email'=>'required|min:10|max:255',
          'tipo'=>'required',
		  'password'=>'required|min:3|max:255',
		];
    }
	
	public function messages(){
		return [
			  'username.required'=>'Nome é Obrigatório',
			  'username.max'=>'Nome deve contér no máximo 255 caracteres',
			  'username.min'=>'Nome deve contér no mínimo 5 caracteres',
			  'email.required'=>'E-mail é Obrigatório',
			  'email.min'=>'E-mail deve contér no mínimo 5 caracteres',
			  'email.max'=>'E-mail deve contér no máximo 255 caracteres',
			  'tipo.required'=>'Tipo é Obrigatório',
			  'password.required'=>'Senha é Obrigatório',
			  'password.min'=>'Senha deve contér no mínimo 3 caracteres',
			  'password.max'=>'Senha deve contér no máximo 255 números',
		];
	}
	
	public function attributes(){
        return [
            'username'=>'Nome',
            'email'=>'E-mail',
			'tipo'=>'Tipo',
			'password'=>'Senha',
        ];
    }
}