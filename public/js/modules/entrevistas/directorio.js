$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        changeDatatable();
    });
});

function limpiar() {

    $("#identificacion").val('');
    $("#nombres").val('');
    $("#apellidos").val('');
    $('#genero').val(0).change();
    $('#provincia_id').val(null).change();
    $('#ciudad_id').val(null).change();


    $("#convencional").val('');
    $("#celular").val('');
    $("#ing_empresa").val('');
    $("#modo").val(0).change();
    $('#cargo').val(null).change();
    $('#lider').val(null).change();

    $("#direccion").val('');
    $("#email").val('');
    $("#correo_institucional").val('');

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
            "ajax": "/uath/datatableDirectorio/",
            "columns": [

                {data: 'id', "width": "10%"},
                {data: 'name', "width": "25%"},
                {data: 'ciudad', "width": "10%"},
                {data: 'celular', "width": "10%"},
                {data: 'lider', "width": "10%"},
                {data: 'ing_empresa', "width": "10%"},
                {
                    data: 'estados',
                    "width": "5%",
                    "bSortable": false,
                    "searchable": false,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estados).text();
                    }
                },
                {
                    data: 'actions',
                    "width": "5%",
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

$("#provincia_id").on('change', function () {

    $("#ciudad_id").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/asesor/provinciaCiudad', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            var a = $("#ciudad_id_h").val();
            // console.log(a);
            if (_resultContent.status == 200) {

                $("#ciudad_id").append("<option value='0' selected='selected'>* CIUDAD *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#ciudad_id").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });

                $("#ciudad_id").val(a).change();
            } else {
                alertToast(_resultContent.message, 3500);
            }
        });

    }
});

function verificaCelular() {
    var numero = $("#celular").val();
    var d10 = numero.substr(0, 2);
    if (d10 != '09') {
        alertToast("Error en numero Celular", 3500);
    }
}

function SaveChanges() {
    var errores = [];
    var identificacion = $("#identificacion").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var genero = $('#genero').val()
    var provincia_id = $('#provincia_id').val();
    var ciudad_id = $('#ciudad_id').val();
    var telefono = $("#convencional").val();
    var celular = $("#celular").val();
    var ing_empresa = $("#ing_empresa").val();
    var modo = $("#modo").val();
    var cargo = $('#cargo').val();
    var lider = $('#lider').val();
    var direccion = $("#direccion").val();
    var email = $("#email").val();
    var correo_institucional = $("#correo_institucional").val();
    var tipo_empleado = $("#tipo_empleado").val();
    var band = 0;
    var objApiRest = new AJAXRest('/uath/SaveDirectorio', {
            identificacion: identificacion,
            nombres: nombres,
            apellidos: apellidos,
            genero: genero,
            provincia_id: provincia_id,
            ciudad_id: ciudad_id,
            telefono: telefono,
            celular: celular,
            ing_empresa: ing_empresa,
            modo: modo,
            cargo: cargo,
            lider_empleado_id: lider,
            direccion: direccion,
            email: email,
            correo_institucional: correo_institucional,
            tipo_empleado: tipo_empleado,
            band: band
        },
        'post'
        )
    ;
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            location.reload();


        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();

        }
    });
}

function DeleteChanges(id, band) {

    var objApiRest = new AJAXRest('/uath/DirectorioEliminar', {
        id: id, band: band
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

function PedirConfirmacion(id, dato) {
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
                        var band = 1;
                        DeleteChanges(id, band);
                        break;
                    case "activar":
                        var band = 0;
                        DeleteChanges(id, band);
                        break;
                }
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}

function EditChanges(identificacion, apellidos, nombres, lider_empleado_id, provincia_id, ciudad_id, direccion, convencional, celular, ing_empresa, genero, email, estado, correo_institucional, cargo_id, tipo_empleado) {


    var identificacion = $("#identificacion").val(identificacion);
    var nombres = $("#nombres").val(nombres);
    var apellidos = $("#apellidos").val(apellidos);
    var genero = $('#genero').val(genero).change()
    var provincia_id = $('#provincia_id').val(provincia_id).change();
    var ciudad_id = $('#ciudad_id_h').val(ciudad_id).change();
    var convencional = $("#convencional").val(convencional);
    var celular = $("#celular").val(celular);
    var ing_empresa = $("#ing_empresa").val(ing_empresa);
    var modo = $("#modo").val(estado).change();
    var cargo_id = $('#cargo').val(cargo_id).change();
    var lider_empleado_id = $('#lider').val(lider_empleado_id).change();
    var direccion = $("#direccion").val(direccion);
    var email = $("#email").val(email);
    var correo_institucional = $("#correo_institucional").val(correo_institucional);
    var tipo_empleado = $("#tipo_empleado").val(tipo_empleado).change();
    $("#Modalagregar").show();


}

$("#btnGuardar").on('click', function () {

    var errores = [];
    var identificacion = $("#identificacion").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var genero = $('#genero').val()
    var provincia_id = $('#provincia_id').val();
    var ciudad_id = $('#ciudad_id').val();
    var convencional = $("#convencional").val();
    var celular = $("#celular").val();
    var ing_empresa = $("#ing_empresa").val();
    var modo = $("#modo").val();
    var cargo = $('#cargo').val();
    var lider = $('#lider').val();
    var direccion = $("#direccion").val();
    var email = $("#email").val();
    var correo_institucional = $("#correo_institucional").val();

    if (identificacion.length < 1) {
        errores.push("\nidentitifacion");
    }
    if (nombres.length < 1) {
        errores.push("\nnombres");
    }
    if (apellidos.length < 1) {
        errores.push("\napellidos");
    }
    if (modo =='' || modo==null) {
        errores.push("\nmodo");
    }
    if (cargo.length < 1) {
        errores.push("\ncargo");
    }


    if (errores.length == 0) {
        var save = "save";
        PedirConfirmacion('0', save);

    } else {
        alertToast("Los Siguientes campos son obligatorios:" + errores + "", 3500);
    }


    //  var email = $("#email").val();
    // var correo_institucional = $("#correo_institucional").val();

});
