@extends('layouts.lay_admin')

@section('content')

@php
	$disabled = "";
@endphp
    <div class="body-content animated fadeIn">
        {{-- Tela de edição do Usuário --}}
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Editar <i>{{ $userContact->id }}</i></h3>
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body no-padding">
                        <form id="form-userContact" class="form-horizontal mt-10" action="{{ URL::to("userContact/edit/$userContact->id") }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-body">
								<div class="form-group">
									<label for="label_user_id" class="col-sm-3 control-label">Usuário:</label>
									<div class="col-sm-7 div-error">
										<select class="form-control" style="width:100%;" id="user_id" name="UserContact[user_id]" required>
											<option value="">Selecione um Usuário</option>
											@for ($ii = 0; $ii < count($users); $ii++)
												<option value="{{ $users[$ii]->id }}"{{ ($userContact->user_id == $users[$ii]->id) ? " selected" : "" }}>{{ $users[$ii]->id." - ".$users[$ii]->name }}</option>
											@endfor
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="label_nome" class="col-sm-3 control-label">Nome:</label>
									<div class="col-sm-7 div-error">
										<input type="text" name="UserContact[nome]" id="nome" class="form-control" value="{{ $userContact ? $userContact->nome : '' }}" required="required" {{ $disabled }} >
									</div>
								</div>
                                <div class="form-group">
                                    <label for="label_email" class="col-sm-3 control-label">E-mail:</label>
                                    <div class="col-sm-7 div-error">
                                        <input type="email" name="UserContact[email]" class="form-control" id="email" value="{{ $userContact ? $userContact->email : '' }}" {{ $disabled }} >
                                    </div>
                                </div>
								<div class="form-group">
									<label for="label_telefone" class="col-sm-3 control-label">Telefone:</label>
									<div class="col-sm-7 div-error">
										<input type="text" name="UserContact[telefone]" id="telefone" class="form-control" required="required" value="{{ $userContact ? $userContact->telefone : '' }}" {{ $disabled }} >
									</div>
								</div>
								<div class="form-group">
									<label for="label_setor" class="col-sm-3 control-label">Setor:</label>
									<div class="col-sm-7 div-error">
										<input type="text" name="UserContact[setor]" id="setor" class="form-control" required="required" value="{{ $userContact ? $userContact->setor : '' }}" {{ $disabled }} >
									</div>
								</div>
								<div class="form-group">
									<label for="label_observacoes" class="col-sm-3 control-label">Observações:</label>
									<div class="col-sm-7 div-error">
										<textarea style="height:150px;" name="UserContact[observacoes]" id="observacoes" class="form-control">{{ $userContact ? $userContact->observacoes : '' }}</textarea>
									</div>
								</div>
								<div class="form-footer">
                                    <div class="col-sm-offset-3">
                                        <button type="submit" id="btn-submit" class="btn btn-theme" {{ $disabled }} >Salvar</button>
										<a href="<?=URL::to("userContact");?>" class="btn btn-danger" data-dismiss="modal">Cancelar</a>
                                    </div>
                                </div><!-- /.form-footer -->
                            </div>
                        </form>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div>
        </div><!-- /.row -->
	</div>
@endsection