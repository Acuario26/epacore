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
    @if(isset($m))
	alert('{{$m}}');

    @endif
	changeDatatable();
	
	function asignacionCulmina()
	{

		 var lstDepositos = [];
		 $("input:checkbox[name=IdDeposito]:checked").each(function () {
                    lstDepositos.push($(this).val().toString());
                });
              lstDepositos.join();  
        var data = new FormData();
        var d=$("#usuarios option:selected").html();
        var datass=d.split("-");
        d=datass[1];
		data.append('identidad',lstDepositos);
        data.append('usuario',$("#usuarios").val());
        data.append('d',d);


			var objApiRest = new AJAXRestFilePOST('/asignacionCulmina',  data);
			objApiRest.extractDataAjaxFile(function (_resultContent) {
				if (_resultContent.status == 200) 
				{  	    changeDatatable();
						alertToastSuccess(_resultContent.message,3500);
				} else {
                    alertToast(_resultContent.message,3500);

				}
			});
			  
			  
			  
		
	}
     	
	
	
    function changeDatatable() {
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
            "ajax": "/GestionLLamadaDatatable/", 
            "columns": [
			   {
                                                "data":"IDENTIDAD",
                                                "title": "",
                                                "render": function (data, type, row, meta) {
                                                    var checkbox = $("<input/>", {
                                                        "type": "checkbox"
                                                    });
                                                    checkbox.attr("value", data);
                                                    checkbox.attr("name","IdDeposito");
                                                    if (row[2] === "enable") {
                                                        checkbox.attr("checked", "checked");
                                                        
                                                        checkbox.addClass("checkbox_checked");
                                                    } else {
                                                        checkbox.addClass("checkbox_unchecked");
                                                    }
                                                    return checkbox.prop("outerHTML")
                                                }
                },
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
                {data: 'fecha_vencida', "width": "10%"},

                {data: 'dias_mora',
                "width": "10%",
                "bSortable": true,
                "searchable": true,
                "targets": 0,
                "render": function (data, type, row) {
                    return $('<div />').html(row.dias_mora).text();
                }},
                {data: 'valor_vencido', "width": "10%"},
                {
                    data: 'estados',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estados).text();
                    }
                },
                {
                    data: 'actions',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.actions).text();
                    }
                },
				
				{
                    data: 'actions2',
                    "width": "5%",
                    "bSortable": true,
                    "searchable": true,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.actions2).text();
                    }
                }
            ],

        }).ajax.reload();
$("#cel").val(1);

}






    </script>

@endsection
<div class="col-lg-6" style="float:right">
   <div class="col-lg-6" style="float:left">
   {!! Form::select('usuarios', $usuarios, null,['class' => 'form-control select2','id'=>'usuarios']) !!}
</div>
 <div class="col-lg-6">    <a href="#" class="btn btn-primary" onclick="asignacionCulmina()">Asignar</a>
    </div>
</div>
<div class="col-lg-12">
</div>
</div>
<div class="modal fade" id="ModalagregarCl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Asignacion de Clientes</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="col-lg-12" style="margin:5px">
                       
                            <div class="col-md-12">
                                agregar
                            </div>
                
                    </div>
                
                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                 <button type="submit" class="btn btn-primary">Grabar Asignacion</button>

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                    </form>	
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>
            <th></th>

            <th>Celular</th>
            <th>Identificacion</th>
            <th>Nombres y Apellidos</th>
            <th>Fecha Vencida</th>
            <th>Mora(Días)</th>
            <th>Adeudado</th>
            <th>Valor Pendiente</th>
            <th>Operador</th>
            
            <th>Recaudador</th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
    </div>
</div>

@endsection
