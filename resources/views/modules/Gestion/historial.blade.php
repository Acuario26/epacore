@extends('layouts.app')

@section('contentheader_title')
    EPACORE
@endsection

@section('contentheader_description')
    Sistema Integrado 
@endsection

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/pivot/') }}/pivot.css" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/sweetAlert/SWA.css') }}" rel="stylesheet">
    <link href="{{ url('css/bb.css') }}" rel="stylesheet">


  
@endsection
@section('javascript')
<script src="{{ url('adminlte/plugins/sweetAlert/SWA.js') }}"></script>

    <script src="{{ url('adminlte/plugins/pivot/') }}/pivot.js"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
    <script>
    $(document).ready(function () {
    $(function () {
        changeDatatable(0);  
    });
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
 $("#estadobandeja").on('change', function () {
      changeDatatable($("#estadobandeja").val());
    
    });
function changeDatatable(bandeja) {
    $("body").addClass("sidebar-collapse");
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                
                'excel'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[5, -1], [5, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": true,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/clientes/datatableH/"+bandeja, 
            "columns": [
                {
                    data: 'Estadollamada',
                    "width": "10%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                     

                        return $('<div />').html(row.Estadollamada).text();
                    }
                },
                {data: 'identificacion', "width": "5%"},
                {data: 'name', "width": "25%"},
                {data: 'inicio', "width": "10%"},
                {data: 'fin', "width": "10%"},
                {data: 'estados', "width": "10%"},
               
            ],

        }).ajax.reload();


}


function llamada(celular,
                convencional,
                laboral,
                referencia,
                nombrelaboral,
                nombrereferencia,
                id,
                identificacion,
                name,
                dias_mora,
                valor_vencido,
                valor_deuda,
                fecha_acuerdo,
                acuerdo,
                valor_cuota,
                valor_acuerdo,
                intentos,
                fecha_acuerdo2,
                acuerdo2,
                valor_cuota2,
                valor_acuerdo2)
{
    $("#idcl").val(id);
    $("#celularcl").text(celular);
    $("#convencionalcl").text(convencional);
    $("#referenciacl").text(referencia);
    $("#laboralcl").text(laboral);
    $("#nombrelaboralcl").text(nombrelaboral);
    $("#nombrereferenciacl").text(nombrereferencia);

    $("#identificacioncl").text(identificacion);
    $("#nombrecl").text(name);
    $("#dias_moracl").text(dias_mora);
    $("#valor_vencidocl").text(valor_vencido);
    $("#valor_deudacl").text(valor_deuda);

    $("#fecha_acuerdocl").text(fecha_acuerdo);
    $("#acuerdocl").text(acuerdo);
    $("#cuotascl").text(valor_cuota);
    $("#valor_acuerdocl").text(valor_acuerdo);

    $("#fecha_acuerdo2cl").text(fecha_acuerdo2);
    $("#acuerdo2cl").text(acuerdo2);
    $("#cuotas2cl").text(valor_cuota2);
    $("#valor_acuerdo2cl").text(valor_acuerdo2);
  
}

</script>



@endsection


<div class="modal fade" id="ModalConsultaLLamada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Datos del Cliente
                </h4>

            </div>
            <div class="modal-body">
                <div class="panel-body">
                <div class="container-fluid">
	<div class="row">
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
						<td width="35%">
                        <strong> Dias de Mora:</strong>
						</td>
						<td width="65%">
							
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
                    
						</td>
						
					</tr>
				
                    <tr>
						<td width="35%">
                        <strong>Convencional:</strong>
						</td>
						<td>
                        <span id="convencionalcl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Laboral:</strong>
						</td>
						<td>
							
                        <strong><span id="nombrelaboralcl"></span>&nbsp;</strong><span id="laboralcl"></span>

						</td>
						
					</tr>
                    <tr>
						<td width="35%">
                        <strong> Referencia:</strong>
						</td>
						<td>
                        <strong><span id="nombrereferenciacl"></span>&nbsp;</strong><span id="referenciacl"></span>

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
        <div class="col-md-6" >
    
    <label class="label label-warning"> <strong> Detalles del 1er Acuerdo de Pago</strong></label>

        <table class="table">
        
            <tbody>
                
                <tr>
                    <td width="35%">
                    <strong> Fecha de Acuerdo</strong>
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
    <div class="col-md-6"  id="form-llamadaL">
    
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

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="panel panel-default">
    

    <div class="panel-heading">
       
            <label><strong>Consulta de datos de Clientes:</strong>
            
            {!! Form::select('estadobandeja',$operadores, null,['class' => 'form-control select2',"style"=>"max-width:20%","id"=>"estadobandeja"]) !!}
        
            </label> 

      
    </div>

    <div class="panel-body">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>

            <th>Celular</th>
            <th>Identificacion</th>
            <th>Nombres y Apellidos</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estados</th>
            
            <th></th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
    </div>
</div>

@endsection
