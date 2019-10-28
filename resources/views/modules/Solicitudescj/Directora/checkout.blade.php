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
$("body").addClass("sidebar-collapse");

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
		"ajax": "/datatablecheckout/" ,

		"columns": [
			{data: 'identificacion', "width": "10%"},
			{data: 'estudiante', "width": "20%"},
			{data: 'hsitu', "width": "10%"},
			{data: 'hacademicas', "width": "10%"},
			{data: 'hclinica', "width": "10%"},
			{data: 'htrabajoc', "width": "10%"},
			{data: 'capacitaciones', "width": "10%"},
		
			{
                    data: 'Opciones',
                    "width": "10%",
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
@if(isset($m))
	alert('{{$m}}');

	@endif
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
						<a class="nav-link" href="#tab1" data-toggle="tab">Consulta de Horas</a>
					</li>
				<!--	<li class="nav-item">
						<a class="nav-link" href="#tab2" data-toggle="tab">Nuevo Lugar</a>
					</li>-->
				</ul>
				<div class="tab-content">
					<!--<div class="tab-pane" id="tab2">
						<p>
						<form action="/upload" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<!Product name:
						<br />
						<input type="text" name="name" />
						<br /><br />
						<h3>Fotos (Puede Agregar de 1 en adelante):</h3>
						<hr />
						<input type="file" class="form-control" name="photos[]" multiple required />
						<br /><br />
						<button type="submit" class="btn btn-primary">Subida de Fotos</button>
					</form>						</p>
					</div>-->
					<div class="tab-pane active" id="tab1">

<div class="table-responsive"> 
														<table class="table table-bordered table-striped " id="dtmenue" style="width:100%!important" >
																<thead>
																<th>Identificacion</th>
																<th>Estudiante</th>
																<th>Horas/Situ</th>
																<th>Horas/Académicas</th>
																<th>Horas/Clinica</th>
																<th>Horas/trabajo</th>
																<th>Horas/capacitaciones</th>
																<th>Opciones</th>
															

																</thead>
																<tbody id="tbobymenue">

																</tbody>
</div>														</table>
						
					</div>
				</div>
			</div>
		</div>	

					</div>
				</div>
			</div>
		</div>

@endsection

