var userContactOptions = {
	"fixedColumns": true,
	"serverSide": true,
	"paging": true,
	"searching": true,
	"processing": true,
	"pageLength": 10,
	"ajax" : {
		"url":	baseUrl + 'userContact/search',
		"type"			: "GET",
		"contentType"	: "application/json; charset=utf-8",
		"dataType"		: "json",
		"headers"		: { "Authorization": "Bearer " + $('meta[name="csrf-token"]').attr('content') },
		"data"			: function (data) {			
			data.Search = {	
							id 		: 	[ 'id' , $('#search_id').val(), 'number' ],
							user_id : 	[ 'user_id' , $('#search_user_id').val(), 'number' ],
							nome 	: 	$('#search_nome').val(),
							email 	: 	$('#search_email').val(),
							telefone: 	$('#search_telefone').val(),
							setor	:	$('#search_setor').val(),
			};
			data._token	= $('meta[name=csrf-token]').attr('content');
		},
		"error"			: function(xhr, status, err){
			$("#table-userContact tbody").html('<tr><th colspan="10" class="text-center">Erro ao processar os dados</th></tr>');
			$("#table-userContact_processing").css("display","none");
		}
	},
	"order" : [1, 'asc'],
}
createDatatable('#table-userContact', userContactOptions);
$('#table-userContact_filter').hide();

$('#table-userContact tfoot th').each( function () {
	var title = $('#table-userContact thead th').eq( $(this).index() ).text().trim();
	if  ((title	!=	"")&&(title != "Usuário")){
		$(this).html( '<input type="search" style="width: 100%;" class="form-control input-sm" placeholder="'+title+'" />' );
	}
});

$('#table-userContact').DataTable().columns().every(function(){
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
	
	$('.new-userContact').on('click', function(){
		newUserContact();
	});

	$('.btn-delete-userContact').on('click', function(){
		var id = $(this).attr('data-user-id');
		deleteUser(id);
	});
	
	var SPMaskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
			field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};
	
	$("table.order-list").on("click", ".ibtnDel", function (event) {
		var str = $(this).closest("table").attr("class");
		$(this).closest("tr").remove();
    });
	
	$('#user_id,#search_user_id_table').select2();
	$("input[id='telefone'],input[id='search_telefone']").mask(SPMaskBehavior, spOptions);
	
});

function newUserContact(){
	var form 	= 	$('#form-userContact');
	var modal 	=	$('#myModal');

	$(form)
		.attr('action', baseUrl + 'userContact/new')
		.parent('#inputName')
		.val('');
	$('.modal-dialog').css('width','80%');
	$(modal).modal('show');
}

function deleteUserContact(id){
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
		message	: "Tem certeza que deseja excluir este Contato?",
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
				request('userContact/delete', params, 'post');
			}
		}
	}).css({'top':'30%'});
}

function seeUserContact(id){
	var texto = '';
	texto += '<div class="modal-dialog">';
		texto += '<div class="modal-content">';
			texto += '<div class="modal-header">';
				texto += '<div class="row">';
					texto += '<div class="col-md-8">';
						texto += '<h4 class="modal-title" id="myModalLabel"><b>Contato #</b></h4>';
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
	
	$('#seeUsersContactsModal').html(texto);
	$('#seeUsersContactsModal').load(baseUrl + 'userContact/see/' + id);
	$('#seeUsersContactsModal').modal('toggle', {remote: false});
	return false;
}