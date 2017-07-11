<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\EmailHelper;

class EmailController extends Controller
{
    public $request;

    public function __construct(Request $request){
    	$this->request = $request;
    }

    public function index(){
    	$agendamento = AgendaEmail::first();
    	return view('email.index', compact('agendamento'));
    }

    public function enviar(){
    	$emails = Cliente::pluck('email')->toArray();
    	$msg = "Teste de e-mail";
    	$emailHelper = new EmailHelper($emails, $msg);
        if ($emailHelper->send()) {
            $this->request->session()->flash('msg', 'Email enviado');
            $this->request->session()->flash('msg-type', 'success');
        }else{
            $this->request->session()->flash('msg', 'Erro ao enviar e-mail');
            $this->request->session()->flash('msg-type', 'danger');
        }
    	return redirect('email');
    }

}
