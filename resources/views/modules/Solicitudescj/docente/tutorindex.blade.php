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
	if(hora_inicio==''||parseInt(hora_inicio)<9)
	{
		alert("Debe llenar una hora de entrada desde las 9:00 am");
		b=1;
	}
	
	if(b==0)
	{
		document.getElementById("enviarform").click();

	}

}

</script>
	
<script>

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
		"ajax": "/datatableEvaluacionesTutor/" ,

		"columns": [
	 
			{data: 'fecha_registro', "width": "10%"},
			{data: 'estudiante', "width": "10%"},

			{data: 'visita', "width": "10%"},
			{
                    data: 'Opciones',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Opciones).text();
                    }
             },
	
			
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
												<a class="nav-link active" href="#panel-717633" data-toggle="tab">Consulta Evaluaciones</a>
											</li>
											@if($sup>0)
											<li class="nav-item ">
												<a class="nav-link " href="#panel-778868" data-toggle="tab">
													 Evaluaciones
                                                </a>
											</li>
											@endif
										</ul>
										<div class="tab-content">
											@if($sup>0)
											<div class="tab-pane " id="panel-778868">
												<p>
												<form method="POST" action="{{ route ('tutor.evaluacionSave')}}" accept-charset="UTF-8">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">

												<table width="100%">
													<tr>
													<td>Estudiante</td>
												
													<td></td>
													</tr>
													<tr>
													<td>{!! Form::select('estudianteo', $objD, null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"estudianteo","placeholder"=>"ESTUDIANTES","name"=>"estudianteo","required"=>""]) !!}</td>
													<td><button type="submit"class="btn btn-primary" id="enviarform">Generar</button></td>
													</tr>
												</table>

												<table border=1 cellpadding=0 cellspacing=0 width="100%" class="letrapp">
													
													<tr height=20 style='height:15.0pt'>
													<td colspan=3 height=20 class=xl6330233 style='height:15.0pt'>VALORACIÓN</td>
													<td class=xl6330233 width=80 style='border-left:none;width:60pt'>SI/NO</td>
													<td>Observacion</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td colspan=2 rowspan=5 height=120 class=xl6430233
													style='height:90.0ptt'>VALORACIÓN AL ESTUDIANTE</td>
													<td class=xl6530233 width=452 style='border-top:none;border-left:none;
													width:339pt'>Realizo de manera satisfactoria sus PPP, en la institución
													receptora.</td>
														<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
														<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td height=20 class=xl6530233 width=452 style='height:15.0pt;border-top:none;
													border-left:none;width:339pt'>Cumplió con la planificación de PPP</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td height=20 class=xl6530233 width=452 style='height:15.0pt;border-top:none;
													border-left:none;width:339pt'>Se encuentra conforme con las actividades
													realizadas en las PPP</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=40 style='height:30.0pt'>
													<td height=40 class=xl6530233 width=452 style='height:30.0pt;border-top:none;
													border-left:none;width:339pt'>Considera que las PPP, realizadas en la
													insitución , contribuyen a la formación profesional del estudiante</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td height=20 class=xl6530233 width=452 style='height:15.0pt;border-top:none;
													border-left:none;width:339pt'>El ambiente laboral es adecuado para el
													desarrollo de las PPP</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','9'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='mso-height-source:userset;height:15.0pt'>
													<td colspan=2 rowspan=5 height=140 class=xl6430233 
													style='height:105.0pt'>VALORACIÓN CONJUNTA CON EL SUPERVISOR
													INSTITUCIONAL</td>
													<td class=xl6530233 width=600 style='border-top:none;border-left:none;
													width:339pt'>El estudiante cumplió con el horario establecido para las PPP</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=40 style='height:30.0pt'>
													<td height=40 class=xl6530233 width=600 style='height:30.0pt;border-top:none;
													border-left:none;width:339pt'>El comportamiento del estudiante estuvo acorde
													con las políticas de la empresa</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td height=20 class=xl6530233 width=600 style='height:15.0pt;border-top:none;
													border-left:none;width:339pt'>El estudiante se acopló al equipo de trabajo
													del departamento</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=20 style='height:15.0pt'>
													<td height=20 class=xl6530233 width=600 style='height:15.0pt;border-top:none;
													border-left:none;width:339pt'>El estudiante cumplió con las actividades
													asignadas</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													<tr height=40 style='height:30.0pt'>
													<td height=40 class=xl6530233 width=600 style='height:30.0pt;border-top:none;
													border-left:none;width:339pt'>Considera que el estudiante tiene los
													conocimientos necesarios , de acuerdo a su nivel académico</td>
													<td class=xl6330233 style='border-top:none;border-left:none'>&nbsp;{!! Form::select('opcion[]', ['1'=>'SI','0'=>'NO'], null,['class' => 'form-control select2',"style"=>"width:100%","name"=>"opcion[]"]) !!}</td>
													<td>
														<textarea name="ob1[]" class="form-control-t" id="ob1" rows="3"></textarea>
														</td>
													</tr>
													</table>



																										</form>
																									</p>
																								
																								<hr/>
									
											</div>
											@endif
											<div class="tab-pane active" id="panel-717633">
												<p>
												<div class="panel-body">
															<table class="table table-bordered table-striped " id="dtmenuo" style="width:100%!important" >
																<thead>

																<th>Fecha de Registro</th>
																<th>Estudiante</th>
																<th>Visita</th>
																<th>Opciones</th>
															

																</thead>
																<tbody id="tbobymenuo">

																</tbody>
															</table>
												</div>
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

