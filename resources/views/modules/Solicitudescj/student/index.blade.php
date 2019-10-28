@extends('layouts.app')

@section('contentheader_title')
	JuridiCore
@endsection

@section('contentheader_description')
	Sistema Integrado 
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('javascript')
<script>

$("#btnvgverifica").on('click', function () {
	var b=0;
	var lugar=$("#lugar").val();
	var sup=$("#supervisor").val();
	var hor=$("#horario").val();

	if(lugar=='')
	{
		alert("Debe Completar el campo lugar!");
		b=1;
	}
	if(sup==''||sup==0)
	{
		alert("Debe Completar el campo Supervisor!");
		b=1;
	}
	if(hor=='')
	{
		alert("Debe Completar el campo horario!");
		b=1;
	}
	if(b==0)
	{
		document.getElementById("btnvgenv").click()
		
	}
});
$("#lugar").on('change', function () {

    $("#supervisor").html('');

    if (this.value != '') {

        var objApiRest = new AJAXRest('/supervisor', {
            valor: this.value,
        }, 'post');
        objApiRest.extractDataAjax(function (_resultContent) {
            if (_resultContent.status == 200) {

                $("#supervisor").append("<option value='0' selected='selected'>* SUPERVISOR *</option>");

                $.each(_resultContent.message, function (_key, _value) {
                    $("#supervisor").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
                });

            } else {
                alertToast("No hay supervisores asignados en la ubicacion escogida", 3500);
            }
        });

    }
});
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
            alert('El ruc de la empresa del sector público es incorrecto.', 3500);
            b = 1;
        }
        /* El ruc de las empresas del sector publico terminan con 0001*/
        if (numero.substr(9, 4) != '0001') {
            alert('El ruc de la empresa del sector público debe terminar con 0001', 3500);
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
            alert('El ruc de la empresa del sector privado  o Juridico debe terminar con 001', 3500);
            b = 1;
        }
        if (b == 0) {
            b = 3;
        }
    }

    else if (nat == true) {

        if (digitoVerificador != d10) {
            alert('El número de cédula de la persona natural es incorrecto.', 3500);

            b = 1;
        }
        if (numero.length > 10 && numero.substr(10, 3) != '001') {
            alert('El ruc de la persona natural debe terminar con 001', 3500);
            b = 1;
        }
        if (b == 0 && numero.length > 10) {
            b = 4;
        } else if (b == 0 && numero.length == 10) {
            b = 5;

        }

    }

return b;

}

function validarEmail(dato) {
	var valor=$('#'+dato+'').val();
	switch(dato)
	{
		case 'correo':
		if(!validar_emailtoc( valor ) )
		{
			alert("Verifique el email ingresado ,debe ingresar formato de correo valido ");
			$('#'+dato+'').val('');

		}
		break;
		default:
		if(!validar_emailto( valor ) )
		{
			alert("Verifique el email ingresado ,debe ingresar formato de correo institucional ");
			$('#'+dato+'').val('');

		}
		break;
	}
	
  }

function validar_emailto( email ) 
{
    var regex = /^([a-zA-Z0-9_\.\-])+\@ug.edu.ec/;
    return regex.test(email) ? true : false;
}
function validar_emailtoc( email ) 
{
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}
function verifica(dato) {

		var verifica = valida($('[name^="identificacion"]').val());
		if(verifica==5)
		{
			$("#dependencia").show();				
		}else{
			
			$("#dependencia").hide();	
		}
}

$(document).ready(function () {
    $(function () {
	var lugar=$("#lugar").val();
	var sup=$("#supervisor").val();
	var hor=$("#horario").val();
	var cc=$("#cc").val();
    document.getElementById('horario_fin').disabled=true;

			
	switch(cc)
	{
		case '0':
				$("#btnvgverificadiv").show();
				$("#divmensaje").hide();
				document.getElementById('lugar').disabled=false;
				document.getElementById('supervisor').disabled=false;
                document.getElementById('horario_inicio').disabled=false;
                document.getElementById('cant_horas').disabled=false;


		break;
	
		default:
				document.getElementById('lugar').disabled=true;
				document.getElementById('supervisor').disabled=true;
                document.getElementById('horario_inicio').disabled=true;
                document.getElementById('cant_horas').disabled=true;

				$("#btnvgverificadiv").hide();
				$("#divmensaje").show();
		break;
	}
      

    });
   
});

</script>

@endsection
@section('content')
<hr/>
<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Inicio</div>

					<div class="panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="tabbable" id="tabs-999753">
										<ul class="nav nav-tabs">
											<li class="nav-item active">
												<a class="nav-link active" href="#panel-717633" data-toggle="tab">Registro de Horario</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#panel-778868" data-toggle="tab">
                                                Perfil
                                                </a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane" id="panel-778868">
												<p>
												@include('frontend.partials.contenidov')
												</p>
											</div>
											<div class="tab-pane active" id="panel-717633">
												<p>
												@include('frontend.partials.contenidoasigna')
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection

