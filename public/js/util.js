
function ajaxLoader(el, options) {
	var defaults = {
		bgColor :'#fff',
		duration :800,
		opacity :0.7,
		classOveride :false
	}
	this.options = jQuery.extend(defaults, options);
	this.container = $(el);
	this.init = function() {
		var container = this.container;
		this.remove();
		var overlay = $('<div></div>').css( {
			'background-color' :this.options.bgColor,
			'opacity' :this.options.opacity,
			'width' :container.width(),
			'height' :container.height(),
			'position' :'absolute',
			'top' :'0px',
			'left' :'0px',
			'z-index' :99999
		}).addClass('ajax_overlay');
		if (this.options.classOveride) {
			overlay.addClass(this.options.classOveride);
		}
		container.append(overlay.append(
				$('<div></div>').addClass('ajax_loader')).fadeIn(
				this.options.duration));
	};
	this.remove = function() {
		var overlay = this.container.children(".ajax_overlay");
		if (overlay.length) {
			overlay.fadeOut(this.options.classOveride, function() {
				overlay.remove();
			});
		}
	}
	this.init();
}

var loaderR;
loaderR = loaderR || (function (j) {
    //var pleaseWaitDiv = $('<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h2>Realizando la operaci\u00f3n, espere por favor....</h2></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div></div></div></div></div></div>');
	var pleaseWaitDiv = $('<div class="modal bd-example-modal-sm" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\n' +
        '\t<div class="modal-dialog modal-sm modal-dialog-centered">\n' +
        '\t\t<div class="modal-content" style="background-color:transparent;border: 1px solid transparent;">\n' +
        '\t\t\t<div class="modal-header" style="border-bottom:4px solid transparent;">\n' +
        '\t\t\t\t\n' +
        '\t\t\t</div>\n' +
        '\t\t\t<div class="modal-body">\n' +
        '\t\t\t\t<div class="text-center">\n' +
        '\t\t\t\t  <div class="spinner-border" role="status">\t\t\t\t\t\n' +
        '\t\t\t\t  </div>\n' +
        '\t\t\t\t  <p style="color:white;">Procesando, espere por favor...</p>\n' +
        '\t\t\t\t</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>\n' +
        '\t</div>\n' +
        '</div>');
    return {
        showPleaseWait: function () {
            pleaseWaitDiv.modal('show');
        },
        hidePleaseWait: function () {
            pleaseWaitDiv.modal('hide');
        },

    };
})();


function tratarComoNumeroV1(idInput){
	var cantidad = $(idInput).val();
	cantidad = ($.trim(cantidad)==='')?0:parseFloat(cantidad);
	return cantidad;
}

function tratarComoNumeroV2(cantidad){
	cantidad = ($.trim(cantidad)==='')?0:parseFloat(cantidad);
	return cantidad;
}

function validarInputEntero(elemento)
{
	$(elemento).numeric(
            {decimal: false, negative: false},
            function () {
                alert('Solo numeros enteros positivos');
                this.value = '';
                this.focus();
            }
	);
}

function validarInputDecimal(elemento,cantidadDigitos)
{
	$(elemento).numeric(
            {decimal: true, negative: false,altDecimal: '.', decimal: '.',decimalPlaces: cantidadDigitos},
            function () {
                alert('Solo numeros decimales positivos');
                this.value = '';
                this.focus();
            }
  );
}

function asignarDatepicker(elemento)
{
	//antigua version del calendar
	//  $( elemento ).datepicker({
	//      	changeMonth: true,
	//      	changeYear: true,
	//      	yearRange: '1910:2100',
	//        dateFormat: 'dd/mm/yy',
	//        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	//        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	//        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
	//    });
	
 
	 $(elemento).bootstrapDP({
		    format: "dd/mm/yyyy",
		    maxViewMode: 2,
		    todayBtn: "linked",
		    language: "es",
		    orientation: "bottom auto",
		    multidate: false,
		    autoclose: true
		    
	 });   
}

function stringsSimilares(a,b) {
    var lengthA = a.length;
    var lengthB = b.length;
    var equivalency = 0;
    var minLength = (a.length > b.length) ? b.length : a.length;    
    var maxLength = (a.length < b.length) ? b.length : a.length;    
    for(var i = 0; i < minLength; i++) {
        if(a[i] == b[i]) {
            equivalency++;
        }
    }
    var weight = equivalency / maxLength;
    return (weight * 100) + "%";
}

function roundNumber(value, decimals) {
	  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function getCurrentDateFormateado()
{
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
	    dd = '0'+dd;
	}
	if(mm<10) {
	    mm = '0'+mm;
	} 
	today = dd + '/' + mm + '/' + yyyy;
	return today;
}

function asignarRutaLink(elemento,urlnavegar)
{
	$(elemento).attr('href',urlnavegar);
}