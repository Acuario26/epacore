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
	@if(isset($m))
	alert('{{$m}}');

	@endif

</script>
<script type="text/javascript">
$("#estudianteo").on('change', function () {

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
});
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
var hora_inicio=$("#horario_inicio").val().split(":")[0];

	if(fecha_registro=='')
	{
		alert("Debe llenar la fecha de la asistencia");
		b=1;
	}
	//if(hora_inicio==''||parseInt(hora_inicio)<9)
//	{
//		alert("Debe llenar una hora de entrada desde las 9:00 am");
//		b=1;
//	}
	
	if(b==0)
	{
		document.getElementById("enviarform").click();

	}

}
$(document).on('change', '.chkView', function() {
    $(this).closest('tr').find('.inputdis').prop('disabled', !this.checked);
});

</script>
	<script>
		$(document).ready(function(){
			$('.inputdis').prop('disabled', true);
			
		});
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
		"order": [[6, 'ASC']],
		"searching": true,
		"info": true,
		"ordering": true,
		"bPaginate": true,
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"destroy": true,
		"ajax": "/datatableAsistencia/" ,

		"columns": [
	 
			{data: 'fecha', "width": "10%"},
			{data: 'estudiante', "width": "10%"},

			{data: 'semana', "width": "10%"},
			{data: 'hora_inicio', "width": "10%"},
			{data: 'hora_fin', "width": "10%"},
			{data: 'horas', "width": "10%"},


			{
				data: 'Estado',
				"width": "20%",
				"bSortable": true,
				"searchable": true,
				"targets": 0,
				"render": function (data, type, row) {
					return $('<div />').html(row.Estado).text();
				}
			},
			
		]
	}).ajax.reload();


$("body").addClass("sidebar-collapse");

$('#dtmenuo').DataTable().destroy();
$('#tbobymenuo').html('');

$('#dtmenuo').show();
$.fn.dataTable.ext.errMode = 'throw';
	var table=$('#dtmenuo').DataTable(
	{

		dom: 'lfrtip',

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
		"ajax": "/datatableObservaciones/" ,

		"columns": [
	 
			{data: 'fecha_registro', "width": "10%"},
			{data: 'estudiante', "width": "10%"},

			{data: 'semana', "width": "10%"},
			{data: 'observacion', "width": "10%"},
	
			
		]
	}).ajax.reload();



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
												<a class="nav-link active" href="#panel-717633" data-toggle="tab">Reporte de Asistencia</a>
											</li>
											@if($sup>0)
											<li class="nav-item">
												<a class="nav-link" href="#asistencia" data-toggle="tab">
													Registro de Asistencia
                                                </a>
											</li>
										@endif
										@if($sup>0)
											<li class="nav-item">
												<a class="nav-link" href="#panel-778868" data-toggle="tab">
													Observaciones Semanales
                                                </a>
											</li>
										@endif
										</ul>
										<div class="tab-content">
										@if($sup>0)
											<div class="tab-pane" id="panel-778868">
												<p>
												<form method="POST" action="{{ route ('supervisor.observacionSave')}}" accept-charset="UTF-8">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">

												<table width="100%">
													<tr>
													<td>Estudiante</td>
													<td>Semana</td>
													<td>Observacion</td>
													<td>Opciones</td>
													</tr>
													<tr>
													<td>{!! Form::select('estudianteo', $objD, null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"estudianteo","placeholder"=>"ESTUDIANTES","name"=>"estudianteo"]) !!}</td>
													<td>{!! Form::select('se', [], null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"se","name"=>"se"]) !!}</td>
													<td>{!! Form::textarea('observacion', null,['class' => 'form-control-t',"style"=>"width:100%","id"=>"observacion","name"=>"observacion"]) !!}</td>
													<td><button type="submit"class="btn btn-primary" id="enviarform2">Enviar</button></td>
													</tr>
													</table>
													</form>
												</p>
											
											<hr/>
												<div class="panel-body">
																<table class="table table-bordered table-striped " id="dtmenuo" style="width:100%!important" >
																	<thead>

																	<th>Fecha de Registro</th>
																	<th>Estudiante</th>
																	<th>Semana</th>
																	<th>Observacion</th>
																

																	</thead>
																	<tbody id="tbobymenuo">

																	</tbody>
																</table>
												</div>
											</div>
										@endif
											<div class="tab-pane active" id="panel-717633">
											<br/>	
											<div class="col-md-5">
											<form method="POST" target="_blank" action="{{ route ('imprimirAsistencia')}}" accept-charset="UTF-8">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<div class="col-md-6"><strong>MES:</strong></div>
												<div class="col-md-6">
												{!! Form::select('mes',
												[
												'ENERO'=>'ENERO',
												'FEBRERO'=>'FEBRERO',
												'MARZO'=>'MARZO',
												'ABRIL'=>'ABRIL',
												'MAYO'=>'MAYO',
												'JUNIO'=>'JUNIO',
												'JULIO'=>'JULIO',
												'AGOSTO'=>'AGOSTO',
												'SEPTIEMBRE'=>'SEPTIEMBRE',
												'OCTUBRE'=>'OCTUBRE',
												'NOVIEMBRE'=>'NOVIEMBRE',
												'DICIEMBRE'=>'DICIEMBRE'		
												]
												, null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"mes","placeholder"=>"mes","name"=>"mes","required"=>"required"]) !!}
												</div>
												<div class="col-md-6"><strong>ESTUDIANTE:</strong></div>
												<div class="col-md-6">
												{!! Form::select('estudianteo', $objD, null,["required"=>"required",'class' => 'form-control select2',"style"=>"width:100%","id"=>"estudianteo","placeholder"=>"ESTUDIANTES","name"=>"estudianteo"]) !!}
												</div>
												</div>

												<div class="col-md-2">
												</div>
											
												<button type="submit"class="btn btn-primary" id="enviarform3">Imprimir Asistencia</button>
											</form>

													<br/>
												<p>
												@include('modules.Solicitudescj.docente.asistencia')
												</p>
											</div>
										@if($sup>0)
											<div class="tab-pane" id="asistencia">
												<p>
												@include('modules.Solicitudescj.docente.asistenciaRegistro')
												</p>
											</div>

										@endif
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

