<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="row">
				<div class="col-md-8">
					<h4 class="modal-title" id="myModalLabel"><b>Usuário #<?=$userContact->id;?></b></h4>
				</div>
				<div class="col-md-4 pull-right">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
			</div>
		</div>
		<div class="modal-body">
			<div class="row">
				<label class="col-md-4 control-label"><b>Nome do Usuário:</b></label>
				<div class="col-md-8"><?=$user->name;?></div>
			</div>
			</br>
			<div class="row">
				<label class="col-md-4 control-label"><b>Nome do Contato:</b></label>
				<div class="col-md-8"><?=$userContact->nome;?></div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label"><b>Setor:</b></label>
				<div class="col-md-8"><?=$userContact->setor;?></div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label"><b>E-mail:</b></label>
				<div class="col-md-8"><?=$userContact->email;?></div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label"><b>Telefone:</b></label>
				<div class="col-md-8"><?=$userContact->telefone;?></div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label"><b>Observações:</b></label>
				<div class="col-md-8"><?=$userContact->observacoes;?></div>
			</div>
		</div>	
		<div class="modal-footer">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Fechar</button>
		</div>
	</div>
</div>