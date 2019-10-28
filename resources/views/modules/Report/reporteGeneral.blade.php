@extends('layouts.app')

@section('contentheader_title')
	Reporte General de Lotes (Facturación)
@endsection

@section('contentheader_description')
	
@endsection
@section('css')
	<link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ url('adminlte/plugins/orbPivot/') }}/dist/orb.css" />	
	<style>

		.orb-black .orb .fld-btn {
   			 background-color: #3781ad!important;
		}
		.orb-blue .orb-tlbr-sep {
			border-right: 1px solid #ffffff!important;
		}
		.orb-blue.orb-overlay {
			background-color: rgba(0, 0, 0, 0.75)!important;
		}
		.orb-overlay {
			z-index: 900!important;
		}
		.orb-blue .orb-dialog {
			top: 20px!important;
		}
	
		.orb-overlay-visible{
			overflow-x: auto!important;
  			min-height: 0.01%!important;
			width: 100%!important;
			margin-bottom: 15px!important;
		/*	overflow-y: hidden!important;*/
			-ms-overflow-style: -ms-autohiding-scrollbar!important;
			border: 1px solid #ddd!important;
		}
		.orb-black .orb-table th {
			background-color: #205482!important;
			border: 1px solid #ffffff!important;
		}
	</style>
@endsection
@section('javascript')

	<script type="text/javascript" src="{{ url('adminlte/plugins/orbPivot/') }}/deps/react-0.12.2.js"></script>
	<script type="text/javascript" src="{{ url('adminlte/plugins/orbPivot/') }}/dist/orb.js"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/orbPivot/') }}/demo.data.js"></script>

	<script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
	<script src="{{ url('js/modules/report/reporteGeneralFacturacion.js') }}"></script>

	<script>
        $('.pickadate').datepicker({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
            selectYears: true,
            editable: true,
            autoclose: true,
            orientation: 'top'
        });
		$(".orb").addClass('hidden');

	</script>

@endsection
@section('content')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">

				<div class="panel-body">
				
					<div class="col-lg-12">
						<div class="col-lg-2">
						
							{!! Form::text('fecha_inicio','',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Seleccione fecha ', ""]) !!}
						</div>
						<div class="col-lg-1">
							<i class="fa fa-calendar"></i>
						</div>
						<div class="col-lg-2">
							{!! Form::text('fecha_final','',['class'=>'form-control pickadate','id'=>'fechaf','placeholder'=>'Seleccione fecha ', ""]) !!}
						</div>
						<div class="col-lg-1">
							<i class="fa fa-calendar"></i>
						</div>
						<div class="col-lg-2">
							{!! Form::select('tipoReporte',$tipo,NULL,['class'=>'select2','placeholder'=>'SELECCIONE EL TIPO DE CONTENIDO','id'=>'tipoReporte']) !!}
						</div>

						<div class="col-lg-1">
							{!! Form::button('<b><i class="fa fa-sync"></i></b> Generar Reporte', array('type' => 'button', 'class' => 'btn btn-primary btn-xs','id' => "btnGuardar")) !!}
						</div>
					</div>
					<hr/>
													<div id="rr" style="padding: 7px;"></div>
				</div>
			</div>
		</div>
	</div>

@endsection