<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		body{
			
		}
	</style>
</head>
<body>
<table width="100%" >
<tr>
<td style="vertical-align: top;">
<img src="{{'data:image/' . $type_image1 . ';base64,' .$logo1}}"  width="100px" height="120px">
</td>
<td>	 
<center>
	<h5>UNIVERSIDAD DE GUAYAQUIL</h5>
</center>
</td>
<td>
	<img src="{{'data:image/' . $type_image2 . ';base64,' .$logo2}}" style="float:right" width="80px" height="120px">
</td>
</tr>
</table>

@php
	function mes(){
	    $mes = Carbon\Carbon::now()->format('m');
		if($mes=='01'){
		  return 'Enero';
		}elseif($mes=='02'){
		  return 'Febrero';
		}elseif($mes=='03'){
		  return 'Marzo';
		}elseif($mes=='04'){
		  return 'Abril';
		}elseif($mes=='05'){
		  return 'Mayo';
		}elseif($mes=='06'){
		  return 'Junio';
		}elseif($mes=='07'){
		  return 'Julio';
		}elseif($mes=='08'){
		  return 'Agosto';
		}elseif($mes=='09'){
		  return 'Septiembre';
		}elseif($mes=='10'){
		  return 'Octubre';
		}elseif($mes=='11'){
		  return 'Noviembre';
		}elseif($mes=='12'){
		  return 'Diciembre';
		}

		return '';
	}
@endphp

<div style="background: url('/images/fondo1.png') no-repeat center;background-size: 500px 600px;">

<div style="font-size: 13px;">
<p style="text-align: right;">Guayaquil, {{ Carbon\Carbon::now()->format('j') . ' de ' . mes() . ' del ' . Carbon\Carbon::now()->format('Y') }}</p>

</div>



<div style="font-weight: bold; line-height: 0.4;">
<p>Señor Abogado</p>
<p>{{$docente->name}}</p>
<p>Abogado de los Consultorios Jurídicos Gratuitos de la Universidad de Guayaquil</p>
<p>Faculta de Judiprudencia y Ciencias Sociales y Politicas</p>
<p>Ciudad.- Guayaquil</p>
</div>
<br>

<p>De mi consideración.-</p>

<p style="text-align: justify;">Es grato dirigirme a usted, con la finalidad de presentar al estudiante {{$postulante->nombres.' '.$postulante->apellidos}} con cédula de ciudadanía N° {{$postulante->identificacion}}, de la carrera de {{$postulante->carrera}}, que realizará las practicas pre profesionales bajo su supervisión:</p>

<div style="padding-left: 100px;">
	<p>Fecha de inicio de las Prácticas: {{\Carbon\Carbon::parse($periodo->fechai)->format('d-m-Y')}}</p>
	<p>Fecha de fin de las Prácticas {{\Carbon\Carbon::parse($periodo->fechaf)->format('d-m-Y')}}</p>
	<p>Total de horas: {{$cant_horas}} (horas diarias)</p>
	<p>Tutor Académico: {{ $tutor ? $tutor->name : ''}}</p> 
</div>

<p style="text-align: justify;">El estudiante realizará dicho proceso académico, valiéndose de la estructura con que cuenta el Consultorio Jurídico Gratuito de la Universidad de Guayaquil, el misma que deberá garantizar el cumplimiento del programa, proyecto de actividades y aplicación de los conocimientos adquiridos. Usted como Supervisor Institucional junto con el Tutor Académico, debera Evaluar al Practicante de acuerdo al cumplimiento, desempeño y calidad de las actividades encomendadas.</p>

<p style="text-align: justify;">Seguro de seguir contando con su valiosa colaboración en pro al desarrollo profesional de nuestos estudiantes, me suscribo.</p>

<br>
<p style="text-align: center;">Atentamente,</p>
<br>
<div style="line-height: 0.4;">
<p style="text-align: center;">Abg. Econ. M. Katherine Mata E.</p>
<p style="text-align: center;font-weight: bold;">Coordinadora General</p>
<p style="text-align: center;font-weight: bold;">Consultorios Jurídicos Gratuitos</p>
<p style="text-align: center;font-weight: bold;">Universidad de Guayaquil</p>
<p style="text-align: center;font-weight: bold;">Facultad de Jurisprudencia, Ciencias Socuales y Politicas</p>
</div>

</div>


</body>
</html>