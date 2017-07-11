@extends('layouts.lay_account')

@section('content')
<div style="width: 50%; padding-top: 5%;" id="sign-wrapper">
	<form method="post" class="form-horizontal rounded shadow no-overflow sign-up" action="{{ URL::to('signup/save') }}" id="form-signup">
		{{ csrf_field() }}
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-12">
						<h4 class="modal-title" id="myModalLabel" style="margin-top: 9px;">Criar Nova Conta</h4>
					</div>
				</div>
			</div>
			<div class="modal-body">				
				<div class="sign-body">
					<div class="form-group">
						<div class="input-group input-group-lg rounded no-overflow">
							<input id="username" name="User[username]" type="text" class="form-control input-sm" placeholder="Nome do usuário" required>
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group input-group-lg rounded no-overflow">
							<input id="email" name="User[email]" type="email" class="form-control input-sm" placeholder="Seu e-mail" required>
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group input-group-lg rounded no-overflow">
							<input id="password" name="User[password]" type="password" class="form-control input-sm" placeholder="Senha" required>
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group input-group-lg rounded no-overflow">
							<input id="repassword" name="User[repassword]" type="password" class="form-control input-sm" placeholder="Confirme a senha" required>
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
						</div>
					</div>
					<div class="form-group">
						<div class="ckbox ckbox-theme">
							<input id="term-of-service" name="termos" value="1" type="checkbox">
							<label for="term-of-service" class="rounded" style="color: #696969;">Eu concordo com os <a href="#">Termos de serviço</a></label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="callout callout-info no-margin">
						<p class="text-muted" style="color: #696969;">Para confirmar e ativar sua conta, enviaremos para o seu e-mail um link de ativação.</p>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Salvar</button>
					<button type="reset" class="btn btn-default">Limpar</button>
					<a href="<?=URL::to("/login");?>" class="btn btn-danger" data-dismiss="modal">Cancelar</a>
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection