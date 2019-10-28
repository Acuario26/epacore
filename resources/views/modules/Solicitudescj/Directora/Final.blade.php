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
function mensaje(id){
	console.log(id);
	swal({
  title:  "Motivo de Negado!" ,
  text: "Escribir Motivo Negado:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Escribir motivo"
},
function(inputValue){
  if (inputValue === false) 
  return false;

  if (inputValue === "") {
    swal.showInputError("Necesitas escribir un motivo!");
    return false
  }

var objApiRest = new AJAXRest('/allnegarPdf', {
	id: id ,descripcion:inputValue
}, 'post');
objApiRest.extractDataAjax(function (_resultContent) {
	if (_resultContent.status == 200) {

		  swal("Bien!", "Tu motivo fue enviado: " + inputValue, "success");
		  location.reload();
	} else {
		alertToast("Algo ocurrio vuelva a intentarlo", 3500);
	}
});


});
}

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
		"order": [[1, 'asc']],
		"searching": true,
		"info": true,
		"ordering": true,
		"bPaginate": true,
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"destroy": true,
		"ajax": "/datatableAllFinal/" ,

		"columns": [
			{data: 'fecha_registro', "width": "20%"},

			{data: 'estudiante', "width": "40%"},
			{
                    data: 'Estados',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Estados).text();
                    }
             },

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
					@if($cc)

					<div class="alert alert-warning" id="divmensaje">
					
												Aun no tiene las 160 horas
					</div>
					@endif
					@if(!$cc)
					<li class="nav-item active">
						<a class="nav-link" href="#tab1" data-toggle="tab">Consulta de Proceso Final</a>
					</li>
					@if($estudiante)
						@if(!$countEs)
					<li class="nav-item">
						<a class="nav-link" href="#tab2" data-toggle="tab">Subida de Información</a>
					</li>
						@endif
					@endif
					@endif
				</ul>
				<div class="tab-content">
				
					<div class="tab-pane" id="tab2">
						<p>
						<form action="/uploadFinal" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						<strong>Archivo en pdf final para aprobación</strong>
						<hr />
						<input type="file" class="form-control" name="archivo"accept=".pdf" required />
						<br /><br />
						<button type="submit" class="btn btn-primary">Subida de Datos</button>
					</form>						</p>
					</div>
					<div class="tab-pane active" id="tab1">
<br/>

														<table class="table table-bordered table-striped " id="dtmenue" style="width:100%!important" >
																<thead>
																<th>Fecha/Registro</th>

																<th>Estudiante</th>
																<th>Estado</th>
																<th>Opciones</th>
															

																</thead>
																<tbody id="tbobymenue">

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

