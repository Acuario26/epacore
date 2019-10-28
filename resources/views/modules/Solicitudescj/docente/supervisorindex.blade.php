@extends('layouts.app')

@section('contentheader_title')
	JuridiCore
@endsection

@section('contentheader_description')
	Sistema Integrado 
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
	<style>
	a.tooltips {
  position: relative;
  display: inline;
}
a.tooltips span {
  position: absolute;
  width:140px;
  color: #FFFFFF;
  background: #139C8E;
  border: 2px solid #6D6D6D;
  height: 99px;
  line-height: 99px;
  text-align: center;
  visibility: hidden;
  border-radius: 23px;
}
a.tooltips span:before {
  content: '';
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -12px;
  width: 0; height: 0;
  border-right: 12px solid #6D6D6D;
  border-top: 12px solid transparent;
  border-bottom: 12px solid transparent;
}
a.tooltips span:after {
  content: '';
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -8px;
  width: 0; height: 0;
  border-right: 8px solid #139C8E;
  border-top: 8px solid transparent;
  border-bottom: 8px solid transparent;
}
a:hover.tooltips span {
  visibility: visible;
  opacity: 1;
  left: 100%;
  top: 50%;
  margin-top: -49.5px;
  margin-left: 15px;
  z-index: 999;
}
	</style>

@endsection
@section('javascript')
<script>
	@if(isset($m))
	alert('{{$m}}');

	@endif

</script>
<script type="text/javascript">

function confirma(e,v){
	var bool=confirm("Actividad:"+e);
	if(bool)
	{
		document.getElementById("envio"+v).click();
	}
	
}	
		
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
	
<script>

$("body").addClass("sidebar-collapse");

$('#dtmenuo').DataTable().destroy();
$('#tbobymenuo').html('');

$('#dtmenuo').show();
$.fn.dataTable.ext.errMode = 'throw';
	var table=$('#dtmenuo').DataTable(
	{

		dom: 'lfrtip',

		responsive: true, "oLanguage":
			{
				"sUrl": "/js/config/datatablespanish.json"
			},
	  
	  
		"lengthMenu": [[10, -1], [10, "All"]],
		"order": [[1, 'desc']],
		"searching": true,
		"info": true,
		"ordering": true,
		"bPaginate": true,
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"destroy": true,
		"ajax": "/datatableEvaluacionesSup/" ,

		"columns": [
	 
			{data: 'fecha_registro', "width": "10%"},
			{data: 'estudiante', "width": "10%"},

			{data: 'total', "width": "10%"},
			{
                    data: 'Opciones',
                    "width": "20%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.Opciones).text();
                    }
             },
	
			
		]
	}).ajax.reload();



</script>
@endsection
@section('content')
<hr/>
<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Inicio</div>

					<div class="panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="tabbable" id="tabs-999753">
										<ul class="nav nav-tabs">
											<li class="nav-item active">
												<a class="nav-link active" href="#panel-717633" data-toggle="tab">Consulta Evaluaciones</a>
											</li>
										@if($sup>0)
                    	<li class="nav-item ">
												<a class="nav-link " href="#panel-778868" data-toggle="tab">
													 Evaluaciones
                                                </a>
											</li>
                      @endif
										</ul>
										<div class="tab-content">
                    @if($sup>0)
											<div class="tab-pane " id="panel-778868">
                              <p>
                              <form method="POST" action="{{ route ('supervisor.evaluacionSupSave')}}" accept-charset="UTF-8">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <table width="100%" border="1">
                        
                                <tr>
                                <td>Estudiante</td>
                              
                                <td>Opciones</td>
                                </tr>
                                <tr>
                                <td>{!! Form::select('estudianteo', $objD, null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"estudianteo","placeholder"=>"ESTUDIANTES","name"=>"estudianteo","required"=>""]) !!}</td>
                                <td><button type="submit"class="btn btn-primary" id="enviarform">Generar</button></td>
                                </tr>
                  
                              </table>

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
                                                height:75.0pt;border-top:none;width:98pt'>ASPECTO TÉCNICOS / OPERATIVOS</td>
                                                <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
                                              Los conocimientos del practicante aseguran una exitosa realizacion de los trabajos</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e1" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e1" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e1" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e1" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e1" value="1"></td>
                                                <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
                                                border-top:none'>&nbsp;<input type="textarea" maxlength="255" class="form-control-t" name="ob1"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Posee iniciativa, constantemente pregunta por nuevos trabajos</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e2" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e2" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e2" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e2" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e2" value="1"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Demuestra capacidad y  compromiso en la realización de sus trabajos</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e3" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e3" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e3" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e3" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e3" value="1"></td>

                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Cumple con exactitud , esmero y orden de trabajos</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e4" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e4" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e4" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e4" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e4" value="1"></td>

                                              </tr>
                                              <tr height=40 style='mso-height-source:userset;height:30.0pt'>
                                                <td rowspan=4 height=100 class=xl662406 width=130 style='border-bottom:.5pt solid black;
                                                height:75.0pt;border-top:none;width:98pt'>ASPECTO SOCIAL</td>
                                                <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
                                                Su actitud es proactiva y facilita la tarea en equipo
                                                </td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e5" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e5" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e5" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e5" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e5" value="1"></td>
                                                <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
                                                border-top:none'>&nbsp;<input type="textarea" maxlength="255" class="form-control-t" name="ob2"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Coopera de manera permanente y espontánea</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e6" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e6" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e6" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e6" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e6" value="1"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Es repetuoso con todo el personal</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e7" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e7" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e7" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e7" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e7" value="1"></td>

                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Demuestra ser cuidadoso en su presentación personal</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e8" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e8" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e8" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e8" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e8" value="1"></td>

                                              </tr>
                                              <tr height=40 style='mso-height-source:userset;height:30.0pt'>
                                                <td rowspan=4 height=100 class=xl662406 width=130 style='border-bottom:.5pt solid black;
                                                height:75.0pt;border-top:none;width:98pt'>ASPECTO ESTRATÉGICO</td>
                                                <td colspan=3 class=xl672406 width=371 style='border-left:none;width:279pt'>
                                              Planifica y organiza de manera adecuada los trabjos diarios</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e9" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e9" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e9" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e9" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e9" value="1"></td>
                                                <td rowspan=4 class=xl712406 style='border-bottom:.5pt solid black;
                                                border-top:none'>&nbsp;<input type="textarea" maxlength="255" class="form-control-t" name="ob3"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Propone soluciones y/o alternativas para mejorar situaciones del trabajo</td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e10" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e10" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e10" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e10" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e10" value="1"></td>
                                              </tr>
                                              <tr height=20 style='height:15.0pt'>
                                                <td colspan=3 height=20 class=xl672406 width=371 style='height:15.0pt;
                                                border-left:none;width:279pt'>Es puntual en trabajo </td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio"required name="e11" value="5"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e11" value="4"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e11" value="3"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e11" value="2"></td>
                                                <td class=xl632406 style='border-top:none;border-left:none'><input type="radio" name="e11" value="1"></td>

                                              </tr>
                                              

                                              </table>

                             </div>

                                    </p>



                                </form>
                                </p>
                              
                              <hr/>
									
											</div>
                     @endif
											<div class="tab-pane active" id="panel-717633">
												<p>
												<div class="panel-body">
															<table class="table table-bordered table-striped " id="dtmenuo" style="width:100%!important" >
																<thead>

																<th>Fecha de Registro</th>
																<th>Estudiante</th>
																<th>Total</th>
																<th>Opciones</th>
															

																</thead>
																<tbody id="tbobymenuo">

																</tbody>
															</table>
												</div>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection

