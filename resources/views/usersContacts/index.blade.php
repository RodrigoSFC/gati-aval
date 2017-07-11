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
							<button class="btn btn-sm btn-success new-userContact">
								<i class="fa fa-plus-square" aria-hidden="true"></i> Novo Contato
							</button>
						</div>
						<div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
						<div id="div_advanced_search" style="display: none;">
							<form id="form-search-userContact" class="form-horizontal shadow rounded no-overflow" action="#" method="post" enctype="multipart/form-data" role="form">
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">ID:</div>
									<div class="col-md-2"><input class="form-control" type="text" name="Search[id]" id="search_id"></div>								
									<div class="col-md-1" style="text-align: right;">Usuário:</div>
									<div class="col-md-5">
										<select class="form-control" style="width:100%;" id="user_id" name="UserContact[user_id]" required>
											<option value="">Selecione um Usuário</option>
											@for ($ii = 0; $ii < count($users); $ii++)
												<option value="{{ $users[$ii]->id }}">{{ $users[$ii]->id." - ".$users[$ii]->name }}</option>
											@endfor
										</select>
									</div>								
								</div>
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">Nome:</div>
									<div class="col-md-5"><input class="form-control" type="text" name="Search[nome]" id="search_nome"></div>
									<div class="col-md-1" style="text-align: right;">Setor:</div>
									<div class="col-md-2"><input class="form-control" type="text" name="Search[setor]" id="search_setor"></div>
								</div>
								<div class="form-group">
									<div class="col-md-2" style="text-align: right;">E-mail:</div>
									<div class="col-md-5"><input class="form-control" type="text" name="Search[email]" id="search_email"></div>
									<div class="col-md-1" style="text-align: right;">Telefone:</div>
									<div class="col-md-2"><input class="form-control" type="text" name="Search[telefone]" id="search_telefone"></div>
								</div>
								<div class="form-group">
									<div class="col-md-2">&nbsp;</div>
									<div class="col-md-8"><a class="btn btn-md btn-success btn-search" onClick=" $('#table-userContact').DataTable().ajax.reload();"><i class="fa fa-search" aria-hidden="true"></i> Pesquisar</a></div>
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
                        <table class="table table-striped table-theme" id="table-userContact">
                            <thead>
                                <tr>
									<th width="7%">ID</th>
									<th width="19%">Usuário</th>
									<th width="10%">Setor</th>
									<th width="20%">Nome</th>
									<th width="18%">E-mail</th>
                                    <th width="12%">Telefone</th>
                                    <th width="14%" data-orderable="false">&nbsp;</th>
                                </tr>
                            </thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>
										<select class="form-control" id="search_user_id_table" style="width:100%;">
											<option value="">Selecione um Usuário</option>
											@for ($ii = 0; $ii < count($users); $ii++)
												<option value="{{ $users[$ii]->id }}">{{ $users[$ii]->id." - ".$users[$ii]->name }}</option>
											@endfor
										</select>
									</th>
									<th>Setor</th>
									<th>Nome</th>
									<th>E-mail</th>
                                    <th>Telefone</th>
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
        <form id="form-userContact" class="form-horizontal shadow rounded no-overflow" action="{{ URL::to('userContact/new') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
					<div class="modal-header">
						<div class="col-md-12">
							<h4 class="modal-title" id="myModalLabel" style="margin-top: 9px;">Novo Contato</h4>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="label_user_id" class="col-sm-3 control-label">Usuário:</label>
							<div class="col-sm-7 div-error">
								<select class="form-control" style="width:100%;" id="user_id" name="UserContact[user_id]" required>
									<option value="">Selecione um Usuário</option>
									@for ($ii = 0; $ii < count($users); $ii++)
										<option value="{{ $users[$ii]->id }}">{{ $users[$ii]->id." - ".$users[$ii]->name }}</option>
									@endfor
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="label_nome" class="col-sm-3 control-label">Nome:</label>
							<div class="col-sm-7 div-error"><input type="text" name="UserContact[nome]" id="nome" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_email" class="col-sm-3 control-label">E-mail:</label>
							<div class="col-sm-7 div-error"><input type="email" name="UserContact[email]" id="email" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_telefone" class="col-sm-3 control-label">Telefone:</label>
							<div class="col-sm-7 div-error"><input type="text" name="UserContact[telefone]" id="telefone" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_setor" class="col-sm-3 control-label">Setor:</label>
							<div class="col-sm-7 div-error"><input type="text" name="UserContact[setor]" id="setor" class="form-control" required="required"></div>
						</div>
						<div class="form-group">
							<label for="label_observacoes" class="col-sm-3 control-label">Observações:</label>
							<div class="col-sm-7 div-error"><textarea style="height:150px;" name="UserContact[observacoes]" id="observacoes" class="form-control"></textarea></div>
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
		#seeUsersContactsModal .modal-dialog  {width:40%; height:auto;}
	}
	</style>
	<div class="modal large fade" id="seeUsersContactsModal" role="dialog"></div>
@endsection