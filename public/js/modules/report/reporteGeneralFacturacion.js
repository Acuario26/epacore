dataArray='';

	var configFacturacion = {
		dataSource: dataArray,
		canMoveFields: true, 
		dataHeadersLocation: 'columns',
		width: 1000,
		height: 1000,
		theme: 'black',
		toolbar: {
			visible: true
		},
		grandTotal: {
			rowsvisible: true,
			columnsvisible: true,
			caption:'Totales'
		},
		subTotal: {
			visible: true,
			collapsed: true,
			collapsible: true
		},
		rowSettings: {
			subTotal: {
				visible: true,
				collapsed: true,
				collapsible: true
			}
		},
		columnSettings: {
			subTotal: {
				visible: true,
				collapsed: true,
				collapsible: true
			}
		},
		fields: [
			{
				name: 'valor',
				caption: 'Valor',
				dataSettings: {
					aggregateFunc: 'sum',
					formatFunc: function(value) {
						return value ?  ' $'+Number(value).toFixed(2): '';
					}
				}
			},
			{
				name: 'saldo',
				caption: 'Saldo',
				dataSettings: {
					aggregateFunc: 'sum',
					formatFunc: function(value) {
						return value ?  ' $'+Number(value).toFixed(2): '';
					}
				}
			},
			{
				name: 'mes',
				caption: 'Meses'
			},
			{
				name: 'dh',
				caption: 'DH',
			},
			{
				name: 'tipo',
				caption: 'Tipo',
			},
			{
				name: 'codigo',
				caption: 'Codigo',
			},
			{
				name: 'tipos_facturacion',
				caption: 'Tipo Facturacion',
			},
			{
				name: 'cac',
				caption: 'cac',
			},
			{
				name: 'id',
				caption: '#',
				dataSettings: {
					aggregateFunc: 'count',
					formatFunc: function(value) {
						return value!=null?value:0;
					}
				}
			}
		],
		rows    : ['DH'],
		columns : [ 'mes' ],
		data    : [ 'id', 'valor','saldo'],
	
	};
	
	var elem = document.getElementById('rr')
	var pgridwidget = new orb.pgridwidget(configFacturacion);
		pgridwidget.render(elem);



$(document).ready(function(){
    $(function () {
	   $(".orb-overlay-visible").addClass('table-reponsive');
		$("#output").empty();
    });
});


function exportToExcel(anchor) {
	anchor.href = orb.export(pgridwidget);
	return true;
}


$("#btnGuardar").on('click', function () {
	
    $("#output").empty();
    var fechai=$("#fechai").val();
    var fechaf=$("#fechaf").val();
    var tabla='FACTURACION';

    var objApiRest = new AJAXRest('/reporte/reporteGeneralDatos', {fechai:fechai,fechaf:fechaf,tabla:tabla}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        dataArray=_resultContent.message;
        if (_resultContent.status != 200) {
			$(".orb").addClass('hidden');
			$("#Modalagregar").hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
			alertToast(_resultContent.message, 3500);
			dataArray=[];
        }else{
			$(".orb").removeClass('hidden');
		}
	    tabla=$("#tipoReporte option:selected" ).text();
		var data = $.grep(dataArray, function (element, index) {
            return element.tipo.toUpperCase().trim() == tabla.toUpperCase().trim();
        });
		pgridwidget.refreshData(data);
    });
});

