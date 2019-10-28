
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
																			FICHA DE SUPERVISIÓN DEL TUTOR ACADÉMICO</h5>
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

																<div class="modal-body" style='background: url({{public_path("images/fondo1.png")}}) no-repeat center;background-size: 200px 300px;'>

																	<div class="agileits-w3layouts-info">
																		<div>
																		<div class="divTable letrapp">
																			<div class="divTableBody">
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Fecha</div>
																			<div class="divTableCell">&nbsp;{{$obj->created_at}}</div>
																			</div>
																			<div class="divTableRow">
																			<div class="divTableCell">&nbsp;Visita</div>
																			<div class="divTableCell">&nbsp;{{$obj->visita}}</div>
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
										
<div id="pantallas tesis_30233" x:publishsource="Excel">

<div style="background: url('/images/fondo1.png') no-repeat center;background-size: 10px 60px!important;" >

<table border=1 cellpadding=0 cellspacing=0 width="100%" class='letrapp' style="background: url('images/fondo1.png') no-repeat center;
        background-size: 200px 300px;"
>
 <tr>
  <td colspan="2">VALORACIÓN</td>
  <td>SI</td>
  <td>NO</td>
  <td>OBSERVACIONES</td>
 </tr>
 <tr>
 
  <td rowspan="5">VALORACIÓN AL ESTUDIANTE</td>
  <td>Realizo de manera satisfactoria sus PPP, en la institución
  receptora.</td>
  <td>&nbsp;
  @if($obj->e1)
  {{$obj->e1}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->e1)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob1}}
  </td>
 </tr>
 <tr>
  <td>Cumplió con la planificación de PPP</td>
  <td>&nbsp;
  @if($obj->e2)
  {{$obj->e2}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->e2)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob2}}</td>
 </tr>
 <tr>
  <td>Se encuentra conforme con las actividades
  realizadas en las PPP</td>
  <td>&nbsp;
  @if($obj->e3)
  {{$obj->e3}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->e3)
  {{"1"}}
  @endif
  </td>
  <td >{{$obj->ob3}}</td>
 </tr>
 <tr>
  <td>Considera que las PPP, realizadas en la
  insitución , contribuyen a la formación profesional del estudiante</td>
  <td>&nbsp;
  @if($obj->e4)
  {{$obj->e4}}
  @endif
  </td>
  <td >&nbsp;
  @if(!$obj->e4)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob4}}</td>
 </tr>
 <tr>
  <td>El ambiente laboral es adecuado para el
  desarrollo de las PPP</td>
  <td>&nbsp;
  @if($obj->e5)
  {{$obj->e5}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->e5)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob5}}</td>
 </tr>
 <tr>
  <td rowspan="5">VALORACIÓN CONJUNTA CON EL SUPERVISOR
  INSTITUCIONAL</td>
  <td>El estudiante cumplió con el horario establecido para las PPP</td>
  <td>&nbsp;
  
  @if($obj->ec1)
  {{$obj->ec1}}
  @endif
  </td>
  <td>&nbsp;
  
  @if(!$obj->ec1)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob6}}</td>
 </tr>
 <tr>
  <td>El comportamiento del estudiante estuvo acorde
  con las políticas de la empresa</td>
  <td>&nbsp;
  
  @if($obj->ec2)
  {{$obj->ec2}}
  @endif
  </td>
  <td>&nbsp;
  
  @if(!$obj->ec2)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob7}}</td>
 </tr>
 <tr>
  <td>El estudiante se acopló al equipo de trabajo
  del departamento</td>
  <td >&nbsp;
  
  @if($obj->ec3)
  {{$obj->ec3}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->ec3)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob8}}</td>
 </tr>
 <tr>
  <td >El estudiante cumplió con las actividades
  asignadas</td>
  <td>&nbsp;
  @if($obj->ec4)
  {{$obj->ec4}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->ec4)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob9}}</td>
 </tr>
 <tr >
  <td >Considera que el estudiante tiene los
  conocimientos necesarios , de acuerdo a su nivel académico</td>
  <td >&nbsp;
  @if($obj->ec5)
  {{$obj->ec5}}
  @endif
  </td>
  <td>&nbsp;
  @if(!$obj->ec5)
  {{"1"}}
  @endif
  </td>
  <td>{{$obj->ob10}}</td>
 </tr>
 </table>
 <table  class="letrap">

 <tr height=40 style='height:30.0pt'>
  <td height=40 class=xl6730233 width=151 style='height:30.0pt;width:113pt'>VALORACION
  FINAL APROBADO</td>
  <td class=xl6630233>{{$obj->vfa}}</td>
  <td class=xl6830233 colspan=4>(Si el número de valoraciones &quot;SI&quot;
  son minimo 7 y la evaluación del supervisor de la empresa es minimo de 7</td>
 </tr>
 <tr height=51 style='mso-height-source:userset;height:38.25pt'>
  <td height=51 class=xl6730233 width=151 style='height:38.25pt;width:113pt'>REPROBADO</td>
  <td class=xl6630233>{{$obj->vfr}}</td>
  <td class=xl6830233 colspan=4>(Si el número de valoraciones &quot;SI&quot; es
  menos de 7 y la evaluación del supervisor de la empresa es menos de 7</td>
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
