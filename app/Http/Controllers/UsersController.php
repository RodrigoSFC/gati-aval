<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\JsonHelper;
use App\Http\Controllers\Handle\UserHandle;
use App\Models\UserContact;
use App\Models\UserValidation;
use App\Models\User;
use Session;
use View;
use Auth;
use Redirect;
use URL;
use Hash;

class UsersController extends \App\Http\Controllers\BaseController
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
		$this->js['scripts'][] = 'js/users.js';
		$this->js['additionalScripts'][]	=	['view'=>'vendor.lfav.ajax_script','form'=>'#form-user','request'=>'App/Http/Requests/UsersRequest','on_start'=>false];
		$this->css['pages'][] = 'bower_components/select2/dist/css/select2.min.css';
        $js = $this->js;
		$css = $this->css;
    	$title = 'Cadastro de Usuários';
		$iconTitle = 'fa-users';
		$users = User::all();
		$user = Auth::user();
    	return View::make('users.index', compact('users','user','js','css','title','iconTitle'));
    }

    public function new(){
		$userHandle = new UserHandle(new User());
		$userHandle->user->tipo = $this->request->get('User')['tipo'];
		$user = $userHandle->newUser($this->request);
        if ($user) {
			$this->toastrMessage('success', 'Usuário Salvo');
			return redirect('user');
        } else {
            $this->toastrMessage('danger', $userHandle->log->message);
            return redirect()->back()->withInput();
        }
    }
	
	public function see($id = null){
		if ($id != null){
			$user = User::find($id);
			return view('users.see', compact('user'));
		} else {
			$this->toastrMessage('danger','Usuário não encontrado!');
			return redirect('user');
		}
	}

    public function edit($id = null){
        if ($id != null){
			$user = User::find($id);
			if  ($this->request->get('User')){
				$user->tipo = $this->request->get("User")['tipo'];
				$user->name = $this->request->get("User")['username'];
				if ($user->save()){
					$this->toastrMessage('success', 'Usuário ('.$user->name.') alterado!');
				}
				return redirect('user');
			} else {
				$this->js['scripts'][] = 'bower_components/jquery-mask-plugin/dist/jquery.mask.min.js';
				$this->js['scripts'][] = 'bower_components/select2/dist/js/select2.min.js';
				$this->js['scripts'][] = 'js/usersEdit.js';
				$this->css['pages'][] = 'bower_components/select2/dist/css/select2.min.css';
				$js = $this->js;
				$css = $this->css;
				$title = 'Cadastro de Usuários';
				$iconTitle = 'fa-users';
				
				$userAuth = Auth::user();
				
				return view('users.edit',compact('user','userAuth','js','css','title','iconTitle'));
			}			
		} else {
			$this->toastrMessage('danger','Usuário não encontrado!');
			return redirect('user');
		}
    }
	
	public function config($id = null){
        if ($id != null){
			$user = User::find($id);
			if  ($this->request->get('User')){
				$this->toastrMessage('danger', 'Senhas não conferem!');
				if ($this->request->get("User")['password']	==	$this->request->get("User")['repassword']){
					$user->password = Hash::make($this->request->get("User")['password']);
					$user->tipo = $this->request->get("User")['tipo'];
					$user->name = $this->request->get("User")['username'];
					if ($user->save()){
						$this->toastrMessage('success', 'Configuração salva!');
					}
				}
				return redirect('user/config/'.$user->id);
			} else {
				$this->js['scripts'][] = 'bower_components/jquery-mask-plugin/dist/jquery.mask.min.js';
				$this->js['scripts'][] = 'bower_components/select2/dist/js/select2.min.js';
				$this->js['scripts'][] = 'js/usersEdit.js';
				$this->css['pages'][] = 'bower_components/select2/dist/css/select2.min.css';
				$js = $this->js;
				$css = $this->css;
				$title = 'Configuração do Usuário';
				$iconTitle = 'fa-cogs';
				
				return view('users.config',compact('user','js','css','title','iconTitle'));
			}			
		} else {
			$this->toastrMessage('danger','Usuário não encontrado!');
			return redirect('user/config/'.Auth::user()->id);
		}
    }

    public function delete(){
		$this->toastrMessage('danger', 'Usuário não pode ser excluído!');
        $id = $this->request->get("id");
		$user = User::find($id);
		$userContact = UserContact::where('user_id',$user->id)->delete();
		$userValidation = UserValidation::where('user_id',$user->id)->delete();
		$name = $user->name;
		if  ($user->delete()){
			$this->toastrMessage('success', 'Usuário ('.$name.') excluído!');
		}
		return redirect('user');
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
			case 0:		$orderbycampo = 'id'; 	break;
			case 1:		$orderbycampo = 'name'; 	break;
			case 2:		$orderbycampo = 'email'; 	break;
			case 3: 	$orderbycampo = 'tipo'; 	break;
			default:	$orderbycampo = 'name';
		}
		
		$search = $this->request->get('columns');
		$pesquisa = [];
		for ($cont = 0; $cont < count($search); $cont++){
			$pesquisa[] = $search[$cont]['search']['value'];
		}
		
		$users = User	::where('name' ,'LIKE','%'.$pesquisa[1].'%')
						->where('email','LIKE','%'.$pesquisa[2].'%');
		if  ($pesquisa[3]	>	0){
			$users = $users->where('tipo',$pesquisa[3]);
		}
		if  ($pesquisa[0]	>	0){
			$users = $users->where('id',$pesquisa[0]);
		}
		switch(Auth::user()->tipo){
			case 2:		$users = $users->where('tipo','>=',2);
						$users = $users->where('tipo','<=',3);
						break;
			case 3: 	$users = $users->where('tipo','=',3);
						break;
			default:	$users = $users->where('tipo','=',3);
						break;	
		}
		
		$advanced_search = $this->request->get('Search');
		foreach($advanced_search as $field => $value){
			if  (is_array($value)){
				switch ($value[2]){
					case 'number':	
						if  (($value[1]!="")&&($value[1] > 0)){
							$users = $users->where($value[0],$value[1]);
						}
						break;
				}
			} else {
				$users = $users->where($field,'LIKE','%'.$value.'%');
			}
		}
		$users = $users->orderBy($orderbycampo,$orderby)
							->skip($start)
							->take($length)
							->get(['id','name', 'email', 'tipo'])
							->toArray();
		foreach ($users as $key => $user){
			switch($users[$key]["tipo"]){
				case 1	:	$users[$key]["tipo"]	=	"Super";	break;
				case 2	: 	$users[$key]["tipo"]	=	"Admin";	break;
				case 3	: 	$users[$key]["tipo"]	=	"User";		break;
				default	:	$users[$key]["tipo"]	=	"User";		break;
			}
			$users[$key][]	=	"<a class='btn btn-sm btn-success btn-see-user' data-toggle='tooltip' title='Visualizar Usuário' onClick='seeUser(".$user["id"].");'><i class='fa fa-eye' aria-hidden='true'></i></a><a data-toggle='tooltip' title='Editar Usuário' class='btn btn-sm btn-primary btn-edit-user' href=\"".URL::to("user/edit/".$user["id"])."\"><i class='fa fa-edit'></i></a><a data-toggle='tooltip' data-placement='left' title='Excluir Usuário' class='btn btn-sm btn-danger btn-delete-user' onClick='deleteUser(".$user["id"].");'><i class='fa fa-trash-o'></i></a>";
		}
        $jsonHelper->data($users);
		
		$iTotalRecords	= User::count();
		$iTotalDisplayRecords	= User	::where('name' ,'LIKE','%'.$pesquisa[1].'%')
										->where('email','LIKE','%'.$pesquisa[2].'%');
		if  ($pesquisa[3]	>	0){
			$iTotalDisplayRecords = $iTotalDisplayRecords->where('tipo',$pesquisa[3]);
		}
		if  ($pesquisa[0]	>	0){
			$iTotalDisplayRecords = $iTotalDisplayRecords->where('id',$pesquisa[0]);
		}
		switch(Auth::user()->tipo){
			case 2:		$iTotalDisplayRecords = $iTotalDisplayRecords->where('tipo','>=',2);
						$iTotalDisplayRecords = $iTotalDisplayRecords->where('tipo','<=',3);
						break;
			case 3: 	$iTotalDisplayRecords = $iTotalDisplayRecords->where('tipo','=',3);
						break;
			default:	$iTotalDisplayRecords = $iTotalDisplayRecords->where('tipo','=',3);
						break;	
		}
		foreach($advanced_search as $field => $value){
			if  (is_array($value)){
				switch ($value[2]){
					case 'number':	
						if  (($value[1]!="")&&($value[1] > 0)){
							$iTotalDisplayRecords = $iTotalDisplayRecords->where($value[0],$value[1]);
						}
						break;
				}
			} else {
				$iTotalDisplayRecords = $iTotalDisplayRecords->where($field,'LIKE','%'.$value.'%');
			}
		}
		$iTotalDisplayRecords = $iTotalDisplayRecords->count();
		
		$jsonHelper->jsonArr['iTotalRecords']			=	(intval($iTotalRecords));
		$jsonHelper->jsonArr['iTotalDisplayRecords']	=	(intval($iTotalDisplayRecords));
		
        return response()->json($jsonHelper->jsonArr());
	}
}