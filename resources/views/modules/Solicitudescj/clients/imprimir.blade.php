<html>
<head>
	
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
	<h5>FACULTAD DE JURIPRUDENCIA Y CIENCIAS SOCIALES Y POLITICAS</h5>
	<h5>CONSULTORIO JURIDICO GRATUITO</h5>
	<h6>Formulario de ateción al usuario</h6>
</center>
</td>
<td>
	<img src="{{asset('images/juris.png')}}"style="float:right" width="80px" height="120px">
</td>
</tr>
</table>

<div style="background: url('/images/fondo1.png') no-repeat center;background-size: 500px 600px;">

<div style="border: 1px solid #000;padding: 5px; font-size: 12px;">
	<div style="width: 30%; display: inline-block;">
	NOMBRES
	<p>{{$client->nombres}}</p>
	</div>
	<div style="width: 30%; display: inline-block;">
	APELLIDOS
	<p>{{$client->apellidos}}</p>
	</div>
	<div style="width: 30%; display: inline-block;">
	N° CEDULA
	<p>{{$client->cedula}}</p>
	</div>
</div>
<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 15%; border-right: 1px solid; padding: 5px;font-size: 10px;">FECHA DE NACIMIENTO</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->fecha_nacimiento}}</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px; font-size: 10px;">NACIONALIDAD</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->nacionalidad}}</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">EDAD</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;"></td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">ETNIA</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->etnia}}</td>
	</tr>
</table>
<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">N° CELULAR</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->celular}}</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">N° CONVENCIONAL</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->convencional}}</td>
		<td style="width: 4%; border-right: 1px solid; padding: 5px; font-size: 10px;">SEXO</td>
		<td style="width: 7%; border-right: 1px solid; padding: 5px; font-size: 10px;">FEMENINO</td>
		<td style="width: 4%; border-right: 1px solid; padding: 5px; font-size: 10px; text-align: center;">{!!$client->sexo=='Femenino' ? 'X' : ''!!}</td>
		<td style="width: 7%; border-right: 1px solid; padding: 5px;font-size: 10px;">MASCULINO</td>
		<td style="width: 4%; border-right: 1px solid; padding: 5px; font-size: 10px; text-align: center;">{!!$client->sexo=='Masculino' ? 'X' : '' !!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">OTROS {!!$client->sexo=='Otros' ? 'X' : '' !!}</td>
		<td style="width: 12%; border-right: 1px solid; padding: 5px; font-size: 10px;">INDIQUE <p>{{ $client->sexo=='Otros' ? $client->tipo_sexo : '' }}</p></td>
	</tr>
</table>
<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">INTRUCCIÓN</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">BÁSICA</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->instruccion=='Basica' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">SECUNDARIA</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->instruccion=='Secundaria' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">SUPERIOR</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->instruccion=='Superior' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">DOMICILIO</td>
		<td style="width: 30%; border-right: 1px solid; padding: 5px;">{{$client->domicilio}}</td>
	</tr>
</table>

<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">ESTADO CIVIL</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">SOLTERA</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->estado_civil=='Soltera' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px; font-size: 10px;">CASADA</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->estado_civil=='Casada' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">VIUDA</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->estado_civil=='Viuda' ? 'X' : ''!!}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">DIVORSIDAD</td>
		<td style="width: 3%; border-right: 1px solid; padding: 5px;font-size: 10px;text-align: center;">{!!$client->estado_civil=='Divorsidad' ? 'X' : ''!!}</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">SECTOR DONDE VIVE</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->sector}}</td>
	</tr>
</table>

<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">OCUPACION</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 12px;">{{$client->ocupacion}}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px; font-size: 10px;">AFILIADO AL IESS</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">{{$client->iess}}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">INGRESOS</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;">{{$client->ingresos}}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">BONO</td>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;">{{$client->bono}}</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 10px;">DISCAPACIDAD</td>
		<td style="width: 4%; border-right: 1px solid; padding: 5px;">{{$client->discapacidad}}</td>
		<td style="width: 20%; border-right: 1px solid; padding: 5px;">INDIQUE: <span>{{$client->tipo_discapacidad}}</span></td>
	</tr>
</table>

<table style="width: 100%;font-size: 12px;border:1px solid #000;border-collapse: collapse;">
	<tr>
		<td style="width: 10%; border-right: 1px solid; padding: 5px;font-size: 10px;">ENFERMEDAD CATASTROFICA</td>
		<td style="width: 5%; border-right: 1px solid; padding: 5px;font-size: 12px;">{{$client->enfermedad}}</td>
		<td style="width: 50%; border-right: 1px solid; padding: 5px; font-size: 10px;">INDIQUE <span style="font-size: 10px;" >{{$client->tipo_enfermedad}}</span></td>
	</tr>
</table>

<br>

<p style="font-size: 12px;">RAZÓN POR LA QUE ACUDE AL CONSULTORIO</p> 

<div style="width: 300px; font-size: 12px; display: inline-block;">
	ASESORÍA <div style="display: inline-block;width: 10px; border: 1px solid #000; padding: 8px;">{!!$client->razon=='Asesoría' ? 'X' : '&nbsp;'!!}</div>
</div>

<div style="width: 300px; font-size: 12px; display: inline-block;">
	PATROCINIO <div style="display: inline-block;width: 10px; border: 1px solid #000; padding: 8px;">{!!$client->razon=='Patrocinio' ? 'X' : '&nbsp;' !!}</div>
</div>

<br><br>

<table style="width: 100%; border-collapse: collapse;font-size: 12px;">
	
	<tr>
		<td style="border: 1px solid #000;height: 70px;vertical-align: text-top;" >DETALLE: {{$client->detalle}}</td>
	</tr>
</table>

<br>

<table style="width: 100%; border-collapse: collapse;font-size: 12px;">

	<tr>
		<td style="border: 1px solid #000;">CAUSA:</td>
	</tr>

	<tr>
		<td style="border: 1px solid #000;">TIPO DE PROCESO:</td>
	</tr>

	<tr>
		<td style="border: 1px solid #000;">UNIDAD JUDICIAL:</td>
	</tr>

	<tr>
		<td style="border: 1px solid #000;">FECHA DE INICIO DE CAUSA:</td>
	</tr>

</table>

<!--
<div style="width: 100%; height: 70px; font-size: 12px; border: 1px solid #000; padding: 3px;">
	
</div>

<br>

<div style="width: 100%;  border: 1px solid #000; padding: 3px;">
	CAUSA: 
</div>
<div style="width: 100%; font-size: 12px; border: 1px solid #000; padding: 3px;">
	TIPO DE PROCESO: 
</div>
<div style="width: 100%; font-size: 12px; border: 1px solid #000; padding: 3px;">
	UNIDAD JUDICIAL: 
</div>
<div style="width: 100%; font-size: 12px; border: 1px solid #000; padding: 3px;">
	FECHA DE INICIO DE CAUSA: 
</div>-->

<!--<div style="width: 24%; font-size: 12px; border: 1px solid #000; padding: 3px; display: inline-block; margin-left: 0px;">
	 
</div>
<div style="width: 24%; font-size: 12px; border: 1px solid #000; padding: 3px; display: inline-block;margin-left: -5px;">
	&nbsp;
</div>
<div style="width: 24%; font-size: 12px; border: 1px solid #000; padding: 3px; display: inline-block;margin-left: -5px;">
	DEMANDADO: 
</div>
<div style="width: 25%; font-size: 12px; border: 1px solid #000; padding: 3px; display: inline-block;margin-left: -5px;">
	&nbsp;
</div>-->

<table style="width: 100%; border-collapse: collapse;">
	<tr>
		<td style="width: 25%;border: 1px solid #000; font-size: 12px;" >DEMANDANTE:</td>
		<td style="width: 25%;border: 1px solid #000; font-size: 12px;" >&nbsp;</td>
		<td style="width: 25%;border: 1px solid #000; font-size: 12px;" >DEMANDADO:</td>
		<td style="width: 28%;border: 1px solid #000; font-size: 12px;">&nbsp;</td>
	</tr>
</table>



<!--<div style="border: 1px solid #000; font-size: 12px;">
	<div style="width: 15%; display: inline-block;">
	
	</div>
	<div style="width: 10%; display: inline-block; border-right: 1px solid;">
		{{$client->fecha_nacimiento}}
	</div>

	<div style="width: 15%; display: inline-block;">
	NACIONALIDAD
	</div>
	<div style="width: 15%; display: inline-block;">
		<p>{{$client->nacionalidad}}</p>
	</div>

	<div style="width: 10%; display: inline-block;">
	Edad
	</div>
	<div style="width: 10%; display: inline-block;">
		<p>&nbsp;</p>
	</div>

	<div style="width: 10%; display: inline-block;">
	Etnia
	</div>
	<div style="width: 10%; display: inline-block;">
		<p>{{$client->etnia}}</p>
	</div>

</div>-->
<br><br><br><br>
<div style="text-align: center; width: 49%; display: inline-block;">

______________________________________
<p>USUARIO</p>
</div>

<div style="text-align: center; width: 49%; display: inline-block;">

______________________________________
<p>ASESOR-TUTOR</p>
</div>
</div>

</body>
</html>