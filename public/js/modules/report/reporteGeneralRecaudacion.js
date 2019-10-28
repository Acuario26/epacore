dataArray='';
var configRecaudacion = {
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
			name: 'valor_cubierto',
			caption: 'ValorCubierto',
			dataSettings: {
				aggregateFunc: 'sum',
				formatFunc: function(value) {
					return value ?  ' $'+Number(value).toFixed(2): '';
				}
			}
		},
		{
			name: 'valor_cobro',
			caption: 'ValorCobro',
			dataSettings: {
				aggregateFunc: 'sum',
				formatFunc: function(value) {
					return value ?  ' $'+Number(value).toFixed(2): '';
				}
			}
		},
		{
			name: 'valor_total',
			caption: 'ValorTotal',
			dataSettings: {
				aggregateFunc: 'sum',
				formatFunc: function(value) {
					return value ?  ' $'+Number(value).toFixed(2): '';
				}
			}
		},
		{
			name: 'forma_cobro',
			caption: 'forma_cobro'
		},
		{
			name: 'mes',
			caption: 'Meses'
		},
		{
			name: 'dh',
			caption: 'DH'
		},
		{
			name: 'tipo_facturacion',
			caption: 'Tipo Facturacion',
		},
		{
			name: 'cac',
			caption: 'cac',
		},
		{
			name: 'idRecaudacion',
			caption: 'id',
		},
		{
			name: 'fecha_cobro',
			caption: 'fecha_cobro',
		},
		{
			name: 'emision',
			caption: 'fecha_emision',
		}
	],
	rows    : ['DH'],
	columns : ['mes' ],
	data    : ['valor_cubierto'],

};

var elem2 = document.getElementById('rr2')
var pgridwidget2 = new orb.pgridwidget(configRecaudacion);
	pgridwidget2.render(elem2);


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
    var tabla='RECAUDACION';
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
		pgridwidget2.refreshData(dataArray);
    });
});

