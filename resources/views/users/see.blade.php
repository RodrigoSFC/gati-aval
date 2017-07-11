<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="row">
				<div class="col-md-8">
					<h4 class="modal-title" id="myModalLabel"><b>Usuário #<?=$user->id;?></b></h4>
				</div>
				<div class="col-md-4 pull-right">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
			</div>
		</div>
		<div class="modal-body">
			<div class="row">
				<label class="col-md-2 control-label"><b>Nome:</b></label>
				<div class="col-md-10"><?=$user->name;?></div>
			</div>
			<div class="row">
				<label class="col-md-2 control-label"><b>E-mail:</b></label>
				<div class="col-md-10"><?=$user->email;?></div>
			</div>
			<div class="row">
				<label class="col-md-2 control-label"><b>Tipo:</b></label>
				<div class="col-md-10"><?php			
					switch($user->tipo){
						case 1: 	echo "Super"; 	break;
						case 2: 	echo "Admin"; 	break;
						case 3: 	echo "User"; 	break;
						default: 	echo "User"; 	break;
					}
				?></div>
			</div>
		</div>	
		<div class="modal-footer">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Fechar</button>
		</div>
	</div>
</div>