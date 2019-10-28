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
	.containerll {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 18px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.containerll input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.containerll:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.containerll input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.containerll input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.containerll .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
	</style>
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
						<a class="nav-link" href="#tab2" data-toggle="tab">Checkout</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab2">
						<p>
						<form action="/savecheckout" method="post">
						{{ csrf_field() }}
						<br />
						{!! Form::hidden('id',$id,['class'=>'form-control','id'=>'id']) !!}
						<strong>Estudiante: </<strong>{{$result->estudiante}}
						<hr/>
						<table border="1" width="100%">
						<tr>
						<td>CONCEPTO</td>
						<td>LUGAR</td>
						<td>N° DE HORAS</td>
						<td>DETALLE</td>
						<td>DURACION</td>
				

						</tr>
						<tr>
						<td>HORAS EN SITU</td>
						<td>CONSULTORIO ASISGNADO</td>
						<td>2 HORAS DIARIAS X 16 SEMANAS</td>
						<td>ASESORIAS Y PATROCINIOS EN LOS CONSULTORIOS JURÍDICOS BAJO LAS TUTORÍAS DE 
						LOS ABOGADOS ESPECIALISTAS</td>
						<td><label class="containerll">160 
						@if($result->hsitu!=0)
						<input type="checkbox" class="" name="hsitu" checked>

						@endif
						@if($result->hsitu==0)
						<input type="checkbox" class="" name="hsitu">

						@endif

						<span class="checkmark"></span>
						</label>
						 </td>
						

						</tr>
						<tr>
						<td>HORAS ACDÉMICAS</td>
						<td>TUTORÍAS ACADÉMICAS</td>
						<td>5 HORAS DIARIAS X 16 SEMANAS</td>
						<td>TUTORÍAS ACADÉMICAS BAJO LAS TUTORÍAS DE 
						LOS DOCENTES DE LA UNIVERSIDAD</td>
						<td><label class="containerll">80
						@if($result->hacademicas!=0)
						<input type="checkbox" class="" name="hacademicas" checked>

						@endif
						@if($result->hacademicas==0)
						<input type="checkbox" class="" name="hacademicas">

						@endif
						<span class="checkmark"></span>
						</label>
						</td>

						</tr>
						<tr>
						<td>HORAS EN CLÍNICA JURÍDICA MÓVIL</td>
						<td>ASESORÍAS MÓVILES</td>
						<td>10 HORAS DIARIAS X 16 SEMANAS</td>
						<td>DILEGENCIAS EN DONDE LOS ESTUDIANTES SE TRASLADAN PARA REALIZAR SUS PRÁCTICAS EN TIEMPO REAL</td>
						<td><label class="containerll">100
						@if($result->hclinica!=0)
						<input type="checkbox" class="" name="hclinica" checked>
						@endif
						@if($result->hclinica==0)
						<input type="checkbox" class="" name="hclinica" >

						@endif
						<span class="checkmark"></span>
						</label>
						</td>

						</tr>
						<tr>
						<td>HORAS EN TRABAJO DE CAMPO</td>
						<td>AUDIENCIAS,IMPULSOS,DILEGENCIAS EN GENERAL</td>
						<td>50 HORAS DIARIAS X 16 SEMANAS EN FUNCIÓN DE LOS PROCESOS QUE MANEJE CADA TUTOR-ABOGADO</td>
						<td>CLÍNICAS MÓVILES SE BRINDARÁN ASESORÍAS BAJO LA SUPERVISIÓN DE LOS TUTORES 
						ABOGADOS ESPECIALISTAS</td>
						<td><label class="containerll">80
						@if($result->htrabajoc==0)

						<input type="checkbox" class="" name="htrabajoc" >
						@endif
						@if($result->htrabajoc!=0)

						<input type="checkbox" class="" name="htrabajoc" checked>
						@endif
						<span class="checkmark"></span>
						</label></td>

						</tr>
						<tr>
						<td>CAPACITACIONES , SEMINARIOS, CONVERSATORIOS</td>
						<td>ASESORÍAS MÓVILES</td>
						<td>50 HORAS DESTINADAS A EVENTOS ACADÉMICOS ORGANIZADOS DURANTE EL PROCESO DE LAS 16 SEMANAS</td>
						<td>EVENTOS ACADÉMICOS ORGANIZADOS POR LOS TUTORES ACADÉMICOS Y EL CONSULTORIO JURÍDICO GRATUITO UG</td>
						<td><label class="containerll">80 
						@if($result->capacitaciones==0)

						<input type="checkbox" class="" name="capacitaciones">
						@endif
						@if($result->capacitaciones!=0)

						<input type="checkbox" class="" name="capacitaciones" checked>
						@endif
						<span class="checkmark"></span>
						</label></td>

						</tr>
						</table>
						
						<br /><hr />
						<div class="col-md-12">
						<div class="col-md-2" style="text-align:center">
						<button type="submit" class="btn btn-primary">Grabar datos</button>
						</div>
					</form>	
					<div class="col-md-2">
										
					<a href="{{route('all.checkout')}}" class="btn btn-danger">Cancelar</a>
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

