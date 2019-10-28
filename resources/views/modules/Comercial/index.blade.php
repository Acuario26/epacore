@extends('layouts.app')
@section('css')
<link href="{{ url('adminlte/plugins/fileinput/fileinput.min.css') }}"rel="stylesheet">
<link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">

<style>
.file-error-message {
    font-size: 12px!important;
}
         .btn-file{
             padding: 1px 5px!important;
            font-size: 12px!important;
            line-height: 1.5!important;
            max-height: 25px!important;
        }
        .fileinput-remove{
            padding: 1px 5px!important;
            font-size: 12px!important;
            line-height: 1.5!important;
        }
        .kv-file-content{
            display:none;
        }
        .file-thumbnail-footer{
            background: url("/images/icons/excel.png") center;
            background-size: 70px 70px;
            background-repeat: no-repeat;
        }
        .file-footer-caption{
           color:#fff0!important;
        }
        .file-upload-indicator{
            display:none!important;
        }
        .file-thumbnail-footer
        {
            width: 80px; 
        }
      
</style>
@endsection
@section('javascript')
<script src="{{ url('adminlte/plugins/fileinput/fileinput.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>

<script>
Arreglochecklist='';
var datalote=''
var dataloteR=''
$("body").addClass("sidebar-collapse");
 $('.file-input-new').fileinput({
            showUpload: false,
            showPreview: true,
            browseLabel: "",
            removeLabel: "Quitar",
            allowedFileExtensions: ['xls','xlsx'],
            maxFileCount: 1,
            maxFileSize: 5120
        }).on('fileerror', function (event, data) {
            alertToast("Solo se admiten máximo 1 archivo y las extensiones deben ser pdf con un peso para cada uno de 5mb", 2000);
        });
function cargadata(){
    modal.style.display = "block";
    $("#envioArchivo").removeClass('hidden');
    $("#envioEsperando").addClass('hidden');
}
function getdataLote(i=1){
    var data= new FormData();
    var fecha_fin=$("#fecha_fin").val();
    var fecha_inicio=$("#fecha_inicio").val();
    data.append('fechai',fecha_inicio);
    data.append('fechaf',fecha_fin);
    datalote=[];
    var objApiRest = new AJAXRestFilePOST('/comercial/getLote',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            datalote=_resultContent.message;
            if(i==1)
			getdatatablependiente();          
        }else{
            getdatatablependiente();
            alertToast(_resultContent.message,3500);
        } 
    });
}
function getdataLoteR(i=1){
    var data= new FormData();
    
    var fecha_fin=$("#fecha_fin").val();
    var fecha_inicio=$("#fecha_inicio").val();
    data.append('fechai',fecha_inicio);
    data.append('fechaf',fecha_fin);
    dataloteR=[];
    var objApiRest = new AJAXRestFilePOST('/comercial/getLoteR',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            dataloteR=_resultContent.message;
            if(i==1)
            getdatatablependienteR();
        }else{
            
            getdatatablependienteR();
            alertToast(_resultContent.message,3500);
        }
    });
}
function saveFile(){
    var data= new FormData();
    var error=0;
    $('#excel').each(function(a, array)
    {
        if(array.files.length<1)
        {
             error=1;
             data.append('excel','');
            
            return false;
        }
        $.each(array.files, function (k, file)
        {
            data.append('excel', file);
        })
    });
    var tabla=$("#tipoTabla").val();
    if(tabla==null||tabla=='')
      {
          error=1;
          alertToast("No ha seleccionado un Tipo de Lote",3500);
          return false;
      }

    if(error!=1)
    {
	    tabla=$("#tipoTabla option:selected" ).text();

        data.append('tabla',tabla);
        $("#envioArchivo").addClass('hidden');
        $("#envioEliminados").addClass('hidden');
        $("#envioEsperando").removeClass('hidden');
        $(".fileinput-remove,.file-input-new").attr('disabled','disabled');
        $(".close").addClass('hidden');
        if(tabla!='FACTURACION')
        {
            var objApiRest = new AJAXRestFilePOST('/comercial/importR',  data);
            objApiRest.extractDataAjaxFile(function (_resultContent) {
                if (_resultContent.status == 200) {
                    alertToastSuccess(_resultContent.message,3500);
                    getdataLoteR();  
                    $("#envioArchivo").removeClass('hidden');
                    $("#envioEliminados").removeClass('hidden');
                    $("#envioEsperando").addClass('hidden');
                    $(".fileinput-remove,.file-input-new").removeAttr('disabled');
                    $(".close").removeClass('hidden');
                    $(".close").click();
                     $("#btnCancelar").click();    
                } else{
                   
                    alertToast("Error en el archivo de importacion",3500);
                }
            });
        }else{
            var objApiRest = new AJAXRestFilePOST('/comercial/import',  data);
            objApiRest.extractDataAjaxFile(function (_resultContent) {
                if (_resultContent.status == 200) {
                    alertToastSuccess(_resultContent.message,3500);
                    getdataLote();      
                    $("#envioArchivo").removeClass('hidden');
                    $("#envioEliminados").removeClass('hidden');
                    $("#envioEsperando").addClass('hidden');
                    $(".fileinput-remove,.file-input-new").removeAttr('disabled');
                    $(".close").removeClass('hidden');
                    $(".close").click();
                     $("#btnCancelar").click();   
                }else{
                    alertToast("Error en el archivo de importacion",4500);
                    $("#btnCancelar").click();   
                } 
            });
        }
                    
    }else{
        alertToast("No hay archivo cargado",3500);
    }
       
}
function EliminarFile(){
    swal({
            title: "¿Estas seguro de realizar esta accion?",
            text: "Al confirmar se ejecutara el proceso exitosamente",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si!",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                if(Arreglochecklist.length>1)
                    {
                            var data= new FormData();
                            data.append('Arreglochecklist',Arreglochecklist);
                            
                            tabla=$("#tipoTabla option:selected" ).text();

                            if(tabla=='FACTURACION')
                            var objApiRest = new AJAXRestFilePOST('/comercial/eliminaFile',  data);
                            else
                            var objApiRest = new AJAXRestFilePOST('/comercial/eliminaFileR',  data);

                            objApiRest.extractDataAjaxFile(function (_resultContent) {
                                if (_resultContent.status == 200) {
                                    alertToastSuccess(_resultContent.message,3500);
                                    if(tabla=='FACTURACION'){
                                        getdataLote(); 
                                    }
                                     else{
                                         getdataLoteR(); 
                                     }

                                }else{
                                    alertToast(_resultContent.message,3500);
                                }
                            });
                    }else{
                            alertToast("No ha seleccionado ningun registro",3500);
                    }
            } else {
                swal("¡Cancelado!", "No se registraron cambios...", "error");
            }
        });
}


$("#btnConsultar").on("click",function(){
    var tabla=$("#tipoTablaConsulta").val();
    $("#tipoTabla").val(tabla).change();
    if(tabla==null||tabla=='')
      {
          error=1;
          alertToast("No ha seleccionado un Tipo de Lote",3500);
          return false;
      }
    tabla=$("#tipoTabla option:selected" ).text()!='FACTURACION'?getdataLoteR():getdataLote();

});



function getdatatablependiente(){
            var dt = {
                draw: 1,
                recordsFiltered: datalote.length,
                recordsTotal: datalote.length,
                data: datalote
            };
            $("#tablaConsulta").attr('style','margin-top:10px');
            $('#tbobymenu').show();
            $.fn.dataTable.ext.errMode = 'throw';
            $("#dtmenu").dataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                        titleAttr: 'Excel'
                    },
                 
                    {
                        extend:    'pdfHtml5',
                        text:      '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        title:'PLANTILLAS REGISTRADOS',
                        footer: true,
                        pageSize: 'A4'
                    }
                ],
                "lengthMenu": [[5, -1], [5, "TODOS"]],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "draw": dt.draw,
                "destroy":true,
                "recordsFiltered": dt.recordsFiltered,
                "recordsTotal": dt.recordsTotal,
                "data": dt.data,
                "order": [[1, "desc"]],
                
                "columnDefs": [
                    { "targets": [0], "orderable": true }
                ],
                "columns": [
                    {
                                title:'<input type="checkbox"  id="selectall" onclick="chequearTodos(this)">',
                                  data: 'actions',
                                  "width": "5%",
                                  "bSortable": false,
                                  "searchable": false,
                                  "targets": 0,
                                  "render": function (data, type, row) {
                                    var html='<input type="checkbox" class="case" onclick="ListaElimina(\'' + row.id + '\');" value="'+ row.id +'" name="checklist[]">';
                                                        return html;
                                  }
                              },
                    {title:'N&deg;',data: 'id', "width": "5%"},
                    {title:'Fecha/Creacion',data: 'created_at', "width": "5%"},
                    {title:'Emisión',data: 'emision', "width": "15%"
                        ,"render": function (data, type, row) {
                            
                                    return row.emision;
                                }
                    
                    },
                    {title:'MES',data: 'mes', "width": "15%"
                        ,"render": function (data, type, row) {
                            
                            return row.mes.split('.')[1];
                        }
                    },
                    {title:'Codigo',data: 'codigo', "width": "15%"},
                    {title:'DH',data: 'dh', "width": "15%"},
                    {title:'CAC',data: 'cac', "width": "15%"},
                    {title:'TIPOS',data: 'tipo', "width": "15%"},
                    {title:'TIPOS /FACTURACION',data: 'tipos_facturacion', "width": "15%"},
                    {title:'VALOR',data: 'valor', "width": "15%"},
                    {title:'SALDO',data: 'saldo', "width": "15%"},
                            
                            {title:'ESTADO',data: 'estado', "width": "5%"
                                ,"render": function (data, type, row) {
                                    var st='<label class="label label-danger label-xs">ELIMINADO</label>';
                                    if(row.estado!='INA')   
                                    st='<label class="label label-primary label-xs">SUBIDO</label>';
                                    return st;
                                }
                             },
                             
                             

                ],
            });
     
}
function getdatatablependienteR(){
            var dt = {
                draw: 1,
                recordsFiltered: dataloteR.length,
                recordsTotal: dataloteR.length,
                data: dataloteR
            };
            $("#tablaConsulta").attr('style','margin-top:10px');
            $('#tbobymenu').show();
            $.fn.dataTable.ext.errMode = 'throw';
            $("#dtmenu").dataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                        titleAttr: 'Excel'
                    },
                 
                    {
                        extend:    'pdfHtml5',
                        text:      '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        title:'PLANTILLAS REGISTRADOS',
                        footer: true,
                        pageSize: 'A4'
                    }
                ],
                "lengthMenu": [[5, -1], [5, "TODOS"]],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "draw": dt.draw,
                "destroy":true,
                "recordsFiltered": dt.recordsFiltered,
                "recordsTotal": dt.recordsTotal,
                "data": dt.data,
                "order": [[1, "desc"]],
                
                "columnDefs": [
                    { "targets": [0], "orderable": true }
                ],
                "columns": [
                    {
                                title:'<input type="checkbox"  id="selectall" onclick="chequearTodos(this)">',
                                  data: 'actions',
                                  "width": "5%",
                                  "bSortable": false,
                                  "searchable": false,
                                  "targets": 0,
                                  "render": function (data, type, row) {
                                    var html='<input type="checkbox" class="case" onclick="ListaElimina(\'' + row.id + '\');" value="'+ row.id +'" name="checklist[]">';
                                                        return html;
                                  }
                              },
                              {title:'N&deg;',data: 'id', "width": "5%"},
                    {title:'Fecha/Creacion',data: 'created_at', "width": "5%"},
                    {title:'Emisión',data: 'emision', "width": "15%"
                        ,"render": function (data, type, row) {
                            
                                    return row.emision;
                                }
                    
                    },
                    {title:'MES',data: 'mes', "width": "15%"
                        ,"render": function (data, type, row) {
                            
                            return row.mes.split('.')[1];
                        }
                    },
                    {title:'Codigo',data: 'codigo', "width": "15%"},
                    {title:'DH',data: 'dh', "width": "15%"},
                    {title:'CAC',data: 'cac', "width": "15%"},
                    {title:'TIPOS /FACTURACION',data: 'tipo_facturacion', "width": "15%"},
                    {title:'VALOR CUBIERTO',data: 'valor_cubierto', "width": "15%"},
                    {title:'VALOR COBRO',data: 'valor_cobro', "width": "15%"},
                    {title:'FECHA COBRO',data: 'fecha_cobro', "width": "15%"},       
                            {title:'ESTADO',data: 'estado', "width": "5%"
                                ,"render": function (data, type, row) {
                                       st='<label class="label label-primary label-xs">SUBIDO</label>';

                                    return st;
                                }
                             },
                             
                             

                ],
            });
     
}
function chequearTodos(e){
  $('[name="checklist[]"]').prop("checked", e.checked);
  ListaElimina(0);  
}

function ListaElimina(id)
{
                var arr = $('[name="checklist[]"]:checked').map(function(){
                return this.value;
                }).get();
                Arreglochecklist= arr.join(','); 
           
}
$('.pickadate').datepicker({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
            selectYears: true,
            editable: true,
            autoclose: true,
            orientation: 'top'
        });
</script>
@endsection

@section('content')
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Carga Lotes</h4>
            </div>
            <div class="modal-body">
                                 <label>Lote:</label>
                                 {!! Form::file('excel',['id'=>'excel','label'=>'SELECCIONE UN LOTE ','required'=>true,'multiple'=>"multiple", 'class'=>"file-input-new"]) !!}
                                <label>Tipo:</label>
                                 {!! Form::select('tipoTabla',$tabla,null,['id'=>'tipoTabla','placeholder'=>'SELECCIONE UN TIPO DE ARCHIVO', 'class'=>"form-group select2"]) !!}
                                 <br/>
                           
            </div>
            <div class="modal-footer">
                    {!! Form::button('<b></b> Cargar Archivo', array('type' => 'button', 'class' => 'btn btn-primary','id' => "envioArchivo","onclick"=>"saveFile()")) !!}
                    {!! Form::button('<b><i class="fa fa-spinner fa-pulse fa-fw"></i></b>Enviando...', array('type' => 'button', 'class' => 'btn btn-primary','id' => "envioEsperando","onclick"=>"saveFile()","disabled"=>"disabled")) !!}
                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger cerrarmodal','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
            </div>
         
        </div>
        
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Consulta de datos
        <div style="float:right">
                <a href="#" class="btn btn-default btn-xs" title="Agregar Nuevo Lote" onclick="cargadata()"> <i class="fa fa-plus"></i></a>    
        </div>
    
    </div>

    <div class="panel-body">
                    <div class="col-lg-12">
						<div class="col-lg-2">
						
							{!! Form::text('fecha_inicio','',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Seleccione fecha ', 'id'=>'fecha_inicio']) !!}
						</div>
						<div class="col-lg-1">
							<i class="fa fa-calendar"></i>
						</div>
						<div class="col-lg-2">
							{!! Form::text('fecha_final','',['class'=>'form-control pickadate','id'=>'fechaf','placeholder'=>'Seleccione fecha ', 'id'=>'fecha_fin']) !!}
						</div>
						<div class="col-lg-1">
							<i class="fa fa-calendar"></i>
						</div>
						<div class="col-lg-2">

						{!! Form::select('tipoTablaConsulta',$tabla,null,['id'=>'tipoTablaConsulta','placeholder'=>'SELECCIONE EL LOTE', 'class'=>"form-group select2"]) !!}
						</div>
						<div class="col-lg-1">
							{!! Form::button('<b><i class="fa fa-sync"></i></b> Consultar Lote', array('type' => 'button', 'class' => 'btn btn-primary btn-xs','id' => "btnConsultar")) !!}
						</div>
					</div>
<hr/>

    <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
     </div>
     <div class="col-md-1" id="envioEliminados">  
                                 <button class="btn btn-danger btn-xs" value="Eliminar" onclick="EliminarFile()" id="eliminadatos">
                                     Eliminar Datos Seleccionados
                                 </button>
                            </div>
    </div>
@endsection
