var id = 1;
var sum = 0;
var i = 0;

function ocultarDependiente() {
    $("#debito").hide();
    $("#tarjeta").hide();
    $("#contrafactura").hide();
}

function ocultar() {
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
            $('Input[name="addplan[' + id + ']"]').val('');
            $('Input[name="addplanh[' + id + ']"]').val(0);
            $('Input[name="addtb[' + id + ']"]').val('');
            $('select[name="addbp[' + id + ']"]').val(0);
            $('select[name*="cuota[' + id + ']"]').val('');
            alertToast("Error de conexion", 3500);

        }
    });
}

function obtienedatos(id) {
    if ($('select[name^="addtipo_solicitud[' + id + ']"]').val() == 'Transferencia_Beneficiario') {
        $('input[name="addiddonante[' + id + ']"]').val('1');
        $('Div[name="ddiaddddonante[' + id + ']"]').show();
        $('Div[name="ddiadddrl[' + id + ']"]').show();

    }
    else {
        $('input[name="addiddonante[' + id + ']"]').val('0');
        $('Div[name="ddiaddddonante[' + id + ']"]').hide();
        $('Div[name="ddiadddrl[' + id + ']"]').hide();

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

            }
            else {
                $('input[name^="valor_garantia"]').val('');
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
            $('Input[name="addtb[' + id + ']"]').val('');

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
    $('input[name="tobsequios"]').val(_value.tobsequios);
    $('input[name="tlineas"]').val(id);
    $('#dentregai').val(_value.entrega_ciudad_id).change();
    //datos de solicitud - con estado

    $('input[name="solicitud_axis_s"]').val(_value.n_solicitud_axis);
    $('[name="fecha_activa_s"]').val(_value.fecha_activacion);
    $('[name="ciclo_factura_s"]').val(_value.ciclo_facturacion);
    $('[name="fecha_factura_s"]').val(_value.fecha_facturacion);
    $("#lote_s").val(_value.lote);
    $('[name="fecha_lote_s"]').val(_value.fecha_lote);
}

function datos_lineas(_value, c, controladd, salida) {
    $('[name*="[' + c + ']"]').attr('disabled', true);

    if (_value.obsequio1 != 0) {
        contadorObsequios++;
    }
    if (_value.obsequio2 != 0) {
        contadorObsequios++;
    }

    $('input[name="control_lineas"]').val(1);
    //Solicitud axis
    $('input[name="addaxis[' + c + ']"]').val(_value.s_axis);

    $('select[name="addtipo_solicitud[' + c + ']"]').val(_value.tipo_solicitud).change();
    if (_value.celular != null && _value.celular != '') {
        $('input[name="addcelular[' + c + ']"]').val(_value.celular);
        $('input[name="addcelular[' + c + ']"]').attr("disabled", true);

    } else {
        $('input[name="addcelular[' + c + ']"]').attr("disabled", false);
    }
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

        $('[name*="imei[' + c + ']"]').hide();


    } else {
        $('input[name="addequipo[' + c + ']"]').prop('checked', false);
        $('input[name="addmarca[' + c + ']"]').val(_value.marca);
        $('input[name="addmodelo[' + c + ']"]').val(_value.modelo);
        $('[name*="marca[' + c + ']"]').show();
        $('[name*="modelo[' + c + ']"]').show();
        $('[name*="imei[' + c + ']"]').val(_value.imei);

        $('[name*="imei[' + c + ']"]').show();
    }

    if (_value.cuota != 0 && _value.cuota != null) {
        $('input[name="addcuota[' + c + ']"]').val(_value.cuota);
    } else {
        $('input[name="addcuota[' + c + ']"]').val('');
    }

    if (_value.plan != 0 && _value.plan != null) {
        $('input[name="addplan[' + c + ']"]').val(_value.plan);

    } else {
        $('input[name="addplan[' + c + ']"]').val('');
    }
    $('input[name="addsimcard[' + c + ']"]').val(_value.simcard);
    $('input[name="addcobsequio1[' + c + ']"]').val(_value.cobsequio1);
    $('input[name="addcobsequio2[' + c + ']"]').val(_value.cobsequio2);

    if (_value.tarifa_basica != 0 && _value.tarifa_basica != null) {
        $('input[name="addtb[' + c + ']"]').val(_value.tarifa_basica);

    } else {
        $('input[name="addtb[' + c + ']"]').val('');
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
    $('[name*="axisestado[' + c + ']"]').val(_value.axisestado).change();
    $('input[name="addctarl[' + c + ']"]').val(_value.n_cuenta_donante);
    $('input[name="addceduladonante[' + c + ']"]').val(_value.cedula_donante);
    $('input[name="addnombredonante[' + c + ']"]').val(_value.nombre_donante);
    $('input[name="adddirecciondonante[' + c + ']"]').val(_value.direccion_donante);
    $('input[name="addcelulardonante[' + c + ']"]').val(_value.celular_donante);
    $('input[name="addcirl[' + c + ']"]').val(_value.cedula_RL);
    $('input[name="addnombrerl[' + c + ']"]').val(_value.nombre_RL);
    $('input[name="addcargorl[' + c + ']"]').val(_value.cargo_RL);

    /*  switch (controladd) {
          case 'BANDEJA_CREDITO':
              if (salida == 1) {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();

              } else {
                  $('[name*="as1"]').show();
                  document.getElementById("region").disabled = false;

                  $('Input[name*="addimei"]').attr('disabled', false);
              }

              break;
          case 'BANDEJA_CALIDAD':
              if (salida == 1) {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();

              } else {
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();
                  $('[name*="simcard"]').show();
                  $('[name*="simcard"]').attr('disabled', false);
                  $('[name*="cobsequio1"]').attr('disabled', true);
                  $('[name*="cobsequio2"]').attr('disabled', true);
              }
              break;
          case 'BANDEJA_RECEPCION':
              if (salida == 1) {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();

              } else {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();
                  $('[name*="cobsequio1"]').attr('disabled', false);
                  $('[name*="cobsequio2"]').attr('disabled', false);
                  document.getElementById("provincia_entrega").disabled = false;
                  document.getElementById("dato_entrega_ciudad").disabled = false;
              }
              break;
          case 'BANDEJA_REGULARIZACION':
              if (salida == 1) {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();
              }
              else {
                  $('[name*="simcard"]').show();
                  $('[name*="cobsequio1"]').show();
                  $('[name*="cobsequio2"]').show();
              }
              break;
      }

  */

}

function busquedaDatos(dato, solicitud_id, controladd, salida) {
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
                        datos_lineas(_value, c, controladd);
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
        $('[name*="ddiaddborra"]').hide();
        $("#agregaitem").hide();
        $('[name*="as1["]').hide();
        $('#formulario').find('input, textarea, button, select').css('border', '0');
        $('#item').find('input, textarea, button, select').css('border', '0');
        switch (controladd) {

            case 'BANDEJA_CREDITO':
                if (salida != 0) {
                    $('[name*="add"]').attr('disabled', true);
                    $('[name*="simcard"]').show();
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();

                } else {
                    $('[name*="as1["]').show();
                    document.getElementById("region").disabled = false;
                    $('[name*="addequipo["]').attr('disabled', false);
                    $('Input[name*="addmarca["]').attr('disabled', false);
                    $('Input[name*="addmodelo["]').attr('disabled', false);
                    $('Input[name*="addimei["]').attr('disabled', false);
                }

                break;
            case 'BANDEJA_CALIDAD':
                if (salida != 0) {
                    $('[name*="add"]').attr('disabled', true);
                    $('[name*="simcard"]').show();
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();

                } else {
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();
                    $('[name*="simcard"]').show();
                    $('[name*="simcard"]').attr('disabled', false);
                    $('[name*="cobsequio1"]').attr('disabled', true);
                    $('[name*="cobsequio2"]').attr('disabled', true);
                }
                break;
            case 'BANDEJA_RECEPCION':
                if (salida != 0) {
                    $('[name*="add"]').attr('disabled', true);
                    $('[name*="simcard"]').show();
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();

                } else {
                    $('[name*="simcard"]').show();
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();
                    $('[name*="cobsequio1"]').attr('disabled', false);
                    $('[name*="cobsequio2"]').attr('disabled', false);
                    document.getElementById("provincia_entrega").disabled = false;
                    document.getElementById("dato_entrega_ciudad").disabled = false;
                }
                break;
            case 'BANDEJA_REGULARIZACION':
                if (salida != 0) {
                    $('[name*="simcard"]').show();
                    $('[name*="add"]').attr('disabled', true);
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();
                }
                else {
                    $('[name*="simcard"]').show();
                    $('[name*="cobsequio1"]').show();
                    $('[name*="cobsequio2"]').show();
                }
                break;
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

function checkequipo(id) {
    if ($('Input[name="addequipo[' + id + ']"]:checked').val() == "on") {
        $('[name*="marca[' + id + ']"]').show();
        $('[name*="modelo[' + id + ']"]').show();
        $('[name*="imei[' + id + ']"]').show();

        $('Input[name="addequipoid[' + id + ']"]').val(1);

    } else {
        $('Input[name="addequipoid[' + id + ']"]').val(0);
        $('[name*="marca[' + id + ']"]').hide();
        $('[name*="modelo[' + id + ']"]').hide();
        $('[name*="imei[' + id + ']"]').hide();
        $('Input[name="addmarca[' + id + ']"]').val('');
        $('Input[name="addmodelo[' + id + ']"]').val('');
    }

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
    $('input[name*="valor_garantia"]').val('');
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

function start() {
    $("#asesorh").hide();
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
    //------------------------------------------------------------------------
    //Solicitud Axis
    $('[name="solicitud_axis_s"]').attr('disabled', true);
    $('[name="fecha_activa_s"]').attr('disabled', true);
    $('[name="ciclo_factura_s"]').attr('disabled', true);
    $('[name="fecha_factura_s"]').attr('disabled', true);
    $('[name="lote_s"]').attr('disabled', true);
    $('[name="fecha_lote_s"]').attr('disabled', true);
    //------------------------------------------------------------------------
    var objApiRest = new AJAXRest('/asesor/NSolicitud', {}, 'post');
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            $('input[name^="n_solicitud"]').val(_resultContent.message);
        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
    document.getElementById("usuario").disabled = true;

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
function solonumero(id,tipo) {
    switch(tipo)
    {

        case 0:
        var i=$("#"+id).val();
            i=parseInt(i);
                if(isNaN(i))
                {
                    $("#"+id).val('');
                }else{
                    $("#"+id).val(i);
        
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
        var i=$('[name*="'+tipo+'[' + id + ']"]').val();
        i=parseInt(i);
            if(isNaN(i))
            {
                $('[name*="'+tipo+'[' + id + ']"]').val('');
            }else{
                $('[name*="'+tipo+'[' + id + ']"]').val(i);
            }
        break;
    }
}
function verificatipoSolicitud(id) {
    var i=$('[name*="addcelular[' + id + ']"]').val();
    var res = i.substring(0, 1);
    i=parseInt(i);
        if(isNaN(i))
        {
            $('[name*="addcelular[' + id + ']"]').val('');
        }else{
            $('[name*="addcelular[' + id + ']"]').val('0'+i);
        }
}
function Add() {

    if (id % 2 == 0) {
        var color = '#dde9ff';
    } else {
        var color = '#fff';
    }
    var id1=id+1;
    i = i++;
    $("#item").append(
        "<div class='panel-body' name='ddicolor[" + id + "]' style='background-color:" + color + "'>" +

        "<input type='hidden'  name='addinicio_linea[" + id + "]' value='inicio_linea'>" +
        "<div class='col-lg-2' name='ddiaxiscabeceraaxischs[" + id + "]'>" +
        "<label class='containera' name='ddiprint[" + id + "]'>"+
        "<input type='checkbox'  id='ddiprintc[" + id + "]'>"+
        "<span class='checkmark'></span>"+
        "</label>"+
        "</div>" +
        "<div class='col-lg-2' name='ddiaxiscabeceraaxis10[" + id + "]'>" +
        "<strong>Solicitud del Axis:</strong>" +
        "</div>" +
        "<div class='col-lg-3' name='ddiaxiscabecera11[" + id + "]'>" +
        "<input type='text' class='addaxis' name='addaxis[" + id + "]' placeholder='Solicitud Axis' onkeyup='solonumero("+id+",\"addaxis\")' >" +
        "</div>" +
        "<div class='col-lg-2' name='ddiaxisabecera12[" + id + "]'>" +
        "<strong>Estado del Axis:</strong>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiaxiscabecera13[" + id + "]'>" +
        "<select class='form-control select2' style='border-radius: 10px' name='addaxisestado[" + id + "]'>" +
        "<option class='form-control select2' value='0'>Estados" +
        "</option>" +
        "<option class='form-control select2' value='Aprobado'>Aprobado" +
        "</option>" +
        "<option class='form-control select2' value='Negado'>Negado" +
        "</option>" +
        "</select>" +
        "</div>" +
        "<div class='col-lg-12' name='ddiaddditem[" + id + "]'>" +
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
        "<div class='col-lg-3' name='ddicabecera4[" + id + "]'>" +
        "<strong>Linea:</strong>" +
        "</div>" +
        "<div class='col-lg-1' name='ddicabecerasimcard[" + id + "]'>" +
        "<strong>Simcard:</strong>" +
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
        "<input class='form-control' type='text' name='addcelular[" + id + "]' onblur='verificaNumero(" + id + ")' onkeyup='verificatipoSolicitud("+id+")'placeholder='Celular' maxlength='10' >" +
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
        "<div class='col-lg-2' name='ddiadddtipo_linea[" + id + "]'>" +
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
        "<div class='col-lg-1' id='as1' name='as1[" + id + "]'>" +
        "<label style='padding-left:5px;padding-right:5px;' name='ddiaddlabelequipo[" + id + "]'>Equipo</label> " +
        "<input type='checkbox' name='addequipo[" + id + "]' id='echeck' onclick='checkequipo(" + id + ")'>" +
        "<input type='hidden' name='addequipoid[" + id + "]' value='0'>" +
        "</div>" +
        "<div class='col-lg-2' name='ddiadddsimcard[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addsimcard[" + id + "]' maxlength='18' placeholder='Simcard' 'onKeypress'='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' onkeyup='solonumero("+id+",\"addsimcard\")'>" +
        "</div>" +
        "</div>" +
        "<div class='col-lg-12' style='margin-top:5px;margin-bottom:5px' name='ddiadddeq1[" + id + "]'>" +

        "<div class='col-lg-4' name='ddiadddmarca[" + id + "]'>" +

        "<strong>Marca:</strong>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiadddmodelo[" + id + "]'>" +
        "<strong>Modelo:</strong>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiadddimei[" + id + "]'>" +
        "<strong>Imei:</strong>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiadddmarca[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addmarca[" + id + "]' placeholder='marca'>" +
        "</div>" +
        "<div class='col-lg-4' name='ddiadddmodelo[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addmodelo[" + id + "]' placeholder='modelo' >" +
        "</div>" +
        "<div class='col-lg-3' name='ddiadddsimei[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addimei[" + id + "]' placeholder='imei' onkeyup='solonumero("+id+",\"addimei\")'>" +
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
        "<input class='form-control' type='text'  name='addtb[" + id + "]' placeholder='Tarifa' disabled> " +
        "</div>" +

        "<div class='col-lg-1'name='ddiaddconsultacuota[" + id + "]' >" +

        "<input class='form-control' type='text' maxlength='5' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' name='addcuota[" + id + "]' id='addcuota[" + id + "]' placeholder='Cuota'>" +
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
        "<div class='col-lg-3' name='ddiadddcobsequio1[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addcobsequio1[" + id + "]' placeholder='Codigo de Barra Obsequio 1' onkeyup='solonumero("+id+",\"addcobsequio1\")'>" +

        "</div>" +

        "<div class='col-lg-3' name='ddiadddcobsequio2[" + id + "]'>" +
        "<strong>Codigo de Barra Obsequio 2:</strong>" +

        "</div>" +
        "<div class='col-lg-3' name='ddiadddobsequioc2[" + id + "]'>" +
        "<input class='form-control' type='text'  name='addcobsequio2[" + id + "]' placeholder='Codigo de Barra Obsequio 2'onkeyup='solonumero("+id+",\"addcobsequio2\")' >" +
        "</div>" +


        "</div>" +

        "<div style='margin:2px'>" +
        "<div name='ddiaddddonante[" + id + "]'>" +
        "<div class='col-lg-3' name='ddiadddcidonante[" + id + "]''>" +
        "<input type='hidden' name='addiddonante[" + id + "]' value='0'>" +
        "<strong>Cédula Donante</strong>" +
        "<input class='form-control' type='text' name='addceduladonante[" + id + "]'   placeholder='Cedula Donante' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
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
        "<input class='form-control' type='text' name='addcelulardonante[" + id + "]'  placeholder='Celular Donante' maxlength='10' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
        "</div>" +
        "</div>" +
        "<div name='ddiadddrl[" + id + "]'>" +
        "<div class='col-lg-3' name='ddiadddctarl[" + id + "]''>" +
        "<strong>Número de Cuenta</strong>" +
        "<input class='form-control' type='text' name='addctarl[" + id + "]'  placeholder='N° Cuenta' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
        "</div>" +
        "<div class='col-lg-3' name='ddiadddcirl[" + id + "]''>" +
        "<strong>Cédula de Representante Legal</strong>" +
        "<input class='form-control' type='text' name='addcirl[" + id + "]'  placeholder='Cedula RL' maxlength='10' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>" +
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
    ;
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


