@extends('layouts.lay_admin')

@section('content')
    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow no-overflow">
                    <div class="panel-heading">	
						<div class="col-md-6 text-left">
							<button class="btn btn-sm btn-primary btn-advanced-search">
								<i class="fa fa-search" aria-hidden="true"></i> Pesquisa Avançada
							</button>
						</div>
						<div class="col-md-6 text-right">
							<button class="btn btn-sm btn-success new-user">
								<i class="fa fa-plus-square" aria-hidden="true"></i> Novo Usuário
							</button>
						</div>
						<div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
						<div id="div_advanced_search" style="display: none;">
							<form id="form-search-user" class="form-horizontal shadow rounded no-overflow" action="#" method="post" enctype="multipart/form-data" role="form">
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">ID:</div>
									<div class="col-md-8"><input class="form-control" type="text" name="Search[id]" id="search_id"></div>								
								</div>
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">Nome:</div>
									<div class="col-md-8"><input class="form-control" type="text" name="Search[name]" id="search_name"></div>								
								</div>
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">E-mail:</div>
									<div class="col-md-8"><input class="form-control" type="text" name="Search[email]" id="search_email"></div>
								</div>
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">Tipo:</div>
									<div class="col-md-8">
										<select id="search_tipo" name="Search[tipo]" data-width="100%">
											<option value="">Todos</option>
											<?=$user->tipo==1?'<option value="1">Super</option>':'';?>
											<?=$user->tipo>=1&&$user->tipo<=2?'<option value="2">Admin</option>':'';?>
											<option value="3">User</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-2">&nbsp;</div>
									<div class="col-md-8"><a class="btn btn-md btn-success btn-search" onClick=" $('#table-user').DataTable().ajax.reload();"><i class="fa fa-search" aria-hidden="true"></i> Pesquisar</a></div>
								</div>
							</form>
						</div>
						<?php 
							if(Session::has('toastr-message') && !is_null(Session::has('toastr-message'))) {
								$sess_message_arr = explode("::", Session::get('toastr-message'));
								$sess_class = (isset($sess_message_arr[0]) && isset($sess_message_arr[1]) ? $sess_message_arr[0] : "info");
								$sess_message = (isset($sess_message_arr[1]) ? $sess_message_arr[1] : $sess_message_arr[0]);
								echo "</br>";
								echo('<div class="text-center alert alert-'.$sess_class.'" style="width:50%; left:25%;">'.$sess_message.'</div>');
								Session::put('toastr-message',null);
							} 
						?>
                        <table class="table table-striped table-theme" id="table-user">
                            <thead>
                                <tr>
									<th width="12%">ID</th>
									<th width="35%">Nome</th>
									<th width="30%">E-mail</th>
                                    <th width="10%">Tipo</th>
                                    <th width="13%" data-orderable="false">&nbsp;</th>
                                </tr>
                            </thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Nome</th>
									<th>E-mail</th>
									<th>
										<select id="search_tipo_table" data-width="100%">
											<option value="">Todos</option>
											<?=$user->tipo==1?'<option value="1">Super</option>':'';?>
											<?=$user->tipo>=1&&$user->tipo<=2?'<option value="2">Admin</option>':'';?>
											<option value="3">User</option>
										</select>
									</th>
									<th>&nbsp;</th>
								</tr>
							</tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal large fade" role="dialog" id="myModal">
        <form id="form-user" class="form-horizontal shadow rounded no-overflow" action="{{ URL::to('user/new') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
					<div class="modal-header">
						<div class="row">
							<div class="col-md-12">
								<h4 class="modal-title" id="myModalLabel" style="margin-top: 9px;">Novo Usuário</h4>
							</div>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="label_username" class="col-sm-3 control-label">Nome:</label>
							<div class="col-sm-7 div-error"><input type="text" name="User[username]" id="username" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_tipo" class="col-sm-3 control-label">Tipo:</label>
							<div class="col-sm-7 div-error">
								<select id="tipo" name="User[tipo]" data-width="100%" required="required">
									<?=$user->tipo==1?'<option value="1">Super</option>':'';?>
									<?=$user->tipo>=1&&$user->tipo<=2?'<option value="2">Admin</option>':'';?>
									<option value="3">User</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="label_email" class="col-sm-3 control-label">E-mail:</label>
							<div class="col-sm-7 div-error"><input type="email" name="User[email]" id="email" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_password" class="col-sm-3 control-label">Senha:</label>
							<div class="col-sm-7 div-error"><input type="password" name="User[password]" id="password" class="form-control" required="required"></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Salvar</button>
						<button type="reset"  class="btn btn-default">Limpar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
            </div>
        </form>
    </div>
	<style>
	@media screen and (min-width: 768px) {
		#seeUsersModal .modal-dialog  {width:40%; height:auto;}
	}
	</style>
	<div class="modal large fade" id="seeUsersModal" role="dialog"></div>
@endsection