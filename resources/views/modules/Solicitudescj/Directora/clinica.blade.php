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
@if(isset($m))
	alert('{{$m}}');

	@endif
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
		"order": [[1, 'desc']],
		"searching": true,
		"info": true,
		"ordering": true,
		"bPaginate": true,
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"destroy": true,
		"ajax": "/datatableClinica/" ,

		"columns": [
	 
			{data: 'Identificacion', "width": "40%"},
			{data: 'Estudiante', "width": "10%"},
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
					<div class="panel-heading">Evidencia de Practicas Pre profesionales</div>
					<div class="panel-body">

			<div class="col-md-12">
			<div class="tabbable" id="tabs-670358">
				<ul class="nav nav-tabs">
				    <li class="nav-item active">
						<a class="nav-link active" href="#tab3" data-toggle="tab">Consulta Clinica</a>
					</li>
			
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab3">
					<table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
								<thead>

								<th>Identificacion</th>
								<th>Estudiante</th>
								<th>Opciones</th>

							

								</thead>
								<tbody id="tbobymenu">

								</tbody>
								
							</table>
					</div>
				
				</div>
			</div>
		</div>	

					</div>
				</div>
			</div>
		</div>

@endsection

