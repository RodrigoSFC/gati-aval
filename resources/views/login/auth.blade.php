@extends('layouts.lay_account')

<!-- START @SIGN WRAPPER -->
@section('content')
<div id="sign-wrapper" style="padding-top: 10%;">
    <form class="sign-in form-horizontal shadow rounded no-overflow" action="{{url('login/doLogin')}}" method="post">
        {{ csrf_field() }}
        <div class="sign-header">
            <div class="form-group">
                <div class="sign-text">
                    <span>Gati - Aval</span>
                </div>				
            </div>
        </div>
        <div class="sign-body">
			<?php
				if(Session::has('toastr-message') && !is_null(Session::has('toastr-message'))) {
					$sess_message_arr = explode("::", Session::get('toastr-message'));
					$sess_class = (isset($sess_message_arr[0]) && isset($sess_message_arr[1]) ? $sess_message_arr[0] : "info");
					$sess_message = (isset($sess_message_arr[1]) ? $sess_message_arr[1] : $sess_message_arr[0]);
					echo('<div class="alert alert-'.$sess_class.'">'.$sess_message.'</div>');
					Session::put('toastr-message',null);
				} 
			?>
            <div class="form-group">
                <div class="input-group input-group-lg rounded no-overflow">
                    <input type="text" class="form-control input-sm" placeholder="E-mail" name="username">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                </div>
            </div><!-- /.form-group -->
            <div class="form-group">
                <div class="input-group input-group-lg rounded no-overflow">
                    <input type="password" class="form-control input-sm" placeholder="Senha" name="password">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                </div>
            </div><!-- /.form-group -->
        </div><!-- /.sign-body -->
        <div class="sign-footer">
            <div class="form-group">
                <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn">Entrar</button>
            </div><!-- /.form-group -->
        </div><!-- /.sign-footer -->
    </form><!-- /.form-horizontal -->
	<div class="form-group">
		<p class="text-muted text-center sign-link" style="color:#696969;">
			Precisa de uma conta? <a href="{{url('signup')}}"> Cadastre-se</a></br></br>
			Caso não tenha recebido seu e-mail de confirmação ou esqueceu sua senha, <a data-toggle="modal" href='#myModal'>clique aqui</a>
		</p>
	</div>
    <!--/ Login form -->
	<div class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" id="myModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form class="form-horizontal shadow rounded no-overflow" action="{{url('validaUsuario/reenviaEmail')}}" method="post">
                    <div class="modal-body" style="padding: 0!important">
                        {{ csrf_field() }}
                        <div class="sign-header">
                            <div class="form-group">
                                <div class="sign-text">
                                    <span>Reenviar link de ativação</span>
                                </div>
                            </div><!-- /.form-group -->
                        </div><!-- /.sign-header -->
                        <div class="sign-body">
                            <div class="form-group">
                                <div class="input-group input-group-lg rounded no-overflow">
                                    <input type="text" class="form-control input-sm" placeholder="E-mail" name="email" required>
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /#sign-wrapper -->
@stop
<!--/ END SIGN WRAPPER -->
