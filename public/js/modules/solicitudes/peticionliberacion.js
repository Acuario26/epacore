var id = 1;
var sum = 0;
var i = 0;
var edit = 0;
var contadorObsequios = 0;

$(document).ready(function () {
    $(function () {
        changeDatatable(0);
        var v=$("#controlAdmin").val();
        if(v!=0)
        {
            $("#destado").show();
        }
        else
        {
            $("#destado").hide();
        }
    });
});
$("#estado").on('change', function () {

    if (this.value != '') {

        switch (this.value) {
            case '0':
                //pendiente de estado
                changeDatatable(0);

                break;
            case 'A':

                //pendiente de asesor
                changeDatatable('A');

                break;
            case 'I':
                //saliente
                changeDatatable('I');

                break;
        }
    }
});


function SolicitudInactiva(id) {
    var objApiRest = new AJAXRest('/lider/SolicitudInactiva', {
        id: id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            recargar();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function PedirConfirmacion(id) {
    swal({
            title: "¿Estas seguro de realizar esta accion?",
            text: "Al confirmar se grabaran los datos exitosamente",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si!",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                SolicitudInactiva(id);
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}


function changeDatatable(dato) {
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
            "ajax": "/lider/datatableSolicitudInactiva/"+dato,
            "columns": [

                {data: 'Solicitud', "width": "10%"},
                {data: 'Observacion', "width": "50%"},
                {data: 'Usuario', "width": "20%"},
                {data: 'Fecha', "width": "10%"},
                {
                    data: 'estado',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },

            ],

        }).ajax.reload();


}

function recargar() {
    $('#dtmenu').dataTable()._fnAjaxUpdate();
}

