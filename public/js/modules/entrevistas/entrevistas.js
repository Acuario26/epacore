$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        changeDatatable('REGISTRADOS');
        $("#bandejasA").val(127).change();
        $("#hijos").hide();

    });
});

$("#bandejasA").on('change', function () {
    var select = document.getElementById("bandejasA"), //El <select>
    value = select.value, //El valor seleccionado
    text = select.options[select.selectedIndex].innerText;
    changeDatatable(text);
});

function limpiar() {
    var respuesta11 = $("#respuesta11").val('');
    var observacion11 = $("#observacion11").val('');
    var respuesta12 = $("#respuesta12").val('');
    var observacion12 = $("#observacion12").val('');
    var respuesta13 = $("#respuesta13").val('');
    var observacion13 = $("#observacion13").val('');
    var respuesta14 = $("#respuesta14").val('');
    var observacion14 = $("#observacion14").val('');
    var respuesta15 = $("#respuesta15").val('');
    var observacion15 = $("#observacion15").val('');
    var respuesta16 = $("#respuesta16").val('');
    var observacion16 = $("#observacion16").val('');
    var respuesta17 = $("#respuesta17").val('');
    var observacion17 = $("#observacion17").val('');
    var respuesta18 = $("#respuesta18").val('');
    var observacion18 = $("#observacion18").val('');
    var respuesta1 = $("#respuesta1").val('');
    var respuesta2 = $("#respuesta2").val('');
    var respuesta3 = $("#respuesta3").val('');
    var respuesta4 = $("#respuesta4").val('');
    var p=0;
    var i=0;
    do{
        p++;
        $('input[name='+p+']').attr('checked',false);
    }while(p<12);
    var mantener_casa_nucleo = $("#mantener_casa_nucleo").val('');
    var convive_nucleo = $("#convive_nucleo").val('');
    var actividad = $("#actividad").val('');
    var dias_estudio = $("#dias_estudio").val(null).change();
    var horario_estudio = $("#horario_estudio").val(null).change();
    var casa_estudio = $("#casa_estudio").val('');
    var carrera = $("#carrera").val('');
    var nivel = $("#nivel").val('');
    var edad = $("#edad").val('');
    var edad_hijo = $("#edad_hijo").val('');
    var edad_hijo_m = $("#edad_hijo_m").val('');
    var asignacion_hijo = $("#asignacion_hijo").val('');
    var convencional = $("#convencional").val('');
    var celular = $("#celular").val('');
    var civil = $("#civil").val(null).change();
    var modo = $("#modo").val(null).change();
    var lider = $("#lider").val(null).change();
    var genero = $("#genero").val(null).change();
    var ciudad_id = $("#ciudad_id").val(null).change();
    var provincia_id = $("#provincia_id").val(null).change();
    var identificacion = $("#identificacion").val('');
    var nombres = $("#nombres").val('');
    var email = $("#email").val('');

}

function checkedhijo() {
    if (document.getElementById("cc").checked == true) {
        $("#hijos").show();
    }
    if (document.getElementById("cc").checked == false) {
            var edad_hijo = $("#edad_hijo").val('');
            var edad_hijo_m = $("#edad_hijo_m").val('');
			var asignacion_hijo = $("#asignacion_hijo").val('');
        $("#hijos").hide();
    }
}

function changeDatatable(dato) {
    
	    $("body").addClass("sidebar-collapse");

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
            "info": true,
            "ordering": true,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/encuestador/datatablePostulante/"+dato,
            "columns": [

                {data: 'celular', "width": "10%"},
                {data: 'id', "width": "10%"},
                {data: 'name', "width": "25%"},
                {data: 'created_at', "width": "10%"},
                {data: 'usuario_validad', "width": "10%"},
                {data: 'ciudad', "width": "10%"},
                {data: 'edad', "width": "10%"},
                {data: 'total_p', "width": "10%"},
                {data: 'total_et', "width": "10%"},

                {
                    data: 'estados',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estados).text();
                    }
                },
                {
                    data: 'opciones',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.opciones).text();
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
    var p1 = $('input:radio[name=1]:checked').val()
    var p2 = $('input:radio[name=2]:checked').val();
    var p3 = $('input:radio[name=3]:checked').val();
    var p4 = $('input:radio[name=4]:checked').val();
    var p5 = $('input:radio[name=5]:checked').val();
    var p6 = $('input:radio[name=6]:checked').val();
    var p7 = $('input:radio[name=7]:checked').val();
    var p8 = $('input:radio[name=8]:checked').val();
    var p9 = $('input:radio[name=9]:checked').val();
    var p10 = $('input:radio[name=10]:checked').val();
    var p11 = $('input:radio[name=11]:checked').val();
    var p12 = $('input:radio[name=12]:checked').val();

    var respuesta11 = $("#respuesta11").val();
    var observacion11 = $("#observacion11").val();
    var respuesta12 = $("#respuesta12").val();
    var observacion12 = $("#observacion12").val();
    var respuesta13 = $("#respuesta13").val();
    var observacion13 = $("#observacion13").val();
    var respuesta14 = $("#respuesta14").val();
    var observacion14 = $("#observacion14").val();
    var respuesta15 = $("#respuesta15").val();
    var observacion15 = $("#observacion15").val();
    var respuesta16 = $("#respuesta16").val();
    var observacion16 = $("#observacion16").val();
    var respuesta17 = $("#respuesta17").val();
    var observacion17 = $("#observacion17").val();
    var respuesta18 = $("#respuesta18").val();
    var observacion18 = $("#observacion18").val();
    var respuesta1 = $("#respuesta1").val();
    var respuesta2 = $("#respuesta2").val();
    var respuesta3 = $("#respuesta3").val();
    var respuesta4 = $("#respuesta4").val();

    var edad_hijo = $("#edad_hijo").val();
    var edad_hijo_m = $("#edad_hijo_m").val();

    
    var asignacion_hijo = $("#asignacion_hijo").val();
    var mantener_casa_nucleo = $("#mantener_casa_nucleo").val();
    var convive_nucleo = $("#convive_nucleo").val();
    var actividad = $("#actividad").val();
    var dias_estudio = $("#dias_estudio").val();
    var horario_estudio = $("#horario_estudio").val();
    var casa_estudio = $("#casa_estudio").val();
    var carrera = $("#carrera").val();
    var nivel = $("#nivel").val();
    var edad = $("#edad").val();
    var convencional = $("#convencional").val();
    var celular = $("#celular").val();
    var civil = $("#civil").val();
    var modo = $("#modo").val();
    var lider = $("#lider").val();
    var genero = $("#genero").val();
    var ciudad_id = $("#ciudad_id").val();
    var provincia_id = $("#provincia_id").val();
    var identificacion = $("#identificacion").val();
    var nombres = $("#nombres").val();
    var email = $("#email").val();
    var pr0 = [];
    var pr1 = [];
    var pr2 = [];
    var pr3 = [];
    var pr4 = [];
    var pr5 = [];
    var pr6 = [];
    var pr7 = [];
    pr0.push(p1, respuesta11, observacion11);
    pr1.push(p2, respuesta12, observacion12);
    pr2.push(p3, respuesta13, observacion13);
    pr3.push(p4, respuesta14, observacion14);
    pr4.push(p5, respuesta15, observacion15);
    pr5.push(p6, respuesta16, observacion16);
    pr6.push(p7, respuesta17, observacion17);
    pr7.push(p8, respuesta18, observacion18);
    var et0 = [];
    var et1 = [];
    var et2 = [];
    var et3 = [];
    et0.push(p9, respuesta1);
    et1.push(p10, respuesta2);
    et2.push(p11, respuesta3);
    et3.push(p12, respuesta4);
	var observacion_estado=$("#observacion_estado").val();



    var objApiRest = new AJAXRest('/encuestador/Save', {
            mantener_casa_nucleo: mantener_casa_nucleo,
            convive_nucleo: convive_nucleo,
            actividad: actividad,
            dias_estudio: dias_estudio,
            horario_estudio: horario_estudio,
            casa_estudio: casa_estudio,
            carrera: carrera,
            nivel: nivel,
            edad: edad,
            convencional: convencional,
            celular: celular,
            civil: civil,
            modo: modo,
            lider: lider,
            genero: genero,
            ciudad_id: ciudad_id,
            provincia_id: provincia_id,
            identificacion: identificacion,
            nombres: nombres,
            email: email,
            pr0: pr0,
            pr1: pr1,
            pr2: pr2,
            pr3: pr3,
            pr4: pr4,
            pr5: pr5,
            pr6: pr6,
            pr7: pr7,
            et0: et0,
            et1: et1,
            et2: et2,
            et3: et3,
            edad_hijo: edad_hijo,
            edad_hijo_m: edad_hijo_m,
            asignacion_hijo: asignacion_hijo,
			observacion_estado:observacion_estado
        },
        'post'
        )
    ;
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            location.reload();

        } else {
            alertToast(_resultContent.message, 3500);

        }
    });
}

function DeleteChanges(id, band) {

    var objApiRest = new AJAXRest('/encuestador/Descartar', {
        id: id, band: band
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

function EditChanges(
    id,
    name,
    celular,
    email,
    edad,
    provincia_id,
    ciudad_id,
    estado_id,
    genero,
    usuario_valida,
    estado_civil,
    convencional,
    actividad,
    dias_estudio,
    horario_estudio,
    casa_estudio,
    carrera,
    nivel,
    edad_hijo,
    edad_hijo_m,
    asignacion_hijo,
    mantener_casa_nucleo,
    convive_nucleo,
    p1,
    respuesta1,
    observacion1,
    p2,
    respuesta2,
    observacion2,
    p3,
    respuesta3,
    observacion3,
    p4,
    respuesta4,
    observacion4,
    p5,
    respuesta5,
    observacion5,
    p6,
    respuesta6,
    observacion6,
    p7,
    respuesta7,
    observacion7,
    p8,
    respuesta8,
    observacion8,
    et1,
    observacionet1,
    et2,
    observacionet2,
    et3,
    observacionet3,
    et4,
    observacionet4,
    extension,
    prefijo,
	observacion_estado,
	estado
) {
	var observacion_estado=$("#observacion_estado").val(observacion_estado);

    var receptor=celular;
    var celular = $("#celular").val(celular);

    var extension = $("#Extension").val(extension);
    var prefijo = $("#Prefijo").val(prefijo);
    var receptor_llamada = $("#receptor").val(receptor);
	if(estado=='REGISTRADOS')
	{
		$("#btnenviarllamada").click();
	}
    var lider_empleado_id = $('#lider').val(usuario_valida).change();
    var identificacion = $("#identificacion").val(id);
    var nombres = $("#nombres").val(name);
    var apellidos = $("#email").val(email);
    var genero = $('#genero').val(genero).change()
    var provincia_id = $('#provincia_id').val(provincia_id).change();
    var ciudad_id = $('#ciudad_id_h').val(ciudad_id).change();
    var convencional = $("#convencional").val(convencional);
    var edad = $("#edad").val(edad);
    var modo = $("#modo").val(estado_id).change();
    if((edad_hijo!='' && edad_hijo!=null) ||(edad_hijo_m!='' && edad_hijo_m!=null)){
        document.getElementById("cc").checked = true;
        $("#hijos").show();

    }

    var edad_hijo = $("#edad_hijo").val(edad_hijo);
    var edad_hijo_m = $("#edad_hijo_m").val(edad_hijo_m);

    var asignacion_hijo = $("#asignacion_hijo").val(asignacion_hijo);
    var mantener_casa_nucleo = $("#mantener_casa_nucleo").val(mantener_casa_nucleo);
    var convive_nucleo = $("#convive_nucleo").val(convive_nucleo);
    var actividad = $("#actividad").val(actividad);
    var dias_estudio = $("#dias_estudio").val(dias_estudio).change();
    var horario_estudio = $("#horario_estudio").val(horario_estudio).change();
    var casa_estudio = $("#casa_estudio").val(casa_estudio);
    var carrera = $("#carrera").val(carrera);
    var nivel = $("#nivel").val(nivel);
    var civil = $("#civil").val(estado_civil).change();

    switch (p1) {
        case '1':
            document.getElementById("p11").checked=true;
            break;
        case '2':
            document.getElementById("p12").checked=true;
            break;
        case '3':
            document.getElementById("p13").checked=true;
            break;
        case '4':
            document.getElementById("p14").checked=true;
            break;
        case '5':
            document.getElementById("p15").checked=true;
            break;
    }
    switch (p2) {
        case "1":
            document.getElementById("p21").checked=true;
            break;
        case '2':
            document.getElementById("p22").checked=true;

            break;
        case '3':
            document.getElementById("p23").checked=true;

            break;
        case '4':
            document.getElementById("p24").checked=true;

            break;
        case '5':
            document.getElementById("p25").checked=true;
            break;
    }
    switch (p3) {
        case '1':
            document.getElementById("31").checked=true;
            break;
        case '2':
            document.getElementById("p32").checked=true;

            break;
        case '3':
            document.getElementById("p33").checked=true;

            break;
        case '4':
            document.getElementById("p34").checked=true;

            break;
        case '5':
            document.getElementById("p35").checked=true;
            break;
    }
    switch (p4) {
        case '1':
            document.getElementById("p41").checked=true;
            break;
        case '2':
            document.getElementById("p42").checked=true;

            break;
        case '3':
            document.getElementById("p43").checked=true;

            break;
        case '4':
            document.getElementById("p44").checked=true;

            break;
        case '5':
            document.getElementById("p45").checked=true;
            break;
    }
    switch (p5) {
        case '1':
            document.getElementById("p51").checked=true;
            break;
        case '2':
            document.getElementById("p52").checked=true;

            break;
        case '3':
            document.getElementById("p53").checked=true;

            break;
        case '4':
            document.getElementById("p54").checked=true;

            break;
        case '5':
            document.getElementById("p55").checked=true;
            break;
    }
    switch (p6) {
        case '1':
            document.getElementById("p61").checked=true;
            break;
        case '2':
            document.getElementById("p62").checked=true;

            break;
        case '3':
            document.getElementById("p63").checked=true;

            break;
        case '4':
            document.getElementById("p64").checked=true;

            break;
        case '5':
            document.getElementById("p65").checked=true;
            break;
    }
    switch (p7) {
        case '1':
            document.getElementById("p71").checked=true;
            break;
        case '2':
            document.getElementById("p72").checked=true;

            break;
        case '3':
            document.getElementById("p73").checked=true;

            break;
        case '4':
            document.getElementById("p74").checked=true;

            break;
        case '5':
            document.getElementById("p75").checked=true;
            break;
    }
    switch (p8) {
        case '1':
            document.getElementById("p81").checked=true;
            break;
        case '2':
            document.getElementById("p82").checked=true;

            break;
        case '3':
            document.getElementById("p83").checked=true;

            break;
        case '4':
            document.getElementById("p84").checked=true;

            break;
        case '5':
            document.getElementById("p85").checked=true;
            break;
    }
    switch (et1) {
        case '1':
            document.getElementById("et11").checked=true;
            break;
        case '2':
            document.getElementById("et12").checked=true;

            break;
        case '3':
            document.getElementById("et13").checked=true;

            break;
        case '4':
            document.getElementById("et14").checked=true;

            break;
        case '5':
            document.getElementById("et15").checked=true;
            break;
    }
    switch (et2) {
        case '1':
            document.getElementById("et21").checked=true;
            break;
        case '2':
            document.getElementById("et22").checked=true;

            break;
        case '3':
            document.getElementById("et23").checked=true;

            break;
        case '4':
            document.getElementById("et24").checked=true;

            break;
        case '5':
            document.getElementById("et25").checked=true;
            break;
    }
    switch (et3) {
        case '1':
            document.getElementById("et31").checked=true;
            break;
        case '2':
            document.getElementById("et32").checked=true;

            break;
        case '3':
            document.getElementById("et33").checked=true;

            break;
        case '4':
            document.getElementById("et34").checked=true;

            break;
        case '5':
            document.getElementById("et35").checked=true;
            break;
    }
    switch (et4) {
        case '1':
            document.getElementById("et41").checked=true;
            break;
        case '2':
            document.getElementById("et42").checked=true;

            break;
        case '3':
            document.getElementById("et43").checked=true;

            break;
        case '4':
            document.getElementById("et44").checked=true;

            break;
        case '5':
            document.getElementById("et45").checked=true;
            break;
    }



    var respuesta1 = $("#respuesta11").val(respuesta1);
    var observacion1 = $("#observacion11").val(observacion1);
    var respuesta2 = $("#respuesta12").val(respuesta2);
    var observacion2 = $("#observacion12").val(observacion2);
    var respuesta3 = $("#respuesta13").val(respuesta3);
    var observacion3 = $("#observacion13").val(observacion3);
    var respuesta4 = $("#respuesta14").val(respuesta4);
    var observacion4 = $("#observacion14").val(observacion4);
    var respuesta5 = $("#respuesta15").val(respuesta5);
    var observacion5 = $("#observacion15").val(observacion5);
    var respuesta6 = $("#respuesta16").val(respuesta6);
    var observacion6 = $("#observacion16").val(observacion6);
    var respuesta7 = $("#respuesta17").val(respuesta7);
    var observacion7 = $("#observacion17").val(observacion7);
    var respuesta8 = $("#respuesta18").val(respuesta8);
    var observacion8 = $("#observacion18").val(observacion8);
    var observacionet1 = $("#respuesta1").val(observacionet1);
    var observacionet2 = $("#respuesta2").val(observacionet2);
    var observacionet3 = $("#respuesta3").val(observacionet3);
    var observacionet4 = $("#respuesta4").val(observacionet4);


    $("#Modalagregar").show();


}

$("#btnGuardar").on('click', function () {
    var p1 = $('input:radio[name=1]:checked').val()
    var p2 = $('input:radio[name=2]:checked').val();
    var p3 = $('input:radio[name=3]:checked').val();
    var p4 = $('input:radio[name=4]:checked').val();
    var p5 = $('input:radio[name=5]:checked').val();
    var p6 = $('input:radio[name=6]:checked').val();
    var p7 = $('input:radio[name=7]:checked').val();
    var p8 = $('input:radio[name=8]:checked').val();
    var p9 = $('input:radio[name=9]:checked').val();
    var p10 = $('input:radio[name=10]:checked').val();
    var p11 = $('input:radio[name=11]:checked').val();
    var p12 = $('input:radio[name=12]:checked').val();

    var errores = [];
	var celular = $("#celular").val();
	if(celular==null || celular=='')
	{
	     errores.push("\nDebe de Existir un numero de celular")

	}

    if (p9 == null) {
        errores.push("\nSeleccione un valor en la entonación de la expresión telefónica")
    }
    if (p10 == null) {
        errores.push("\nSeleccione un valor en el timbre de la expresión telefónica")
    }
    if (p11 == null) {
        errores.push("\nSeleccione un valor en la articulación de la expresión telefónica")
    }
    if (p12 == null) {
        errores.push("\nSeleccione un valor en el ritmo de la expresión telefónica")
    }


    if (errores.length == 0) {
        var save = "save";
        PedirConfirmacion('0', save);

    } else {
        alertToast("Los Siguientes campos son obligatorios:" + errores + "", 3500);
    }


});
