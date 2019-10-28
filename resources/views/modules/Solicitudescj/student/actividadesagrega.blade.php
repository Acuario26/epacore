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

<script type="text/javascript">
function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}
			
    </script>

@endsection
@section('content')
<hr/>
<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">Agregar Actividad</div>

					<div class="panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12 ">
									
						<div class="col-md-12">
							<div class=" panel panel-body col-md-12">

									<div class="col-md-12">
									<label>Fecha:</label>
										 {!! Form::text('fecha',$fecha,['class'=>'form-control','id'=>'fecha','disabled'=>'']) !!}

									</div>
					<form method="POST" action="{{ route ('estudiante.actividadSave')}}" accept-charset="UTF-8">

									<div class="col-md-12">
									<label>Descripcion (255 caracteres):</label>

									</div>
									<div class="col-md-12">
										  {!! Form::textarea('descripcion',null,[
										  
										  'class'=>'form-control-t','id'=>'descripcion',"maxlength"=>"255"]) !!}

									</div>
						
							
							</div>
													
								</div>
						
						  
				  <hr/>
							<div class="panel-body">
								
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" value="{{$id}}" name="id">

								
								<div class="col-md-12">
								
								<hr/>
	
									<button type="submit" class="btn btn-primary" value="1" name="btnvg">Enviar</button>
								</div>
								
							  </form>
							</div>
									
					
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection

