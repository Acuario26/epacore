var id = 1;
var sum = 0;
var i = 0;
var edit = 0;
var contadorObsequios = 0;
var countBtn = 0;
$("#bandejaLider").on('change', function () {

    changeDatatable();

});

$(document).ready(function () {
    $(function () {

        changeDatatable();
        
        $("#dtmenu22").hide();
        $("#contenido").hide();
        $("#forma_pago").hide();
        $("#lineas").hide();
        ocultar();
        $("#Modalagregar").hide();
        $("#btnGuardar").hide();
        $("#btnGuardarValida").hide();
        $("#contenidoLider").hide();

    });
});

function ocultarDependiente() {
    $("#debito").hide();
    $("#tarjeta").hide();
    $("#contrafactura").hide();
}

function ocultar() {
    $("#asesorh").hide();

    ocultarDependiente();
    $("#natural").hide();
    $("#natural_domicilio").hide();
    $("#juridico").hide();
    $("#dato_solicitud").hide();
    $("#dato_observacion").hide();
    $("#dato_laborales").hide();
    $("#domicilio_entrega").hide();
    $("#dato_observacion2").hide();
    $("#forma_pago").hide();
    $("#lineas").hide();
    $("#btnGuardar").hide();
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

$('input[name^="identificacion"]').on('keydown', function (e) {
    if ((e.which === 9) || (e.which === 13)) {
        var dato = $('input[name^="identificacion"]').val();
        busquedaDatos(dato, 0, 0);
    }
});
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
                alertToast("Error de conexion", 3500);
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
                alertToast("Error de conexion", 3500);
            }
        });

    }
});
$("#provincia_entrega").on('change', function () {

    $("#dato_entrega_ciudad").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/asesor/provinciaCiudad', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            var a = $("#dentregai").val();
            if (_resultContent.status == 200) {
                $("#dato_entrega_ciudad").append("<option value='0' selected='selected'>* CIUDAD *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#dato_entrega_ciudad").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });
                $("#dato_entrega_ciudad").val(a).change();
            } else {
                alertToast("Error de conexion", 3500);
            }
        });

    }
});

function obtienedatoselect(id) {
    $('Input[name="addplan[' + id + ']"]').val('');
    $('Input[name="addtb[' + id + ']"]').val('');
    var dato = $('select[name="addbp[' + id + ']"]').val();
    var objApiRest = new AJAXRest('/asesor/ConfiguracionPlan', {dato: dato}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $.each(_resultContent.message, function (_key, _value) {
                $('Input[name="addplan[' + id + ']"]').val(_value.descripcion);
                $('Input[name="addplanh[' + id + ']"]').val(_value.id);
                obtenerdatosvalores(id, _value.id);
            });


        } else {
            $('Input[name="addplan[' + id + ']"]').val(0);
            $('Input[name="addplanh[' + id + ']"]').val(0);
            $('Input[name="addtb[' + id + ']"]').val(0);
            $('select[name="addbp[' + id + ']"]').val(0);
            $('select[name*="cuota[' + id + ']"]').val(0);
            alertToast(_resultContent.message, 3500);

        }
    });
}
function solonumero(id,tipo) {
    switch(tipo)
    {
        case "addcuota":
     
        var i=$('[name*="addcuota[' + id + ']"]').val();

        res=parseFloat(i);
        if(isNaN(i))
            {
                $('[name*="addcuota[' + id + ']"]').val('');
            }else{
                $('[name*="addcuota[' + id + ']"]').val(i);
            }

        break;
        case "addcelulardonante":
        var i=$('[name*="addcelulardonante[' + id + ']"]').val();
        i=parseInt(i);
            if(isNaN(i))
            {
                $('[name*="addcelulardonante[' + id + ']"]').val('');
            }else{
                $('[name*="addcelulardonante[' + id + ']"]').val('0'+i);
            }
        break;
        case "celular":
        var i=$("#"+id).val();
        i=parseInt(i);
            if(isNaN(i))
            {
                $("#"+id).val('');
            }else{
                    $("#"+id).val("0"+i);
            }
            break;
        default:
            var i=$("#"+id).val();
            i=parseInt(i);
                if(isNaN(i))
                {
                    $("#"+id).val('');
                }else{
                    $("#"+id).val(i);
        
                }
            break;
    }
   
 
}


function verificatipoSolicitud(id) {
    var i=$('[name*="addcelular[' + id + ']"]').val();
    i=parseInt(i);
        if(isNaN(i))
        {
            $('[name*="addcelular[' + id + ']"]').val('');
        }else{
            $('[name*="addcelular[' + id + ']"]').val('0'+i);
            if ($('select[name^="addtipo_solicitud[' + id + ']"]').val() == 'Linea_Nueva') {
                $('input[name="addcelular[' + id + ']"]').val('');
            }
        }
}

function obtienedatos(id) {
    if ($('select[name^="addtipo_solicitud[' + id + ']"]').val() == 'Transferencia_Beneficiario') {
        $('input[name="addiddonante[' + id + ']"]').val('1');
        $('Div[name="ddiaddddonante[' + id + ']"]').show();
        $('Div[name="ddiadddrl[' + id + ']"]').show();
        $('input[name="addcelular[' + id + ']"]').attr('disabled', false);

    }
    else {
        $('input[name="addiddonante[' + id + ']"]').val('0');
        $('Div[name="ddiaddddonante[' + id + ']"]').hide();
        $('Div[name="ddiadddrl[' + id + ']"]').hide();
        if ($('select[name^="addtipo_solicitud[' + id + ']"]').val() == 'Linea_Nueva') {
            $('input[name="addcelular[' + id + ']"]').attr('disabled', true);
            $('input[name="addcelular[' + id + ']"]').val('');
        } else {
            $('input[name="addcelular[' + id + ']"]').attr('disabled', false);

        }


    }
    var tipo_solicitud = [];
    $('select[name^="addtipo_solicitud"]').each(function () {
        tipo_solicitud.push($(this).val());
    });
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
            if (tipo_solicitud.includes('Migracion') == true) {
                $("#contrafactura").show();
                $('Input[name="depositocheck"]').val(1);
            }
            else {
                $('Input[name="depositocheck"]').val(0);
                $('input[name^="valor_garantia"]').val(0);
                $("#contrafactura").hide();
            }
            break;
        default:
            $("#contrafactura").hide();
            $("#tarjeta").hide();
            $("#debito").hide();
            break;
    }
}

function configuracionBP(i, dato, parametro) {
    var objApiRest = new AJAXRest('/asesor/ConfiguracionBP', {parametro: parametro}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            var a = $('input[name*="addbphi[' + i + ']"]').val();
            $('select[name="add' + dato + '[' + i + ']"]').append("<option value='0'>* " + parametro + " *</option>");
            $.each(_resultContent.message, function (_key, _value) {
                $('select[name="add' + dato + '[' + i + ']"]').append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
            });
            if (a != 0) {
                $('select[name="add' + dato + '[' + i + ']"]').val(a).change();
            }

        } else {
            alertToast("Error de conexion", 3500);
        }
    });
}

function cantidadLineas() {
    var idm = $('Input[name="tlineas"]').val();
    idm++;
    $('Input[name="tlineas"]').val(idm);
}

function cantidadOb() {
    var c = 0;
    var f = 0;
    $('select[name^="addobsequio1"]').each(function () {
        if ($(this).val() != 0) {
            c++;
        }

    });
    $('select[name^="addobsequio2"]').each(function () {
        if ($(this).val() != 0) {
            f++;
        }

    });

    sum = f + c;
    $('Input[name="tobsequios"]').val(parseInt(sum));

}

function obtenerdatosvalores(id, dato) {
    var dato1 = dato;
    var objApiRest1 = new AJAXRest('/asesor/ConfiguracionPlan2', {dato1: dato1}, 'post');
    objApiRest1.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $.each(_resultContent.message, function (_key, _value) {
                $('Input[name="addtb[' + id + ']"]').val(_value.descripcion);

            });

        } else {
            $('Input[name="addtb[' + id + ']"]').val(0);

            alertToast("Error de conexion", 3500);

        }
    });


}

function datos_cliente(_value) {
    $('input[name="control"]').val(1);

    $('input[name^="name_natural"]').val(_value.nombres);
    $('input[name^="email_natural"]').val(_value.correo);
    $('input[name^="fecha_nacimiento_natural"]').val(_value.fecha_nacimiento);
    $('select[name^="civil_natural"]').val(_value.estado_civil).change();
    $('input[name^="razon_juridico"]').val(_value.nombres);
    $('input[name^="cedula_rl_juridico"]').val(_value.cedula_RL);
    $('input[name^="fecha_vencimiento_juridico"]').val(_value.fecha_vence_emp);
    $('input[name^="email_juridico"]').val(_value.correo);
    $('input[name^="nombre_rl_juridico"]').val(_value.nombre_RL);
    $('input[name^="cargo_rl_juridico"]').val(_value.cargo_RL);
    $('input[name^="domicilio_natural"]').val(_value.direccion_domicilio);
    $('input[name^="referencia_natural"]').val(_value.referencia_domicilio);
    $('input[name^="convencional_natural"]').val(_value.convencional);
    $('select[name^="cperteneciente_natural"]').val(_value.convencional_perteneciente).change();
    $('input[name^="celular_natural"]').val(_value.movil);
    $("#dprovincia").val(_value.provincia_domicilio_id).change();
    $('#dciudadi').val(_value.ciudad_domicilio_id).change();
    $('input[name^="razon_laborales"]').val(_value.empresa);
    $('input[name^="direccion_laborales"]').val(_value.direccion_laboral);
    $('select[name^="lprovincia_laborales"]').val(_value.provincia_laboral_id).change();
    $('#dlaboralesi').val(_value.ciudad_laboral_id).change();
    $('input[name^="convencional_laborales"]').val(_value.convencional_laboral);
    $('input[name^="cargo_laborales"]').val(_value.cargo);
    $('input[name^="tiempo_laborales"]').val(_value.tiempo_laboral);
    $('input[name^="ingresos_laborales"]').val(_value.ingresos_laboral);
    $('select[name^="forma_pago"]').val(_value.forma_pago).change();
    $('input[name^="valor_garantia"]').val(_value.valor_garantia);
    $('select[name^="banco"]').val(_value.banco_id).change();
    if (_value.cta_ahorro != null && _value.cta_ahorro != '') {
        $('select[name^="tipo_cuenta_banco"]').val("AHORRO").change();
        $('input[name^="n_cuenta_banco"]').val(_value.cta_ahorro);
    }
    if (_value.cta_corriente != null && _value.cta_corriente != '') {
        $('select[name^="tipo_cuenta_banco"]').val("CORRIENTE").change();
        $('input[name^="n_cuenta_banco"]').val(_value.cta_corriente);
    }
    $('input[name^="tarjeta"]').val(_value.nombre_tarjeta);
    $('input[name^="n_tarjeta"]').val(_value.numero_tarjeta);
    $('input[name^="codigo_tarjeta"]').val(_value.codigo_seguridad_tarjeta);
    $('input[name^="fecha_caducidad_tarjeta"]').val(_value.vencimiento_tarjeta);
}

function datos_solicitud(_value) {
    $('input[name="control_solicitud"]').val(1);
    $('input[name="n_solicitud"]').val(_value.n_solicitud);
    $('input[name="direccion_entrega"]').val(_value.direccion_entrega);
    $('select[name="provincia_entrega"]').val(_value.provincia_id).change();
    $('select[name="region_entrega"]').val(_value.region).change();
    $('input[name="celular_entrega"]').val(_value.celular_entrega);
    $('select[name="gestor"]').val(_value.gestor_id).change();
    $("#usuario").val(_value.name);

    $('textarea[name="observacion"]').val(_value.observacion);
    $('input[name="tchip"]').val(_value.tchip);
    $('input[name="tobsequios"]').val(contadorObsequios);
    $('input[name="tlineas"]').val(id);
    $('#dentregai').val(_value.entrega_ciudad_id).change();

    //datos de solicitud - con estado

    $('[name="solicitud_axis_s"]').val(_value.n_solicitud_axis);
    $('[name="fecha_activa_s"]').val(_value.fecha_activacion);
    $('[name="ciclo_factura_s"]').val(_value.ciclo_facturacion);
    $('[name="fecha_factura_s"]').val(_value.fecha_facturacion);
    $("#lote_s").val(_value.lote);
    $('[name="fecha_lote_s"]').val(_value.fecha_lote);

}

function datos_lineas(_value, c) {

    if (_value.obsequio1 != 0) {
        contadorObsequios++;
    }
    if (_value.obsequio2 != 0) {
        contadorObsequios++;
    }

    $('input[name="control_lineas"]').val(1);

    $('select[name="addtipo_solicitud[' + c + ']"]').val(_value.tipo_solicitud).change();

    $('input[name="addcelular[' + c + ']"]').val(_value.celular);

    $('select[name="addoperadora[' + c + ']"]').val(_value.operadora).change();
    $('select[name="addtipo_linea[' + c + ']"]').val(_value.tipo_linea).change();
    if (_value.equipo != 0 && _value.equipo != null) {
        $('input[name="addequipoid[' + c + ']"]').val(_value.equipo);
    }
    else {
        $('input[name="addequipoid[' + c + ']"]').val(0);
    }
    if (_value.equipo != 0 && _value.equipo != null) {
        $('[name*="marca[' + c + ']"]').hide();
        $('[name*="modelo[' + c + ']"]').hide();
        $('input[name="addequipo[' + c + ']"]').prop('checked', true);

    } else {
        $('input[name="addequipo[' + c + ']"]').prop('checked', false);
        $('input[name="addmarca[' + c + ']"]').val(_value.marca);
        $('input[name="addmodelo[' + c + ']"]').val(_value.modelo);
        $('[name*="marca[' + c + ']"]').show();
        $('[name*="modelo[' + c + ']"]').show();

        //  $('[name*="imei[' + c + ']"]').hide();

    }
    //  $('input[name="addsimcard[' + c + ']"]').val(_value.simcard);

    //  $('input[name="addcobsequio1[' + c + ']"]').val(_value.cobsequio1);
    //  $('input[name="addcobsequio2[' + c + ']"]').val(_value.cobsequio2);

    if (_value.cuota != 0 && _value.cuota != null) {
        $('input[name="addcuota[' + c + ']"]').val(_value.cuota);
    } else {
        $('input[name="addcuota[' + c + ']"]').val(0);
    }

    if (_value.plan != 0 && _value.plan != null) {
        $('input[name="addplan[' + c + ']"]').val(_value.plan);

    } else {
        $('input[name="addplan[' + c + ']"]').val(0);
    }

    if (_value.tarifa_basica != 0 && _value.tarifa_basica != null) {
        $('input[name="addtb[' + c + ']"]').val(_value.tarifa_basica);

    } else {
        $('input[name="addtb[' + c + ']"]').val(0);
    }


    if (_value.obsequio1 != 0 && _value.obsequio1 != null) {
        $('select[name*="obsequio1[' + c + ']"]').val(_value.obsequio1).change();

    } else {
        $('select[name*="obsequio1[' + c + ']"]').val(0).change();
    }

    if (_value.obsequio2 != 0 && _value.obsequio2 != null) {
        $('select[name*="obsequio2[' + c + ']"]').val(_value.obsequio2).change();

    } else {
        $('select[name*="obsequio2[' + c + ']"]').val(0).change();
    }
    if (_value.bp_id != 0 && _value.bp_id != null) {
        $('input[name*="addbphi[' + c + ']"]').val(_value.bp_id);

    } else {
        $('input[name*="addbphi[' + c + ']"]').val(0);
    }
    $('input[name="addctarl[' + c + ']"]').val(_value.n_cuenta_donante);
    $('input[name="addceduladonante[' + c + ']"]').val(_value.cedula_donante);
    $('input[name="addnombredonante[' + c + ']"]').val(_value.nombre_donante);
    $('input[name="adddirecciondonante[' + c + ']"]').val(_value.direccion_donante);
    $('input[name="addcelulardonante[' + c + ']"]').val(_value.celular_donante);
    $('input[name="addcirl[' + c + ']"]').val(_value.cedula_RL);
    $('input[name="addnombrerl[' + c + ']"]').val(_value.nombre_RL);
    $('input[name="addcargorl[' + c + ']"]').val(_value.cargo_RL);

}

function busquedaDatos(dato, solicitud_id, controladd) {

    ocultar();
    var objApiRest1 = new AJAXRest('/asesor/SearchCedula', {dato: dato, solicitud_id: solicitud_id}, 'post');
    objApiRest1.extractDataAjax(function (_resultContent) {
        switch (_resultContent.status) {
            case 200:
                limpiar();
                verifica(dato);
                $.each(_resultContent.message, function (_key, _value) {
                    datos_cliente(_value);
                    alertToastSuccess("Cliente Encontrado", 3500);
                });
                break;
            case 300:
                id = 0;
                limpiar();
                var iden = 0;
                var clineas = 0;
                if (_resultContent.cliente != 0) {
                    $.each(_resultContent.cliente, function (_key, _value) {
                        datos_cliente(_value);
                        var iden = $("#identificacion").val(_value.identificacion);
                        verifica(_value.identificacion);
                    });
                }
                if (_resultContent.lineas != 0) {
                    var c = 0;
                    $.each(_resultContent.lineas, function (_key, _value) {
                        Add();
                        c = id - 1;
                        datos_lineas(_value, c);

                    });

                }
                if (_resultContent.solicitud != 0) {
                    $.each(_resultContent.solicitud, function (_key, _value) {
                        datos_solicitud(_value);
                    });
                }

                alertToastSuccess("Registro Encontrado", 3500);
                break;
            case 404:
                alertToastSuccess("Registro de Cliente No Encontrado", 3500);
                limpiar();
                verifica(dato);

                $('input[name="control"]').val(0);
                $('input[name="control_lineas"]').val(0);
                $('input[name="control_solicitud"]').val(0);

                break;
        }

        if (controladd) {
            $('[name*="add"]').attr('disabled', true);
            $("#btnGuardar").hide();
            $('[name*="ddiaddborra"]').hide();
            $("#agregaitem").hide();
            $('#formulario').find('input, textarea, button, select').css('border', '0');
            $('#item').find('input, textarea, button, select').css('border', '0');
            $('[name*="simcard"]').show();
            $('[name*="cobsequio1"]').show();
            $('[name*="cobsequio2"]').show();

        } else {
            $('[name*="add"]').attr('disabled', false);
            $("#btnGuardar").show();
            $('[name*="ddiaddborra"]').show();
            $("#agregaitem").show();
        }
    });
}

function verifica(dato) {

    if (dato.length < 10 && dato.length > 1) {
        showVerifica(9, 0, 0);
    } else {
        var verifica = valida($('input[name^="identificacion"]').val());
        showVerifica(verifica, 0, 0);
    }
}

function SolicitudActiva(id) {
    var objApiRest = new AJAXRest('/asesor/SolicitudActiva', {
        id: id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {

            alertToastSuccess(_resultContent.message, 3500);
            location.reload()
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function refresh() {
    window.location.reload();
}

function SolicitudEliminada(id) {
    var objApiRest = new AJAXRest('/asesor/SolicitudEliminada', {
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

function valida(campo) {
    var numero = campo;
    var suma = 0;
    var residuo = 0;
    var ju = false;
    var pub = false;
    var nat = false;
    var numeroProvincias = 22;
    var modulo = 11;

    d1 = numero.substr(0, 1);
    d2 = numero.substr(1, 1);
    d3 = numero.substr(2, 1);
    d4 = numero.substr(3, 1);
    d5 = numero.substr(4, 1);
    d6 = numero.substr(5, 1);
    d7 = numero.substr(6, 1);
    d8 = numero.substr(7, 1);
    d9 = numero.substr(8, 1);
    d10 = numero.substr(9, 1);

    /* El tercer digito es: */
    /* 9 para sociedades privadas y extranjeros */
    /* 6 para sociedades publicas */
    /* menor que 6 (0,1,2,3,4,5) para personas naturales */

    if (d3 == 7 || d3 == 8) {
        alert('El tercer dígito ingresado es inválido');
    }

    /* Solo para personas naturales (modulo 10) */
    if (d3 < 6) {
        nat = true;
        p1 = d1 * 2;
        if (p1 >= 10) p1 -= 9;
        p2 = d2 * 1;
        if (p2 >= 10) p2 -= 9;
        p3 = d3 * 2;
        if (p3 >= 10) p3 -= 9;
        p4 = d4 * 1;
        if (p4 >= 10) p4 -= 9;
        p5 = d5 * 2;
        if (p5 >= 10) p5 -= 9;
        p6 = d6 * 1;
        if (p6 >= 10) p6 -= 9;
        p7 = d7 * 2;
        if (p7 >= 10) p7 -= 9;
        p8 = d8 * 1;
        if (p8 >= 10) p8 -= 9;
        p9 = d9 * 2;
        if (p9 >= 10) p9 -= 9;
        modulo = 10;
    }

    /* Solo para sociedades publicas (modulo 11) */
    /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
    else if (d3 == 6) {
        pub = true;
        p1 = d1 * 3;
        p2 = d2 * 2;
        p3 = d3 * 7;
        p4 = d4 * 6;
        p5 = d5 * 5;
        p6 = d6 * 4;
        p7 = d7 * 3;
        p8 = d8 * 2;
        p9 = 0;
    }

    /* Solo para entidades privadas (modulo 11) */
    else if (d3 == 9) {
        ju = true;
        p1 = d1 * 4;
        p2 = d2 * 3;
        p3 = d3 * 2;
        p4 = d4 * 7;
        p5 = d5 * 6;
        p6 = d6 * 5;
        p7 = d7 * 4;
        p8 = d8 * 3;
        p9 = d9 * 2;
    }

    suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
    residuo = suma % modulo;

    /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
    digitoVerificador = residuo == 0 ? 0 : modulo - residuo;

    var b = 0;
    /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/

    if (pub == true) {

        if (digitoVerificador != d9) {
            alertToast('El ruc de la empresa del sector público es incorrecto.', 3500);
            b = 1;
        }
        /* El ruc de las empresas del sector publico terminan con 0001*/
        if (numero.substr(9, 4) != '0001') {
            alertToast('El ruc de la empresa del sector público debe terminar con 0001', 3500);
            b = 1;
        }
        if (b == 0) {
            b = 2;
        }
    }
    else if (ju == true) {
        if (digitoVerificador != d10) {
            alertToast('El ruc de la empresa del sector privado o Juridico es incorrecto.', 3500);
            b = 1;
        }
        if (numero.substr(10, 3) != '001') {
            alertToast('El ruc de la empresa del sector privado  o Juridico debe terminar con 001', 3500);
            b = 1;
        }
        if (b == 0) {
            b = 3;
        }
    }

    else if (nat == true) {

        if (digitoVerificador != d10) {
            alertToast('El número de cédula de la persona natural es incorrecto.', 3500);

            b = 1;
        }
        if (numero.length > 10 && numero.substr(10, 3) != '001') {
            alertToast('El ruc de la persona natural debe terminar con 001', 3500);
            b = 1;
        }
        if (b == 0 && numero.length > 10) {
            b = 4;
        } else if (b == 0 && numero.length == 10) {
            b = 5;

        }

    }


    if (b != 0 && b != 1) {
        return b;
    } else {
        $("#natural").hide();
        $("#natural_domicilio").hide();
        $("#juridico").hide();
        $("#dato_solicitud").hide();
        $("#dato_observacion").hide();
        $("#dato_laborales").hide();
    }


}


$('Input[name*="deposito_garantia"]').on('click', function () {
    if (this.checked) {
        $('Input[name="depositocheck"]').val(1);

    } else {
        $('Input[name="depositocheck"]').val(0);
    }

});


function checkequipo(id) {
    if ($('Input[name="addequipo[' + id + ']"]:checked').val() == "on") {
        $('[name*="marca[' + id + ']"]').hide();
        $('[name*="modelo[' + id + ']"]').hide();
        $('Input[name="addmarca[' + id + ']"]').val('');
        $('Input[name="addmodelo[' + id + ']"]').val('');
        $('Input[name="addequipoid[' + id + ']"]').val(1);

    } else {
        $('Input[name="addequipoid[' + id + ']"]').val(0);

        $('[name*="marca[' + id + ']"]').show();
        $('[name*="modelo[' + id + ']"]').show();

    }

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
                    case "activa":
                        SolicitudActiva(id);
                        break;
                    case "delete":
                        SolicitudEliminada(id);
                        break;

                }
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}

function PedirConfirmacionLibera(id, dato, correo) {
    swal({
            title: "Petición de Liberación de Solicitud",
            text: "Escriba el motivo de la solicitud:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Escriba el motivo"
        },
        function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("Necesita escribir motivo");
                return false
            }

            switch (dato) {
                case "libera_Lider":
                    var lider = 1;
                    SolicitudLibera(id, inputValue, lider, correo);
                    break;

                case "libera":
                    var lider = 0;
                    SolicitudLibera(id, inputValue, lider, correo);
                    break;
            }
        });
}

function SolicitudLibera(id, inputValue, lider, correo) {
    var objApiRest = new AJAXRest('/asesor/SolicitudLiberada', {
        id: id, inputValue: inputValue, lider: lider, correo: correo
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            swal("Bien!", "El motivo de tu petición: " + inputValue, "success");
            recargar();
        } else {
            alertToast(_resultContent.message, 3500);
        }

    });


}

function estadoVenta(solicitud){
    var venta=$("#venta_notificada").val();
    var objApiRest=new AJAXRest('/asesor/VentaNotificada',{
        venta:venta,solicitud:solicitud
    },'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,2500);
            recargar();
        } else {
            alertToast(_resultContent.message, 3500);
        }

    });

}

function changeDatatable() {
    var dato=$("#bandejaLider").val();
    $("body").addClass("sidebar-collapse");

    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
var table=$('#dtmenu').DataTable(
        {

            dom: 'lfrtip',

            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
                "columnDefs": [
                    {
                        "targets": [ 5 ],
                        "visible": false,
                        "searchable": true
                    },
                   
                ],
                drawCallback: function() {
                    $('[rel="popover"]').popover({
                        container: 'body',
                        html: true,
                        placement:'left',
                        content: function () {
                            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                            return clone;
                        }
                    }).click(function(e) {
                        e.preventDefault();
                    });


                    $('[data-toggle="popover"]').popover({
                     
                    });
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
            "footerCallback":true,
            "ajax": "/asesor/datatableDepartamento/" + dato,

            "columns": [
                {
                    data: 'Contactos',
                    "width": "15%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Contactos).text();
                    }
                },
                {data: 'Cliente', "width": "25%"},
                {
                    data: 'DetalleEstado',
                    "width": "30%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.DetalleEstado).text();
                    }
                },
                {data: 'Asesor', "width": "10%"},
                {data: 'total_lineas', "width": "10%"},
                {data: 'total_l', "width": "10%"},

            ],
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                   
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
                total
            );
        }



        }).ajax.reload();

}
function changeDatatablemenuLi(tipo,dato,celular) {
    $("body").addClass("sidebar-collapse");

    $('#dtmenuLi').DataTable().destroy();
    $('#tbobymenuLi').html('');

    $('#dtmenuLi').show();
    $.fn.dataTable.ext.errMode = 'throw';
    var table=$('#dtmenuLi').DataTable(
        {

            dom: 'lfrtip',

            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
                drawCallback: function() {
                                $('[rel="popover"]').popover({
                                    container: 'body',
                                    html: true,
                                    placement:'right',
                                    width:'600px',
                                    content: function () {
                                        var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                                        return clone;
                                    }
                                }).on("show.bs.popover", function() {
                                    return $(this).data("bs.popover").tip().css({
                                      maxWidth: "600px",
                                      paddingTop:"15px",
                                      paddingBottom:"15px"
                                    });
                                  }).click(function(e) {
                                    e.preventDefault();
                                });

                    $('[data-toggle="popover"]').popover({
                     
                    });
                },
            "lengthMenu": [[10, -1], [10, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": true,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/adminSolicitudes/datatableLinea/" + tipo +'/'+dato+'/'+celular,

            "columns": [
                {data: 'Tipo_Solicitud', "width": "15%"},
                {data: 'celular', "width": "25%"},
                {data: 'solicitud_id', "width": "10%"},
                {data: 'tipo_linea', "width": "10%"},
                
                {
                    data: 'DetalleBp',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.DetalleBp).text();
                    }
                },
                {
                    data: 'Equipo',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Equipo).text();
                    }
                },
             
                
             
            ]

        }).ajax.reload();

}
function changeDatatable2(id) {
    $('#dtmenu2').DataTable().destroy();
    $('#tbobymenu2').html('');

    $('#dtmenu2').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu2').DataTable(
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
            "ajax": "/asesor/datatableDepartamentoS/" + id,
            "columns": [


                {data: 'Usuario', "width": "20%"},
                {data: 'Observacion', "width": "40%"},
                {data: 'Fecha_e', "width": "10%"},
                {data: 'Tiempo', "width": "10%"},
                {
                    data: 'Estado_Solicitud',
                    "width": "15%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Estado_Solicitud).text();
                    }
                },
                {data: 'departamento', "width": "10%"},
                {
                    data: 'estado',
                    "width": "15%",
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

function limpiar() {
    $('[name*="add"]').remove();
    $('[name^="as"]').remove();
    $('[name*="ddi"]').remove();
    $('input[name*="natural"]').val('');
    $('select[name*="natural"]').val(null).change();
    $('input[name*="laborales"]').val('');
    $('select[name*="laborales"]').val(null).change();
    $('input[name*="juridico"]').val('');
    $('input[name*="entrega"]').val('');
    $('select[name*="entrega"]').val(null).change();
    $('input[name*="banco"]').val('');
    $('select[name*="banco"]').val(null).change();
    $('input[name*="tarjeta"]').val('');
    $('input[name*="tobsequios"]').val(0);
    $('input[name*="tlineas"]').val(0);
    $('input[name*="tchip"]').val(0);
    $('input[name*="valor_garantia"]').val(0);
    $('select[name*="forma_pago"]').val(null).change();
    $("#dciudadi").val(0);
    $("#dlaboralesi").val(0);
    $("#dentregai").val(0);
    $("#dciudad").val(null).change();
    $("#ciudad_laboral").val(null).change();
    $("#dato_entrega_ciudad").val(null).change();
    $('select[name*="gestor"]').val(null).change();
    $('[name*="observacion"]').val('');

}

function borraitem(id) {
    $('Input[name$="[' + id + ']"]').remove();
    $('select[name$="[' + id + ']"]').remove();
    $('Div[name$="[' + id + ']"]').remove();
    var idr = $('Input[name="tlineas"]').val();
    idr--;
    i--;
    $('Input[name="tlineas"]').val(idr);
    cantidadOb();
    obtienedatos()
}

function reset() {
    contadorObsequios = 0;
    $("#contenidoLider").hide();
    $("#dtmenu22").hide();
    $("#contenido").hide();

    $('input[name^="control"]').val('0');
    $('input[name^="control_lineas"]').val('0');
    $('input[name^="control_solicitud"]').val('0');

    $('select[name*="banco"]').val(null).change();
    $("#natural").hide();
    $("#natural_domicilio").hide();
    $("#juridico").hide();
    $("#dato_solicitud").hide();
    $("#dato_observacion").hide();
    $("#dato_laborales").hide();
    $("#domicilio_entrega").hide();
    $("#dato_observacion2").hide();


    $('input[name^="dato_natural"]').val('');

    //-Contrafactura----------------------------------------------------------

    var valor_garantia = $('input[name^="valor_garantia"]').val('');
    //-----------------------------------------------------------
    var observacion = $('input[name^="observacion"]').val('');


//-natural----------------------------------------------------------
    $('input[name^="dato_natural"]').val('');
    $('input[name^="dato_natural"]').val('');
//-dato_laborales----------------------------------------------------------
    $('input[name^="dato_laborales"]').val('');
    $('input[name^="dato_laborales"]').val('');
//--dato_entrega---------------------------------------------------------
    $('input[name^="dato_entrega"]').val('');
    //  $('select[name^="dato_entrega"]').val(null).change();
//---dato_juridico--------------------------------------------------------
    $('input[name^="dato_juridico"]').val('');
//---banco--------------------------------------------------------
    $('input[name^="banco"]').val('');
//---tarjeta--------------------------------------------------------
    $('input[name^="tarjeta"]').val('');
    //---solicitud--------------------------------------------------------
    $('input[name^="solicitud"]').val('');

}

function todoBorrado() {
    $("#contrafactura").hide();
    $("#debito").hide();
    $("#tarjeta").hide();
    $('Input[name^="add"]').remove();
    $('select[name^="add"]').remove();
    $('[name^="as"]').remove();
    $('Div[name^="add"]').remove();
    $('Div[name^="ddi"]').remove();

    $('Input[name="tlineas"]').val(0);
    $('Input[name="tobsequios"]').val(0);
    $('Input[name="tchip"]').val(0);
}

function recargar() {
    $('#dtmenu').dataTable()._fnAjaxUpdate();
    $('#dtmenu2').dataTable()._fnAjaxUpdate();
}

function EditChanges(id) {
    edit = 0;
    limpiar();
    reset();
    todoBorrado();
    $("#dtmenu22").hide();
    $("#contenido").show();
    busquedaDatos(0, id, 0);
    $('#formulario').find('input, textarea, button, select').attr('disabled', false);
    $('#formulario').find('input, textarea, button, select').css('border', '1px solid');
    $('#formulario').find('input, textarea, button, select').css('border-color', '#d2d6de');
    document.getElementById("identificacion").disabled = true;
    document.getElementById("tipo_persona").disabled = true;
    document.getElementById("usuario").disabled = true;
    $("#tobsequios").attr('disabled', true);
    $("#n_solicitud").attr('disabled', true);
    $("#tlineas").attr('disabled', true);
    $("#contenidoLider").hide();
    //Solicitud Axis
    $('[name="solicitud_axis_s"]').attr('disabled', true);
    $('[name="fecha_activa_s"]').attr('disabled', true);
    $('[name="ciclo_factura_s"]').attr('disabled', true);
    $('[name="fecha_factura_s"]').attr('disabled', true);
    $('[name="lote_s"]').attr('disabled', true);
    $('[name="fecha_lote_s"]').attr('disabled', true);
}
function llamadaOb(celular,extension,prefijo)
{
    var receptor=celular;
    var extension = $("#Extension").val(extension);
    var prefijo = $("#Prefijo").val(prefijo);
    var receptor_llamada = $("#receptor").val(receptor);
        $("#btnenviarllamada").click();
}
function
EditChangesPro(
    usuario_ing,
    n_solicitud,
    entrega_ciudad_id,
    direccion_entrega,
    provincia_id,
    region,
    fecha_lote,
    lote,
    ciclo_facturacion,
    fecha_activacion,
    fecha_facturacion,
    celular_entrega,
    estado,
    empleado_id,
    gestor_id,
    cliente_id,
    usuario_mod,
    created_at,
    updated_at,
    observacion,
    tchip,
    tobsequios,
    tlineas,
    n_solicitud_axis,
    name,
    identificacion,
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
    updated_at,
    usuario_ing,
    usuario_mod,
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
    valor_garantia, editar, deposito_garantia, nueva, dato,extension,prefijo) {
        $("#btnGuardarValida").hide();

        if(editar!=0&&extension!=0)
                            {
                                var receptor=celular_entrega;
                                var extension = $("#Extension").val(extension);
                                var prefijo = $("#Prefijo").val(prefijo);
                                var receptor_llamada = $("#receptor").val(receptor);
                                    $("#btnenviarllamada").click();
                           }
    $("#n_solicitud_escape").val(0);

    $("#asesorh").hide();

    limpiar();
    reset();
    todoBorrado();
    if (deposito_garantia == 1) {
        document.getElementById("deposito_garantia").checked = true;
        document.getElementById("depositocheck").value = 1;
    } else {
        document.getElementById("deposito_garantia").checked = false;
        document.getElementById("depositocheck").value = 0;
    }

    var objApiRest1 = new AJAXRest('/asesor/SearchCedula', {dato: 0, solicitud_id: n_solicitud}, 'post');
    objApiRest1.extractDataAjax(function (_resultContent) {
        $("#btnGuardarValida").show();

        switch (_resultContent.status) {
            case 300:
                id = 0;
                var iden = 0;
                var clineas = 0;
                if (_resultContent.lineas != 0) {
                    var c = 0;
                    $.each(_resultContent.lineas, function (_key, _value) {
                        Add();
                        c = id - 1;
                        datos_lineas(_value, c);

                    });

                }
                alertToastSuccess("Registro Encontrado", 3500);
                $('input[name="control"]').val(1);
                $('input[name^="identificacion"]').val(identificacion);
                $('input[name^="tipo_persona"]').val(tipo_persona);
                switch (tipo_persona) {
                    case 'JURIDICO':
                        juridico();

                        break;
                    default:
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

                $('input[name="control_solicitud"]').val(1);
                if (nueva == 1) {
                    creaSolicitud();
                    $("#n_solicitud_escape").val(n_solicitud);
                } else {
                    $('input[name="n_solicitud"]').val(n_solicitud);
                }
                $('input[name="direccion_entrega"]').val(direccion_entrega);
                $('select[name="provincia_entrega"]').val(provincia_id).change();
                $('select[name="region_entrega"]').val(region).change();
                $('input[name="celular_entrega"]').val(celular_entrega);
                $('select[name="gestor"]').val(gestor_id).change();
                $("#usuario").val(name);

                $("#observacion").val(observacion);
                $('input[name="tchip"]').val(tchip);
                $('input[name="tobsequios"]').val(contadorObsequios);
                $('#dentregai').val(entrega_ciudad_id).change();

                //datos de solicitud - con estado

                $('[name="solicitud_axis_s"]').val(n_solicitud_axis);
                $('[name="fecha_activa_s"]').val(fecha_activacion);
                $('[name="ciclo_factura_s"]').val(ciclo_facturacion);
                $('[name="fecha_factura_s"]').val(fecha_facturacion);
                $("#lote_s").val(lote);
                $('[name="fecha_lote_s"]').val(fecha_lote);

                $('#formulario').find('input, textarea, button, select').attr('disabled', false);
                $('#formulario').find('input, textarea, button, select').css('border', '1px solid');
                $('#formulario').find('input, textarea, button, select').css('border-color', '#d2d6de');
                document.getElementById("identificacion").disabled = true;
                document.getElementById("tipo_persona").disabled = true;
                document.getElementById("usuario").disabled = true;
                $("#tobsequios").attr('disabled', true);
                $("#n_solicitud").attr('disabled', true);
                $("#tlineas").attr('disabled', true);
                //Solicitud Axis
                $('[name="solicitud_axis_s"]').attr('disabled', true);
                $('[name="fecha_activa_s"]').attr('disabled', true);
                $('[name="ciclo_factura_s"]').attr('disabled', true);
                $('[name="fecha_factura_s"]').attr('disabled', true);
                $('[name="lote_s"]').attr('disabled', true);
                $('[name="fecha_lote_s"]').attr('disabled', true);

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

                if (editar == 0) {
                    $('[name*="add"]').attr('disabled', true);
                    $("#btnGuardar").hide();
                    $('[name*="ddiaddborra"]').hide();
                    $("#agregaitem").hide();
                    $('#formulario').find('input, textarea, button, select').attr('disabled', true);
                    $('#formulario').find('input, textarea, button, select').css('border', '0');
                    $('#item').find('input, textarea, button, select').css('border', '0');
                    $('[name*="simcard"]').hide();
                    $('[name*="cobsequio1"]').hide();
                    $('[name*="cobsequio2"]').hide();
                    $("#btnGuardarValida").hide();

                } else {
                    $("#btnGuardar").hide();
                    $("#btnGuardarValida").show();

                    $('[name*="add"]').attr('disabled', false);
                    $('[name*="addplan').attr('disabled', true);
                    $('[name*="addtb').attr('disabled', true);
                    $('[name*="ddiaddborra"]').show();
                    $("#agregaitem").show();
                }
                $("#contenido").show();
                break;
            case 404:
                alertToastSuccess("Registro de Cliente No Encontrado", 3500);
                limpiar();
                $('input[name="control"]').val(0);
                $('input[name="control_lineas"]').val(0);
                $('input[name="control_solicitud"]').val(0);
                break;
        }

    });
    var bandeja = 'BANDEJA_VALIDACION';
    var valida = 1;
    if (dato != 0) {
        var objApiRest = new AJAXRest('/lider/CambioEstados', {
            bandeja: bandeja,
            solicitud: n_solicitud,
            valida: valida,
            verifica: 1
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {

            if (_resultContent.status == 200) {
                if (editar == 0) {
                    $("#contenidoLider").show();

                } else {
                    $("#contenidoLider").hide();

                }
            } else {
                $("#contenidoLider").hide();
            }
        });
    }
    else {
        $("#contenidoLider").hide();
    }


}

function viewChanges(id) {
    limpiar();
    reset();
    todoBorrado();
    $("#contenidoLider").hide();
    document.getElementById("identificacion").disabled = true;
    $("#dtmenu22").hide();
    $("#contenido").show();
    $('#formulario').find('input, textarea, button, select').attr('disabled', true);
    busquedaDatos(0, id, 1);

}

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

function SeguimientoChanges(id, dato, identificacion,
                            tipo_persona, nombres,
                            fecha_lote, lote,
                            ciclo_facturacion,
                            fecha_activacion,
                            fecha_facturacion,
                            tchip, tobsequios, tlineas, Asesor, uestado, adendum_sp, castigoc_sp, consumo_sp, financiamiento_sp, tcredito_sp, otros_sp, region, inicio_deuda) {

    var clase = '';
    var u = 1;
    changeDatatable2(id);
    limpiar();
    reset();
    todoBorrado();

    $("#estado_sg").text(uestado);

    if (uestado == 'DEUDA CREDITO') {
        $("#destado_sg").show();
        $("#adendum_sp").text(adendum_sp);
        $("#castigoc_sp").text(castigoc_sp);
        $("#consumo_sp").text(consumo_sp);
        $("#financiamiento_sp").text(financiamiento_sp);
        $("#tcredito_sp").text(tcredito_sp);
        $("#otros_sp").text(otros_sp);
        if(inicio_deuda!=null && inicio_deuda!='')
        {
            $("#inicio_deuda_sp").text(inicio_deuda);
            var fecha_ini = inicio_deuda;
            var date_1 = new Date(fecha_ini);
            var date_2 = new Date();

            var hoy = new Date();
            var dia = hoy.getDate();
            var mes = hoy.getMonth() + 1;
            var anio = hoy.getFullYear();

            var fecha_actual = String(anio + "-" + mes + "-" + dia);

            if (validate_fechaMayorQue(fecha_ini, fecha_actual) != 0) {
                var day_as_milliseconds = 86400000;
                var diff_in_millisenconds = date_2 - date_1;
                var dias = diff_in_millisenconds / day_as_milliseconds;
                $("#tiempo_vencido").text(parseInt(dias)+' '+'días');
            } else {
                $("#tiempo_vencido").text(0);

            }
        }else{
            $("#inicio_deuda_sp").text('--/--/--');
            $("#tiempo_vencido").text(0);

        }

        clase = 'col-lg-12';
        u = 0;
    } else {
        $("#destado_sg").hide();
        $("#adendum_sp").text(0);
        $("#castigoc_sp").text(0);
        $("#consumo_sp").text(0);
        $("#financiamiento_sp").text(0);
        $("#tcredito_sp").text(0);
        $("#otros_sp").text(0);
        $("#inicio_deuda_sp").text('');
    }

    $('[name*=obsequioR]').remove();
    var objApiRest = new AJAXRest('/asesor/CantidadObsequio', {
        solicitud_id: id
    }, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {

        if (_resultContent.status == 200) {
            $("#cantidadObsequios").append("<div name='icantidadobsequioR' class='" + clase + "' ><div name='dcantidadobsequioR' class='col-lg-12'><hr/></div><h5 name='hcantidadobsequioR' style='color: #4985d2;text-decoration: underline'><strong>Obsequios:</strong>");
            $.each(_resultContent.message, function (_key, _value) {
                if (u == 1) {
                    $("#cantidadObsequios").append("<h5 name='encantidadobsequioR'>");
                }
                $("#cantidadObsequios").append("<strong name='kcantidadobsequioR' style='color: #4985d2;margin-left:10px' class='" + clase + "'>" + _key + ":<span  name='vcantidadobsequioR'style='margin-right:10px'>" + _value + "</span></strong>");
                if (u == 1) {
                    $("#cantidadObsequios").append("</h5>");
                }
            });
            $("#cantidadObsequios").append("<div name='lcantidadobsequioR' class='col-lg-12'><hr/></div>");

            $("#cantidadObsequios").append("</h5></div>");

        }
    });
    $("#asesorh").show();
    $("#asesor_sg").text(Asesor);
    $("#n_solicitud_sg").text(id);
    $("#identificacion_sg").text(identificacion);
    $("#cliente_sg").text(nombres);
    $("#ciclo_fact_sg").text(ciclo_facturacion);

    $("#fecha_activa_sg").text(fecha_activacion);
    $("#fecha_lote_sg").text(fecha_lote);
    $("#fecha_fact_sg").text(fecha_facturacion);
    $("#lote_sg").text(lote);
    $("#n_lineas_sg").text(tlineas);
    $("#n_chip_sg").text(tchip);
    $("#region_sg").text(region);

    if (ciclo_facturacion != null && ciclo_facturacion != '') {
        $("#ciclo_fact_sg").text(ciclo_facturacion);

    } else {
        $("#ciclo_fact_sg").text('Aun no definido');

    }


    if (fecha_facturacion != null && fecha_facturacion != '') {
        $("#fecha_fact_sg").text(fecha_facturacion);

    } else {
        $("#fecha_fact_sg").text('Aun no definido');

    }

    if (fecha_lote != null && fecha_lote != '') {
        $("#fecha_lote_sg").text(fecha_lote);

    } else {
        $("#fecha_lote_sg").text('Aun no definido');

    }
    if (lote != null && lote != '') {
        $("#lote_sg").text(lote);

    } else {
        $("#lote_sg").text('Aun no definido');

    }

    if (fecha_activacion != null && fecha_activacion != '') {
        $("#fecha_activa_sg").text(fecha_activacion);

    } else {
        $("#fecha_activa_sg").text('Aun no definido');

    }


    if (tlineas != null && tlineas != '') {
        $("#n_lineas_sg").text(tlineas);

    } else {
        $("#n_lineas_sg").text(0);

    }
    if (tchip != null && tchip != '') {
        $("#n_chip_sg").text(tchip);

    } else {
        $("#n_chip_sg").text(0);

    }

    $("#solicitud_estado_id").val(id);
    $("#dtmenu22").show();
    $("#contenido").hide();
    $("#btnGuardar").hide();
    $("#btnGuardarValida").hide();


}

function start() {
    $("#n_solicitud_escape").val(0);

    $("#asesorh").hide();
    edit = 0;
    $("#contenidoLider").hide();
    document.getElementById("identificacion").disabled = false;
    $('input[name^="identificacion"]').val('');
    $('input[name^="tipo_persona"]').val('Tipo Persona');
    limpiar();
    reset();
    todoBorrado();
    $("#Modalagregar").show();
    $("#btnGuardar").hide();
    $("#dtmenu22").hide();
    $("#contenido").show();
    $("#forma_pago").hide();
    $("#lineas").hide();
    $('#formulario').find('input, textarea, button, select').attr('disabled', false);
    $('#formulario').find('input, textarea, button, select').css('border', '1px solid');
    $('#formulario').find('input, textarea, button, select').css('border-color', '#d2d6de');

    $("#tipo_persona").attr('disabled', true);
    $("#tobsequios").attr('disabled', true);
    $("#n_solicitud").attr('disabled', true);
    $("#tlineas").attr('disabled', true);
    //------------------------------------------------------------------------
    //Solicitud Axis
    $('[name="solicitud_axis_s"]').attr('disabled', true);
    $('[name="fecha_activa_s"]').attr('disabled', true);
    $('[name="ciclo_factura_s"]').attr('disabled', true);
    $('[name="fecha_factura_s"]').attr('disabled', true);
    $('[name="lote_s"]').attr('disabled', true);
    $('[name="fecha_lote_s"]').attr('disabled', true);
    //------------------------------------------------------------------------

    creaSolicitud();
    document.getElementById("usuario").disabled = true;

}

function creaSolicitud() {
    var objApiRest = new AJAXRest('/asesor/NSolicitud', {}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $('input[name^="n_solicitud"]').val(_resultContent.message);
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
}

function showVerifica(verifica, id, control) {
    if (control != 0) {
        reset();
        todoBorrado();
    }
    switch (verifica) {
        case 2:
            mostrar();
            $('input[name^="tipo_persona"]').val('PUBLICO');

            natural();

            break;
        case 3:
            mostrar();
            $('input[name^="tipo_persona"]').val('JURIDICO');
            juridico();

            break;
        case 4:
            mostrar();
            $('input[name^="tipo_persona"]').val('NATURAL');
            natural();

            break;
        case 5:
            mostrar();
            $('input[name^="tipo_persona"]').val('CEDULA');
            natural();
            break;
        case 9:
            mostrar();
            $('input[name^="tipo_persona"]').val('PASAPORTE');
            natural();
            break;
        default:
            $('input[name^="tipo_persona"]').val('Tipo Persona');
            $('input[name^="identificacion"]').val('');
            limpiar();
            ocultar();
            break;
    }

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

function Add() {


    if (id % 2 == 0) {
        var color = '#dde9ff';
    } else {
        var color = '#fff';
    }

    i = i++;
    $("#item").append("<input type='hidden'  name='addinicio_linea[" + id + "]' value='inicio_linea'>" +
        "<div class='panel-body'name='ddicolor[" + id + "]' style='background-color:" + color + "'>" +
        "<div class='col-lg-12' name='ddiaddditem[" + id + "]'>" +
        "<div class='col-lg-2' name='ddicabecera14[" + id + "]'>" +
        "<br/>" +
        "</div>" +
        "<div  style='margin:2px'>" +
        "<div class='col-lg-12' name='ddicabecera[" + id + "]'>" +
        "<div class='col-lg-2' name='ddicabecera1[" + id + "]'>" +
        "<strong>Tipo/Solicitud:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddicabecera2[" + id + "]'>" +
        "<strong>Celular:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddicabecera3[" + id + "]'>" +
        "<strong>Operadora:</strong>" +
        "</div>" +
        "<div class='col-lg-1' name='ddicabecera4[" + id + "]'>" +
        "<strong>Linea:</strong>" +
        "</div>" +
        "<div class='col-lg-1' name='ddicabecerasimcard[" + id + "]'>" +
        "<strong>Simcard:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiespacio[" + id + "]'>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiadddmarca[" + id + "]'>" +
        "<strong>Marca:</strong>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiadddmodelo[" + id + "]'>" +
        "<strong>Modelo:</strong>" +
        "</div>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddtipo_solicitud[" + id + "]'>" +

        "<select class='form-control select2' style='border-radius: 10px' name='addtipo_solicitud[" + id + "]' onchange='obtienedatos(" + id + ")'>" +
        "<option class='form-control select2' value='0'>Seleccione un tipo de solicitud" +
        "</option>" +
        "<option class='form-control select2' value='Linea_Nueva'>Linea Nueva" +
        "</option>" +
        "<option class='form-control select2' value='Migracion'>Migracion" +
        "</option>" +
        "<option class='form-control select2' value='Transferencia_Beneficiario'>Transferencia Beneficiario" +
        "</option>" +
        "<option class='form-control select2' value='Portabilidad'>Portabilidad" +
        "</option>" +
        "</select>" +
        "</div>" +

        "<div class='col-lg-2' name='ddiadddcelular[" + id + "]'>" +
        "<input class='form-control' type='text' name='addcelular[" + id + "]' onkeyup='verificatipoSolicitud(" + id + ")' onblur='verificaNumero(" + id + ")' placeholder='Celular' maxlength='10'>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddoperadora[" + id + "]'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addoperadora[" + id + "]'>" +
        "<option class='form-control select2' value='0'>Operadora" +
        "</option>" +
        "<option class='form-control select2' value='Claro'>Claro" +
        "</option>" +
        "<option class='form-control select2' value='Movistar'>Movistar" +
        "</option>" +
        "<option class='form-control select2' value='Cnt'>Cnt" +
        "</option>" +
        "<option class='form-control select2' value='Twenty'>Twenty" +
        "</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiadddtipo_linea[" + id + "]'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addtipo_linea[" + id + "]'>" +
        "<option class='form-control select2' value='0'>Linea" +
        "</option>" +
        "<option class='form-control select2' value='Prepago'>Prepago" +
        "</option>" +
        "<option class='form-control select2' value='Pospago'>Pospago" +
        "</option>" +
        "<option class='form-control select2' value='Migracion'>Migracion" +
        "</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-2'name='as1[" + id + "]'>" +
        "<label style='padding-left:5px;padding-right:5px;' name='ddiaddlabelequipo[" + id + "]'>Equipo Propio</label> " +
        "<input type='checkbox' name='addequipo[" + id + "]' onclick='checkequipo(" + id + ")' checked>" +
        "<input type='hidden' name='addequipoid[" + id + "]' value='1'>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddsimcard[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addsimcard[" + id + "]' maxlength='18' placeholder='Simcard' 'onKeypress'='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiadddmarca[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addmarca[" + id + "]' placeholder='marca'>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiadddmodelo[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addmodelo[" + id + "]' placeholder='modelo' >" +
        "</div>" +
        "</div>" +
        "<div class='col-lg-12' style='margin-top:5px;margin-bottom:5px' name='ddiadddeq1[" + id + "]'>" +

        "<div class='col-lg-4' name='ddiadddimei[" + id + "]'>" +
        "<strong>Imei:</strong>" +
        "</div>" +

        "<div class='col-lg-3' name='ddiadddsimei[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addsimei[" + id + "]' placeholder='imei' >" +
        "</div>" +

        "</div>" +


        "<div class='col-lg-12' name='ddicabecera22[" + id + "]'>" +
        "<div class='col-lg-2' name='ddicabecera12[" + id + "]'>" +
        "<strong>Bp:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddicabecera22[" + id + "]'>" +
        "<strong>Plan:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddicabecera32[" + id + "]'>" +
        "<strong>Tárifa Básica:</strong>" +
        "</div>" +
        "<div class='col-lg-1' name='ddicabecera42[" + id + "]'>" +
        "<strong>Cuota:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddicabecera52[" + id + "]'>" +
        "<strong>Obsequio 1:</strong>" +

        "</div>" + "<div class='col-lg-2' name='ddicabecera62[" + id + "]'>" +
        "<strong>Obsequio 2:</strong>" +

        "</div>" +
        "</div>" +
        "<div style='margin:2px'>" +
        "<div class='col-lg-12' name='ddiadddselectbp[" + id + "]'>" +
        "<div class='col-lg-2' name='ddiaddselectbp[" + id + "]'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addbp[" + id + "]' onchange='obtienedatoselect(" + id + ")'>" +
        "</select>" +
        "</div>" +

        "<div class='col-lg-2' name='ddiaddconsultabp[" + id + "]'>" +
        "<input class='form-control' type='hidden' name='addbphi[" + id + "]' value='0' >" +
        "<input class='form-control' type='text' name='addplan[" + id + "]'  placeholder='Plan' disabled>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiaddconsultatb[" + id + "]' >" +
        "<input class='form-control' type='text'  name='addtb[" + id + "]' placeholder='Tarifa' disabled > " +
        "</div>" +

        "<div class='col-lg-1'name='ddiaddconsultacuota[" + id + "]' >" +

        "<input class='form-control' type='text' maxlength='5' onkeyup='solonumero("+id+",\"addcuota\")' name='addcuota[" + id + "]' id='addcuota[" + id + "]' placeholder='Cuota'>" +
        "</div>" +

        "<div class='col-lg-2' name='ddiaddconsultaobsequio[" + id + "]' style='padding-right:0px!important;'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addobsequio1[" + id + "]' onchange='cantidadOb()'>" +
        "<option class='form-control select2' value='0'>Obsequio" +
        "</option>" +
        "<option class='form-control select2' value='Agenda_Guayaquil'>Agenda Guayaquil" +
        "</option>" +
        "<option class='form-control select2' value='Spinner'>Spinner" +
        "</option>" +
        " <option class='form-control select2' value='BMOBILE_K360'>BMOBILE K360" +
        "</option>" +
        "<option class='form-control select2' value='Gift_Card'>Gift Card" +
        "</option>" +
        "<option class='form-control select2' value='Reloj'>Reloj" +
        "</option>" +
        "<option class='form-control select2' value='Tarjeta_de_memoria'>Tarjeta de Memoria" +
        "</option>" +
        "<option class='form-control select2' value='VR_BOX'>VR BOX" +
        "</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiaddconsultaobsequio[" + id + "]' style='padding-right:0px!important;'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addobsequio2[" + id + "]' onchange='cantidadOb()'>" +
        "<option class='form-control select2' value='0'>Obsequio" +
        "</option>" +
        "<option class='form-control select2' value='Agenda_Guayaquil'>Agenda Guayaquil" +
        "</option>" +
        "<option class='form-control select2' value='Spinner'>Spinner" +
        "</option>" +
        " <option class='form-control select2' value='BMOBILE_K360'>BMOBILE K360" +
        "</option>" +
        "<option class='form-control select2' value='Gift_Card'>Gift Card" +
        "</option>" +
        "<option class='form-control select2' value='Reloj'>Reloj" +
        "</option>" +
        "<option class='form-control select2' value='Tarjeta_de_memoria'>Tarjeta de Memoria" +
        "</option>" +
        "<option class='form-control select2' value='VR_BOX'>VR BOX" +
        "</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-1' name='ddiaddborra[" + id + "]'>" +
        "<span onclick='borraitem(" + id + ")' name='ddiaddborraspan[" + id + "]' class='btn btn-danger btn-xs'><i class='glyphicon glyphicon-trash'></i></span>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<div class='col-lg-12' style='margin-top:15px;margin-bottom:15px' name='ddiadddcobsequios[" + id + "]'>" +

        "<div class='col-lg-3' name='ddiadddcobsequio1[" + id + "]'>" +

        "<strong>Codigo de Barra Obsequio 1:</strong>" +
        "</div>" +
        "<div class='col-lg-3' name='ddiadddcobsequio2[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addcobsequio1[" + id + "]' placeholder='Codigo de Barra Obsequio 1'>" +

        "</div>" +

        "<div class='col-lg-3' name='ddiadddcobsequio1[" + id + "]'>" +
        "<strong>Codigo de Barra Obsequio 2:</strong>" +

        "</div>" +
        "<div class='col-lg-3' name='ddiadddobsequioc2[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addcobsequio2[" + id + "]' placeholder='Codigo de Barra Obsequio 2' >" +
        "</div>" +


        "</div>" +

        "<div style='margin:2px'>" +
        "<div name='ddiaddddonante[" + id + "]'>" +
        "<div class='col-lg-3' name='ddiadddcidonante[" + id + "]''>" +
        "<input type='hidden' name='addiddonante[" + id + "]' value='0'>" +
        "<strong>Cédula Donante</strong>" +
        "<input class='form-control' type='text' name='addceduladonante[" + id + "]'   placeholder='Cedula Donante' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' maxlength='13'>" +
        "</div>" +
        "<div class='col-lg-3' name='ddiadddnombredonante[" + id + "]''>" +
        "<strong>Nombre Donante</strong>" +
        "<input class='form-control' type='text' name='addnombredonante[" + id + "]'   placeholder='Nombre Donante'>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiaddddirecciondonante[" + id + "]''>" +
        "<strong>Dirección Donante</strong>" +
        "<input class='form-control' type='text' name='adddirecciondonante[" + id + "]'   placeholder='Direccion Donante'>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddcelulardonante[" + id + "]''>" +
        "<strong>Celular Donante</strong>" +
        "<input class='form-control' type='text' name='addcelulardonante[" + id + "]'  placeholder='Celular Donante' maxlength='10' onkeyup='solonumero("+id+",\"addcelulardonante\")'>" +
        "</div>" +
        "</div>" +
        "<div name='ddiadddrl[" + id + "]'>" +
        "<div class='col-lg-3' name='ddiadddctarl[" + id + "]''>" +
        "<strong>Número de Cuenta</strong>" +
        "<input class='form-control' type='text' name='addctarl[" + id + "]'  placeholder='N° Cuenta' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
        "</div>" +
        "<div class='col-lg-3' name='ddiadddcirl[" + id + "]''>" +
        "<strong>Cédula de Representante Legal</strong>" +
        "<input class='form-control' type='text' name='addcirl[" + id + "]'  placeholder='Cedula RL' maxlength='13' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' maxlength='13'>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiadddnombrerl[" + id + "]''>" +
        "<strong>Nombre del Representante Legal</strong>" +
        "<input class='form-control' type='text' name='addnombrerl[" + id + "]' placeholder='Nombre RL'>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddcargorl[" + id + "]''>" +
        "<strong>Cargo - R.Legal</strong>" +
        "<input class='form-control' type='text' name='addcargorl[" + id + "]' placeholder='Cargo RL'  >" +
        "</div>" +

        "</div>" +

        "</div>" +

        "</div>" +
        "</div>" +
        "<div class='col-lg-12' name='ddiaddht[" + id + "]'>" +
        "<hr/>" +
        "</div> "
    )

    $('[name*="simcard[' + id + ']"]').hide();
    $('[name*="cobsequio1[' + id + ']"]').hide();
    $('[name*="cobsequio2[' + id + ']"]').hide();
    $('Div[name="ddiaddddonante[' + id + ']"]').hide();
    $('Div[name="ddiadddrl[' + id + ']"]').hide();

    configuracionBP(id, 'bp', 'BP');
    $('[name*="marca[' + id + ']"]').hide();
    $('Input[name="addmarca[' + id + ']"]').val('');
    $('[name*="modelo[' + id + ']"]').hide();
    $('[name*="imei[' + id + ']"]').hide();
    $('Input[name="addmodelo[' + id + ']"]').val('');
    cantidadLineas();
    id++;
}

$("#btnGuardarValida").on('click', function () {
    guardar('valida');

});

$("#btnGuardar").on('click', function () {

    guardar('novalida');
});

function guardar(dato) {

    var lineas = [];
    var dato_natural = [];
    var dato_laborales = [];
    var dato_entrega = [];
    var banco = [];
    var tarjeta = [];
    var dato_juridico = [];
    var lineasc = [];
    var identificacion = $('input[name^="identificacion"]').val();
    var tipo_persona = $('input[name^="tipo_persona"]').val();
    var valor_garantia = $('input[name^="valor_garantia"]').val();

    //---solicitud--------------------------------------------------------
    var solicitud_escape = $("#n_solicitud_escape").val();

    var solicitud = $('input[name^="n_solicitud"]').val();
    var tobsequios = $('input[name^="tobsequios"]').val();
    var tlineas = $('input[name^="tlineas"]').val();
    var tchip = $('input[name^="tchip"]').val();
    //-----------------------------------------------------------
    var observacion = $("#observacion").val();
    var gestor = $('select[name^="gestor"]').val();
    var lineaclean = [];
    var ic = 0;
    if (document.getElementById("deposito_garantia").checked == true) {
        var deposito_garantia = 1;
    } else {
        var deposito_garantia = 0;
    }

    // var deposito_garantia= $('Input[name="depositocheck"]').val();
//-lineas----------------------------------------------------------
    if (tlineas > 0) {
        $('[name^="add"]').each(function () {
            lineas.push($(this).val());
        });


        var n_lineas = parseInt(lineas.length) / 29;
        do {
            lineaclean[ic] = lineas.splice(0, 29);
            ic++;
        } while (ic < (n_lineas));

        var lineaclean = lineaclean.filter(Boolean);

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

//--dato_entrega---------------------------------------------------------
    $('input[name*="entrega"]').each(function () {
        dato_entrega.push($(this).val());
    });
    $('select[name*="entrega"]').each(function () {
        dato_entrega.push($(this).val());
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

    var control = $('input[name="control"]').val();
    var control_lineas = $('input[name="control_lineas"]').val();
    var control_solicitud = $('input[name="control_solicitud"]').val();

    if (tipo_persona != 'JURIDICO') {
        var dato_general = dato_natural;
    } else {
        var dato_general = dato_juridico;
    }

    switch (forma_pago) {
        case 'DEBITO_BANCARIO':
            pago = banco;

            var objApiRest = new AJAXRest('/asesor/SaveSolicitud', {
                identificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                dato_entrega: dato_entrega,
                solicitud: solicitud,
                tlineas: tlineas,
                tchip: tchip,
                tobsequios: tobsequios,
                observacion: observacion,
                gestor: gestor,
                lineas: lineaclean,
                forma_pago: forma_pago,
                pago: pago,
                control: control,
                control_lineas: control_lineas,
                control_solicitud: control_solicitud,
                deposito_garantia: deposito_garantia,
                solicitud_escape: solicitud_escape
            }, 'post');

            break;
        case 'TARJETA_CREDITO':
            pago = tarjeta;

            var objApiRest = new AJAXRest('/asesor/SaveSolicitud', {
                identificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                dato_entrega: dato_entrega,
                solicitud: solicitud,
                tlineas: tlineas,
                tchip: tchip,
                tobsequios: tobsequios,
                observacion: observacion,
                gestor: gestor,
                lineas: lineaclean,
                forma_pago: forma_pago,
                pago: pago,
                control: control,
                control_lineas: control_lineas,
                control_solicitud: control_solicitud,
                deposito_garantia: deposito_garantia,
                solicitud_escape: solicitud_escape

            }, 'post');

            break;
        case 'CONTRAFACTURA':
            pago = banco;
            pago1 = tarjeta;

            if (valor_garantia != 0 && valor_garantia != "" && valor_garantia != null) {
                var objApiRest = new AJAXRest('/asesor/SaveSolicitud', {
                    identificacion: identificacion,
                    tipo_persona: tipo_persona,
                    dato_general: dato_general,
                    dato_laborales: dato_laborales,
                    dato_entrega: dato_entrega,
                    solicitud: solicitud,
                    tlineas: tlineas,
                    tchip: tchip,
                    tobsequios: tobsequios,
                    observacion: observacion,
                    gestor: gestor,
                    lineas: lineaclean,
                    forma_pago: forma_pago,
                    pago: pago,
                    pago1: pago1,
                    valor: valor_garantia,
                    control: control,
                    control_lineas: control_lineas,
                    control_solicitud: control_solicitud,
                    deposito_garantia: deposito_garantia,
                    solicitud_escape: solicitud_escape

                }, 'post');
            } else {
                var objApiRest = new AJAXRest('/asesor/SaveSolicitud', {
                    identificacion: identificacion,
                    tipo_persona: tipo_persona,
                    dato_general: dato_general,
                    dato_laborales: dato_laborales,
                    dato_entrega: dato_entrega,
                    solicitud: solicitud,
                    tlineas: tlineas,
                    tchip: tchip,
                    tobsequios: tobsequios,
                    observacion: observacion,
                    gestor: gestor,
                    lineas: lineaclean,
                    forma_pago: forma_pago,
                    pago: pago,
                    pago1: pago1,
                    control: control,
                    control_lineas: control_lineas,
                    control_solicitud: control_solicitud,
                    deposito_garantia: deposito_garantia,
                    solicitud_escape: solicitud_escape

                }, 'post');
            }

            break;
        default:
            var objApiRest = new AJAXRest('/asesor/SaveSolicitud', {
                identificacion: identificacion,
                tipo_persona: tipo_persona,
                dato_general: dato_general,
                dato_laborales: dato_laborales,
                dato_entrega: dato_entrega,
                solicitud: solicitud,
                tlineas: tlineas,
                tchip: tchip,
                tobsequios: tobsequios,
                observacion: observacion,
                gestor: gestor,
                lineas: lineaclean,
                control: control,
                control_lineas: control_lineas,
                control_solicitud: control_solicitud,
                deposito_garantia: deposito_garantia,
                solicitud_escape: solicitud_escape

            }, 'post');
            break;
    }
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {

            if (dato == 'valida') {
                SolicitudActiva(solicitud);
            } else {
                location.reload();
                alertToastSuccess(_resultContent.message, 4500);
            }

        } else {

            alertToast(_resultContent.message, 4500);

        }
    });

}

function verificaNumero(id) {
        
    var celular = $('[name*="addcelular[' + id + ']"]').val();
    
        
    var solicitud = $('input[name*="n_solicitud"]').val();

    if (celular != 0) {
        var objApiRest = new AJAXRest('/asesor/verificaNumero', {celular: celular, solicitud: solicitud}, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            if (_resultContent.status == 200) {
                alertToast(_resultContent.message, 2500);
                start();
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

$("#btnEstado").on('click', function () {

    var estado = $("#estado_solicitud").val();
    var solicitud_id = $("#n_solicitud").val();
    var bandeja = 'BANDEJA_VALIDACION';
    var observacion = $("#observacion_lider").val();
    var band = 0;

    if (estado != null && estado != 0) {

        var objApiRest = new AJAXRest('/lider/EstadosBandeja', {
            observacion: observacion,
            estado: estado,
            solicitud_id: solicitud_id,
            bandeja: bandeja,
            band: band,
        }, 'post');

        objApiRest.extractDataAjax(function (_resultContent) {
            if (_resultContent.status == 200) {
                alertToastSuccess(_resultContent.message, 4500);
                location.reload();
            } else {

                alertToast(_resultContent.message, 4500);

            }
        });
    } else {
        alertToast("Seleccione un estado para la solictud", 4500);
    }


});
