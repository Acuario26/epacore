@extends('layouts.appsn')

@section('contentheader_title')
  
@endsection

@section('contentheader_description')
    
@endsection

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

    
<style>
/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  height: 20px;
  float:right;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 12px;
  width: 15px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.default:checked + .slider {
  background-color: #444;
}
input.primary:checked + .slider {
  background-color: #2196F3;
}
input.success:checked + .slider {
  background-color: #8bc34a;
}
input.info:checked + .slider {
  background-color: #3de0f5;
}
input.warning:checked + .slider {
  background-color: #FFC107;
}
input.danger:checked + .slider {
  background-color: #f44336;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.list-group-item {
    height: 49px!important;
    padding: 0px 10px!important;
}
.form-group {
    margin-bottom: 15px!important;
}
</style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/informes/informetics.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
    <script src="{{ url('adminlte/plugins/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript">
    var archivo=[];
            $(function() {
                $('input[name="fechaconsulta"]').daterangepicker({
                                "locale": {
                                    "format": "YYYY-MM-DD",
                                    "separator": "/",
                                    "applyLabel": "Guardar",
                                    "cancelLabel": "Cancelar",
                                    "fromLabel": "Desde",
                                    "toLabel": "Hasta",
                                    "customRangeLabel": "Personalizar",
                                    "daysOfWeek": [
                                        "Do",
                                        "Lu",
                                        "Ma",
                                        "Mi",
                                        "Ju",
                                        "Vi",
                                        "Sa"
                                    ],
                                    "monthNames": [
                                        "Enero",
                                        "Febrero",
                                        "Marzo",
                                        "Abril",
                                        "Mayo",
                                        "Junio",
                                        "Julio",
                                        "Agosto",
                                        "Setiembre",
                                        "Octubre",
                                        "Noviembre",
                                        "Diciembre"
                                    ],
                                    "firstDay": 1
                                },
                                "opens": "center"
                            });

                    $('input[name="fechaconsulta"]').daterangepicker({
                          autoUpdateInput: false,
                          locale: {
                              cancelLabel: 'Clear'
                          }
                      });

                      $('input[name="fechaconsulta"]').on('apply.daterangepicker', function(ev, picker) {
                          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
                          fecha_ini = picker.startDate.format('YYYY-MM-DD');
                          fecha_fin = picker.endDate.format('YYYY-MM-DD');
                      });
                    
                      $('input[name="fechaconsulta"]').on('cancel.daterangepicker', function(ev, picker) {
                          $(this).val('');
                      });
            }); 
///////////////////////////////////////////////////////////////////////DROPZONE
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

          var baseUrl = "{{ url('/') }}";
          var token=$("[name*='_token']").val();
          Dropzone.autoDiscover = false;
           var myDropzone = new Dropzone(document.body, { 
               url: baseUrl+"/dropzone",
               params: {
                  _token: token
                },
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 5,
                maxFiles: 100,
                thumbnailWidth: 160,
                thumbnailHeight: 160,
                thumbnailMethod: 'contain',
                previewTemplate: previewTemplate,
                autoQueue: true,
                previewsContainer: "#previews",
                clickable: ".fileinput-button"
                
           });
/*
           Dropzone.options.myAwesomeDropzone = {
              paramName: "file", // The name that will be used to transfer the file
              maxFilesize: 2,
              maxFiles: 3,
              thumbnailWidth: 160,
              thumbnailHeight: 160,
              thumbnailMethod: 'contain',
              previewTemplate: previewTemplate,
              autoQueue: true,
              previewsContainer: "#previews",
              clickable: ".fileinput-button"
            };
*/
myDropzone.on("addedfile", function(file) {
  $('.dropzone-here').addClass('hidden');
  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
  
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {

  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  if(progress==100){
    setTimeout(function() {
        $(".progress").addClass('hidden');
      },2000);
    }
});

myDropzone.on("sending", function(file) {
  document.querySelector("#total-progress").style.opacity = "1";
  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
 /* var archivoagrega=file.name
  archivo.push(archivoagrega);*/
});

myDropzone.on("queuecomplete", function(progress) {
  document.querySelector("#total-progress").style.opacity = "0";
});

document.querySelector("#actions .start").onclick = function() {
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};

$('#previews').sortable({
  items:'.file-row',
  cursor: 'move',
  opacity: 0.5,	
  containment: "parent",
  distance: 20,
  tolerance: 'pointer',
  update: function(e, ui){
    $('.dropzone-here').removeClass('hidden');
  }
});
    </script>

@endsection
<div id="myModalPrint" class="modal">
   <div class="modal-content" style="width:60%!important">
       {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b>', array('type' => 'button', 'class' => 'btn btn-danger btn-xs cerrarmodalPrint','style'=>'float:right;margin-top:7px;margin-right:10px','id' => "btnCancelarPrint")) !!}

      <div id="imprimirContenido"></div>
      <div id="cargaAnexos" style="display:none"></div>
      <div class="modal-footer">
                   {!! Form::button('<b><i class="fa fa-print"></i></b> Anexos', array('type' => 'button', 'class' => 'btn btn-primary','id' => "anexosd")) !!}

                    {!! Form::button('<b><i class="fa fa-print"></i></b> Imprimir', array('type' => 'button', 'class' => 'btn btn-primary','id' => "printDiv")) !!}
      </div>
    </div>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
            <div class="">
        
                <div class="">
                    <div class="container-fluid">
                      
                        <div class="tabbable" id="tabs-555441">
                                  <div class="tabbable-line">
                                  <div class="col-lg-12" style="background-color: #f1f1f1;">
                                                    <div class="tab col-lg-11" style="float:left">
                                                        <button class="tablinks active" value="tab1" id="tabdatosgenerales">Datos Generales</button>
                                                        <button class="tablinks" value="tab2" id="tabdatostecnicos">Datos T&eacute;cnicos</button>
                                                        <button class="tablinks" value="tab3" id="tabdatoselaboracion">Datos de Elaboraci&oacute;n</button>
                                                        <button class="tablinks" value="tab4" id="tabdatosanexos">Anexos</button>

                                                    </div>
                                                    <div class="col-lg-1" style="float:right;">
                                                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b>', array('type' => 'button', 'class' => 'btn btn-danger btn-xs cerrarmodal','style'=>'float:right;margin-top:7px','id' => "btnCancelar")) !!}
                                                    </div>
                                                    <br/>
                                  </div>
                                            <div class="tab-content" >
                                            <div class="tabcontent" id="tab4" >
                                               <div class="container col-lg-12" style="margin-top:20px!important">
                                                     <div class="row" style="padding: 00px!important;padding-bottom: 0px!important;">
                                                            <div class="col-lg-10" id="divAnexo">
                                                                 <div class="container">
                                                                     <div class="dropzone" id="dropzoneFileUpload" style="width:80%">
                                                                     <div class="container" style="width:100%">
  
  <div class="row">
      <div id="content" class="col-lg-12">

  <div class="fallback">
      <input name="file" type="file" multiple />
  </div>
  <div id="actions" class="row">
      <div class="col-lg-7">
          <!-- The fileinput-button span is used to style the file input field as button -->
          <span class="btn btn-success fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
              <span>A&ntilde;adir im&aacute;genes...</span>
          </span>
          <button type="submit" class="btn btn-primary start" style="display: none;">
              <i class="glyphicon glyphicon-upload"></i>
              <span>Start upload</span>
          </button>
          <button type="reset" class="btn btn-warning cancel" style="display: none;">
              <i class="glyphicon glyphicon-ban-circle"></i>
              <span>Cancel upload</span>
          </button>
      </div>

      <div class="col-lg-5">
          <!-- The global file processing state -->
          <span class="fileupload-process">
              <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                  <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
              </div>
          </span>
      </div>
  </div>

  <div class="table table-striped files" id="previews">
      <div id="template" class="file-row row">
          <!-- This is used as the file preview template -->
          <div class="col-xs-12 col-lg-3">
              <span class="preview" style="width:160px;height:160px;">
                  <img data-dz-thumbnail style="width:160px;height:160px;"/>
              </span>
              <br/>
              <button class="btn btn-primary start" style="display:none;">
                  <i class="glyphicon glyphicon-upload"></i>
                  <span>Empezar</span>
              </button>
              <button data-dz-remove class="btn btn-warning cancel btn-xs">
                  <i class="icon-ban-circle fa fa-ban-circle"></i> 
                  <span>Cancelar</span>
              </button>
              <button data-dz-remove class="btn btn-danger delete btn-xs" >
                  <i class="icon-trash fa fa-trash"></i> 
                  <span>Eliminar</span>
              </button>
          </div>
          <div class="col-xs-12 col-lg-9">
              <input type="text" value="" class="form-control" placeholder="slug" onkeyup=""><p class="name" data-dz-name></p>
              <p class="size" data-dz-size></p>
              <select name="tamano[]">
         
                  <option value="Mitad">Mitad Slot</option>
            
              </select>
              
              <div>
                  <strong class="error text-danger" data-dz-errormessage></strong>
              </div>
              <div>
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="dropzone-here">Cargar Archivos.</div>

      </div>
  </div>
  
    
</div>



                                                                     </div>                                                                        
                                                                        
                                                                  </div>
                                                            </div>
                                                     </div>

                                                </div>
                                            </div>
                                                <div class="tabcontent active" id="tab1" >
                                                    <div class="container col-lg-12" style="margin-top:20px!important">
                                                            <div class="row" style="padding: 00px!important;padding-bottom: 0px!important;">
                                                            <input type="hidden" id="id" value="0">
                                                            <div class="col-lg-6">
                                                                        <label for="name" class="control-label">ASUNTO</label><br/>
                                                                        {!! Form::text('asunto', '',['class'=>'form-control','placeholder'=>'Asunto del Informe','id'=>'asunto','maxlength'=>'500'])!!}
                                                                        <hr/>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                        <label for="name" class="control-label">USUARIO</label><br/>
                                                                        {!! Form::select('usuario', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Usuario','id'=>'usuario'])!!}
                                                                        <hr/>
                                                            </div>
                                                            <div class="col-lg-12"> 
                                                                    <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                    <label for="name" class="control-label">ANTECEDENTES</label><br/>
                                                                                        <textarea class="ckeditor" name="editor1" id="antecedentes" style="max-height:200px!important"></textarea>
                                                                            </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                    <label for="name" class="control-label">OBJETIVOS</label><br/>
                                                                                    <textarea class="ckeditor" name="editor1" id="objetivos"></textarea>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                    <label for="name" class="control-label">ACCIONES REALIZADAS</label><br/>
                                                                                    <textarea class="ckeditor" name="editor1" id="acciones"></textarea>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-lg-12"> 
                                                                        <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                        <label for="name" class="control-label ">CONCLUSIONES</label><br/>
                                                                                        <textarea class="ckeditor" name="editor1" id="conclusiones"></textarea>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                        <label for="name" class="control-label">RECOMENDACIONES</label><br/>
                                                                                        <textarea class="ckeditor" name="editor1" id="recomendaciones" ></textarea>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                              <div class="card">
                                                                                                      <div class="title">
                                                                                                              <label for="name" class="control-label">CHECKLIST</label><br/>
                                                                                                      </div>
                                                                                                      <ul class="list-group list-group-flush">
                                                                                                            <div id="checklistUsuario">
                                                                                                                
                                                                                                          
                                                                                                            </div> 
                                                                                                      </ul>
                                                                              </div> 
                                                                        </div>
                                                            </div>
                                                    
                                                                    
                                                                  
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="tabcontent" id="tab2">
                                                  <div class="col-lg-12">
                                                  <br/>
                                                  <div class="alert alert-danger" role="alert" id="contentMensajeTab2">
                                                  
                                                          No se Encuentra Agregado Ning&uacute;n Equipo para el Informe
                                                  </div>
                                                  <div  id="contentTab2">
                                                        <div class="col-lg-12" style="margin-top:20px!important">
                                                                          <div class="card col-lg-4" id="cardComputador">
                                                                                                        <div class="title">
                                                                                                                <div class="col-lg-12">
                                                                                                                  <label for="name" class="control-label">CHECKLIST COMPUTADOR</label>
                                                                                                                </div>
                                                                                                                <br/>
                                                                                                        </div>
                                                                                                    
                                                                                                        <ul class="list-group list-group-flush">
                                                                                                                  <li class="list-group-item"  style="border: 0px!important;">
                                                                                                                      <div class="col-lg-11">
                                                                                                                        <input type="text" class="form-control" id="agregaitemcomputador" placeholder="AGREGA NUEVO ITEM" maxlength="255">
                                                                                                                      </div>
                                                                                                                      <div class="col-lg-1">
                                                                                                                        <a href="#" onclick="grabaitem('computador')" class="btn btn-info btn-xs"><i class="fa fa-save"></i></a>
                                                                                                                      </div>
                                                                                                                  </li>
                                                                                                                <li class='list-group-item'  id="nohayregistroProblemascomputador" style="border: 0px!important;">
                                                                                                                  <div class="alert alert-info" role="alert">
                                                                                                                      No se encontro registros                                                                                                        
                                                                                                                  </div>
                                                                                                                </li>
                                                                                                                <div id="checklistcomputador">
                                                                                                                </div> 
                                                                                                        </ul>
                                                                          </div> 
                                                                          <div class="card col-lg-4" id="cardMonitor">
                                                                                                        <div class="title">
                                                                                                                <label for="name" class="control-label">CHECKLIST MONITOR</label><br/>
                                                                                                        </div>
                                                                                                        <ul class="list-group list-group-flush">
                                                                                                            
                                                                                                                  <li class="list-group-item"  style="border: 0px!important;">
                                                                                                                      <div class="col-lg-11">
                                                                                                                        <input type="text" class="form-control" id="agregaitemmonitor" placeholder="AGREGA NUEVO ITEM" maxlength="255">
                                                                                                                      </div>
                                                                                                                      <div class="col-lg-1">
                                                                                                                        <a href="#" onclick="grabaitem('monitor')" class="btn btn-info btn-xs"><i class="fa fa-save"></i></a>
                                                                                                                      </div>
                                                                                                                  </li>
                                                                                                                <li class='list-group-item'  id="nohayregistroProblemasmonitor" style="border: 0px!important;">
                                                                                                                <div class="alert alert-info" role="alert">
                                                                                                                      No se encontro registros                                                                                                        
                                                                                                                  </div>
                                                                                                                  </li>
                                                                                                                  <div id="checklistmonitor">
                                                                                                              </div> 
                                                                                                        </ul>
                                                                          </div> 
                                                                          <div class="card col-lg-4" id="cardPeriferico">
                                                                                                        <div class="title">
                                                                                                                <label for="name" class="control-label">CHECKLIST PERIFERICOS</label><br/>
                                                                                                        </div>
                                                                                                        <ul class="list-group list-group-flush">
                                                                                                              
                                                                                                                  <li class="list-group-item" style="border: 0px!important;">
                                                                                                                      <div class="col-lg-11">
                                                                                                                        <input type="text" class="form-control"  id="agregaitemPerifericos" placeholder="AGREGA NUEVO ITEM" maxlength="255">
                                                                                                                      </div>
                                                                                                                      <div class="col-lg-1">
                                                                                                                        <a href="#" onclick="grabaitem('Perifericos')" class="btn btn-info btn-xs"><i class="fa fa-save"></i></a>
                                                                                                                      </div>
                                                                                                                  </li> 
                                                                                                                <li class='list-group-item'  id="nohayregistroProblemasPerifericos" style="border: 0px!important;">
                                                                                                                <div class="alert alert-info" role="alert">
                                                                                                                      No se encontro registros                                                                                                        
                                                                                                                  </div>  
                                                                                                                  </li> 
                                                                                                                  <div id="checklistPerifericos">                                                                                                    
                                                                                                              </div> 
                                                                                                        </ul>
                                                                          </div> 
                                                                      
                                                          </div>
                                                          <div class="col-lg-12">
                                                          <div class="card col-lg-4" id="cardOtros"> 
                                                                                                            <div class="title">
                                                                                                                    <label for="name" class="control-label">CHECKLIST OTROS DISPOSITIVOS</label><br/>
                                                                                                            </div>
                                                                                                            <ul class="list-group list-group-flush">
                                                                                                                  
                                                                                                                  <li class="list-group-item"  style="border: 0px!important;">
                                                                                                                      <div class="col-lg-11">
                                                                                                                        <input type="text" class="form-control" id="agregaitemdispositivos" placeholder="AGREGA NUEVO ITEM" maxlength="255">
                                                                                                                      </div>
                                                                                                                      <div class="col-lg-1">
                                                                                                                        <a href="#" onclick="grabaitem('dispositivos')" class="btn btn-info btn-xs"><i class="fa fa-save"></i></a>
                                                                                                                      </div>
                                                                                                                  </li>
                                                                                                                    <li class='list-group-item' id="nohayregistroProblemasdispositivos" style="border: 0px!important;">
                                                                                                                    <div class="alert alert-info" role="alert">
                                                                                                                          No se encontro registros                                                                                                        
                                                                                                                      </div> 
                                                                                                                    </li> 
                                                                                                                      <div id="checklistdispositivos">                                                                                                     
                                                                                                                  </div> 
                                                                                                            </ul>
                                                                          </div> 
                                                                              <div class="card col-lg-4" id="cardImpresora">
                                                                                                            <div class="title">
                                                                                                                    <label for="name" class="control-label">CHECKLIST IMPRESORAS</label><br/>
                                                                                                            </div>
                                                                                                            <ul class="list-group list-group-flush">
                                                                                                                  
                                                                                                                  <li class="list-group-item" style="border: 0px!important;">
                                                                                                                      <div class="col-lg-11">
                                                                                                                        <input type="text" class="form-control" id="agregaitemimpresora" placeholder="AGREGA NUEVO ITEM" maxlength="255">
                                                                                                                      </div>
                                                                                                                      <div class="col-lg-1">
                                                                                                                        <a href="#" onclick="grabaitem('impresora')" class="btn btn-info btn-xs"><i class="fa fa-save"></i></a>
                                                                                                                      </div>
                                                                                                                  </li>
                                                                                                                    <li class='list-group-item'  id="nohayregistroProblemasimpresora" style="border: 0px!important;">
                                                                                                                    <div class="alert alert-info" role="alert">
                                                                                                                          No se encontro registros                                                                                                        
                                                                                                                      </div>  
                                                                                                                      </li>
                                                                                                                      <div id="checklistimpresora">                                                                                                      
                                                                                                                  </div> 
                                                                                                            </ul>
                                                                              </div> 
                                                                        
                                                        </div>
                                                  </div>
                                                  </div>
                                                </div>
                                                <div class="tabcontent" id="tab3">
                                                  <div class="col-lg-12">
                                                      <br/>
                                                      <div class="alert alert-danger" role="alert" id="contentMensajeTab3">
                                                            
                                                              No se Encuentra Agregado Ning&uacute;n Equipo para el Informe
                                                      </div>
                                                      <div  id="contentTab3">
                                                          <div class="col-lg-12" style="margin-top:20px!important">
                                                                            <div class="card col-lg-12">
                                                                                <div class="col-lg-4">
                                                                                            <label for="name" class="control-label">ELABORADO POR:</label><br/>
                                                                                            {!! Form::select('usuarioelaborado', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Usuario','id'=>'usuarioelaborado'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                                <div class="col-lg-8">
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">CARGO:</label><br/>
                                                                                        {!! Form::select('cargos', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Cargo','id'=>'cargoElaborado'])!!}
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">AREA </label><br/>
                                                                                         {!! Form::select('areas', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Areas','id'=>'areaElaborado'])!!}
                                                                                    </div>
                                                                                            <label for="name" class="control-label hidden">CARGO ELABORADO POR:</label><br/>
                                                                                            {!! Form::text('usuarioelaboradocargo', null,['class'=>'form-control hidden','placeholder'=>'Cargo Elaborado','id'=>'usuarioelaboradocargo'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                            </div> 
                                                                            <div class="card col-lg-12">
                                                                                <div class="col-lg-4">


                                                                                            <label for="name" class="control-label">REVISADO POR:</label><br/>
                                                                                            {!! Form::select('usuariorevisado', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Usuario','id'=>'usuariorevisado'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                                <div class="col-lg-8">
                                                                                     <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">CARGO:</label><br/>
                                                                                        {!! Form::select('cargos', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Cargo','id'=>'cargoRevisado'])!!}
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">AREA </label><br/>
                                                                                         {!! Form::select('areas', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Areas','id'=>'areaRevisado'])!!}
                                                                                    </div>
                                                                                            <label for="name" class="control-label hidden">CARGO REVISADO POR:</label><br/>
                                                                                            {!! Form::text('usuariorevisadocargo', null,['class'=>'form-control hidden','placeholder'=>'Cargo Revisado','id'=>'usuariorevisadocargo'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                            </div> 
                                                                            <div class="card col-lg-12">
                                                                                <div class="col-lg-4">
                                                                                            <label for="name" class="control-label">APROBADO POR:</label><br/>
                                                                                            {!! Form::select('usuarioaprobado', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Usuario','id'=>'usuarioaprobado'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                                <div class="col-lg-8">
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">CARGO:</label><br/>
                                                                                        {!! Form::select('cargos', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Cargo','id'=>'cargoAprobado'])!!}
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">AREA </label><br/>
                                                                                         {!! Form::select('areas', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Areas','id'=>'areaAprobado'])!!}
                                                                                    </div>
                                                                                            <label for="name" class="control-label hidden">CARGO APROBADO POR:</label><br/>
                                                                                            {!! Form::text('usuarioaprobadocargo', null,['class'=>'form-control hidden','placeholder'=>'Cargo Aprobado','id'=>'usuarioaprobadocargo'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                            </div> 
                                                                            <div class="card col-lg-12">
                                                                                <div class="col-lg-4">
                                                                                            <label for="name" class="control-label">RECIBIDO POR:</label><br/>
                                                                                            {!! Form::select('usuariorecibido', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Usuario','id'=>'usuariorecibido'])!!}
                                                                                            <hr/>
                                                                                </div>
                                                                                <div class="col-lg-8">
                                                                                   <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">CARGO:</label><br/>
                                                                                        {!! Form::select('cargos', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Cargo','id'=>'cargoRecibido'])!!}
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                         <label for="name" class="control-label ">AREA </label><br/>
                                                                                         {!! Form::select('areas', [],null,['class'=>'form-control select2','placeholder'=>'Seleccione un Areas','id'=>'areaRecibido'])!!}
                                                                                    </div>
                                                                                            <label for="name" class="control-label hidden">CARGO RECIBIDO POR:</label><br/>
                                                                                            {!! Form::text('usuariorecibidocargo', null,['class'=>'form-control hidden','placeholder'=>'Cargo Revisado','id'=>'usuariorecibidocargo'])!!}
                                                                                            <hr/>
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

                </div>
            </div>
            <div class="modal-footer">
                    {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
            </div>
    </div>
</div>

<div class="panel panel-default">

<div class="panel-heading hidden" style="background-color: #006eae;">
      
      <label>Epacore Informes Tecnicos
      </label> 
</div>
<div class="panel-body">

    <div class="col-lg-2"> 
        <label for="name" class="control-label">Periodo de Fechas:</label><br/>
    </div>
    <div class="col-lg-2"> 
        <input type="text" name="fechaconsulta" value=""  class="form-control-i" id="fechaconsulta"/>

    </div>
    <div class="col-lg-2"> 
                        <button class="btn btn-primary btn-xs" onclick="BuscarFechaD()">Buscar</button>
                        <button id="myBtn" onclick="limpiar();" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
          </div>
    </div>


    <div class="table table-responsive" id="tablaConsulta">
      
        <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
            <thead>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
</div>

</div>

@endsection
