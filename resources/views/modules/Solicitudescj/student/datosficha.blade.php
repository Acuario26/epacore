
<!DOCTYPE html>
<html lang="es">
<head>
@include('frontend.partials.head')

</head>
<style>
.divTable{
	display: table;
	width: 100%;
}
.divTableRow {
	display: table-row;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
}
.divTableCell, .divTableHead {
	border: 1px solid #999999;
	display: table-cell;
	padding: 3px 10px;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
	font-weight: bold;
}
.divTableFoot {
	background-color: #EEE;
	display: table-footer-group;
	font-weight: bold;
}
.divTableBody {
	display: table-row-group;
}
.letrap{
		font-size:14px;
}
.letrapp{
		font-size:11px;
}
ol.d {
	list-style-type:none;
text-align:center;
}
</style>
<body>
<div id="renderMe">
<div class="header">
				<table width="100%" cellpadding=0 cellspacing=0 >
																<tr>
																<td>
																<img src="{{public_path('images/')}}ug.png"  width="80px" height="100px">
																</td>
																<td>	 <center>
																				<h4><strong>UNIVERSIDAD DE GUAYAQUIL</strong></h4>
																				<h4><strong>FACULTAD DE JURISPRUDENCIA Y CIENCIAS SOCIALES Y POLÍTICAS</strong></h4> 
																	</center></td>
																	
																	<td>
																	
																	<img src="{{public_path('images/')}}juris.png"style="float:right" width="60px" height="100px">

																	</td>
																	</tr>
																	</table>
																	<ol class="d">
									<li class="modal-title">	FICHA DE INSCRIPCIÓN</li>
										<li class="modal-title">
								COORDINACIÓN DE VINCULACIÓN</li>
								<li class="modal-title">
								PRÁCTICAS PRE PROFESIONALES</li>
								</ol>
				</div>

						<div style="background: url('/images/fondo1.png') no-repeat center;background-size: 10px 60px!important;" >

							<div class="agileits-w3layouts-info">
							<div >
							
							<Table width="100%" border="1" class="letrap">
							<tr> 		
							<td><strong>ESCUELA</strong></td>
							<td>DERECHO:</td>
							<td>	
							@if($ob->carrera=="Derecho")
							{{"X"}}
							@endif</td>
							<td>SOCIOLOGÍA:</td>
							<td colspan="2">
							@if($ob->carrera=="Sociologia")
							{{"X"}}
							@endif
							</td>
							
							</tr>
							<tr>
							<td colspan="6"><strong>MODALIDAD</strong></td>
							</tr>
							<tr>
							<td>SEMESTRAL:</td>
							<td>	
							@if($ob->modalidad=="SEMESTRAL")
							{{"X"}}
							@endif
							</td>

							<td>ANUAL:</td>
							<td>
							@if($ob->modalidad=="ANUAL")
							{{"X"}}
							@endif
							</td>

							<td>MODULAR:</td>
							<td>
							@if($ob->modalidad=="MODULAR")
							{{"X"}}
							@endif
							</td>

							</tr>
							<tr>
							<td><strong>NIVEL:</strong></td>
							<td>
							{{$ob->semestre}}
							</td>

							<td><strong>PARALELO:</strong></td>
							<td>
							{{$ob->paralelo}}
							</td>

							<td>HORARIO:</td>

							<td>
							{{$ob->horario}}
							</td>
							</tr>
							<tr>
							<td colspan="3"><strong>FECHA DE MATRICULA EN EL PRIMER NIVEL (DD/MM/AAAA)</strong></td>
							<td colspan="3">.</td>
							</tr>

							<tr>
							<td colspan="3"><strong>Nombres</strong></td>
							<td colspan="3"><strong>Apellidos</strong></td>

							</tr>
							<tr>
							<td colspan="3">{{$ob->nombres}}</td>
							<td colspan="3">{{$ob->apellidos}}</td>

							</tr>
							<tr>
							<td colspan="2"><strong>Cedula</strong></td>
							<td colspan="2"><strong>Edad</strong></td>
							<td colspan="2"><strong>Fecha de Nacimiento</strong></td>

							</tr>
							<tr>
							<td colspan="2">{{$identificacion}}</td>
							<td colspan="2">{{$ob->edad}}</td>
							<td colspan="2">{{$ob->fecha_nacimiento}}</td>	
							</tr>
							
							<tr>
							<td colspan="3"><strong>Estado Civil</strong></td>
							<td colspan="3"><strong>Direccion Domiciliaria</strong></td>

							</tr>
							<tr>
							<td colspan="2">Soltero:
							@if($ob->estado_civil=="SOLTERO")
							{{"X"}}
							@endif
							</td>
							<td >Casado:
							@if($ob->estado_civil=="CASADO")
							{{"X"}}
							@endif</td>
							<td rowspan="2" colspan="3">
							{{$ob->direccion}}
							</td>
							</tr>
							<tr>
							<td colspan="2" >Unión Libre:
							@if($ob->estado_civil=="UNION LIBRE")
							{{"X"}}
							@endif
							</td>
							<td >Viudo:
							@if($ob->estado_civil=="VIUDO")
							{{"X"}}
							@endif
							</td>
					
							</tr>
							<tr>
							<td colspan="3"><strong>Sufre alguna discapacidad</strong></td>
							<td><strong>Provincia</strong></td>
								<td colspan="2">{{$ob->provincia_id}}</td>
							</tr>
							<tr>
							<td>Si:
							@if($ob->discapacidad=="SI")
							{{"X"}}
							@endif
							</td>
							<td>Carnet CONADIS:
							{{$ob->carnet}}
						</td>
							<td>No:
							@if($ob->discapacidad=="NO")
							{{"X"}}
							@endif
							</td>
							<td><strong>Canton</strong></td>
								<td colspan="2">{{$ob->ciudad_id}}</td>
							</tr>
							<tr>
							<td colspan="3"><strong>telefono convencional</strong></td>

							<td colspan="3"><strong>Correo institucional</strong></td>

							</tr>
							<tr>
							<td colspan="3">{{$ob->convencional}}</td>

							<td colspan="3">{{$ob->correo_institucional}}</td>

							</tr>
							<tr>
							<td colspan="3"><strong>telefono Celular</strong></td>

							<td colspan="3"><strong>Correo Personal</strong></td>

							</tr>
							<tr>
							<td colspan="3">{{$ob->celular}}</td>

							<td colspan="3">{{$ob->correo}}</td>

							</tr>
							<tr>
							<td colspan="3"><strong>trabaja</strong></td>
							<td><strong>lugar:</strong></td>
								<td colspan="2">{{$ob->direccion_t}}</td>
							</tr>
							<tr>
							<td colspan="2">Si:
							@if($ob->labora=="SI")
							{{"X"}}
							@endif
							</td>
							<td>No:
							@if($ob->labora=="NO")
							{{"X"}}
							@endif
							</td>
							<td><strong>telefonos:</strong></td>
								<td colspan="2">{{$ob->telefono_t}}</td>
							</tr>
							<tr>
				

							<td colspan="6" ><strong>Ocupación</strong></td>

							</tr>
							<tr>
						

							<td colspan="6" >
							@if($ob->ocupacion!="")
							{{$ob->ocupacion}}
							@endif
							@if($ob->ocupacion=="")
							{{"-"}}
							@endif
							</td>

							</tr>
							<tr>
							<td colspan="6"><strong>Area de preferencia para prácticas Pre Profesionales (elección multiple)</strong></td>
						
							</tr>
							<tr>
							<td>Civil</td>
							<td>
							@if($ob->civil=="1")
							{{"X"}}
							@endif
							</td>
							<td>Familia</td>
							<td>@if($ob->familia=="1")
							{{"X"}}
							@endif</td>
							<td>Fiscalía</td>
							<td>@if($ob->fiscalia=="1")
							{{"X"}}
							@endif</td>
							</tr>
							<tr>
							<td>Penal</td>
							<td>@if($ob->penal=="1")
							{{"X"}}
							@endif</td>
							<td>Violencia Intrafamiliar</td>
							<td>@if($ob->violenciaf=="1")
							{{"X"}}
							@endif</td>
							<td>Defensoría Pública</td>
							<td>@if($ob->defensoria=="1")
							{{"X"}}
							@endif</td>
							</tr>
							<tr>
							<td>Laboral</td>
							<td>@if($ob->laboral=="1")
							{{"X"}}
							@endif</td>
							<td>Inquilinato</td>
							<td>@if($ob->inquilinato=="1")
							{{"X"}}
							@endif</td>
							<td>Constitucional</td>
							<td>@if($ob->constitucional=="1")
							{{"X"}}
							@endif</td>
							</tr>
							<tr>
							<td colspan="6" border="1">
							<center>DECLARO  BAJO MI RESPONSABILIDAD QUE TODA LA INFORMACIÓN CONTENIDA EN ESTA FICHA ES VERDADERA.
							AUTORIZO PARA QUE SE CONFIRME LA INFORMACIÓN Y LA MISMA PUEDA SER UTILIZADA SI SE REQUIERE PARA 
							ASUNTOS ACADÉMICOS DE LA INSITUCIÓN
</center>
							
							</td>
							</tr>
							</table>
						</div>
						</div>
						</div>
						</div>
</div>
</body>
</html>