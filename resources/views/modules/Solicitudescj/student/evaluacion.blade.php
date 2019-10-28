
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
		font-size:11px;
	text-align:center;
}
.letrapp{
		font-size:12px;
}
</style>
<body>

<div id="renderMe">
									<div class="modal-content">

															<div class="modal-header">
																<table width="100%" >
																<tr>
																<td>
																<img src="{{public_path('images/')}}ug.png"  width="100px" height="120px">
																</td>
																<td>	 <center>
																				<h5>UNIVERSIDAD DE GUAYAQUIL</h5>
																				<h5>
																			FICHA DE EVALUACION ESTUDIANTIL</h5>
																	</center></td>
																	
																	<td>
																	
																	<img src="{{public_path('images/')}}juris.png"style="float:right" width="80px" height="120px">

																	</td>
																	</tr>
																	</table>
																	</center>
															</div>

																<div class="modal-body" class="letrap">

																	<div class="agileits-w3layouts-info">
																		<div>
																		<div class="divTable letrapp">
																			<div class="divTableBody">
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Estudiante</div>
																			<div class="divTableCell">&nbsp;{{$objPostulant->apellidos.' '.$objPostulant->nombres}}</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Facultad</div>
																			<div class="divTableCell">&nbsp;Facultad de Jurisprudencia y Ciencias Sociales</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Carrera</div>
																			<div class="divTableCell">&nbsp;{{$objPostulant->carrera}}</div>
																			</div>
																			
																			</div>
																			</div>
																										
																		<div class="divTable letrapp">
																			<div class="divTableBody">
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Insitucion</div>
																			<div class="divTableCell">&nbsp;{{$teachers->lugar->descripcion}}</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Area de Desempeño</div>
																			<div class="divTableCell">&nbsp;CONSULTORÍA JURÍDICA</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Supervisor Institucional</div>
																			<div class="divTableCell">&nbsp;{{$teachers->docente->name}}</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Cargo de Supervisor Institucional</div>
																			<div class="divTableCell">&nbsp;ABOGADO</div>
																			</div>
																			
																			</div>
																			</div>
																		<br/>
  <div style="background: url('/images/fondo1.png') no-repeat center;background-size: 500px 600px;">
	<div id="pantallas tesis_31300" align=center x:publishsource="Excel">



<table border=1 align=center cellpadding=0 cellspacing=0 width=664 
style='border-collapse:
 collapse;table-layout:fixed;width:499pt' class="letrap">

 <tr height=20 style='height:15.0pt'>
  <td colspan=5 height=20 class=xl6431300 width=664 style='border-right:.5pt solid black;
  height:15.0pt;width:499pt'>Indique con una X la calificacion que usted
  considere adecuada , según la siguiente escala</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6731300 width=130 style='height:15.0pt;border-top:none;
  width:98pt'>5</td>
  <td class=xl6731300 width=129 style='border-top:none;border-left:none;
  width:97pt'>4</td>
  <td class=xl6731300 width=120 style='border-top:none;border-left:none;
  width:90pt'>3</td>
  <td class=xl6731300 width=122 style='border-top:none;border-left:none;
  width:92pt'>2</td>
  <td class=xl6731300 width=163 style='border-top:none;border-left:none;
  width:122pt'>1</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6831300 width=130 style='height:15.0pt;border-top:none;
  width:98pt'>EXCELENTE</td>
  <td class=xl6831300 width=129 style='border-top:none;border-left:none;
  width:97pt'>MUY SATISFECHO</td>
  <td class=xl6831300 width=120 style='border-top:none;border-left:none;
  width:90pt'>SATISFACTORIO</td>
  <td class=xl6831300 width=122 style='border-top:none;border-left:none;
  width:92pt'>POCO SATISFECHO</td>
  <td class=xl6831300 width=163 style='border-top:none;border-left:none;
  width:122pt'>NADA SATISFECHO</td>
 </tr>

 
 <tr height=0 style='display:none'>
  <td width=130 style='width:98pt'></td>
  <td width=129 style='width:97pt'></td>
  <td width=120 style='width:90pt'></td>
  <td width=122 style='width:92pt'></td>
  <td width=163 style='width:122pt'></td>
 </tr>

</table>

</div>
<br/>
<div id="pantallas tesis_2406" x:publishsource="Excel">

<table border=1 class="letrap" cellpadding=0 cellspacing=0 style='border-collapse:
 collapse;width:100%'>
 <col width=130 style='mso-width-source:userset;mso-width-alt:4754;width:98pt'>
 <col width=129 style='mso-width-source:userset;mso-width-alt:4717;width:97pt'>
 <col width=120 style='mso-width-source:userset;mso-width-alt:4388;width:90pt'>
 <col width=122 style='mso-width-source:userset;mso-width-alt:4461;width:92pt'>
 <col width=24 style='mso-width-source:userset;mso-width-alt:877;width:18pt'>
 <col width=19 style='mso-width-source:userset;mso-width-alt:694;width:14pt'>
 <col width=17 style='mso-width-source:userset;mso-width-alt:621;width:13pt'>
 <col width=20 style='mso-width-source:userset;mso-width-alt:731;width:15pt'>
 <col width=17 style='mso-width-source:userset;mso-width-alt:621;width:13pt'>
 <col width=165 style='mso-width-source:userset;mso-width-alt:6034;width:124pt'>
 <tr height=20 style='height:15.0pt'>
  <td colspan=4 height=20 class=xl652406 width=501 style='height:15.0pt;
  width:377pt'>Valoracion</td>
  <td class=xl702406 width=24 style='border-left:none;width:18pt'>5</td>
  <td class=xl702406 width=19 style='border-left:none;width:14pt'>4</td>
  <td class=xl702406 width=17 style='border-left:none;width:13pt'>3</td>
  <td class=xl702406 width=20 style='border-left:none;width:15pt'>2</td>
  <td class=xl702406 width=17 style='border-left:none;width:13pt'>1</td>
  <td class=xl642406 style='border-left:none'>OBSERVACIONES</td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td rowspan=4 height=100 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:75.0pt;border-top:none;width:98pt'>CONOCIMIENTOS Y HABILIDADES</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>Aplicación
  de los conocimientos practivos y teoricos de la carrera</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e1=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e1=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e1=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e1=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e1=="1")
  {{"x"}}
  @endif
  </td>
  <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;{{$objEv->ob1}}</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Capacidad de resolver problemas</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e2=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e2=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e2=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e2=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e2=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Utilización adecuada de procedimientos
  metodológicos</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e3=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e3=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e3=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e3=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e3=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Integracion y trabajo en equipo</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e4=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e4=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e4=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e4=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e4=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td rowspan=2 height=40 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:30.0pt;border-top:none;width:98pt'>ASISTENCIA</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>Puntualidad
  del estudiante</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e5=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e5=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e5=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e5=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e5=="1")
  {{"x"}}
  @endif
  </td>
  <td rowspan=2 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;{{$objEv->ob2}}</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Responsabilidad, disposicion y cumplimiento en
  la ejecucion de las tareas</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e6=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e6=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e6=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e6=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e6=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td rowspan=3 height=80 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:60.0pt;border-top:none;width:98pt'>APOYO Y ACTIVIDADES</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>Integracion
  al equipo de trabajo</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e7=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e7=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e7=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e7=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e7=="1")
  {{"x"}}
  @endif
  </td>
  <td rowspan=3 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;{{$objEv->ob3}}</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Guia de la insitucion para el desarrollo de
  actividades</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e8=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e8=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e8=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e8=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e8=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Asesoria del tutor academico</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e9=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e9=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e9=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e9=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e9=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td rowspan=2 height=60 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:45.0pt;border-top:none;width:98pt'>ESPACIO Y RECURSOS</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>Facilidad
  del espacio fisico</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e10=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e10=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e10=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e10=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e10=="1")
  {{"x"}}
  @endif
  </td>
  <td rowspan=2 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;{{$objEv->ob4}}</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Facilidad en la utilizacion y movilidad de los
  recursoso</td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e11=="5")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e11=="4")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e11=="3")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e11=="2")
  {{"x"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>&nbsp;
  @if($objEv->e11=="1")
  {{"x"}}
  @endif
  </td>
 </tr>
 <tr height=0 style='display:none'>
  <td width=130 style='width:98pt'></td>
  <td width=129 style='width:97pt'></td>
  <td width=120 style='width:90pt'></td>
  <td width=122 style='width:92pt'></td>
  <td width=24 style='width:18pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=17 style='width:13pt'></td>
  <td width=20 style='width:15pt'></td>
  <td width=17 style='width:13pt'></td>
  <td></td>
 </tr>

</table> 

</div>

<p align="justify"><strong>Sugerencias:</strong>
<table width="100%" border="1" class="letrap"><tr><td>
{{$objEv->sugerencias}}
</td></tr>
</table>
</p>
</div>
<p align="justify" style="font-size:10px">

INDIQUE SUS SUGERENCIAS A LA UNIVERSIDAD PARA QUE ESTA PUEDA MEJORAR SUS PROCESOS
ACADÉMICOS PARA UN MEJOR DESENVOLVIMIENTO EN EL MUNDO LABORAL DE SUS ESTUDIANTES.
</p>



																		</div>					
										 							</div>
																</div>
		</div>
<div id="editor"></div>


</body>

</html>
