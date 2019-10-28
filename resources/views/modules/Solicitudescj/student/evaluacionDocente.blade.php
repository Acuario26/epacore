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
	}
.letrap{
		font-size:12px;
}
.letrapp{
		font-size:11px;
}
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
		"ajax": "/datatableEvaluacionesTutorEst/" ,

		"columns": [
	 
			{data: 'fecha_registro', "width": "10%"},
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

<script>

$('#dtmenue').DataTable().destroy();
$('#tbobymenue').html('');

$('#dtmenue').show();
$.fn.dataTable.ext.errMode = 'throw';
	var table=$('#dtmenue').DataTable(
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
		"ajax": "/datatableEvaluacionesSupEst/" ,

		"columns": [
	 
			{data: 'fecha_registro', "width": "10%"},
			{data: 'estudiante', "width": "10%"},

			{data: 'total', "width": "10%"},
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
												<a class="nav-link active" href="#panel-717633" data-toggle="tab">Consulta Evaluacion Tutor</a>
											</li>
									
                    	<li class="nav-item ">
												<a class="nav-link " href="#panel-778868" data-toggle="tab">
                        Consulta Evaluacion Supervisor
                                                </a>
											</li>
                 
										</ul>
										<div class="tab-content">
											<div class="tab-pane " id="panel-778868">
												<p>
												<table class="table table-bordered table-striped " id="dtmenue" style="width:100%!important" >
																<thead>

																<th>Fecha de Registro</th>
																<th>Estudiante</th>
																<th>Total</th>
																<th>Opciones</th>
															

																</thead>
																<tbody id="tbobymenue">

																</tbody>
															</table>

												</p>
											
											<hr/>
									
												</div>
											<div class="tab-pane active" id="panel-717633">
												<p>
												<div class="panel-body">
                         <table class="table table-bordered table-striped " id="dtmenuo" style="width:100%!important" >
																<thead>

																<th>Fecha de Registro</th>
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

