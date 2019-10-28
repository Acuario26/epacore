<form method="POST" action="{{ route ('supervisor.asistenciaSave')}}" accept-charset="UTF-8">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-md-12">
<div class="col-md-2">
Fecha/Registro:
</div>
<div class="col-md-2">
{!! Form::date('fecha_registro', null,['class' => 'form-control','placeholder'=>'fecha_registro',"style"=>"width:100%","id"=>"fecha_registro","name"=>"fecha_registro"]) !!}
</div>

<div class="col-md-2">
</div>
<div style="display:none">
<button type="submit"class="btn btn-primary" id="enviarform">Enviar</button>
</div>

<span class="btn btn-primary" onclick="validarform()">Enviar</span>
<hr/>
</div>
<table width="100%" border="1">
<tr>

<strong>
<td></td>
<td>Estudiante</td>
<td>Semana</td>
<td>Hora/Entrada</td>
<td>Horas/trabajo(0-6)</td>
<td>Hora/Salida</td>
</strong>
</tr>

@foreach($objD as $key => $value)

<tr>
		<td>
        <input type="checkbox" value="{{$key}}" class="chkView" name="estudianteid[{{$key}}]">
        </td>				
<td>
<!--<input type="hidden" value="{{$key}}" name="estudianteid[]" id="estudianteid">-->
<input type="text" value="{{$value}}" class="form-control inputdis" name="estudiante[]" id="estudiante">

</td>	
<td>
<input type="text" value="1" class="form-control inputdis" name="semana[{{$key}}]" id="semana" onkeypress="return soloNumeros1_99(event)" maxlength="2">

</td>
<td>
<input type="time" class="inputdis" id="horario_inicio" name="hora_inicio[{{$key}}]" step="3600" onclick="agregahora({{$key}})" onkeyup="agregahora({{$key}})" min="9:00" max="15:00" required />
</td>
<td>
<input type="text" class="inputdis" value="0" id="cant_horas"  name="cant_horas[{{$key}}]" onkeyup="agregahora({{$key}})" onKeypress="return soloNumeros0_6(event)" maxlength="1" required />
</td>
<td>
<div style="display:none">
<input type="time" class="inputdis" id="idhf" name="hf[{{$key}}]"/></div>
<input type="time"  id="horario_fin" name="hora_fin[{{$key}}]" disabled />

</td>

</form>


</tr>
@endforeach
</table>
