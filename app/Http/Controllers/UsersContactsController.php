<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserContact;
use App\Models\User;
use App\Http\Controllers\Helpers\JsonHelper;
use Session;
use View;
use Auth;
use Redirect;
use URL;
use DB;

class UsersContactsController extends \App\Http\Controllers\BaseController
{
    private $request;

	public function __construct(Request $request){
		parent::__construct();
        $this->request = $request;	
		$this->setApp();
		
		$this->js['plugins'][] = 'bower_components/datatables/media/js/jquery.dataTables.min.js';
        $this->js['plugins'][] = 'bower_components/datatables/media/js/dataTables.bootstrap.min.js';
	}

    public function index(){
		$this->js['scripts'][] = 'bower_components/jquery-mask-plugin/dist/jquery.mask.min.js';
		$this->js['scripts'][] = 'bower_components/bootbox.js/bootbox.js';
		$this->js['scripts'][] = 'bower_components/select2/dist/js/select2.min.js';
		$this->js['scripts'][] = 'js/usersContacts.js';
		$this->js['additionalScripts'][]	=	['view'=>'vendor.lfavp.ajax_script','form'=>'#form-userContact','request'=>'App/Http/Requests/UsersContactsRequest','on_start'=>false];
		$this->css['pages'][] = 'bower_components/select2/dist/css/select2.min.css';
        $js = $this->js;
		$css = $this->css;
    	$title = 'Cadastro de Contatos dos Usuários';
		$iconTitle = 'fa-user';
		
		$usersContacts = DB::table('users_contacts')
                ->join('users', 'users.id', '=', 'users_contacts.user_id');
		$usersContacts = $this->tipoSwitch(Auth::user()->tipo,$usersContacts);
        $usersContacts = $usersContacts->get();
		
		$users = User::orderBy("name","ASC");
		$users = $this->tipoSwitch(Auth::user()->tipo,$users);
		$users = $users->get();
		
    	return View::make('usersContacts.index', compact('usersContacts','users','js','css','title','iconTitle'));
    }

    public function new(){
		$userContact = new UserContact($this->request->get('UserContact'));
		$id = Auth::user()->id;
		$userContact->created_user_id	=	$id;
		$userContact->updated_user_id	=	$id;
        if ($userContact->save()){
			$this->toastrMessage('success', 'Contato Salvo!');
			return redirect('userContact');
        } else {
            $this->toastrMessage('danger', 'Erro ao salvar Contato');
            return redirect()->back()->withInput();
        }
    }
	
	public function see($id = null){
		if ($id != null){
			$userContact = UserContact::find($id);
			$user = User::find($userContact->user_id);
			return view('usersContacts.see', compact('userContact','user'));
		} else {
			$this->toastrMessage('danger','Contato não encontrado!');
			return redirect('user');
		}
	}

    public function edit($id = null){
        if ($id != null){
			$userContact = UserContact::find($id);
			if  ($this->request->get('UserContact')){
				if ($userContact->update($this->request->get("UserContact"))){
					$this->toastrMessage('success', 'Contato ('.$userContact->nome.') alterado!');
				}
				return redirect('userContact');
			} else {
				$this->js['scripts'][] = 'bower_components/jquery-mask-plugin/dist/jquery.mask.min.js';
				$this->js['scripts'][] = 'bower_components/select2/dist/js/select2.min.js';
				$this->js['scripts'][] = 'js/usersContactsEdit.js';
				$this->js['additionalScripts'][]	=	['view'=>'vendor.lfavp.ajax_script','form'=>'#form-userContact','request'=>'App/Http/Requests/UsersContactsRequest','on_start'=>true];
				$this->css['pages'][] = 'bower_components/select2/dist/css/select2.min.css';
				$js = $this->js;
				$css = $this->css;
				$title = 'Cadastro de Contatos dos Usuários';
				$iconTitle = 'fa-users';
				
				$users = User::orderBy("name","ASC");
				$users = $this->tipoSwitch(Auth::user()->tipo,$users);
				$users = $users->get();
				
				return view('usersContacts.edit',compact('userContact','users','js','css','title','iconTitle'));
			}			
		} else {
			$this->toastrMessage('danger','Contato não encontrado!');
			return redirect('userContact');
		}
    }

    public function delete(){
		$this->toastrMessage('danger', 'Contato não pode ser excluído!');
        $id = $this->request->get("id");
		$userContact = UserContact::find($id);
		$nome = $userContact->nome;
		if  ($userContact->delete()){
			$this->toastrMessage('success', 'Contato ('.$nome.') excluído!');
		}
		return redirect('userContact');
    }
	
	public function search(){
		$jsonHelper = new JsonHelper();
        $jsonHelper->status('success');
        $jsonHelper->message('Sucesso na requisição');
		
		$start	= $this->request->get('start');
		$length = $this->request->get('length');
		$order = $this->request->get('order');
		$orderby = $order[0]['dir'];
		switch($order[0]['column']){
			case 0:		$orderbycampo = 'users_contacts.id'; 		break;
			case 1:		$orderbycampo = 'users.name'; 				break;
			case 2:		$orderbycampo = 'users_contacts.setor'; 	break;
			case 3:		$orderbycampo = 'users_contacts.nome'; 		break;
			case 4:		$orderbycampo = 'users_contacts.email'; 	break;
			case 5: 	$orderbycampo = 'users_contacts.telefone'; 	break;
			default:	$orderbycampo = 'users_contacts.setor';
		}
		
		$search = $this->request->get('columns');
		$pesquisa = [];
		for ($cont = 0; $cont < count($search); $cont++){
			$pesquisa[] = $search[$cont]['search']['value'];
		}
		
		$usersContacts = UserContact::join('users','users.id','=','users_contacts.user_id')
									->where('users_contacts.setor'		,'LIKE','%'.$pesquisa[2].'%')
									->where('users_contacts.nome' 		,'LIKE','%'.$pesquisa[3].'%')
									->where('users_contacts.email'		,'LIKE','%'.$pesquisa[4].'%')
									->where('users_contacts.telefone'	,'LIKE','%'.$pesquisa[5].'%');
		if  ($pesquisa[0]	>	0){
			$usersContacts = $usersContacts->where('users_contacts.id',$pesquisa[0]);
		}
		if  (($pesquisa[1]	!=	"")&&($pesquisa[1]	>	0)){
			$usersContacts = $usersContacts->where('users_contacts.user_id',$pesquisa[1]);
		}
		switch(Auth::user()->tipo){
			case 2:		$usersContacts = $usersContacts->where('users.tipo','>=',2);
						$usersContacts = $usersContacts->where('users.tipo','<=',3);
						break;
			case 3: 	$usersContacts = $usersContacts->where('users.tipo','=',3);
						break;
			default:	$usersContacts = $usersContacts->where('users.tipo','=',3);
						break;	
		}
		$advanced_search = $this->request->get('Search');
		foreach($advanced_search as $field => $value){
			if  (is_array($value)){
				switch ($value[2]){
					case 'number':	
						if  (($value[1]!="")&&($value[1] > 0)){
							$usersContacts = $usersContacts->where('users_contacts.'.$value[0],$value[1]);
						}
						break;
				}
			} else {
				$usersContacts = $usersContacts->where('users_contacts.'.$field,'LIKE','%'.$value.'%');
			}
		}
		$usersContacts = $usersContacts->orderBy($orderbycampo,$orderby)
							->skip($start)
							->take($length)
							->get(['users_contacts.id as id','users.name as name','users_contacts.setor as setor','users_contacts.nome as nome','users_contacts.email as email','users_contacts.telefone as telefone'])
							->toArray();
		foreach ($usersContacts as $key => $userContact){
			$usersContacts[$key][]	=	"<a class='btn btn-sm btn-success btn-see-user' data-toggle='tooltip' title='Visualizar Contato' onClick='seeUserContact(".$userContact["id"].");'><i class='fa fa-eye' aria-hidden='true'></i></a><a data-toggle='tooltip' title='Editar Usuário' class='btn btn-sm btn-primary btn-edit-userContact' href=\"".URL::to("userContact/edit/".$userContact["id"])."\"><i class='fa fa-edit'></i></a><a data-toggle='tooltip' data-placement='left' title='Excluir Usuário' class='btn btn-sm btn-danger btn-delete-user' onClick='deleteUserContact(".$userContact["id"].");'><i class='fa fa-trash-o'></i></a>";
		}
        $jsonHelper->data($usersContacts);
		
		$iTotalRecords	= UserContact::count();
		$iTotalDisplayRecords	= UserContact	::join('users','users.id','=','users_contacts.user_id')
												->where('users_contacts.setor'		,'LIKE','%'.$pesquisa[2].'%')
												->where('users_contacts.nome' 		,'LIKE','%'.$pesquisa[3].'%')
												->where('users_contacts.email'		,'LIKE','%'.$pesquisa[4].'%')
												->where('users_contacts.telefone'	,'LIKE','%'.$pesquisa[5].'%');
		if  ($pesquisa[0]	>	0){
			$iTotalDisplayRecords = $iTotalDisplayRecords->where('users_contacts.id',$pesquisa[0]);
		}
		if  (($pesquisa[1]	!=	"")&&($pesquisa[1]	>	0)){
			$iTotalDisplayRecords = $iTotalDisplayRecords->where('users_contacts.user_id',$pesquisa[1]);
		}
		switch(Auth::user()->tipo){
			case 2:		$iTotalDisplayRecords = $iTotalDisplayRecords->where('users.tipo','>=',2);
						$iTotalDisplayRecords = $iTotalDisplayRecords->where('users.tipo','<=',3);
						break;
			case 3: 	$iTotalDisplayRecords = $iTotalDisplayRecords->where('users.tipo','=',3);
						break;
			default:	$iTotalDisplayRecords = $iTotalDisplayRecords->where('users.tipo','=',3);
						break;	
		}
		foreach($advanced_search as $field => $value){
			if  (is_array($value)){
				switch ($value[2]){
					case 'number':	
						if  (($value[1]!="")&&($value[1] > 0)){
							$iTotalDisplayRecords = $iTotalDisplayRecords->where('users_contacts.'.$value[0],$value[1]);
						}
						break;
				}
			} else {
				$iTotalDisplayRecords = $iTotalDisplayRecords->where('users_contacts.'.$field,'LIKE','%'.$value.'%');
			}
		}
		$iTotalDisplayRecords = $iTotalDisplayRecords->count();
		
		$jsonHelper->jsonArr['iTotalRecords']			=	(intval($iTotalRecords));
		$jsonHelper->jsonArr['iTotalDisplayRecords']	=	(intval($iTotalDisplayRecords));
		
        return response()->json($jsonHelper->jsonArr());
	}
}