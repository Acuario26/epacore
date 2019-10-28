$(document).ready(function(){
    $(function () {
        changeDatatable();
    });

    $("#btnGuardar").on('click', function (event) {

        event.preventDefault();
        var save="save";
        PedirConfirmacion('0',save,event,'FrmStatus');
        


    });

    $("#btnIncompleto").on('click', function (event) {

        event.preventDefault();
        var save="save";
        PedirConfirmacion('0',save,event,'FrmIncompleto');     


    });



function PedirConfirmacion(id,dato,event,frm)
{

    swal({ title:                "¿Estas seguro de realizar esta accion?",
            text:                "Al confirmar se grabaran los datos exitosamente",
            type:                "warning",
            showCancelButton:    true,
            confirmButtonColor:  "#DD6B55",
            confirmButtonText:   "Si!",
            cancelButtonText:    "No",
            closeOnConfirm:      true,
            closeOnCancel:       false },
        function(isConfirm)
        {

            if (isConfirm)
            {
                //console.log(event);
                //return true;
                $('#'+frm).submit();

            } else {
                swal("¡Cancelado!","No se registraron cambios...","error");

                
            }
        });
}
});


function changeDatatable()
{
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

        $('#dtmenu').show();
        $.fn.dataTable.ext.errMode = 'throw';
        $('#dtmenu').DataTable(
            {
                responsive: true,"oLanguage":
                    {
                        "sUrl": "/js/config/datatablespanish.json"
                    },
                "lengthMenu": [[5,10,20 -1], [5,10,20, "All"]],
                "order": [[ 1, 'desc' ]],
                "searching": true,
                "info":  false,
                "ordering": false,
                "bPaginate": true,
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "destroy": true,
                "ajax": "/admin/postulantes/data",
                "columns":[

                    {data: 'identificacion', "width": "10%"},
                    {data: 'nombres', "width": "12%"},
                    {data: 'apellidos',   "width": "12%"},
                    {data: 'semestre',   "width": "10%"},
                    {data: 'request.id', "width": "10%"},
                    {data: 'status_label', "width": "10%"},
                    {
                        data: 'actions',
                        "width": "10%",
                        "bSortable": false,
                        "searchable": false,
                        "targets": 0,
                        
                    }
                ],

            }).ajax.reload();


}


