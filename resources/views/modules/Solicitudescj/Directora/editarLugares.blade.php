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
						<a class="nav-link" href="#tab2" data-toggle="tab">Editar Lugar</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab2">
						<p>
						<form action="/saveLugar" method="post">
						{{ csrf_field() }}
						<br />
						{!! Form::hidden('id',$obj->id,['class'=>'form-control','id'=>'id']) !!}
						
						<div class="col-md-2">
						Descripcion:
						</div>
						<div class="col-md-4">
						{!! Form::text('descripcion',$obj->descripcion,['class'=>'form-control','id'=>'descripcion']) !!}

						</div>
						<div class="col-md-2">
						Estado:
						</div>
						<div class="col-md-2">
						{!! Form::select('estado',['A'=>'ACTIVO','I'=>'INACTIVO'],$obj->estado,['class'=>'form-control select2','id'=>'estado']) !!}
						</div>
						<br /><hr />
						<div class="col-md-12">
						<div class="col-md-2" style="text-align:center">
						<button type="submit" class="btn btn-primary">Grabar datos</button>
						</div>
					</form>	
					<div class="col-md-2">
										
					<a href="{{route('admin.placeIndex')}}" class="btn btn-danger">Cancelar</a>
					</div>
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

@endsection

