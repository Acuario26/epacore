$(document).ready(function(){
    $(function () {
        changeDatatable();
    });

    $("#btnGuardar").on('click', function (event) {

        event.preventDefault();
        var save="save";
        PedirConfirmacion('0',save,event);
        


});

function PedirConfirmacion(id,dato,event)
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
                $('#FrmStatus').submit();

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
                "order": [[ 3, 'asc' ]],
                "searching": true,
                "info":  true,
                "ordering": true,
                "bPaginate": true,
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "destroy": true,
                "ajax": "/admin/gestion/periodos/data",
                "columns":[

                    {data: 'descripcion', "width": "20%"},
                    {data: 'fechai', "width": "12%"},
                    {data: 'fechaf',   "width": "10%"},
                    {data: 'estado_label',   "width": "12%"},
                    {
                        data: 'actions',
                        "width": "10%",
                        "bSortable": true,
                        "searchable": true,
                        "targets": 0,
                        
                    }
                ],

            }).ajax.reload();


}