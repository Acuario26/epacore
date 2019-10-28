var count;
$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("#id").val(0);
        changeDatatable($("#estadobandeja").val());
        $('[data-toggle="tooltip"]').tooltip();  
		 count=1;
    });
});

setInterval('call()',3000);

function call()
{
    bandcall=$("#bandcall").val();
    if(bandcall==1)
    {
        contador(3);
    }
}
function contador(id)
{
    var data          = new FormData();
    data.append('id',   id ? id: '' );
    var objApiRest = new AJAXRestFilePOST('/iniciarllamadaCall',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) 
        {  
           
            $("#bandcall").val(0);
			switch(_resultContent.message)
			{
				case 0:
					$("#bandcall").val(0);
			
					alertToast("No hay numeros para llamar, se detendra el proceso de llamadas",3500);
				//NO HAY LLAMADAS
				break;
				case 4:
				$("#bandcall").val(1);
		
				//	alertToast("Porfavor espere , hay un operador en la linea",3500);

				//EN ESPERA
				break;
                default:
                        $("#checkCel").addClass("hidden");
                        $("#checkConve").addClass("hidden");
                        $("#checkLabo").addClass("hidden");
                        $("#checkRefe").addClass("hidden");
                        $("#btnCancelarAcu").click();
                        count=1;
                setTimeout(function(){
                        var numeros=_resultContent.message.split(',');
                        $("#cel").val(numeros[0]);
                        $("#conve").val(numeros[1]);
                        $("#labo").val(numeros[2]);
                        $("#refe").val(numeros[3]);
                        $('#'+numeros[0]+'').click();
                        $("#idLLamada").val(0);
                         iniciarllamada("iniciar",0);
                    },2000);
				
				break;
			}
		
        } else {
            $("#bandcall").val(0);
        
        }
    });

}
//
function limpiar() {
    $("#id").val(0);
    $("#identificacion").val('');
    $("#nombres").val('');
    $("#apellidos").val('');
    $('#ciudad_id').val(null).change();
    $("#convencional").val('');
    $("#celular").val('');
    $("#ing_empresa").val('');
    $('#cargo').val(null).change();
    $("#direccion").val('');
    $("#email").val('');
}


    $("#estadobandeja").on('change', function () {
      changeDatatable($("#estadobandeja").val());
    
    });


function savechangesLLamada(comentario,id) {

    var band=2;
 var data          = new FormData();
    data.append('id',   id ? id: '' );
    data.append('comentario',   comentario ? comentario: '' );
    data.append('band',   band ? band: '' );


    var objApiRest = new AJAXRestFilePOST('/clientes/llamadas',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            location.reload();


        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable($("#estadobandeja").val());

        }
    });
    
}

function grabardata()
{
    var data          = new FormData();
    var identificacion=$("#datoidentificacion").val();
    var nombres= $("#datonombres").val();
    var ciudad= $("#datociudad").val();
    var celular= $("#datocelular").val();
    var direccion= $("#datodireccion").val();
    var fecha_vencida= $("#datofecha_vencida").val();
    var valor_vencido= $("#datovalor_vencido").val();
    var convencional= $("#datoconvencional").val();
    var nombrelaboral= $("#datonombrelaboral").val();
    var celularlaboral=  $("#datocelularlaboral").val();
    var nombrereferencia=  $("#datonombrereferencia").val();
    var celularreferencia= $("#datocelularreferencia").val();
    var id=0;

    if(identificacion==''||nombres==''||fecha_vencida==''||valor_vencido==''||celular=='')
    {

        alertToast("Los campo de Identificacion, Nombre,Fecha , Valor Vencido, y Celular son obligatorios", 3500);

    }
    else{
        
    
    data.append('id',   id ? id: '' );
    data.append('identificacion',   identificacion ? identificacion: '' );
    data.append('nombres',   nombres ? nombres: '' );
    data.append('direccion',   direccion ? direccion: '' );
    data.append('ciudad',   ciudad ? ciudad: '' );
    data.append('convencional',   convencional ? convencional: '' );
    data.append('celular',   celular ? celular: '' );
    data.append('fecha_vencida',   fecha_vencida ? fecha_vencida: '' );
    data.append('nombrelaboral',   nombrelaboral ? nombrelaboral: '' );
    data.append('celularlaboral',   celularlaboral ? celularlaboral: '' );
    data.append('valor_vencido',   valor_vencido ? valor_vencido: '' );
    data.append('nombrereferencia',   nombrereferencia ? nombrereferencia: '' );
    data.append('celularreferencia',   celularreferencia ? celularreferencia: '' );
    var objApiRest = new AJAXRestFilePOST('/clientes/savecliente',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            location.reload();


        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable($("#estadobandeja").val());

        }
    });
}
}

function solonumero(id,tipo) {

    switch(tipo)
    {
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
function saveAcuerdo(){
    count =1;
	
    var valor_mitad=parseFloat($("#valor_vencidocl").text())/2;
    var va=parseFloat($("#valor_acuerdo").val());
     if(va>=valor_mitad)
    {
        var data          = new FormData();
        var id = $("#idcl").val();
        var cuota_acuerdo = $("#cuota_acuerdo").val();
        var valor_acuerdo = $("#valor_acuerdo").val();
        var fecha_acuerdo = $("#fecha_acuerdo").val();
        var acuerdo = $("#acuerdo").val();
      
    
        data.append('id',   id ? id: '' );
        data.append('cuota_acuerdo',   cuota_acuerdo ? cuota_acuerdo: '' );
        data.append('valor_acuerdo',   valor_acuerdo ? valor_acuerdo: '' );
        data.append('fecha_acuerdo',   fecha_acuerdo ? fecha_acuerdo: '' );
        data.append('acuerdo',   acuerdo ? acuerdo: '' );
    
        var objApiRest = new AJAXRestFilePOST('/clientes/SaveAcuerdo',  data);
        objApiRest.extractDataAjaxFile(function (_resultContent) {
            if (_resultContent.status == 200) {
                alertToastSuccess(_resultContent.message, 3500);
                limpiar();
                iniciarllamada('terminar',0);
                $('#btnCancelarAcu').click();
               // location.reload();
    
    
            } else {
                alertToast(_resultContent.message, 3500);
                changeDatatable($("#estadobandeja").val());
    
    
            }
        });
    }else{
        alertToast("El valor minimo de pago debe ser:"+valor_mitad.toFixed(2)+", correspondiente al 50%",3000);
    }

   				 $("#checkCel").addClass("hidden");
				 $("#checkConve").addClass("hidden");
				 $("#checkLabo").addClass("hidden");
				 $("#checkRefe").addClass("hidden");


}


function llamada(extension,celular,convencional,laboral,referencia,nombrelaboral,nombrereferencia,id,operador,admin,identificacion,name,dias_mora,valor_vencido,valor_deuda,fecha_acuerdo,acuerdo,valor_cuota,valor_acuerdo,intentos,fecha_acuerdo2,acuerdo2,valor_cuota2,valor_acuerdo2,recaudador)
{
 if(operador>0||admin>0)
 {
    $( "[name*='fllama']").removeClass("hidden");
 }else{
    $( "[name*='fllama']").addClass("hidden");
 }
    
    var receptor=celular;
    var extension = $("#Extension").val(extension);
   // var prefijo = $("#Prefijo").val(prefijo);
  var receptor_llamada = $("#receptor").val(celular);
    $("#idcl").val(id);
    $("#celularcl").text(celular);
    $("#convencionalcl").text(convencional);
    $("#referenciacl").text(referencia);
    $("#laboralcl").text(laboral);
    $("#nombrelaboralcl").text(nombrelaboral);
    $("#nombrereferenciacl").text(nombrereferencia);

    $("#identificacioncl").text(identificacion);
    $("#nombrecl").text(name);
    $("#dias_moracl").text(dias_mora);
    $("#valor_vencidocl").text(valor_vencido);
    $("#valor_deudacl").text(valor_deuda);

    $("#fecha_acuerdocl").text(fecha_acuerdo);
    $("#acuerdocl").text(acuerdo);
    $("#cuotascl").text(valor_cuota);
    $("#valor_acuerdocl").text(valor_acuerdo);

    $("#fecha_acuerdo2cl").text(fecha_acuerdo2);
    $("#acuerdo2cl").text(acuerdo2);
    $("#cuotas2cl").text(valor_cuota2);
    $("#valor_acuerdo2cl").text(valor_acuerdo2);

switch(intentos)
{
    case 0:
    $("#fecha_acuerdocl").text('--');
    $("#acuerdocl").text('--');
    $("#cuotascl").text('--');
    $("#valor_acuerdocl").text('--');

    $("#fecha_acuerdo2cl").text('--');
    $("#acuerdo2cl").text('--');
    $("#cuotas2cl").text('--');
    $("#valor_acuerdo2cl").text('--');
    break;
    case 1:
    
    $("#fecha_acuerdo2cl").text('--');
    $("#acuerdo2cl").text('--');
    $("#cuotas2cl").text('--');
    $("#valor_acuerdo2cl").text('--');
    break;
   
}
    
   
    if(intentos==2)
    {
        $("#form-llamadaL").removeClass("hidden");
        $("#form-llamada").addClass("hidden");
        $("#btnAcuerdo").addClass("hidden");

    }else{
        $("#form-llamada").removeClass("hidden");
        $("#form-llamadaL").addClass("hidden");
    }
    if(admin>0)

    {
        $("#form-llamada").addClass("hidden");
        $("#btnAcuerdo").addClass("hidden");
        $("#form-llamadaL").removeClass("hidden");

        
    }
    if(recaudador>0)
    {
        $("#form-llamada").addClass("hidden");
        $("#btnAcuerdo").addClass("hidden");
        $("#form-llamadaL").removeClass("hidden");

    }
  
}
function Finllamada() {
    var id=$("#idcl").val();
    Swal({
        title: 'Escriba un comentario de la llamada',
        input: 'text',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        showLoaderOnConfirm: true
       
      }).then((result) => {
        if (result.value) {
            var comentario=result.value;
            
            savechangesLLamada(comentario,id);
          Swal({
            title: `${result.value}`,
          })
        }
      })
}
function PagosChanges(id) {
    
    $('#dtrecaudo').DataTable().destroy();
    $('#tbobyrecaudo').html('');

    $('#dtrecaudo').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtrecaudo').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'excel'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[-1], ["All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": true,
            "bPaginate": false,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/clientes/datatablePagos/"+id,
            "columns": [
             
                {data: 'comprobante', "width": "10%"},
                {data: 'valor', "width": "25%"},
                {data: 'tipo_pago', "width": "10%"},
                {data: 'recaudador_user', "width": "10%"},
                
                {
                    data: 'estados',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estados).text();
                    }
                }
            ],

        }).ajax.reload();


}


function changeDatatable(bandeja) {
    $("body").addClass("sidebar-collapse");
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                
                'excel'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[-1], ["All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": true,
            "bPaginate": false,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/clientes/datatable/"+bandeja, 
            "columns": [
              
                {
                    data: 'Estadollamada',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                     

                        return $('<div />').html(row.Estadollamada).text();
                    }
                },
                {data: 'identificacion', "width": "5%"},
                {data: 'name', "width": "25%"},
                {data: 'fecha_vencida', "width": "10%"},

                {data: 'dias_mora',
                "width": "10%",
                "bSortable": true,
                "searchable": true,
                "targets": 0,
                "render": function (data, type, row) {
                    return $('<div />').html(row.dias_mora).text();
                }},
                {data: 'valor_vencido', "width": "10%"},
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
                {data: 'updated_at', "width": "10%"},
                {
                    data: 'actions',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.actions).text();
                    }
                }
            ],

        }).ajax.reload();
$("#cel").val(1);

}

function verificaCelular() {
    var numero = $("#celular").val();
    var d10 = numero.substr(0, 2);
    if (d10 != '09') {
        alertToast("Error en numero Celular", 3500);
    }
}

function SaveChanges() {
    var errores = [];
    var listaTribunal = $('select[name^=departamento_id]').val();
    var myJsonString=[];
    if(listaTribunal!=null&&listaTribunal.length>0)
    {
        var myJsonString  = JSON.stringify(listaTribunal);
    }
    var data          = new FormData();

    var id = $("#id").val();
    var identificacion = $("#identificacion").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var ciudad_id = $('#ciudad_id').val();
    var convencional = $("#convencional").val();
    var celular = $("#celular").val();
    var ing_empresa = $("#ing_empresa").val();
    var cargo = $('#cargo').val();
    var direccion = $("#direccion").val();
    var email = $("#email").val();
    var band = 0;

    data.append('id',   id ? id: '' );
    data.append('identificacion',   identificacion ? identificacion: '' );
    data.append('nombres',   nombres ? nombres: '' );
    data.append('apellidos',   apellidos ? apellidos: '' );
    data.append('ciudad_id',   ciudad_id ? ciudad_id: '' );
    data.append('convencional',   convencional ? convencional: '' );
    data.append('celular',   celular ? celular: '' );
    data.append('ing_empresa',   ing_empresa ? ing_empresa: '' );
    data.append('cargo',   cargo ? cargo: '' );
    data.append('direccion',   direccion ? direccion: '' );
    data.append('email',   email ? email: '' );
    data.append('band',   band ? band: '' );

    var objApiRest = new AJAXRestFilePOST('/uploadFinal',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            location.reload();


        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable($("#estadobandeja").val());

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
            changeDatatable($("#estadobandeja").val());

        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable($("#estadobandeja").val());

        }
    });

}

function PedirConfirmacion(id, dato) {
    swal({
            title: "Â¿Estas seguro de realizar esta accion?",
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
                swal("Â¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}


function RecaudoChanges(id) {
    var id = $("#id").val(id);



    $("#Modalagregar").show();


}
function EditChanges(id,identificacion, apellidos, nombres, ciudad_id, direccion, convencional, celular, ing_empresa, email, estado, cargo_id) {
    var id = $("#id").val(id);

    var identificacion = $("#identificacion").val(identificacion);
    var nombres = $("#nombres").val(nombres);
    var apellidos = $("#apellidos").val(apellidos);
    var ciudad_id = $('#ciudad_id').val(ciudad_id).change();
    var convencional = $("#convencional").val(convencional);
    var celular = $("#celular").val(celular);
    var ing_empresa = $("#ing_empresa").val(ing_empresa);
    var cargo_id = $('#cargo').val(cargo_id).change();
    var direccion = $("#direccion").val(direccion);
    var email = $("#email").val(email);

    $("#Modalagregar").show();


}

$("#btnGuardar").on('click', function () {

    var errores = [];
    var identificacion = $("#identificacion").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var ciudad_id = $('#ciudad_id').val();
    var convencional = $("#convencional").val();
    var celular = $("#celular").val();
    var ing_empresa = $("#ing_empresa").val();
    var cargo = $('#cargo').val();
    var direccion = $("#direccion").val();
    var email = $("#email").val();


    if (identificacion.length < 1) {
        errores.push("\nidentitifacion");
    }
    if (nombres.length < 1) {
        errores.push("\nnombres");
    }
    if (apellidos.length < 1) {
        errores.push("\napellidos");
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
