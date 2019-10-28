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
            "ajax": "/datatableasistencias/" ,
            "footerCallback":true,

            "columns": [
              
                {data: 'fecha', "width": "20%"},
				 {data: 'descripcion', "width": "40%"},

				{data: 'semana', "width": "10%"},
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
				
            ],
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                   
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                total
            );
			
			}
        }).ajax.reload();

</script>
<script>

    $("body").addClass("sidebar-collapse");

    $('#dtmenusemana').DataTable().destroy();
    $('#tbobymenusemana').html('');

    $('#dtmenusemana').show();
    $.fn.dataTable.ext.errMode = 'throw';
		var table=$('#dtmenusemana').DataTable(
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
            "ajax": "/datatablesemanas/" ,

            "columns": [
         
				{data: 'semana', "width": "10%"},
                {data: 'horas', "width": "10%"},
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
	@if(session('message'))
			alert('{{session("message")}}');
	@endif
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
					<div class="panel-heading">Registro de Actividades</div>

					<div class="panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
					<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable" id="tabs-345026">
				<ul class="nav nav-tabs">
					<li class="nav-item active">
						<a class="nav-link " href="#panel-559352" data-toggle="tab">Consulta</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#panel-321203" data-toggle="tab">Formularios</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel-559352">
						<table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
								<thead>

								<th>Fecha</th>
								<th>Descripcion</th>
								<th>Semana</th>
								<th>horas</th>
								<th>Opciones</th>
							

								</thead>
								<tbody id="tbobymenu">

								</tbody>
								 <tfoot>
									   <tr>
										   <th colspan="3" style="text-align:right">Total de horas:</th>
										   <th></th>
									   </tr>
								   </tfoot>
							</table>
								
					</div>
					<div class="tab-pane" id="panel-321203" >
					<table class="table table-bordered table-striped " id="dtmenusemana" style="width:50%!important">
								<thead>

								
								<th>Semana</th>
								<th>Horas</th>
								<th>Opciones</th>
							

								</thead>
								<tbody id="tbobymenusemana">

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
						</div>
					</div>
				</div>
			</div>
		</div>
@endif
@endsection

