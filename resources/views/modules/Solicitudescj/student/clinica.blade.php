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
@if($cc!=2)

<div class="alert alert-{{$tipoM}}" id="divmensaje">
 
								  {{$message}}.
</div>
@endif
@if($cc==2)
<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Evidencia de Practicas Pre profesionales</div>
					<div class="panel-body">

			<div class="col-md-12">
			<div class="tabbable" id="tabs-670358">
				<ul class="nav nav-tabs">
				   
					<li class="nav-item active">
						<a class="nav-link" href="#tab1" data-toggle="tab">Subida de Fotos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#tab2" data-toggle="tab">Galeria de Fotos</a>
					</li>

				</ul>
				<div class="tab-content">
				
					<div class="tab-pane active" id="tab1">
						<p>
						<form action="/upload" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<!--Product name:
						<br />
						<input type="text" name="name" />
						<br /><br />-->
						<h3>Agregar Fotos:</h3>
						<hr />
						<input type="file" class="form-control" name="photos[]" required />
						<br /><br />
						<button type="submit" class="btn btn-primary">Subida de Fotos</button>
					</form>						</p>
					</div>
					<div class="tab-pane" id="tab2">
					@foreach($images as $image)
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-body">
								<img src="/storage/{{$image->filename}}" class="img-responsive">
								</div>
								<div class="panel-footer">
								<form method="POST" action="{{ route ('student.deleteFoto')}}" accept-charset="UTF-8">
								<input type="hidden" value="{{$image->filename}}" name="filename">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
								<button type="submit" class="btn btn-danger btn-sm fa fa-trash"></button>
								</form>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>	

					</div>
				</div>
			</div>
		</div>
@endif
@endsection

