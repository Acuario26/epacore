@extends('layouts.app')
@section('contentheader_title')
    Juridicore
@endsection

@section('contentheader_description')
    Gestion de Asistencia
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
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
        function validarform(){

var b=0;
var fecha_registro=$("#fecha_registro").val();
var hora_inicio=$("#horario_inicio").val().split(":")[0];

	if(fecha_registro=='')
	{
		alert("Debe llenar la fecha de la asistencia");
		b=1;
	}
	if(hora_inicio==''||parseInt(hora_inicio)<9)
	{
		alert("Debe llenar una hora de entrada desde las 9:00 am");
		b=1;
	}
	
	if(b==0)
	{
		document.getElementById("enviarform").click();

	}

}

    </script>
@endsection

@section('content')
    <hr/>
    <div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">Inicio</div>

					<div class="panel-body">
                    <form method="POST" action="{{ route ('d.saveEditAsistencia')}}" accept-charset="UTF-8">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-md-12">
<div class="col-md-2">
Fecha/Registro:
</div>
<div class="col-md-12">
{!! Form::date('fecha_registro', $objD->fecha,['class' => 'form-control','placeholder'=>'fecha_registro',"style"=>"width:100%","id"=>"fecha_registro","name"=>"fecha_registro"]) !!}
</div>

<div class="col-md-12">
</div>
<div style="display:none">
<button type="submit"class="btn btn-primary" id="enviarform">Enviar</button>
</div>



</div>


<input type="hidden" value="{{$objD->id}}" name="id" id="id">
<input type="hidden" value="{{$objD->user_id}}" name="user_id" id="user_id">

<div class="col-md-12"> 
<div class="col-md-12">
Semana:</div><div class="col-md-12">
<input type="text" value="{{$semana}}" class="form-control" name="semana" id="semana" onkeypress="return soloNumeros1_99(event)" maxlength="2">
</div>
<div class="col-md-12">
Hora de Inicio:</div><div class="col-md-12">
<input type="time" value="{{$objD->hora_inicio}}" id="horario_inicio" name="hora_inicio[{{$objD->id}}]" step="3600" onclick="agregahora({{$objD->id}})" onkeyup="agregahora({{$objD->id}})" min="9:00" max="15:00" required />
</div>
<div class="col-md-12">
Horas de Trabajo(0-6):</div><div class="col-md-12">
<input type="text"value="{{$objD->horas}}" value="0" id="cant_horas"  name="cant_horas[{{$objD->id}}]" onkeyup="agregahora({{$objD->id}})" onKeypress="return soloNumeros0_6(event)" maxlength="1" required />
</div>
<div style="display:none">
<input type="time" value="{{$objD->hora_fin}}" id="idhf" name="hf[{{$objD->id}}]"/></div>
<div class="col-md-12">
Hora final:</div><div class="col-md-12">
<input type="time" value="{{$objD->hora_fin}}" id="horario_fin" name="hora_fin[{{$objD->id}}]" disabled />
<hr/>
</div>

</div>

<span class="btn btn-primary" onclick="validarform()">Enviar</span>
<a class="btn btn-danger" href="{{route('supervisor.asistencia')}}">Cancelar</a>

<hr/>
</form>

					</div>
				</div>
			</div>
		</div>

@endsection
