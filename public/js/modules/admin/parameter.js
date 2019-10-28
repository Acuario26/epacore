$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        changeDatatable();
    });
});


$("#btnGuardar").on('click', function () {

    var save = "save";
    PedirConfirmacion('0', '0', save);
});


function PedirConfirmacion(id, parameter, dato) {
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
                switch (dato) {
                    case "save":
                        SaveChanges();
                        break;

                    case "delete":
                        DeleteChanges(id, parameter);
                        break;
                }
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}

function EditChanges(id, name, estado, parameter,verificacion) {
    modal.style.display = "block";
    $("#var").val(id);
    $("#father").val(parameter).change();
    $("#optionid").val(estado).change();
    $("#verificacion").val(verificacion).change();
    $("#name").val(name);
}

function DeleteChanges(id, parameter) {
    var objApiRest = new AJAXRest('/admin/ParameterEliminar', {
        id: id,
        parameter: parameter
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable();


        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();

        }
    });

}

function SaveChanges() {
    var objApiRest = new AJAXRest('/admin/SaveParameter', {
        optionid: $("#optionid").val(),
        name: $("#name").val(),
        father: $("#father").val(),
        var: $("#var").val(),
        verificacion: $("#verificacion").val()
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            $("#Modalagregar").hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable();

        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();
        }
    });
}

function limpiar() {
    modal.style.display = "block";
    $('#optionid').val(0).change();
    $("#name").val('');
    $("#father").val(0).change();
    $("#var").val(0);

}

function changeDatatable() {
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[5, -1], [5, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/admin/datatable-parameter/",
            "columns": [

                {data: 'name', "width": "50%"},
                {
                    data: 'estado',
                    "width": "20%",
                    "bSortable": false,
                    "searchable": false,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },
                {
                    data: 'actions',
                    "width": "20%",
                    "bSortable": false,
                    "searchable": false,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.actions).text();
                    }
                }
            ],

        }).ajax.reload();


}
