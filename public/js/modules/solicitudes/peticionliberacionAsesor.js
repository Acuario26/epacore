var id = 1;
var sum = 0;
var i = 0;
var edit = 0;
var contadorObsequios = 0;


$(document).ready(function () {
    $("#identificacion").val('TODOS').change();
    changeDatatable();
});
$("#btnEnviar").on('click', function () {
    changeDatatable();
});




function activaAsesor(id,identificacion) {

     var objApiRest = new AJAXRest('/adminSolicitudes/activarAsesor', {
             id: id,identificacion:identificacion,
        }, 'post');
        
		objApiRest.extractDataAjax(function (_resultContent) {
          
            if (_resultContent.status == 200) {
                alertToastSuccess(_resultContent.message, 3500);
                location.reload();

            } else {
                alertToast(_resultContent.message, 3500);
            }
        });
     

}

/*
 */

function changeDatatable() {
    var identificacion=$("#identificacion").val()
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lfrtip',

            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/adminSolicitudes/getDatatableLiberacionAsesor/"+identificacion,
            "columns": [

                {data: 'Tipo', "width": "10%"},
                {data: 'Usuario', "width": "20%"},
                {data: 'Fecha', "width": "10%"},
                {
                    data: 'opciones',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.opciones).text();
                    }
                },

            ],

        }).ajax.reload();


}

function recargar() {
    $('#dtmenu').dataTable()._fnAjaxUpdate();
}

