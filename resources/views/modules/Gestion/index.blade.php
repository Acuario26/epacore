@extends('layouts.app')

@section('contentheader_title')
    EPACORE
@endsection

@section('contentheader_description')
<div class="col-md-4">
    Sistema Integrado 
    </div>
<div class="col-md-4">
    <button class="btn btn-warning btn-xs" onclick="Callband(1);"><i class="fa fa-play "></i>&nbsp;INICIAR LLAMADAS</button>
</div>
<div class="col-md-4" style="float:left">
    <button class="btn btn-danger btn-xs"  onclick="Callband(2)"><i class="fa fa-stop "></i>&nbsp;FINALIZAR LLAMADAS</button>
</div>
<input type="hidden" id="bandcall" value="0"/>
@endsection

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/pivot/') }}/pivot.css" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/sweetAlert/SWA.css') }}" rel="stylesheet">
    <link href="{{ url('css/bb.css') }}" rel="stylesheet">


  
@endsection
@section('javascript')
<script src="{{ url('adminlte/plugins/sweetAlert/SWA.js') }}"></script>

    <script src="{{ url('js/modules/gestion/clientes.js') }}"></script>
    <script src="{{ url('adminlte/plugins/pivot/') }}/pivot.js"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
    <script>
    $("document").ready(function() {
            var count=1;
        });
 @if(isset($m))
	alert('{{$m}}');

	@endif
        $('.pickadate').datepicker({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
            selectYears: true,
            editable: true,
            autoclose: true,
            orientation: 'top'
        });

       $('#valor_acuerdo').on('keyup',function(e)
       {
        if($('#valor_acuerdo').val()==0)
        {
            $('#valor_pendiente').val(0);
        }
        if(parseFloat($('#valor_acuerdo').val())>parseFloat($('#valor_vencidocl').text()))
        {
            $('#btnAcuerdo').prop('disabled',true);
            $('#valor_acuerdo').val(0);
            alertToast('El valor de pago no puede ser mayor al valor vencido',3000);
        }else{
           
            var total_pendiente=parseFloat($('#valor_vencidocl').text())-parseFloat($('#valor_acuerdo').val()!=''?$('#valor_acuerdo').val():0);
            $('#btnAcuerdo').prop('disabled',false);
            $('#valor_pendiente').val(total_pendiente.toFixed(2));
            if(total_pendiente<0)
            {
                $('#btnAcuerdo').prop('disabled',true);
                alertToast('El valor de pago no puede ser mayor al valor vencido',3000);
                $('#valor_acuerdo').val(0);
                if($('#valor_acuerdo').val()==0)
                {
                    $('#valor_pendiente').val(0);
                }
            }
        }

       }); 
        
    </script>
        <script>
    /**
     * Función que solo permite la entrada de numeros, un signo negativo y
     * un punto para separar los decimales
     */
    function soloNumeros(e)
    {
        // capturamos la tecla pulsada
        var teclaPulsada=window.event ? window.event.keyCode:e.which;
 
        // capturamos el contenido del input
        var valor=document.getElementById("valor").value;
 
        // 45 = tecla simbolo menos (-)
        // Si el usuario pulsa la tecla menos, y no se ha pulsado anteriormente
        // Modificamos el contenido del mismo añadiendo el simbolo menos al
        // inicio
     
 
        // 13 = tecla enter
        // 46 = tecla punto (.)
        // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
        // punto
        if(teclaPulsada==13 || (teclaPulsada==46 && valor.indexOf(".")==-1))
        {
            return true;
        }
 
        // devolvemos true o false dependiendo de si es numerico o no
        return /\d/.test(String.fromCharCode(teclaPulsada));
    }
    </script>

<script>
var dato=0;
function iniciarllamada(tipo,numero)
{
	var data          = new FormData();
    var id=$("#idcl").val();
    var celu=$("#cel").val();
    var conve=$("#conve").val();
    var labo=$("#labo").val();
    var refe=$("#refe").val();	
    var idLLamada=$("#idLLamada").val();
	//var numero=0;
    var comentario="";
	
     switch(tipo)
	 {
			case "iniciar":
			   if(idLLamada=="0")
			   {
				   if(numero==0)
				   {
					   numero=celu;
				   }
				 $("#checkCel").removeClass("hidden");

			    window.open("../manager_socket.php?NUMERO="+numero+"" , 'Nombre de la ventana');
					
				dato=1;
			   }
			 break;
		    case "terminar":
			 dato=2;
			break;
			case "colgado":
			dato=3;
			break;
		 
	 }
	
   
	if(dato!=0)
	{
		

            data.append('id',   id ? id: '' );
            data.append('celular',   numero ? numero: '' );
            data.append('dato',   dato ? dato: 0 );
            data.append('idLLamada',   idLLamada ? idLLamada: 0 );
            data.append('comentario',   comentario ? comentario: 0 );

            var objApiRest = new AJAXRestFilePOST('/iniciarllamada',  data);
            objApiRest.extractDataAjaxFile(function (_resultContent) {
                if (_resultContent.status == 200) 
                {
							
                   
								if(dato==3)
									{
											count=count+1;
											if(count<5)
											{
												switch(count)
												{
													case 2:
																	   numero=conve;
																	   $("#idLLamada").val(0);
																	   $("#checkConve").removeClass("hidden");

																	   iniciarllamada("iniciar",numero)
														break;
													case 3:
																		 numero=labo;
																		 $("#idLLamada").val(0);
																		  $("#checkLabo").removeClass("hidden");

																		iniciarllamada("iniciar",numero)

													break;
													case 4: 
																		numero=refe;
																		$("#idLLamada").val(0);
																		 $("#checkRefe").removeClass("hidden");

																		iniciarllamada("iniciar",numero)
													
													break;
													
												}
												
											}else{
                                                count=1;
                                            }
										
									}else{
										$("#idLLamada").val(_resultContent.message);
									}
		
                    if(tipo!="iniciar")
                    {
                        $("#bandcall").val(1);
                    }
                    
                } else {
                        dato=0;
						$("#bandcall").val(0);
						alertToast("Hubo un error se detendra el proceso de llamadas",3500);
                }
            });
            $("#cuota_acuerdo").val(0);
            $("#valor_acuerdo").val(0);
            $("#fecha_acuerdo").html('');
            $("#acuerdo").html('');
            $("#acuerdo").val('');
            $("#acuerdo").text('');

            $("#valor_pendiente").val(0);
	}
}

function Callband(tipo)
{
    bandcall=tipo!=2?1:0;
    $("#bandcall").val(bandcall);
}
</script>



@endsection


<a href="../manager_socket.php" target="_blank" id="callautomatico" class="hidden">llamada</a>
                         
@if($admin>0)


<div class="col-lg-2" style="float:right">
    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-primary"
       data-target="#ModalagregarCl" data-toggle="modal" id="modal" onclick="start()">Nuevo</a>
    
</div>
@endif


<input type="hidden" value="0" id="idLLamada">
<div class="modal fade" id="ModalagregarCl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Clientes</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">

                
                    <div class="col-lg-12" style="margin:5px">
                       
                            <div class="col-md-12">
                            <div class="col-md-12"> 
                            <h4>Datos Personales</h4>
                            <hr/>
                            </div>
                            <div class="col-md-4">
                            <strong>Identificacion:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datoidentificacion"required maxlength="10" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Nombre y Apellidos:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datonombres" required class="form-control"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Ciudad:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datociudad"  class="form-control"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Celular:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datocelular" required class="form-control" maxlength="10" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Direccion:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="textarea" id="datodireccion" class="form-control" style="max-height:200px"rows="3"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Fecha/Vencimiento:</strong>
                            </div>  
                            <div class="col-md-8">
                            {!! Form::text('datofecha_vencida',' ',['class'=>'form-control pickadate','id'=>'datofecha_vencida','placeholder'=>'Seleccione fecha ', ""]) !!}
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>valor vencido:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input  id="datovalor_vencido" required class="form-control" type="number"  pattern="\d.{2}$" step="0.01" value="0.01"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Convencional:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datoconvencional"  class="form-control" maxlength="10"  onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
                            </div>
                            <div class="col-md-12"> 
                            <h4>Referencia Laboral</h4>
                            <hr/>
                            </div>
                            <div class="col-md-4">
                            <strong>Entidad(Laboral):</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datonombrelaboral"  class="form-control"/>
                            </div> 
                            
                            <div class="col-md-4">
                            <strong>Celular Laboral:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datocelularlaboral"  class="form-control" maxlength="10" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                            </div> 
                            <div class="col-md-12"> 
                            <h4>Referencia Personal</h4>
                            <hr/>
                            </div>
                            <div class="col-md-4">
                            <strong>Nombre Referencia:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datonombrereferencia"  class="form-control"/>
                            </div>
                            <div class="col-md-4">
                            <strong>Referencia Personal:</strong>
                            </div>  
                            <div class="col-md-8">
                            <input type="text" id="datocelularreferencia" class="form-control"onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>
                            </div> 
                      </div>
                
                    </div>
                
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                 <button  class="btn btn-primary" onclick="grabardata()">Subida de Datos</button>

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recaudaciones</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="col-lg-12" style="margin:5px">
                       
                    <form action="/clientes/uploadFinal" method="post" enctype="multipart/form-data">
                            <div class="col-md-12">
                              
                              <div class="col-md-3">
                                <strong>Entidad:</strong>
                               </div>
                               <div class="col-md-9">
                               {!! Form::text('entidad', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"entidad",'id'=>'entidad'])!!}
                               <hr />
                               </div>
                               <div class="col-md-3">
                                <strong>Tipo/Pago:</strong>
                               </div>
                               <div class="col-md-9">
                               {!! Form::select('tipo_pago', $tipo_pago, null,['class' => 'form-control select2','id'=>'tipo_pago']) !!}
                               <hr />
                               </div>
                               <div class="col-md-3">
                                <strong>Comprobante:</strong>
                               </div>
                               <div class="col-md-9">
                               {!! Form::text('comprobante', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Comprobante",'id'=>'comprobante','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'])!!}
                               <hr />
                               </div>
                               
                                <div class="col-md-3">
                                <strong>Valor:</strong>
                               </div>
                               
                               <div class="col-md-9">
                               {!! Form::text('valor', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Valor","onkeypress"=>"return soloNumeros(event);",'id'=>'valor'])!!}
                               <hr />
                               </div>
                         <h5> <strong>Suba la imagen del documento</strong>   </h5>
                          <strong>Efectivo- cedula /Comprobante - Documento</strong>
						{{ csrf_field() }}
                        {!! Form::hidden('id', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"id",'maxlength'=>'13','id'=>'id'])!!}
						<hr />
						<input type="file" class="form-control" name="archivo" accept=".jpeg" required />
						<br /><br />
					

                            </div>
                
                    </div>
                
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                 <button type="submit" class="btn btn-primary">Subida de Datos</button>

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                    </form>	
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recaudaciones del Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                <table class="table table-bordered table-striped" id="dtrecaudo" style="width:100%!important">
                    <thead>

              
                    <th>COMPROBANTE</th>
                    <th>VALOR</th>
                    <th>TIPO/PAGO</th>
                    <th>RECAUDADOR</th>
                    
                    <th>ESTADO</th>
              

                    </thead>
                    <tbody id="tbobyrecaudo">

                    </tbody>
                </table>

                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalConsultaLLamada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Datos del Cliente
                <button class="btn btn-warning btn-xs hidden" id="iniciar" onclick="iniciarllamada('iniciar',0);"><i class="fa fa-play "></i></button>
                <button class="btn btn-danger btn-xs hidden" id="terminar"  onclick=""><i class="fa fa-stop "></i>EXITOSO</button>
                <button class="btn btn-info btn-xs" id="colgado"  onclick="iniciarllamada('colgado',0)"><i class="fa fa-stop "></i>NO EXITOSO</button>
                </h4>  

            </div>
            <div class="modal-body">
                <div class="panel-body">
                <div class="container-fluid">
	<div class="row">
	
				<input type="text" id="cel" class="hidden" value="0"/>
				<input type="text" id="conve" class="hidden" value="0"/>
				<input type="text" id="labo" class="hidden" value="0"/>
				<input type="text" id="refe" class="hidden" value="0"/>
				
				
		<div class="col-md-12">
        <div class="col-md-6"> 
        <div class="table table-responsive">
        <table style="font-size:12px;border:0px;width:100%">
        <tr>
						<td width="35%">
							<strong>Cedula:</strong>
						</td>
						<td width="65%">

                    <span id="identificacioncl"></span>
                    
						</td>
						
					</tr>
				
                    <tr>
						<td width="35%">
                        <strong>Nombres y Apellidos:</strong>
						</td>
						<td width="65%">
                        <span id="nombrecl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%" style="background-color:yellow">
                        <strong> Dias de Mora:</strong>
						</td>
						<td width="65%" style="background-color:yellow;font-weight:bold">
                        <span id="dias_moracl"></span>
						</td>
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Total Adeudado: </strong>
						</td>
						<td width="65%">
                        <span id="valor_vencidocl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Total Pagado:</strong>
						</td>
						<td width="65%">
                        <span id="valor_deudacl"></span>

						</td>
						
					</tr>
        </table>
        </div>
        </div>
        <div class="col-md-6">
        <div class="table table-responsive">

			<table  style="font-size:12px;border:0px;width:50%"">
            <tr>
						<td width="35%">
							<strong>Celular:</strong>
						</td>
						<td>

						<span id="celularcl"></span>
                    	<i class="fa fa-check hidden" id="checkCel"></i>

						</td>
						
					</tr>
				
                    <tr>
						<td width="35%">
                        <strong>Convencional:</strong>
						</td>
						<td>
                        <span id="convencionalcl"></span>
						<i class="fa fa-check hidden"  id="checkConve"></i>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Laboral:</strong>
						</td>
						<td>
							
                        <strong><span id="nombrelaboralcl"></span>&nbsp;</strong><span id="laboralcl"></span>
						<i class="fa fa-check hidden"  id="checkLabo"></i>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Referencia:</strong>
						</td>
						<td>
                        <strong><span id="nombrereferenciacl"></span>&nbsp;</strong><span id="referenciacl"></span>
						<i class="fa fa-check hidden"  id="checkRefe"></i>
						</td>
						
					</tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                    </tr>
			</table>
            </div>
            </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6" id="form-llamada">
        <div class="panel panel-heading">
          <label class="label label-warning"> <strong> Formulario de Acuerdo de Pago</strong></label>
        </div>
			<div class="panel panel-body">

                            <div class="col-md-4">
                            <strong>Fecha de Acuerdo:</strong>
                            </div>  
                            <div class="col-md-8">
                            {!! Form::text('fecha_acuerdo',' ',['class'=>'form-control pickadate','id'=>'fecha_acuerdo','placeholder'=>'Seleccione fecha ', ""]) !!}
                            </div> 
                            <div class="col-md-12" >
                            
                            </div>
                            <div class="col-md-4 hidden">
                            <strong>Cantidad/Cuotas:</strong>
                            </div>  
                            <div class="col-md-8 hidden">
                            <input  id="cuota_acuerdo" value="1" class="form-control" type="text" maxlength="3"  onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                            </div> 
                            
                            <div class="col-md-12" >
                            <br/>
                            </div>
                            <div class="col-md-4">
                            <strong>Valor pagado:</strong>
                            </div>  
                            <div class="col-md-8">
                            {!! Form::text('valor_acuerdo', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Valor a Pagar","onkeypress"=>"return soloNumeros(event);",'id'=>'valor_acuerdo'])!!}
                            </div> 
                            

                            <div class="col-md-12" >
                            <br/>
                            </div>
                            <div class="col-md-4">
                            <strong>Valor pendiente:</strong>
                            </div>  
                            <div class="col-md-8">
                            {!! Form::text('valor_pendiente', null,["disabled"=>"disabled","class"=>"form-control" ,"placeholder"=>"Valor Pendiente","onkeypress"=>"return soloNumeros(event);",'id'=>'valor_pendiente'])!!}
                            </div> 

                            <div class="col-md-12" >
                            <br/>
                            </div>
                            <div class="col-md-4">
                            <strong>Comentario</strong>
                            </div>  
                            <div class="col-md-8">
                            {{ Form::textarea('acuerdo', null, ['class' => 'form-control-t','row'=>'3','style' => 'max-height: 50px; resize: none;','placeholder' => 'Ingrese Acuerdo',"name"=>"acuerdo","id"=>"acuerdo"]) }}
                            </div> 
                            <input type="hidden" id="idcl">

            </div>
		</div>
		<div class="col-md-6" >
    
        <label class="label label-warning"> <strong> Detalles del 1er Acuerdo de Pago</strong></label>

			<table class="table">
			
				<tbody>
					
                    <tr>
						<td width="35%">
                        <strong> Fecha de Acuerdo </strong>
						</td>
						<td>
                        <span id="fecha_acuerdocl"></span>

						</td>
						
					</tr>
           
                    <tr>
						<td width="35%" class="hidden">
                        <strong> Cuotas</strong>
						</td>
						<td class="hidden">
                        <span id="cuotascl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong>  Valor/Acuerdo</strong>
						</td>
						<td>
                        <span id="valor_acuerdocl"></span>
						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong>  Acuerdo</strong>
						</td>
						<td>
                        <span id="acuerdocl"></span>
						</td>
						
					</tr>

				</tbody>
			</table>
		</div>
        <div class="col-md-6 hidden"  id="form-llamadaL">
        
        <label class="label label-warning"> <strong> Detalles del  2do Acuerdo de Pago</strong></label>

			<table class="table">
			
				<tbody>
				
                    <tr>
						<td width="35%">
                        <strong> Fecha de Acuerdo</strong>
						</td>
						<td>
                        <span id="fecha_acuerdo2cl"></span>

						</td>
						
					</tr>
           
                    <tr>
						<td width="35%" class="hidden">
                        <strong> Cuotas</strong>
						</td>
						<td class="hidden">
                        <span id="cuotas2cl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong>  Valor/Acuerdo</strong>
						</td>
						<td>
                        <span id="valor_acuerdo2cl"></span>
						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong>  Acuerdo</strong>
						</td>
						<td>
                        <span id="acuerdo2cl"></span>
						</td>
						
					</tr>
				</tbody>
			</table>
		
        </div>
	</div>
</div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                {!! Form::button('<b><i class="glyphicon glyphicon-check"></i></b>Guardar Acuerdo de Pago', array('type' => 'button', 'class' => 'btn btn-primary ','id' => 'btnAcuerdo','onclick'=>'saveAcuerdo()')) !!}

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelarAcu", 'data-dismiss'=>"modal")) !!}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="panel panel-default">
    

    <div class="panel-heading">
       
            <label><strong>Consulta de datos de Clientes:</strong>
            @if($admin>0)
            {!! Form::select('estadobandeja', $estado, null,['class' => 'form-control select2',"style"=>"max-width:20%","id"=>"estadobandeja"]) !!}
            @endif
            </label> 

      
    </div>

    <div class="panel-body">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>

            <th>Celular</th>
            <th>Identificacion</th>
            <th>Nombres y Apellidos</th>
            <th>Fecha Vencida</th>
            <th>Mora(Días)</th>
            <th>Adeudado</th>
            <th>Valor Pendiente</th>
            <th>ULT/PAGO</th>
            
            <th></th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
    </div>
</div>
  <form action="/manager_socket.php" method="POST" target="_blank">
                                    <input type="hidden" name="Extension" id="Extension">
                                   <!-- <input type="hidden" name="Prefijo"  id="Prefijo">-->
                                    <input type="hidden" name="receptor"  id="receptor">
                                    <div class="col-lg-12 hidden" style=""><button id="btnenviarllamada">Enviar</button></div>
    </form>
@endsection
