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
                            <h3 class="panel-title">Configuração <i>{{ $user->id }}</i></h3>
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body no-padding">
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
                        <form id="form-user" class="form-horizontal mt-10" action="{{ URL::to("user/config/$user->id") }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-body">
								<div class="form-group">
									<label for="label_username" class="col-sm-3 control-label">Nome:</label>
									<div class="col-sm-7 div-error">
										<input type="text" name="User[username]" id="username" class="form-control" value="{{ $user ? $user->name : '' }}" required="required" {{ $disabled }} >
									</div>
								</div>
                                <div class="form-group">
                                    <label for="label_email" class="col-sm-3 control-label">E-mail:</label>
                                    <div class="col-sm-7 div-error">{{ $user ? $user->email : '' }}</div>
                                </div>
								<div class="form-group">
                                    <label for="label_tipo" class="col-sm-3 control-label">Tipo:</label>
                                    <div class="col-sm-7 div-error">
										<select id="tipo" name="User[tipo]" data-width="100%" required="required">
											<?=$user->tipo==1?'<option value="1"'.(($user->tipo==1)?" selected":"").'>Super</option>':'';?>
											<?=$user->tipo>=1&&$user->tipo<=2?'<option value="2"'.(($user->tipo==2)?" selected":"").'>Admin</option>':'';?>
											<option value="3"<?=($user->tipo==3)?" selected":"";?>>User</option>
										</select>
                                    </div>
                                </div>
								<div class="form-group">
									<label for="label_tipo" class="col-sm-3 control-label">Senha:</label>
									<div class="col-sm-7 div-error">
                                        <input type="password" name="User[password]" class="form-control" id="password" placeholder="Senha" value="" {{ $disabled }} required="required">
                                    </div>
								</div>
								<div class="form-group">
									<label for="label_tipo" class="col-sm-3 control-label">Confirmar Senha:</label>
									<div class="col-sm-7 div-error">
                                        <input type="password" name="User[repassword]" class="form-control" id="repassword" placeholder="Confirmar Senha" value="" {{ $disabled }} required="required">
                                    </div>
								</div>
								<div class="form-footer">
                                    <div class="col-sm-offset-3">
                                        <button type="submit" id="btn-submit" class="btn btn-theme" {{ $disabled }} >Salvar</button>
										<a href="<?=URL::to("user");?>" class="btn btn-danger" data-dismiss="modal">Cancelar</a>
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