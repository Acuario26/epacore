$(document).ready(function(){
    $(function () {
        changeDatatable();
    });

    $("#btnGuardar").on('click', function (event) {

        event.preventDefault();
        var save="save";
        PedirConfirmacion('0',save,event);
        


});

   

    

$(document.body).on("change","#select_tags",function(){
 //alert(this.option);
    $array=this.value.split('-');
     if($array[0]=='SUP' || $array[0]=='MON'){
        $( "#lugar" ).prop( "disabled", false );
    }else{
        $( "#lugar" ).prop( "disabled", true );
        $( "#lugar" ).val('');
    }   
    

 console.log(this.value.split('-'));

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
                "order": [[ 1, 'desc' ]],
                "searching": true,
                "info":  false,
                "ordering": false,
                "bPaginate": true,
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "destroy": true,
                "ajax": "/admin/gestion/empleados/data",
                "columns":[

                    {data: 'persona_id', "width": "10%"},
                    {data: 'name', "width": "12%"},
                    {data: 'roles_label',   "width": "12%"},
                    {data: 'email',   "width": "10%"},
                    {data: 'estado_label',   "width": "12%"},
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

$array=$("#select_tags").val().split('-');
 if($array[0]=='SUP'  || $array[0]=='MON'){
    $( "#lugar" ).prop( "disabled", false );
 }else{
    $( "#lugar" ).prop( "disabled", true );
    $( "#lugar" ).val('');
 } 