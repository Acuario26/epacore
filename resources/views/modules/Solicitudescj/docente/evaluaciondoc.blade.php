
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
		font-size:12px;
}
.letrapp{
		font-size:11px;
        
}
</style>
<body>
<div id="renderMe">
									<div class="modal-content">

															<div class="modal-header">
																<table width="100%" cellpadding=0 cellspacing=0 >
																<tr>
																<td>
																<img src="{{public_path('images/')}}ug.png"  width="80px" height="100px">
																</td>
																<td>	 <center>
																				<h5>UNIVERSIDAD DE GUAYAQUIL</h5>
                                                                                <h5>
																			FICHA DE EVALUACIÓN Y RENDIMIENTO DEL PRACTICANTE</h5>
																	</center></td>
																	
																	<td>
																	
																	<img src="{{public_path('images/')}}juris.png"style="float:right" width="60px" height="100px">

																	</td>
																	</tr>
																	</table>
																<center><strong>	
																
																			
																			
																				</strong>
																				</center>
															</div>

																<div class="modal-body" >

																	<div class="agileits-w3layouts-info">
																		<div style="background: url({{public_path('images/fondo1.jpeg')}}) no-repeat center;background-size: 200px 300px;">
																		<div class="divTable letrapp">
																			<div class="divTableBody">
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Fecha</div>
																			<div class="divTableCell">&nbsp;{{$obj->created_at}}</div>
																			</div>
																		</div>
																			</div>
																	
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
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Hora</div>
																			<div class="divTableCell">&nbsp;{{$teachers->hora_inicio.'-'.$teachers->hora_fin}}</div>
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
                                                                            <div id="pantallas tesis_31300" align=center x:publishsource="Excel">

<table border=1 align=center cellpadding=0 cellspacing=0 width=664 
style='border-collapse:
 collapse;table-layout:fixed;width:499pt' class="ab">

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

</table>

</div>
<br/>
<div id="pantallas tesis_2406" x:publishsource="Excel">
<div style="background: url('/images/fondo1.png') no-repeat center;background-size: 10px 60px!important;" >

<table border=1 class="letrapp">
 
 <tr>
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
  height:75.0pt;border-top:none;width:98pt'>ASPECTO TÉCNICOS / OPERATIVOS</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
 Los conocimientos del practicante aseguran una exitosa realizacion de los trabajos</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e1=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e1=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e1=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e1=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e1=="1")
  {{"1"}}
  @endif
  </td>
  <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;
 
  {{$obj->ob1}}
  
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20>Posee iniciativa, constantemente pregunta por nuevos trabajos</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e2=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e2=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e2=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e2=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e2=="1")
  {{"1"}}
  @endif
  </td>
 </tr>
 <tr>
  <td colspan=3 height="20">Demuestra capacidad y  compromiso en la realización de sus trabajos</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e3=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e3=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e3=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e3=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e3=="1")
  {{"1"}}
  @endif
  </td>

 </tr>
 <tr>
  <td colspan=3 height=20>Cumple con exactitud , esmero y orden de trabajos</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e4=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e4=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e4=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e4=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e4=="1")
  {{"1"}}
  @endif
  </td>

 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td rowspan=4 height=100 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:75.0pt;border-top:none;width:98pt'>ASPECTO SOCIAL</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
  Su actitud es proactiva y facilita la tarea en equipo
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e5=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e5=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e5=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e5=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e5=="1")
  {{"1"}}
  @endif
  </td>
  <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;
  {{$obj->ob2}}
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Coopera de manera permanente y espontánea</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e6=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e6=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e6=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e6=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e6=="1")
  {{"1"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Es repetuoso con todo el personal</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e7=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e7=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e7=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e7=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e7=="1")
  {{"1"}}
  @endif
  </td>

 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Demuestra ser cuidadoso en su presentación personal</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e8=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e8=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e8=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e8=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e8=="1")
  {{"1"}}
  @endif
  </td>

 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td rowspan=3 height=100 class=xl662406 width=130 style='border-bottom:.5pt solid black;
  height:75.0pt;border-top:none;width:98pt'>ASPECTO ESTRATÉGICO</td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
 Planifica y organiza de manera adecuada los trabjos diarios</td>
 <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e9=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e9=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e9=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e9=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e9=="1")
  {{"1"}}
  @endif
  </td>
  <td rowspan=3 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;
  {{$obj->ob3}}
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Propone soluciones y/o alternativas para mejorar situaciones del trabajo</td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e10=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e10=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e10=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e10=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e10=="1")
  {{"1"}}
  @endif
  </td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
  border-left:none;width:279pt'>Es puntual en trabajo </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e11=="5")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e11=="4")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e11=="3")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e11=="2")
  {{"1"}}
  @endif
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  @if($obj->e11=="1")
  {{"1"}}
  @endif
  </td>

 </tr>
 
 <tr>
  <td rowspan=1 class=xl662406 width=130 style='border-bottom:.5pt solid black;border-top:none;width:98pt'>Frecuencia
  </td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
 </td>
 <td class=xl632406 style='border-top:none;border-left:none'>
 
  {{$obj->fr5}}

  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->fr4}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->fr3}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->fr2}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->fr1}}
  </td>
  <td rowspan=3 class=xl712406 style='border-bottom:.5pt solid black;
  border-top:none'>&nbsp;
  {{$obj->nota}}/10
  </td>
 </tr>
 <tr>
  <td rowspan=1 class=xl662406 width=130 style='border-bottom:.5pt solid black;border-top:none;width:98pt'>Sumatoria
  </td>
  <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
 </td>
 <td class=xl632406 style='border-top:none;border-left:none'>
 
  {{$obj->sum5}}

  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->sum4}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->sum3}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->sum2}}
  </td>
  <td class=xl632406 style='border-top:none;border-left:none'>
  {{$obj->sum1}}
  </td>

 </tr>
 <tr>
  <td rowspan=1 class=xl662406 width=130 style='border-bottom:.5pt solid black;border-top:none;width:98pt'>
  Total
  </td>
  <td rowspan=1 colspan=8 class=xl662406 width=130 style='border-bottom:.5pt solid black;border-top:none;width:98pt'>
 <p align="right"> {{$obj->total}}</p>
  </td>
 
 </tr>
</table>

</div>

</div>



																		</div>					
										 							</div>
																</div>
		</div>
<div id="editor"></div>


</body>

</html>
