@extends('layouts.app')

@section('contentheader_title')
	JuridiCore
@endsection

@section('contentheader_description')
	Sistema Integrado de PublyNext
@endsection

@section('content')
@section('css')
	<link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ url('adminlte/plugins/pivot/') }}/pivot.css" rel="stylesheet">
	<link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">

@endsection
@section('javascript')
	<script src="{{ url('js/modules/report/report.js') }}"></script>
	<script src="{{ url('adminlte/plugins/pivot/') }}/pivot_link.js"></script>
	<script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>

	<script>
        $('.pickadate').datepicker({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
            selectYears: true,
            editable: true,
            autoclose: true,
            orientation: 'top'
        });

	</script>
@endsection
<hr/>

<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class=" modal-dialog" style="width:100%" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Detalle</h4>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<div id="output2" style="margin: 30px;"></div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="text-align: center;">
					{!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">

		<div class="panel panel-default">

			<div class="panel-body">
				<div class="col-lg-12">
				<div class="col-lg-2">

					{!! Form::text('fecha_inicio',' ',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Seleccione fecha ', ""]) !!}

				</div>
				<div class="col-lg-1">
					<i class="fa fa-calendar"></i>
				</div>
				<div class="col-lg-2">

					{!! Form::text('fecha_final',' ',['class'=>'form-control pickadate','id'=>'fechaf','placeholder'=>'Seleccione fecha ', ""]) !!}

				</div>
				<div class="col-lg-1">
					<i class="fa fa-calendar"></i>

				</div>
					<div class="col-lg-1">
						{!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
					</div>
				</div>
				<hr/>
				<div id="output" style="margin: 30px;"></div>
			</div>
		</div>
	</div>
</div>

@endsection