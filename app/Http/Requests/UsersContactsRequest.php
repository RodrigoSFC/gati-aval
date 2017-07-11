<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersContactsRequest extends FormRequest
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
          'nome'=>'required|min:5|max:255',
          'setor'=>'required|min:1|max:50',
		  'telefone'=>'max:20',
		  'email'=>'max:255',
		  'user_id'=>'required',
		];
    }
	
	public function messages(){
		return [
			  'nome.required'=>'Nome é Obrigatório',
			  'nome.min'=>'Nome deve contér no mínimo 5 caracteres',
			  'nome.max'=>'Nome deve contér no máximo 255 caracteres',
			  'email.max'=>'E-mail deve contér no máximo 255 caracteres',
			  'telefone.max'=>'Telefone deve contér no máximo 255 caracteres',
			  'setor.required'=>'Setor é Obrigatório',
			  'setor.min'=>'Setor deve contér no mínimo 1 caracteres',
			  'setor.max'=>'Setor deve contér no máximo 50 números',
			  'user_id.required'=>'Usuário é Obrigatório',
		];
	}
	
	public function attributes(){
        return [
            'nome'=>'Nome',
            'email'=>'E-mail',
			'telefone'=>'Telefone',
			'setor'=>'Setor',
			'user_id'=>'Usuário',
        ];
    }
}