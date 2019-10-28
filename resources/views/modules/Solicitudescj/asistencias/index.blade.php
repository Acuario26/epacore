@extends('layouts.app')

@section('contentheader_title')
	JuridiCore
@endsection

@section('contentheader_description')
	Sistema Integrado 
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
	<style>
	a.tooltips {
  position: relative;
  display: inline;
}
a.tooltips span {
  position: absolute;
  width:140px;
  color: #FFFFFF;
  background: #139C8E;
  border: 2px solid #6D6D6D;
  height: 99px;
  line-height: 99px;
  text-align: center;
  visibility: hidden;
  border-radius: 23px;
}
a.tooltips span:before {
  content: '';
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -12px;
  width: 0; height: 0;
  border-right: 12px solid #6D6D6D;
  border-top: 12px solid transparent;
  border-bottom: 12px solid transparent;
}
a.tooltips span:after {
  content: '';
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -8px;
  width: 0; height: 0;
  border-right: 8px solid #139C8E;
  border-top: 8px solid transparent;
  border-bottom: 8px solid transparent;
}
a:hover.tooltips span {
  visibility: visible;
  opacity: 1;
  left: 100%;
  top: 50%;
  margin-top: -49.5px;
  margin-left: 15px;
  z-index: 999;
}
	</style>

@endsection
@section('javascript')
<script>
	@if(($m))
	alert('{{$m}}');

	@endif

</script>
<script type="text/javascript">
/*$("#estudianteo").on('change', function () {

$("#se").html('');

if (this.value != '') {

	var objApiRest = new AJAXRest('/semanaEstudiaante', {
		valor: this.value,
	}, 'post');
	objApiRest.extractDataAjax(function (_resultContent) {
		if (_resultContent.status == 200) {

			$("#se").append("<option value='0' selected='selected'>* SEMANAS *</option>");

			$.each(_resultContent.message, function (_key, _value) {
				$("#se").append("<option value='" + _value.id + "'>" + _value.descripcion + "</option>")
			});

		} else {
			alertToast("No hay semanas pendientes", 3500);
			$("#se").val('').change();
		}
	});

}
});*/
function confirma(e,v){
	var bool=confirm("Actividad:"+e);
	if(bool)
	{
		document.getElementById("envio"+v).click();
	}
	
}	
		
function validarform(){

var b=0;
var fecha_registro=$("#fecha_registro").val();
//var hora_inicio=$("#horario_inicio").val().split(":")[0];

	if(fecha_registro=='')
	{
		alert("Debe llenar la fecha de la asistencia");
		b=1;
	}
	//if(hora_inicio==''||parseInt(hora_inicio)<9)
	//{
	//	alert("Debe llenar una hora de entrada desde las 9:00 am");
	//	b=1;
	//}
	
	if(b==0)
	{
		document.getElementById("enviarform").click();

	}

}

</script>
	
<script>

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
	  
	  
		"lengthMenu": [[10, -1], [10, "All"]],
		"order": [[5, 'ASC']],
		"searching": true,
		"info": true,
		"ordering": true,
		"bPaginate": true,
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"destroy": true,
		"ajax": "/datatableAsistenciaMonitor/" ,

		"columns": [
	 
			{data: 'fecha', "width": "20%"},
			{data: 'estudiante.name', "width": "20%"},

		    /*{data: 'fecha', "width": "10%"},*/
			{data: 'hora_inicio', "width": "20%"},
			{data: 'hora_fin', "width": "20%"},
			{data: 'horas', "width": "10%"},		

			{
				data: 'estado_label',
				"width": "10%",
				"bSortable": true,
				"searchable": true,
			},

			{data: 'firma', "width": "20%"},

			
		],
		dom: 'lBfrtip',
            buttons: [
	              {
                  extend: 'excel',
                  text: 'Imprimir',
                  filename : 'Asistencias',
                  exportOptions: {
                      modifier: {
                          page: 'current'
                      },
                      columns: [ 0, 1, 2, 3, 6 ]
                  }
              },
          ],
	});


$("body").addClass("sidebar-collapse");

//$

$(document).on('change', '.chkView', function() {
    $(this).closest('tr').find('.inputdis').prop('disabled', !this.checked);
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
									
							        <form method="POST" action="{{ route ('monitor.asistenciaSave')}}" accept-charset="UTF-8">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="col-md-12">
									<div class="col-md-2">
									Fecha/Registro:
									</div>
									<div class="col-md-2">
									{!! Form::date('fecha_registro', null,['class' => 'form-control','placeholder'=>'fecha_registro',"style"=>"width:100%","id"=>"fecha_registro","name"=>"fecha_registro"]) !!}
									</div>
									<!--<div class="col-md-2">
									Semana:
									</div>
									<div class="col-md-2">
									{!! Form::text('semana','1',['class' => 'form-control',"style"=>"width:100%","id"=>"semana","name"=>"semana","maxlength"=>"2","onKeypress"=>"return soloNumeros1_99(event)"]) !!}
									</div>-->
									<div style="display:none">
									<button type="submit"class="btn btn-primary" id="enviarform">Enviar</button>
									</div>

									<span class="btn btn-primary" onclick="validarform()">Enviar</span>
									<hr/>
									</div>
									<table width="100%" border="1">
									<tr>

									<strong>
									<td>Estudiante</td>
									<td>Hora/Entrada</td>
									<td>Horas/trabajo(0-6)</td>
									<td>Hora/Salida</td>
									<td></td>									
									</strong>
									</tr>

									@foreach($objD as $key => $value)

									<tr id="tr{{$key}}">
															
									<td>
									{!! Form::hidden('estudianteid', $key,['class' => 'form-control',"style"=>"width:100%","id"=>"estudianteid","name"=>"estudianteid[]"]) !!}

									{!! Form::text('estudiante', $value,['class' => 'form-control inputdis',"style"=>"width:100%","id"=>"estudiante","name"=>"estudiante[]",'disabled']) !!}

									</td>	
									<td>
									<input type="time"  id="horario_inicio" name="hora_inicio[{{$key}}]" step="3600" onclick="agregahora({{$key}})" class="inputdis" onkeyup="agregahora({{$key}})" min="9:00" max="15:00" required disabled="" />
									</td>
									<td>
									<input type="number" value="0" id="cant_horas"  name="cant_horas[{{$key}}]" onkeyup="agregahora({{$key}})" class="inputdis" {{--onKeypress="return soloNumeros0_6(event)"--}} max="6" maxlength="1" required disabled="" />
									</td>
									<td>
									<div style="display:none">
									<input type="time" class="inputdis"  id="idhf" name="hf[{{$key}}]"/></div>
									<input type="time"  id="horario_fin" name="hora_fin[{{$key}}]" disabled />

									</td>
									<td ><input type="checkbox" class="chkView"/><td>

									</form>


									</tr>
									@endforeach
									</table>

									<br><br>

									<table class="table table-bordered table-striped " id="dtmenu" style="width:1000px;!important" >
					                  <thead>

					                  <th>Fecha de Asistencia</th>
					                  <th>Estudiante</th>
									  <!--<th>Semana</th>-->
					                  <th>Hora de inicio</th>
					                  <th>Hora de salida</th>
									  <th>Cantidad/Hora</th>

					                  <th>Estado</th>
					                  <th>Firma Estudiante</th>

					                  </thead>
					                  <tbody id="tbobymenu">

					                  </tbody>
					              	</table>

					              	<br><br>									
											
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection

