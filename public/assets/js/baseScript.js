$(function(){
    $(document).on('click load', ".nav-border-top", function(){
        var cor = $(this).attr('data-border-color');
        $(this).find('a:after').css('border-color', cor);
    });
});

function createDatatable(tableId, extraOption){
	var loadingRecords = "<div class='text-center' id='loading-reg'><img style='width:50px' src='" + baseUrl + "assets/img/loading.gif' /></div>";
	var options = {
		"language": {
			"decimal": ",",
			"thousands": ".",
			"zeroRecords": "<strong>Nenhum registro encontrado</strong>",
			"info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"infoEmpty": "Mostrando 0 até 0 de 0 registros",
			"infoFiltered": "(Filtrados de _MAX_ registros)",
			"infoPostFix": "",
			"infoThousands": ".",
			"lengthMenu": "<br>Mostrar _MENU_ registros",
			"loadingRecords": loadingRecords,
			"processing": loadingRecords,
			"zeroRecords": "Nenhum registro encontrado",
			"search": "<br>Pesquisar: ",
			"paginate": {
				"next": "Próximo",
				"previous": "Anterior",
				"first": "Primeiro",
				"last": "Último"
			},
		},
		"autoWidth": false,
		"bAutoWidth": false,
		"bDestroy":true
	};

	if (extraOption) {
		options = Object.assign(options, extraOption);
	}

	$(tableId).dataTable(options);
}

function toastrMessage(status, message){
    if (!status) {
        status = 'info';
    }
    toastr[status](message);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
}

function request(path, params, method) {
    method = method || "post"; 	// Set method to post by default if not specified.
    path = baseUrl + path;		// Complements path with baseUrl set in layouts files

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }
    var tokenVerify = document.createElement('input');
    tokenVerify.setAttribute("type", "hidden");
    tokenVerify.setAttribute("name", "_token");
    tokenVerify.setAttribute("value", $('meta[name="csrf-token"]').attr('content'));
    form.appendChild(tokenVerify);

    document.body.appendChild(form);
    form.submit();
}

function isValid(yourvar, prop){
	if (prop != null && yourvar != null && yourvar.hasOwnProperty(prop)) {
		return isValid(yourvar[prop], null);
	}
	return Boolean(typeof yourvar != 'undefined' && yourvar != null && yourvar != undefined && yourvar);
}

function modalLoading(identifier, is_loading){
    if (is_loading) {
        $(identifier)
            .find('.modal-body')
            .hide();

        $(identifier)
            .find('button')
            .attr('disabled', true);

        $("<div />",{
            'class' : 'modal-body content-img-loading',
            'style' : 'text-align: center;'
        })
        .append($("<img>", {
            'src': baseUrl + "assets/img/loading.gif",
            'style' : 'width: 50px;'
        }))
        .insertBefore($(identifier)
            .find('.modal-footer'));
    }else{
        $(identifier)
            .find('.content-img-loading')
            .remove();

        $(identifier)
            .find('.modal-body')
            .show();
        $(identifier)
            .find('button')
            .attr('disabled', false);
    }
}

function ColorLuminance(hex, lum) {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    }
    lum = lum || 0;

    // convert to decimal and change luminosity
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i*2,2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00"+c).substr(c.length);
    }

    return rgb;
}