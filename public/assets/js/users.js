var userOptions = {
	"fixedColumns": true,
	"serverSide": true,
	"paging": true,
	"searching": true,
	"processing": true,
	"pageLength": 10,
	"ajax" : {
		"url":	baseUrl + 'user/search',
		"type"			: "GET",
		"contentType"	: "application/json; charset=utf-8",
		"dataType"		: "json",
		"headers"		: { "Authorization": "Bearer " + $('meta[name="csrf-token"]').attr('content') },
		"data"			: function (data) {			
			data.Search = {	
							id 		: 	[ 'id' , $('#search_id').val(), 'number' ],
							name 	: 	$('#search_name').val(),
							email 	: 	$('#search_email').val(),
							tipo 	: 	[ 'tipo' , $('#search_tipo').val(), 'number' ]
			};
			data._token	= $('meta[name=csrf-token]').attr('content');
		},
		"error"			: function(xhr, status, err){
			$("#table-user tbody").html('<tr><th colspan="10" class="text-center">Erro ao processar os dados</th></tr>');
			$("#table-user_processing").css("display","none");
		}
	},
	"order" : [1, 'asc'],
}
createDatatable('#table-user', userOptions);
$('#table-user_filter').hide();

$('#table-user tfoot th').each( function () {
	var title = $('#table-user thead th').eq( $(this).index() ).text().trim();
	if  ((title	!=	"")&&(title != "Tipo")){
		$(this).html( '<input type="search" style="width: 100%;" class="form-control input-sm" placeholder="'+title+'" />' );
	}
});

$('#table-user').DataTable().columns().every(function(){
	var that = this;
	$('input',this.footer()).on('keyup change',function(e){
		if ((that.search() !== this.value) && (e.keyCode == 13)){
			that.search(this.value).draw();
		}
	});
	$('select',this.footer()).on('change',function(e){
		that.search(this.value).draw();
	});	
});

$("body").tooltip({ selector: '[data-toggle=tooltip]' });

$(function(){
	$('.btn-advanced-search').on('click', function(){
		if ($('#div_advanced_search').is(":visible")){
			$('#div_advanced_search').hide();
		} else {
			$('#div_advanced_search').show();
		}
	});
	
	$('.new-user').on('click', function(){
		newUser();
	});

	$('.btn-delete-user').on('click', function(){
		var id = $(this).attr('data-user-id');
		deleteUser(id);
	});
	
	$("#tipo,#search_tipo,#search_tipo_table").select2({minimumResultsForSearch: -1});
	
	var SPMaskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
			field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};
	
	var counter_contatos = $('#tab_contact input[id*="nome"]').length;
	$("#addrow_contatos").click(function(){		
		var newRow = $("<tr>");
        var cols = "";
		
		cols +=	"<td class='col-md-5'><input class='form-control txt-nome-contato' id='nome' type='text' name='UserContact[" + counter_contatos + "][nome]' required></td>";
		cols +=	"<td class='col-md-2'><input class='form-control txt-telefone txt_telefone_" + counter_contatos + "' id='telefone' type='text' name='UserContact[" + counter_contatos + "][telefone]' required></td>";
		cols +=	"<td class='col-md-4'><input class='form-control txt-email-contato' id='email' type='email' name='UserContact[" + counter_contatos + "][email]'></td>";
		cols += "<td class='col-md-1'><input type='button' class='btn btn-md btn-danger ibtnDel pull-right' value='Remover'></td>";
		newRow.append(cols);
        $("table.order-list.contatos").append(newRow);
		$("input.txt_telefone_"+counter_contatos).mask(SPMaskBehavior, spOptions);
		counter_contatos++;
	});
	
	$("table.order-list").on("click", ".ibtnDel", function (event) {
		var str = $(this).closest("table").attr("class");
		$(this).closest("tr").remove();
    });
});

function newUser(){
	var form 	= 	$('#form-user');
	var modal 	=	$('#myModal');

	$(form)
		.attr('action', baseUrl + 'user/new')
		.parent('#inputName')
		.val('');
	$('.modal-dialog').css('width','80%');
	$(modal).modal('show');
}

function deleteUser(id){
	var css = '.modal-dialog { width: 400px !important; }',
		head = document.head || document.getElementsByTagName('head')[0],
		style = document.createElement('style');

	style.type = 'text/css';
	if (style.styleSheet){
	  style.styleSheet.cssText = css;
	} else {
	  style.appendChild(document.createTextNode(css));
	}
	head.appendChild(style);
	
	bootbox.confirm({
		message	: "Tem certeza que deseja excluir este Usuário?",
		buttons	: {
			confirm	: {
				label		: 'Excluir',
				className	: 'btn btn-sm btn-primary'
			},
			cancel	: {
				label		: 'Cancelar',
				className	: 'btn btn-sm btn-danger'
			}
		},
		callback	: 	function (result) {
			if (result) {
				var params = {	'id' : id	}
				request('user/delete', params, 'post');
			}
		}
	}).css({'top':'30%'});
}

function seeUser(id){
	var texto = '';
	texto += '<div class="modal-dialog">';
		texto += '<div class="modal-content">';
			texto += '<div class="modal-header">';
				texto += '<div class="row">';
					texto += '<div class="col-md-8">';
						texto += '<h4 class="modal-title" id="myModalLabel"><b>Usuário #</b></h4>';
					texto += '</div>';
					texto += '<div class="col-md-4 pull-right">';
						texto += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
					texto += '</div>';
				texto += '</div>';
			texto += '</div>';
			texto += '<div class="modal-body">';
				texto += '<img src="' + baseUrl + 'assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto;">';
			texto += '</div>';
			texto += '<div class="modal-footer">';
				texto += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Fechar</button>';
			texto += '</div>';
		texto += '</div>';
	texto += '</div>';
	
	$('#seeUsersModal').html(texto);
	$('#seeUsersModal').load(baseUrl + 'user/see/' + id);
	$('#seeUsersModal').modal('toggle', {remote: false});
	return false;
}