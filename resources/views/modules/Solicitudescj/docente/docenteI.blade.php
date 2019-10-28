
<!DOCTYPE html>
<html lang="es">
<head>
@include('frontend.partials.head')

</head>

<body>
<p>
CONTROL DE ASISTENCIA DIARIA DE LOS ESTUDIANTES QUE SE ENCUENTRAN 
REALIZANDO SUS PRACTICAS EN EL CONSULTORIO JURÍDICO DE LA 
FACULTAD
</p>
<br/>

<table width="100%" border="0" style="font-size:11px">
<tr>
<td><strong>TUTORA : </strong>Abg. {{$docente}}</td>
<td><strong>MES DE :</strong> {{$mes}} </td>
<td><strong>ESTUDIANTE : </strong>{{$estudiante}} </td>
</tr>
</table>
<hr/>
<table width="100%" border="1" style="font-size:12px">
<tr>
<td>Fecha de registro</td>
<td>Hora de Entrada</td>
<td>Hora de Salida</td>

</tr>
@foreach($objD as $obj)
<tr>
<td>{{$obj->fecha_registro}}</td>
<td>{{$obj->hi}}</td>
<td>{{$obj->hf}}</td>
</tr>
@endforeach
</table>
<br/>
<br/>
<div class="col-md-6">
<p>__________________</p>
<p>Firma del Estudiante</p>
</div>
</body>

</html>
