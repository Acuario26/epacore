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

<div style="font-weight: bold; line-height: 0.4;">
<p>Estudiante</p>
<p>{{$postulante->nombres.' '.$postulante->apellidos}}</p>
<p>Carrera de: {{$postulante->carrera}}<p>
<p>Faculta de Judiprudencia y Ciencias Sociales y Politicas</p>
<p>Universidad de Guayaquil</p>
<p>Ciudad.- Guayaquil</p>
</div>
<br>

<p style="text-align: justify;">Una vez analizado su pedido para realizar las practicas pre profesionales, debo manifesrar que lo solicitado es favorable pues cumple con los requisitos para la ejecución de la mismas, motivo por el cual asigno:</p>

<div style="padding-left: 100px;">
	<p>Institución receptora: Consultorio Jurídico Gratuito de la UG (Facultad de Derecho)</p>
	<p>Fecha de inicio de las Prácticas: {{\Carbon\Carbon::parse($periodo->fechai)->format('d-m-Y')}}</p>
	<p>Fecha de fin de las Prácticas {{\Carbon\Carbon::parse($periodo->fechaf)->format('d-m-Y')}}</p>
	<p>Total de horas: 500 (en el horario laboral definido por la empresa)</p>
	<p>Tutor Académico: {{$docente->name}}</p> 
</div>

<p style="text-align: justify;">El tutor será el encargado de garantizar el cumplimiento de los instructivos, el uso de formatos instrumento de desarrollo y evaluacion establecidos, por lo que se deberá concretar una reunión previo al inicio de las practicas pre profesionales.</p>

<p style="text-align: justify;">Sin otro particular me despido, sin antes desearle el mayor de los éxitos en su proceso académico, el mismo que contribuira al desarrollo de destrezas y habilidades específicas, de su profesión.</p>

<br>
<p style="text-align: center;">Atentamente,</p>
<br>
<div style="line-height: 0.4;">
<p style="text-align: center;">Abg. M. Katherine Mata E.</p>
<p style="text-align: center;font-weight: bold;">Coordinadora General</p>
<p style="text-align: center;font-weight: bold;">Consultorios Jurídicos Gratuitos</p>
<p style="text-align: center;font-weight: bold;">Universidad de Guayaquil</p>
<p style="text-align: center;font-weight: bold;">Facultad de Jurisprudencia, Ciencias Socuales y Politicas</p>
</div>

<br>
<p style="text-align: justify;">Copia.- Dr. Jaime Hurtado del Castillo , Gestor/Coordinador de PPP de la Carrera de Derecho de la Facultad de Jurisprudencia Ciencias Sociales y Politicas; Abg. {{$docente->name}} ,Supervisor de Practicas</p>

</p>
</div>
</body>
</html>