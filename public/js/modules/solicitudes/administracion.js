var id = 1;
var sum = 0;
var i = 0;
var edit = 0;
var contadorObsequios = 0;

$(document).ready(function () {
    $(function () {

        if ($("#role").val() != 0) {
            $("#destado").show();

        } else {
            $("#destado").hide();

        }

    });
    configuracionBP('bp', 'BP');
});
$("#provincia_id").on('change', function () {

    $("#entrega_ciudad_id").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/asesor/provinciaCiudad', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            var a = $("#dciudadi").val();
            // console.log(a);
            if (_resultContent.status == 200) {

                $("#entrega_ciudad_id").append("<option value='0' selected='selected'>* CIUDAD *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#entrega_ciudad_id").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });

                $("#entrega_ciudad_id").val(a).change();
            } else {
                alertToast(_resultContent.message, 3500);
            }
        });

    }
});

function validate_fechaMayorQue(fechaInicial, fechaFinal) {
    valuesStart = fechaInicial.split("-");
    valuesEnd = fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart = new Date(valuesStart[0], (valuesStart[1] - 1), valuesStart[2]);
    var dateEnd = new Date(valuesEnd[0], (valuesEnd[1] - 1), valuesEnd[2]);
    if (dateStart > dateEnd) {
        return 0;
    }
    return 1;
}

$("#dprovincia").on('change', function () {

    $("#dciudad").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/asesor/provinciaCiudad', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            var a = $("#dciudadi").val();
            // console.log(a);
            if (_resultContent.status == 200) {

                $("#dciudad").append("<option value='0' selected='selected'>* CIUDAD *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#dciudad").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });

                $("#dciudad").val(a).change();
            } else {
                alertToast(_resultContent.message, 3500);
            }
        });

    }
});
$("#lprovincia_laborales").on('change', function () {

    $("#ciudad_laboral").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/asesor/provinciaCiudad', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            var a = $("#dlaboralesi").val();
            if (_resultContent.status == 200) {
                $("#ciudad_laboral").append("<option value='0' selected='selected'>* CIUDAD *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#ciudad_laboral").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });
                $("#ciudad_laboral").val(a).change();
            } else {
                alertToast(_resultContent.message, 3500);
            }
        });

    }
});

$("#btnEstado").on('click', function () {
    var criterio = $("#criterio").val()
    var parametro = $("#parametro").val()
    var fechai = $("#fechai").val();
    var fechaf = $("#fechaf").val();
    if ($("#role").val() != 0) {
        if (validate_fechaMayorQue(fechai, fechaf)) {
            changeDatatable(criterio, parametro, fechai, fechaf);
        } else {
            alertToast("La fecha " + fechaf + " NO es superior a la fecha " + fechai, 2500);
        }
    } else {
        var criterio = $("#criterio").val()
        var parametro = $("#parametro").val()
        var fechai = $("#fechai").val();
        var fechaf = $("#fechaf").val();


        if (parametro != '' && parametro != null) {
            var objApiRest1 = new AJAXRest('/adminSolicitudes/editChange', {solicitud_id: parametro}, 'post');

            objApiRest1.extractDataAjax(function (_resultContent) {
                switch (_resultContent.status) {
                    case 200:
                        $.each(_resultContent.message, function (_key, _value) {
                            editchangeSolicitud(_value.solicitud, _value.entrega_ciudad_id, _value.direccion_entrega, _value.provincia_id, _value.region, _value.fecha_lote, _value.lote, _value.ciclo_facturacion, _value.fecha_activacion, _value.fecha_facturacion, _value.celular_entrega, _value.estado, _value.gestor_id, _value.created_at, _value.observacion, _value.tchip
                                , _value.tobsequios, _value.tlineas, _value.uestado, _value.empleado_id, _value.tipo);
                        });
                        document.getElementById("btnEstado1").click();
                        break;

                    case 404:
                        alertToast(_resultContent.message, 3500);
                        $("#Modalagregar").hide();

                        break;
                }

            });
        } else {
            alertToast("Ingrese un número de Solicitud", 2500);
        }

    }

});
$("#btnGuardar").on('click', function () {
    var tipo = $("#tipo_dato").val();
    var fecha_desactivacion_ch = $("#fecha_desactivacion_ch").val();

    switch (tipo) {
        case 'solicitud':
            guardar_solicitud();
            break;
        case 'linea':
            guardar_linea();
            break;
        case 'cliente':
            guardar();
            break;
        case 'BAJA':
            if (fecha_desactivacion_ch == '' || fecha_desactivacion_ch == null) {
                alertToast("Debe Ingresar la fecha de desactivación", 2500);
            } else {
                guardar_chargeback();
            }
            break;
        case 'CARRUSEL':
            guardar_chargeback();
            break;
        default:
            guardar_linea();
            break;
    }


});

function guardar_solicitud() {
    var tipo = $("#tipo_dato").val();
    var entrega_ciudad_id = $("#entrega_ciudad_id").val();
    var solicitud = $("#solicitud").val();
    var direccion_entrega = $("#direccion_entrega").val();
    var provincia_id = $("#provincia_id").val();
    var region = $("#region").val();
    var fecha_lote = $("#fecha_lote").val();
    var lote = $("#lote").val();
    var ciclo_facturacion = $("#ciclo_facturacion").val();
    var fecha_activacion = $("#fecha_activacion").val();
    var fecha_facturacion = $("#fecha_facturacion").val();
    var celular_entrega = $("#celular_entrega").val();
    var estado = $("#estado").val();
    var gestor_id = $("#gestor_id").val();
    var empleado_id = $("#empleado_id").val();
    var observacion = $("#observacion").val();
    var motivo = $("#motivo").val();
    var empleado_id_d = $("#empleado_id_d").val();
    if (empleado_id == null || empleado_id == '') {
        alertToast("Debe Ingresar un Nuevo Asesor", 2500)

    } else {

        console.log(motivo);
        if (motivo == null || motivo == '') {
            alertToast("Debe Ingresar el motivo del cambio de asesor", 2500);
        } else {
            var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                    entrega_ciudad_id: entrega_ciudad_id,
                    solicitud: solicitud,
                    direccion_entrega: direccion_entrega,
                    provincia_id: provincia_id,
                    region: region,
                    fecha_lote: fecha_lote,
                    lote: lote,
                    ciclo_facturacion: ciclo_facturacion,
                    fecha_activacion: fecha_activacion,
                    fecha_facturacion: fecha_facturacion,
                    celular_entrega: celular_entrega,
                    estado: estado,
                    gestor_id: gestor_id,
                    empleado_id: empleado_id,
                    empleado_id_d: empleado_id_d,
                    observacion: observacion,
                    tipo: tipo,
                    motivo: motivo
                },
                'post'
                )
            ;
            objApiRest.extractDataAjax(function (_resultContent) {
                if (_resultContent.status == 200) {
                    alertToastSuccess(_resultContent.message, 3500);
                    $("#Modalagregar").hide();
                    $("#dsolicitud").hide();
                    $("#dlinea").hide();
                    $("#dcliente").hide();
                    $("#chargeback").hide();

                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    if ($("#role").val() != 0) {
                        changeDatatable();
                    }

                } else {
                    alertToast(_resultContent.message, 3500);
                }
            });
        }

    }
}

$("#tipo_estado_ch").on('change', function () {
    var change = $("#tipo_estado_ch").val();
    switch (change) {
        case 'BAJA':
            document.getElementById("baja_hide").style.display = "inline-block";
            $("baja_hide").show();
            $("#tipo_dato").val('BAJA');

            break;
        default:
            document.getElementById("baja_hide").style.display = "none";
            $("baja_hide").hide();
            $("#tipo_dato").val('CARRUSEL');
            break;
    }
});
$("#fecha_desactivacion_ch").on('change', function () {
    var fecha_desactivacion_ch = $('#fecha_desactivacion_ch').val();
    var fecha_activacion_ch = $('#fecha_activacion_ch').val();

    var date_1 = new Date(fecha_desactivacion_ch);
    var date_2 = new Date(fecha_activacion_ch);

    var hoy = date_2;
    var dia = hoy.getDate();
    var mes = hoy.getMonth() + 1;
    var anio = hoy.getFullYear();
    var fecha_ac = String(anio + "-" + mes + "-" + dia);

    var hoy2 = date_1;
    var dia2 = hoy2.getDate();
    var mes2 = hoy2.getMonth() + 1;
    var anio2 = hoy2.getFullYear();

    var fecha_desac = String(anio2 + "-" + mes2 + "-" + dia2);

    if (validate_fechaMayorQue(fecha_ac, fecha_desac) != 0) {
        var day_as_milliseconds = 86400000;
        var diff_in_millisenconds = date_1 - date_2;
        var dias = diff_in_millisenconds / day_as_milliseconds;
        if (fecha_desactivacion_ch != '' && fecha_desactivacion_ch != null) {
            $("#dias_ch").val(parseInt(dias + 1) + ' ' + 'días');
        }else{
            $("#dias_ch").val(0 + ' ' + 'días');
        }
        if (dias > 270) {
            $("#tipo_baja_ch").val('BAJA_MENOR').change();
        }
        else {
            $("#tipo_baja_ch").val('CHARGEBACK').change();

        }
    } else {
        $("#dias_ch").val(0);

    }
});

function validate_fechaMayorQue(fechaInicial, fechaFinal) {
    valuesStart = fechaInicial.split("-");
    valuesEnd = fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart = new Date(valuesStart[0], (valuesStart[1] - 1), valuesStart[2]);
    var dateEnd = new Date(valuesEnd[0], (valuesEnd[1] - 1), valuesEnd[2]);
    if (dateStart > dateEnd) {
        return 0;
    }
    return 1;
}

function chargeback(solicitud, identificacion, nombres_cliente, forma_pago, entrega_ciudad, region, fecha_activacion, fecha_facturacion, tlineas, uestado, empleado, celular, tb, plan, tipo_linea) {
    document.getElementById("baja_hide").style.display = "none";
    $("#tipo_estado_ch").val('CARRUSEL').change();

    $("#chargeback").show();
    $("#dsolicitud").hide();
    $("#dlinea").hide();
    $("#dcliente").hide();
    $("#tipo_dato").val('CARRUSEL');

    $("#n_solicitud_ch").val(solicitud);
    $("#identificacion_ch").val(identificacion);
    $("#cliente_ch").val(nombres_cliente);
    $("#forma_pago_ch").val(forma_pago);
    $("#ciudad_entrega_ch").val(entrega_ciudad);
    $("#region_ch").val(region);
    if (fecha_activacion != '' && fecha_activacion != null) {
        var date_1 = new Date(fecha_activacion);

        var hoy = date_1;
        var dia = hoy.getDate();
        var mes = hoy.getMonth() + 1;
        var anio = hoy.getFullYear();
        var fecha_ac = String(anio + "-" + mes + "-" + dia);
    } else {
        fecha_ac = '';
    }
    if (fecha_facturacion != '' && fecha_facturacion != null) {
        var date_2 = new Date(fecha_facturacion);

        var hoy2 = date_2;
        var dia2 = hoy2.getDate();
        var mes2 = hoy2.getMonth() + 1;
        var anio2 = hoy2.getFullYear();
        var fecha_fac = String(anio2 + "-" + mes2 + "-" + dia2);
    } else {
        fecha_fac = '';
    }

    $("#fecha_activacion_ch").val(fecha_ac);
    $("#fecha_facturacion_ch").val(fecha_fac);
    $("#n_lineas_ch").val(tlineas);
    $("#asesor_ch").val(empleado);
    $("#celular_ch").val(celular);
    $("#tb_ch").val(tb);
    $("#plan_ch").val(plan);
    $("#tipo_linea_ch").val(tipo_linea);
    $("#spanText").attr("style", "width:95%");
}

function guardar_chargeback() {
    var solicitud = $("#n_solicitud_ch").val();
    var cliente_id = $("#identificacion_ch").val();
    var celular = $("#celular_ch").val();
    var tipo_estado = $("#tipo_estado_ch").val();
    var motivo_ch = $("#motivo_ch").val();
    var tipo = $("#tipo_dato").val();
    var dias_ch = $("#dias_ch").val();
    var tipo_baja_ch = $("#tipo_baja_ch").val();
    var fecha_desactivacion_ch = $("#fecha_desactivacion_ch").val();

    var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
            fecha_desactivacion_ch: fecha_desactivacion_ch,
            tipo_baja_ch: tipo_baja_ch,
            dias_ch: dias_ch,
            tipo: tipo,
            motivo_ch: motivo_ch,
            tipo_estado: tipo_estado,
            solicitud: solicitud,
            cliente_id: cliente_id,
            celular: celular

        },
        'post'
        )
    ;
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            $("#Modalagregar").hide();
            $("#dsolicitud").hide();
            $("#dlinea").hide();
            $("#dcliente").hide();
            $("#chargeback").hide();

            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function guardar_linea() {
    var cliente_id = $("#cliente_id").val();
    var id_celular = $("#id_celular").val();
    var tipo = $("#tipo_dato").val();
    var s_axis = $('input[name="addaxis"]').val();
    var tipo_solicitud = $('select[name="addtipo_solicitud"]').val();
    var celular = $('input[name="addcelular"]').val();
    var operadora = $('select[name="addoperadora"]').val();
    var tipo_linea = $('select[name="addtipo_linea"]').val();
    var equipo = $('input[name="addequipoid"]').val();
    var marca = $('input[name="addmarca"]').val();
    var modelo = $('input[name="addmodelo"]').val();
    var imei = $('[name="addsimei"]').val();
    var cuota = $('input[name="addcuota"]').val();
    var plan = $('input[name="addplan"]').val();
    var simcard = $('input[name="addsimcard"]').val();
    var cobsequio1 = $('input[name="addcobsequio1"]').val();
    var cobsequio2 = $('input[name="addcobsequio2"]').val();
    var tarifa_basica = $('input[name="addtb"]').val();
    var obsequio1 = $('select[name*="obsequio1"]').val();
    var obsequio2 = $('select[name*="obsequio2"]').val();
    var bp_id = $('[name*="addbp"]').val();
    var axisestado = $('[name*="axisestado"]').val();
    var n_cuenta_donante = $('input[name="addctarl"]').val();
    var cedula_donante = $('input[name="addceduladonante"]').val();
    var nombre_donante = $('input[name="addnombredonante"]').val();
    var direccion_donante = $('input[name="adddirecciondonante"]').val();
    var celular_donante = $('input[name="addcelulardonante"]').val();
    var cedula_RL = $('input[name="addcirl"]').val();
    var nombre_RL = $('input[name="addnombrerl"]').val();
    var cargo_RL = $('input[name="addcargorl"]').val();
    var solicitud_id = $('input[name*="n_solicitud"]').val();
    var estadolinea = $('[name*="estadolinea"]').val();

    var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
            cliente_id: cliente_id,
            id_celular: id_celular,
            s_axis: s_axis,
            tipo_solicitud: tipo_solicitud,
            celular: celular,
            operadora: operadora,
            tipo_linea: tipo_linea,
            equipo: equipo,
            marca: marca,
            modelo: modelo,
            imei: imei,
            cuota: cuota,
            plan: plan,
            simcard: simcard,
            cobsequio1: cobsequio1,
            cobsequio2: cobsequio2,
            tarifa_basica: tarifa_basica,
            obsequio1: obsequio1,
            obsequio2: obsequio2,
            bp_id: bp_id,
            axisestado: axisestado,
            n_cuenta_donante: n_cuenta_donante,
            cedula_donante: cedula_donante,
            nombre_donante: nombre_donante,
            direccion_donante: direccion_donante,
            celular_donante: celular_donante,
            cedula_RL: cedula_RL,
            nombre_RL: nombre_RL,
            cargo_RL: cargo_RL,
            solicitud_id: solicitud_id,
            tipo: tipo,
            estadolinea: estadolinea
        },
        'post'
        )
    ;
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            $("#Modalagregar").hide();
            $("#dsolicitud").hide();
            $("#dlinea").hide();
            $("#dcliente").hide();
            $("#chargeback").hide();

            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });

}

function verificaNumero() {
    var celular = $('[name*="addcelular"]').val();
    var solicitud = $('input[name*="n_solicitud"]').val();
    if (celular != 0) {
        var objApiRest = new AJAXRest('/asesor/verificaNumero', {
            celular: celular,
            solicitud: solicitud,
            admin: 1
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            if (_resultContent.status == 200) {
                alertToast(_resultContent.message, 2500);
                $("#Modalagregar").hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
            else {
                alertToastSuccess("Número Nuevo", 2500);

            }
        });
    }


}

function obtenerdatosvalores(dato) {
    var dato1 = dato;
    var objApiRest1 = new AJAXRest('/asesor/ConfiguracionPlan2', {dato1: dato1}, 'post');
    objApiRest1.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $.each(_resultContent.message, function (_key, _value) {
                $('Input[name="addtb"]').val(_value.descripcion);

            });

        } else {
            $('Input[name="addtb"]').val(0);

            alertToast(_resultContent.message, 3500);

        }
    });


}

function obtienedatoselect() {
    $('Input[name="addplan"]').val('');
    $('Input[name="addtb"]').val('');
    var dato = $('select[name="addbp"]').val();
    var objApiRest = new AJAXRest('/asesor/ConfiguracionPlan', {dato: dato}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $.each(_resultContent.message, function (_key, _value) {
                $('Input[name="addplan"]').val(_value.descripcion);
                $('Input[name="addplanh"]').val(_value.id);
                obtenerdatosvalores(_value.id);
            });


        } else {
            $('Input[name="addplan"]').val(0);
            $('Input[name="addplanh"]').val(0);
            $('Input[name="addtb"]').val(0);
            $('select[name="addbp"]').val(0);
            $('select[name*="cuota"]').val(0);
            alertToast(_resultContent.message, 3500);

        }
    });
}

function checkequipo() {
    if ($('Input[name="addequipo"]:checked').val() == "on") {
        $('[name*="marca"]').hide();
        $('[name*="modelo"]').hide();
        $('Input[name="addmarca"]').val('');
        $('Input[name="addmodelo"]').val('');
        $('Input[name="addequipoid"]').val(1);
        $('[name*="imei"]').hide();
        $('[name*="imei"]').val('');

    } else {
        $('Input[name="addequipoid"]').val(0);

        $('[name*="marca"]').show();
        $('[name*="modelo"]').show();
        $('[name*="imei"]').show();


    }

}

function editchangeSolicitud(solicitud, entrega_ciudad_id, direccion_entrega,
                             provincia_id, region, fecha_lote, lote, ciclo_facturacion,
                             fecha_activacion, fecha_facturacion, celular_entrega, estado, gestor_id, created_at, observacion, tchip
    , tobsequios, tlineas, uestado, empleado_id, tipo) {

    $("#motivo").val('');
    $("#uestado").text(uestado);
    $("#dsolicitud").show();
    $("#dlinea").hide();
    $("#dcliente").hide();
    $("#chargeback").hide();

    $("#entrega_ciudad_id").val(entrega_ciudad_id).change();
    $("#dciudadi").val(entrega_ciudad_id);
    $("#solicitud").val(solicitud);
    $("#direccion_entrega").val(direccion_entrega);
    $("#provincia_id").val(provincia_id).change();
    $("#region").val(region).change();
    $("#fecha_lote").val(fecha_lote);
    $("#lote").val(lote);
    $("#ciclo_facturacion").val(ciclo_facturacion).change();
    $("#fecha_activacion").val(fecha_activacion);
    $("#fecha_facturacion").val(fecha_facturacion);
    $("#celular_entrega").val(celular_entrega);
    $("#estado").val(estado).change();
    $("#gestor_id").val(gestor_id).change();
    if ($("#role").val() != 0) {
        $("#empleado_id").val(empleado_id).change();
        $("#asesor_asignado").hide();
    } else {
        $("#asesor_asignado").show();
        $("#empleado_id").val(null).change();
        $("#empleado_id_d").val(empleado_id).change();

    }

    $("#created_at").val(created_at);
    $("#observacion").val(observacion);
    $("#tchip").val(tchip);
    $("#tobsequios").val(tobsequios);
    $("#tlineas").val(tlineas);
    $("#uestado").val(uestado);
    $("#observacion").val(observacion);

    if ($("#role").val() != 0) {
        $("#tipo_dato").val(tipo);
        $('[name*="_s"]').show();

    } else {
        $('[name*="_s"]').hide();
        $("#tipo_dato").val("solicitud");
    }


    $("#spanText").attr("style", "width:50%");

}

function juridico() {

    $('input[name^="tipo_persona"]').val('JURIDICO');
    $("#natural").hide();
    $("#natural_domicilio").hide();
    $("#juridico").show();
    $("#dato_solicitud").show();
    $("#dato_observacion").show();
    $("#dato_laborales").show();
    $("#domicilio_entrega").show();
    $("#dato_observacion2").show();
}

function natural() {
    $("#natural").show();
    $("#natural_domicilio").show();
    $("#juridico").hide();
    $("#dato_solicitud").show();
    $("#dato_observacion").show();
    $("#dato_laborales").show();
    $("#domicilio_entrega").show();
    $("#dato_observacion2").show();
}

function mostrar() {
    $("#natural").show();
    $("#natural_domicilio").show();
    $("#juridico").show();
    $("#dato_solicitud").show();
    $("#dato_observacion").show();
    $("#dato_laborales").show();
    $("#domicilio_entrega").show();
    $("#dato_observacion2").show();
    $("#forma_pago").show();
    $("#lineas").show();
    $("#btnGuardar").show();
}

function guardar() {

    var dato_natural = [];
    var dato_laborales = [];
    var banco = [];
    var tarjeta = [];
    var dato_juridico = [];
    var identificacion = $('input[name^="identificacion"]').val();
    var tipo_persona = $('input[name^="tipo_persona"]').val();
    var valor_garantia = $('input[name^="valor_garantia"]').val();
    var tipo = $("#tipo_dato").val();

    //-----------------------------------------------------------
    if (document.getElementById("deposito_garantia").checked == true) {
        var deposito_garantia = 1;
    } else {
        var deposito_garantia = 0;
    }

//-natural----------------------------------------------------------
    $('input[name*="natural"]').each(function () {
        dato_natural.push($(this).val());
    });
    $('select[name*="natural"]').each(function () {
        dato_natural.push($(this).val());
    });

//-dato_laborales----------------------------------------------------------
    $('input[name*="laborales"]').each(function () {
        dato_laborales.push($(this).val());
    });
    $('select[name*="laborales"]').each(function () {
        dato_laborales.push($(this).val());
    });

//---dato_juridico--------------------------------------------------------
    $('input[name*="juridico"]').each(function () {
        dato_juridico.push($(this).val());
    });
//---banco--------------------------------------------------------
    $('[name*="banco"]').each(function () {
        banco.push($(this).val());
    });

//---tarjeta--------------------------------------------------------
    $('input[name*="tarjeta"]').each(function () {
        tarjeta.push($(this).val());
    });

    //-Contrafactura----------------------------------------------------------
    var forma_pago = $('select[name^="forma_pago"]').val();


    var da = 0;
    var pago = [];
    var pago1 = [];

    if (tipo_persona != 'JURIDICO') {
        var dato_general = dato_natural;
    } else {
        var dato_general = dato_juridico;
    }
    switch (forma_pago) {
        case 'DEBITO_BANCARIO':
            pago = banco;

            var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                identificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                forma_pago: forma_pago,
                pago: pago,
                deposito_garantia: deposito_garantia,
                tipo: tipo
            }, 'post');

            break;
        case 'TARJETA_CREDITO':
            pago = tarjeta;

            var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                idendatificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                forma_pago: forma_pago,
                pago: pago,
                deposito_garantia: deposito_garantia,
                tipo: tipo
            }, 'post');

            break;
        case 'CONTRAFACTURA':
            pago = banco;
            pago1 = tarjeta;

            if (valor_garantia != 0 && valor_garantia != "" && valor_garantia != null) {
                var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                    identificacion: identificacion,
                    tipo_persona: tipo_persona,
                    dato_general: dato_general,
                    dato_laborales: dato_laborales,
                    forma_pago: forma_pago,
                    pago: pago,
                    pago1: pago1,
                    valor: valor_garantia,
                    deposito_garantia: deposito_garantia,
                    tipo: tipo
                }, 'post');
            } else {
                var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                    identificacion: identificacion,
                    tipo_persona: tipo_persona,
                    dato_general: dato_general,
                    dato_laborales: dato_laborales,
                    forma_pago: forma_pago,
                    pago: pago,
                    pago1: pago1,
                    deposito_garantia: deposito_garantia,
                    tipo: tipo
                }, 'post');
            }

            break;
        default:
            var objApiRest = new AJAXRest('/adminSolicitudes/updateChange', {
                identificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                deposito_garantia: deposito_garantia,
                tipo: tipo
            }, 'post');
            break;
    }
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 4500);
            $("#Modalagregar").hide();
            $("#dsolicitud").hide();
            $("#dlinea").hide();
            $("#dcliente").hide();
            $("#chargeback").hide();

            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable();
        } else {
            alertToast(_resultContent.message, 4500);
        }
    });

}

function editchangeCliente(identificacion,
                           tipo_persona,
                           nombres,
                           correo,
                           cedula_RL,
                           nombre_RL,
                           fecha_vence_emp,
                           cargo_RL,
                           direccion_domicilio,
                           referencia_domicilio,
                           convencional,
                           convencional_perteneciente,
                           movil,
                           ciudad_domicilio_id,
                           provincia_domicilio_id,
                           fecha_nacimiento,
                           created_at,
                           estado,
                           estado_civil,
                           empresa,
                           direccion_laboral,
                           ciudad_laboral_id,
                           provincia_laboral_id,
                           convencional_laboral,
                           cargo,
                           tiempo_laboral,
                           ingresos_laboral,
                           forma_pago,
                           banco_id,
                           cta_ahorro,
                           cta_corriente,
                           nombre_tarjeta,
                           numero_tarjeta,
                           codigo_seguridad_tarjeta,
                           vencimiento_tarjeta,
                           cupo,
                           deuda,
                           valor_garantia,
                           deposito_garantia, tipo) {

    $("#spanText").attr("style", "width:80%");

    $("#tipo_dato").val(tipo);
    $("#dsolicitud").hide();
    $("#dlinea").hide();
    $("#dcliente").show();
    $("#chargeback").hide();

    $('input[name^="identificacion"]').val(identificacion);
    $('input[name^="tipo_persona"]').val(tipo_persona);
    switch (tipo_persona) {
        case 'JURIDICO':
            mostrar();
            juridico();
            break;
        default:
            mostrar();
            natural();
            break;
    }

    $('input[name^="name_natural"]').val(nombres);
    $('input[name^="email_natural"]').val(correo);
    $('input[name^="fecha_nacimiento_natural"]').val(fecha_nacimiento);
    $('select[name^="civil_natural"]').val(estado_civil).change();
    $('input[name^="razon_juridico"]').val(nombres);
    $('input[name^="cedula_rl_juridico"]').val(cedula_RL);
    $('input[name^="fecha_vencimiento_juridico"]').val(fecha_vence_emp);
    $('input[name^="email_juridico"]').val(correo);
    $('input[name^="nombre_rl_juridico"]').val(nombre_RL);
    $('input[name^="cargo_rl_juridico"]').val(cargo_RL);
    $('input[name^="domicilio_natural"]').val(direccion_domicilio);
    $('input[name^="referencia_natural"]').val(referencia_domicilio);
    $('input[name^="convencional_natural"]').val(convencional);
    $('select[name^="cperteneciente_natural"]').val(convencional_perteneciente).change();
    $('input[name^="celular_natural"]').val(movil);
    $("#dprovincia").val(provincia_domicilio_id).change();
    $('#dciudadi').val(ciudad_domicilio_id).change();
    $('input[name^="razon_laborales"]').val(empresa);
    $('input[name^="direccion_laborales"]').val(direccion_laboral);
    $('select[name^="lprovincia_laborales"]').val(provincia_laboral_id).change();
    $('#dlaboralesi').val(ciudad_laboral_id).change();
    $('input[name^="convencional_laborales"]').val(convencional_laboral);
    $('input[name^="cargo_laborales"]').val(cargo);
    $('input[name^="tiempo_laborales"]').val(tiempo_laboral);
    $('input[name^="ingresos_laborales"]').val(ingresos_laboral);
    $('select[name^="forma_pago"]').val(forma_pago).change();

    if (valor_garantia != null && valor_garantia != '') {
        $("#contrafactura").show();
    }

    if (deposito_garantia != null && deposito_garantia != '' & deposito_garantia != 0) {
        $('Input[name="depositocheck"]').val(1);
    } else {
        $('Input[name="depositocheck"]').val(0);
    }
    if (deposito_garantia == 1) {
        document.getElementById("deposito_garantia").checked = true;
    } else {
        document.getElementById("deposito_garantia").checked = false;
    }
    $('input[name^="valor_garantia"]').val(valor_garantia);
    $('select[name^="banco"]').val(banco_id).change();
    if (cta_ahorro != null && cta_ahorro != '') {
        $('select[name^="tipo_cuenta_banco"]').val("AHORRO").change();
        $('input[name^="n_cuenta_banco"]').val(cta_ahorro);
    }
    if (cta_corriente != null && cta_corriente != '') {
        $('select[name^="tipo_cuenta_banco"]').val("CORRIENTE").change();
        $('input[name^="n_cuenta_banco"]').val(cta_corriente);
    }
    $('input[name^="tarjeta"]').val(nombre_tarjeta);
    $('input[name^="n_tarjeta"]').val(numero_tarjeta);
    $('input[name^="codigo_tarjeta"]').val(codigo_seguridad_tarjeta);
    $('input[name^="fecha_caducidad_tarjeta"]').val(vencimiento_tarjeta);


}

function configuracionBP(dato, parametro) {
    var objApiRest = new AJAXRest('/asesor/ConfiguracionBP', {parametro: parametro}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            var a = $('input[name*="addbphi"]').val();
            $('select[name="add' + dato + '"]').append("<option value='0'>* " + parametro + " *</option>");
            $.each(_resultContent.message, function (_key, _value) {
                $('select[name="add' + dato + '"]').append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
            });
            if (a != 0) {
                $('select[name="add' + dato + '"]').val(a).change();
            }

        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function tipo_solicitud()
{
    if ($('select[name^="addtipo_solicitud"]').val() == 'Transferencia_Beneficiario') {
        $('input[name="addiddonante"]').val('1');
        $('Div[name="ddiaddddonante"]').show();
        $('Div[name="ddiadddrl"]').show();

    }
    else {
        $('input[name="addiddonante"]').val('0');
        $('Div[name="ddiaddddonante"]').hide();
        $('Div[name="ddiadddrl"]').hide();
        if ($('select[name^="addtipo_solicitud"]').val() == 'Linea_Nueva') {
            $('input[name="addcelular"]').val('');
        }
    }
}
function obtienedatos() {
    if ($('select[name^="addtipo_solicitud"]').val() == 'Transferencia_Beneficiario') {
        $('input[name="addiddonante"]').val('1');
        $('Div[name="ddiaddddonante"]').show();
        $('Div[name="ddiadddrl"]').show();

    }
    else {
        $('input[name="addiddonante"]').val('0');
        $('Div[name="ddiaddddonante"]').hide();
        $('Div[name="ddiadddrl"]').hide();
        if ($('select[name^="addtipo_solicitud"]').val() == 'Linea_Nueva') {
            $('input[name="addcelular"]').val('');
        }
    }

    var tipo_solicitud = [];
    switch ($('select[name^="forma_pago"]').val()) {
        case "DEBITO_BANCARIO":

            $("#contrafactura").hide();
            $("#tarjeta").hide();
            $("#debito").show();
            break;
        case "TARJETA_CREDITO":
            $("#contrafactura").hide();
            $("#tarjeta").show();
            $("#debito").hide();
            break;
        case "CONTRAFACTURA":
            $("#tarjeta").show();
            $("#debito").show();

            break;
        default:
            $("#contrafactura").hide();
            $("#tarjeta").hide();
            $("#debito").hide();
            break;
    }
}

function editChangeLinea(id,
                         celular,
                         solicitud_id,
                         s_axis,
                         axisestado,
                         operadora,
                         tipo_linea,
                         bp_id,
                         equipo,
                         marca,
                         modelo,
                         cobsequio1,
                         obsequio1,
                         cobsequio2,
                         obsequio2,
                         imei,
                         simcard,
                         cuota,
                         estado,
                         cliente_id,
                         plan,
                         tarifa_basica,
                         tipo_solicitud,
                         n_cuenta_donante,
                         cedula_donante,
                         nombre_donante,
                         direccion_donante,
                         celular_donante,
                         cedula_RL,
                         nombre_RL,
                         cargo_RL,
                         chargeback, tipo) {
    $("#chargeback").hide();

    $("#dsolicitud").hide();
    $("#dlinea").show();
    $("#dcliente").hide();
    $("#tipo_dato").val(tipo);
    $("#spanText").attr("style", "width:80%");
    $("#id_celular").val(id);
    $("#cliente_id").val(cliente_id);
    $('input[name="addaxis"]').val(s_axis);

    $('select[name="addtipo_solicitud"]').val(tipo_solicitud).change();
    $('input[name="addcelular"]').val(celular);
    $('select[name="addoperadora"]').val(operadora).change();
    $('select[name="addtipo_linea"]').val(tipo_linea).change();
    if (equipo != 0 && equipo != null) {
        $('input[name="addequipoid"]').val(equipo);
    }
    else {
        $('input[name="addequipoid"]').val(0);
    }

    if (equipo != 0 && equipo != null) {
        $('[name*="marca"]').hide();
        $('[name*="modelo"]').hide();
        $('input[name="addequipo"]').prop('checked', true);
    } else {
        $('input[name="addequipo"]').prop('checked', false);
        $('input[name="addmarca"]').val(marca);
        $('input[name="addmodelo"]').val(modelo);
        $('[name*="marca"]').show();
        $('[name*="modelo"]').show();
        $('[name*="imei"]').val(imei);

        $('[name*="imei"]').show();
    }

    if (cuota != 0 && cuota != null) {
        $('input[name="addcuota"]').val(cuota);
    } else {
        $('input[name="addcuota"]').val('');
    }

    if (plan != 0 && plan != null) {
        $('input[name="addplan"]').val(plan);

    } else {
        $('input[name="addplan"]').val('');
    }
    $('input[name="addsimcard"]').val(simcard);
    $('input[name="addcobsequio1"]').val(cobsequio1);
    $('input[name="addcobsequio2"]').val(cobsequio2);

    if (tarifa_basica != 0 && tarifa_basica != null) {
        $('input[name="addtb"]').val(tarifa_basica);

    } else {
        $('input[name="addtb"]').val('');
    }
    if (obsequio1 != 0 && obsequio1 != null) {
        $('select[name*="obsequio1"]').val(obsequio1).change();

    } else {
        $('select[name*="obsequio1"]').val(0).change();
    }

    if (obsequio2 != 0 && obsequio2 != null) {
        $('select[name*="obsequio2"]').val(obsequio2).change();

    } else {
        $('select[name*="obsequio2"]').val(0).change();
    }
    if (bp_id != 0 && bp_id != null) {
        $('[name*="addbp"]').val(bp_id).change();
        $('input[name*="addbphi"]').val(bp_id);

    } else {
        $('input[name*="addbphi"]').val(0);
    }
    $('[name*="axisestado"]').val(axisestado).change();
    $('input[name="addctarl"]').val(n_cuenta_donante);
    $('input[name="addceduladonante"]').val(cedula_donante);
    $('input[name="addnombredonante"]').val(nombre_donante);
    $('input[name="adddirecciondonante"]').val(direccion_donante);
    $('input[name="addcelulardonante"]').val(celular_donante);
    $('input[name="addcirl"]').val(cedula_RL);
    $('input[name="addnombrerl"]').val(nombre_RL);
    $('input[name="addcargorl"]').val(cargo_RL);
    $('input[name*="n_solicitud"]').val(solicitud_id);
    $('[name*="estadolinea"]').val(estado).change();
}

function agregarLinea(cliente_id,
                      solicitud_id, tipo) {

    $("#chargeback").hide();

    $('#dlinea').find('select').change(0);
    $("#idlinea")[0].reset();
    $('Div[name="ddiaddddonante"]').hide();
    $('Div[name="ddiadddrl"]').hide();
    $('[name*="marca"]').hide();
    $('[name*="modelo"]').hide();
    $('input[name="addequipo"]').prop('checked', true);

    $('input[name*="n_solicitud"]').val(solicitud_id);
    $("#cliente_id").val(cliente_id);
    $("#dsolicitud").hide();
    $("#dlinea").show();
    $("#dcliente").hide();
    $("#tipo_dato").val(tipo);
    $("#spanText").attr("style", "width:80%");
    $("#id_celular").val(0);
}

function deletechange(id, tipo) {

    var objApiRest = new AJAXRest('/adminSolicitudes/deleteChange', {
            id: id,
            tipo: tipo
        },
        'post'
        )
    ;
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            recargar();
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });

}

function PedirConfirmacion(id, tipo) {
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
                deletechange(id, tipo);
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}

function changeDatatable(criterio, parametro, fechai, fechaf) {
    parametro = parametro != '' && parametro != null ? parametro : '0';
    fechai = fechai != '' && fechai != null ? fechai : '0';
    fechaf = fechaf != '' && fechaf != null ? fechaf : '0';
    $('#datatableChange').show();
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lfrtip',
            colReorder: true,

            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": true,
            "ordering": true,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/adminSolicitudes/datatableAdministracion/" + criterio + "/" + parametro + "/" + fechai + "/" + fechaf,
            "columns": [
                {
                    data: 'Solicitud',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Solicitud).text();
                    }
                },
                {
                    data: 'Usuario',
                    "width": "30%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Usuario).text();
                    }
                },
                {
                    data: 'Cliente',
                    "width": "30%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Cliente).text();
                    }
                },
                {
                    data: 'Celular',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Celular).text();
                    }
                },

            ],
        }).ajax.reload();
}

function recargar() {
    $('#dtmenu').dataTable()._fnAjaxUpdate();
}

