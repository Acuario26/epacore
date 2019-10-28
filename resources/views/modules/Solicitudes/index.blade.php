@extends('layouts.app')

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/pivot/') }}/pivot.css" rel="stylesheet">
    <style>

        .flotante {
            display: scroll;
            position: fixed;
            bottom: 320px;
            right: 0px;
        }

    </style>
@endsection
@section('javascript')

    <script src="{{ url('js/modules/solicitudes/solicitudes.js') }}"></script>
    <script src="{{ url('adminlte/plugins/pivot/') }}/pivot.js"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
    <script src="{{ url('adminlte/plugins/input-mask/') }}/jquery.inputmask.js"></script>

    <script>
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
        function filterNonAphaNumeric(str) {
            let code, i, len, result = '';

            for (i = 0, len = str.length; i < len; i++) {
                code = str.charCodeAt(i);
                if ((code > 47 && code < 58) || // numeric (0-9)
                    (code > 64 && code < 91) || // upper alpha (A-Z)
                    (code > 96 && code < 123)) { // lower alpha (a-z)
                    result += str.charAt(i);
                }
            }
            return result;
        };

        function onKeyUpHandler(event) {
            let value = this.value.toUpperCase();
            if (value) {
                this.value = filterNonAphaNumeric(value)
            }
        }

        let input = document.getElementById('identificacion');
        input.addEventListener('keyup', onKeyUpHandler);
    </script>

@endsection
<div class="col-lg-2" style="float:left">
    {!! Form::select('bandejaLider',$bandejaSolicitudes, 0,['class' => 'form-control select2',"style"=>"width:100%","id"=>"bandejaLider"]) !!}
</div>

<div class="col-lg-2" style="float:right">
    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-primary"
       data-target="#Modalagregar" data-toggle="modal" id="modal" onclick="start()">Nuevo</a>
    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-success"
       onclick="recargar()"><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;Recargar</a>
</div>
<hr/>
<input type="hidden" value="{{$var}}" id="lider">
<div class="modal fade" id="ModalLinea" role="dialog" style="z-index: 1060;">
        <div class="modal-dialog" style="width: 90%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    Detalle de Lineas
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                            <table class="table table-bordered table-striped " id="dtmenuLi" style="width:100%!important">
                                    <thead>
                                    <th>Tipo/Solicitud</th>
                                    <th>Linea</th>
                                    <th>Solicitud</th>
                                    <th>Tipo de Linea</th>
                                    <th>Detalle/Bp</th>
                                    <th>Detalle/Equipo</th>

                                    </thead>
                                    <tbody id="tbobymenuLi">

                                    </tbody>
                                  
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" style="width: 90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">
                    <div id="asesorh" style="font-weight: bold;">Asesor: <span id="asesor_sg"
                                                                               style="color: #0d6aad;font-size: medium"></span>
                        <div style="font-weight: bold;float:right;margin-right: 25px">Ultimo Estado: <span
                                    id="estado_sg" style="color: #0d6aad;font-size: medium"></span></div>
                    </div>
                </h4>
                <input id="n_solicitud_escape" type="hidden" value="0">

                <input type="hidden" value="0" name="control">
                <input type="hidden" value="0" name="control_lineas">
                <input type="hidden" value="0" name="control_solicitud">

                <input type="hidden" id="dciudadi" value="0">
                <input type="hidden" id="dlaboralesi" value="0">
                <input type="hidden" id="dentregai" value="0">
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" id="contenidoLider">

                                <div class="col-lg-2">
                                    <label><strong>Estado de la Solicitud:</strong></label>
                                </div>

                                <div class="col-lg-2">
                                    <input type="hidden" value="0" id="solicitud_estado_id">
                                    {!! Form::select('estado_solicitud', $bandejavalid, null,['class' => 'form-control select2','placeholder'=>'ESTADO DE SOLICITUD',"style"=>"width:100%","id"=>"estado_solicitud"]) !!}
                                </div>
                                <div class="col-lg-6">

                                    {{ Form::textarea('observaciones', null, ['class' => 'form-control-t','row'=>'1','style' => 'max-height: 50px; resize: none;','placeholder' => 'Ingrese Observación',"id"=>"observacion_lider"]) }}

                                </div>
                                <div class="col-lg-2">
                                    {!! Form::button('Enviar', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnEstado")) !!}

                                </div>
                            </div>
                            <div class="col-md-12" id="contenido">
                                <div class="tabbable" id="tabs-580793">
                                    <div id="formulario" class="tab-content">
                                        <div class="tab-pane active" id="panel-1">
                                            <div class="form-group">
                                                <div class="col-lg-12">

                                                    <ul class="timeline">


                                                        <li>
                                                            <i class="fa bg-blue"><b>1</b></i>
                                                            <div class="timeline-item">

                                                                <div class="timeline-body">
                                                                    <div id="cabecera">
                                                                        <div class="timeline-header">
                                                                            <div class="container">
                                                                                <div class="col-lg-12">
                                                                                    <div class="col-lg-2">

                                                                                        <h4><strong>
                                                                                                <a href="#">Datos
                                                                                                    Generales</a>
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </div>

                                                                                    <div class="col-lg-2">
                                                                                        <label>Identificación:</label>

                                                                                        {!! Form::text('identificacion', null,[
                                                                                                "required"=>"required",
                                                                                                'maxlength'=>'13',
                                                                                                "class"=>"form-control col-lg-2" ,
                                                                                                "placeholder"=>"Digite la identificación",
                                                                                                "name"=>"identificacion",
                                                                                                "id"=>"identificacion"]) !!}
                                                                                    </div>
                                                                                    <div class="col-lg-2">
                                                                                        <label>Tipo de Persona:</label>

                                                                                        {!! Form::text('tipo_persona', null,["style"=>"","required"=>"required","class"=>"form-control" ,"placeholder"=>"Tipo persona","disabled","name"=>"tipo_persona",'id'=>'tipo_persona']) !!}

                                                                                    </div>
                                                                                    <p>
                                                                                        &nbsp;
                                                                                    </p>
                                                                                    <br/>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div id="natural">
                                                                            <div class="container-fluid">

                                                                                <div class="col-lg-12 form-group">

                                                                                    <div class="col-lg-3">
                                                                                        <label><strong>Nombres y
                                                                                                Apellidos</strong></label>
                                                                                        {!! Form::text('name', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombres Completo","name"=>"name_natural"]) !!}

                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label><strong>Correo
                                                                                                Electronico</strong></label>
                                                                                        {!! Form::text('email_natural', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Correo Electronico","name"=>"email_natural"]) !!}

                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label><strong>Fecha de
                                                                                                Nacimiento</strong></label>
                                                                                        {!! Form::text('fecha_nacimiento','',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Fecha de Nacimiento',"name"=>"fecha_nacimiento_natural"]) !!}

                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label><strong>Estado
                                                                                                Civil</strong></label>
                                                                                        {!! Form::select('civil', ['SOLTER@'=>'SOLTER@','CASAD@'=>'CASAD@','Divorciad@'=>'DIVORCIAD@','UNION_LIBRE'=>'UNION LIBRE'], null,['class' => 'form-control select2','placeholder'=>'ESTADO CIVIL',"style"=>"width:100%","name"=>"civil_natural"]) !!}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div id="juridico">
                                                                        <div class="container-fluid">
                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Razón
                                                                                            Juridica</strong></label>
                                                                                    {!! Form::text('razon_juridica', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Razon Social","name"=>"razon_juridico"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Cedula de
                                                                                            Representante Legal</strong></label>
                                                                                    {!! Form::text('cedula_rl', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Cedula del Representante Legal","name"=>"cedula_rl_juridico",'maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Fecha de Vencimiento
                                                                                            de
                                                                                            Nombramiento</strong></label>
                                                                                    {!! Form::text('fecha_vencimiento','',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Fecha de vencimiento',"name"=>"fecha_vencimiento_juridico"]) !!}

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Correo
                                                                                            Juridico</strong></label>
                                                                                    {!! Form::text('email_juridico', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Correo Electronico","name"=>"email_juridico"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Nombre del
                                                                                            Representate Legal</strong></label>
                                                                                    {!! Form::text('nombre_rl', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombre del Representante Legal","name"=>"nombre_rl_juridico"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Cargo del
                                                                                            Representante Legal</strong></label>
                                                                                    {!! Form::text('cargo_rl', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Cargo del Representante Legal","name"=>"cargo_rl_juridico"]) !!}

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="natural_domicilio">
                                                                        <div class="timeline-header">
                                                                            <div class="container"
                                                                                 style="margin-left:10px"><h4><strong>
                                                                                        <a href="#">Domicilio</a>
                                                                                    </strong>
                                                                                </h4>
                                                                            </div>
                                                                        </div>

                                                                        <div class="container-fluid">
                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-6">
                                                                                    <label><strong>Dirección</strong></label>
                                                                                    {{ Form::text('domicilio', null, ['class' => 'form-control',
                                                                                    'placeholder' => 'Ingrese el Domicilio',
                                                                                   "name"=>"domicilio_natural"]) }}

                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label><strong>Referencia del
                                                                                            Domicilio</strong></label>
                                                                                    {{ Form::text('referencia', null, ['class' => 'form-control',
                                                                                      'placeholder' => 'Ingrese la referencia del domicilio',
                                                                                    "name"=>"referencia_natural"]) }}

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-2">
                                                                                    <label><strong>Convencional</strong></label>
                                                                                    {!! Form::text('convencional', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Convencional","name"=>"convencional_natural",'maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label><strong>Cv Perteneciente
                                                                                            A:</strong></label>
                                                                                    {!! Form::select('cperteneciente', ['CLIENTE'=>'CLIENTE','AMIGO'=>'AMIGO','FAMILIAR'=>'FAMILIAR'], null,['class' => 'form-control select2','placeholder'=>'PERTENECIENTE A:',"style"=>"width:100%","name"=>"cperteneciente_natural"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label><strong>Celular</strong></label>
                                                                                    {!! Form::text('celular', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Celular","id"=>"celular_natural","name"=>"celular_natural",'maxlength'=>'10','onkeyup'=>'solonumero("celular_natural","celular")']) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Provincia</strong></label>
                                                                                    {!! Form::select('dprovincia', $provincia, null,['class' => 'form-control select2','placeholder'=>'PROVINCIA',"style"=>"width:100%","id"=>"dprovincia","name"=>"dprovincia_natural"]) !!}
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Ciudad</strong></label>
                                                                                    {!! Form::select('dciudad', [], null,['class' => 'form-control select2','placeholder'=>'CIUDAD',"style"=>"width:100%","id"=>"dciudad","name"=>"dciudad_natural"]) !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="dato_laborales">

                                                                        <div class="timeline-header">

                                                                            <div class="container"
                                                                                 style="margin-left:10px">

                                                                                <h4><strong>

                                                                                        <a href="#">Datos Laborales</a>
                                                                                    </strong>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="container-fluid">

                                                                            <div class="col-lg-12 form-group">
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Empresa donde
                                                                                            labora</strong></label>
                                                                                    {!! Form::text('razon', null,['class' => 'form-control',
                                                                                       'placeholder' => 'Razon Social',
                                                                                      "name"=>"razon_laborales"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Dirección de la
                                                                                            Empresa</strong></label>
                                                                                    {{ Form::text('direccion', null, ['class' => 'form-control',
                                                                                       'placeholder' => 'Ingrese Dirección',
                                                                                     "name"=>"direccion_laborales"]) }}
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Provincia</strong></label>

                                                                                    {!! Form::select('lprovincia', $provincia, null,['class' => 'form-control select2','placeholder'=>'PROVINCIA',"style"=>"width:100%","name"=>"lprovincia_laborales",'id'=>'lprovincia_laborales']) !!}
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Ciudad</strong></label>

                                                                                    {!! Form::select('ciudad_laboral', [], null,['class' => 'form-control select2','placeholder'=>'CIUDAD',"style"=>"width:100%","name"=>"dato_laborales[ciudad]","id"=>"ciudad_laboral"]) !!}

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Convencional</strong></label>

                                                                                    {!! Form::text('convencional', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Convencional",'maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',"name"=>"convencional_laborales"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Cargo</strong></label>

                                                                                    {!! Form::text('cargo', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Cargo","name"=>"cargo_laborales"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Tiempo
                                                                                            Laboral</strong></label>

                                                                                    {!! Form::text('tiempo_laboral', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Tiempo Laboral","name"=>"tiempo_laborales"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Ingresos</strong></label>

                                                                                    {!! Form::text('ingresos', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Ingresos",'maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',"name"=>"ingresos_laborales"]) !!}

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-footer">
                                                                            &nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>
                                                        <li id="domicilio_entrega">
                                                            <!-- timeline icon -->
                                                            <i class="fa bg-blue"><b>2</b></i>
                                                            <div class="timeline-item">

                                                                <div class="timeline-body">
                                                                    <div id="dato_laborales">

                                                                        <div class="timeline-header">

                                                                            <div class="container"
                                                                                 style="margin-left:10px">

                                                                                <h4><strong>

                                                                                        <a href="#">Datos de Entrega de
                                                                                            Contrato</a>
                                                                                    </strong>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="container-fluid">

                                                                            <div class="col-lg-12 form-group">
                                                                                <label><strong>Dirección de
                                                                                        Entrega</strong></label>

                                                                                <div class="col-lg-12">
                                                                                    {{ Form::text('direccion_entrega', null, ['class' => 'form-control',
                                                                                    'placeholder' => 'Ingrese la Direccion de Entrega',
                                                                                  "name"=>"direccion_entrega"]) }}

                                                                                </div>

                                                                            </div>

                                                                            <div class="col-lg-12 form-group">


                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Celular de
                                                                                            Entrega</strong></label>

                                                                                    {!! Form::text('celular_entrega', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Celular","id"=>"celular_entrega","name"=>"celular_entrega",'maxlength'=>'10','onkeyup'=>'solonumero("celular_entrega","celular")']) !!}
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Región</strong></label>

                                                                                    {!! Form::select('region', ['R1'=>'R1','R2'=>'R2'], null,['class' => 'form-control select2','placeholder'=>'REGION',"style"=>"width:100%","name"=>"region_entrega"]) !!}
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Provincia de
                                                                                            entrega</strong></label>

                                                                                    {!! Form::select('eprovincia', $provincia, null,['class' => 'form-control select2','placeholder'=>'PROVINCIA',"style"=>"width:100%","name"=>"provincia_entrega",'id'=>'provincia_entrega']) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Ciudad de
                                                                                            entrega</strong></label>

                                                                                    {!! Form::select('ciudad_entrega', [], null,['class' => 'form-control select2','placeholder'=>'CIUDAD',"style"=>"width:100%","name"=>"dato_entrega[ciudad]","id"=>"dato_entrega_ciudad"]) !!}

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-footer">
                                                                            &nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>
                                                        <li id="dato_observacion">
                                                            <!-- timeline icon -->
                                                            <i class="fa bg-blue"><b>3</b></i>
                                                            <div class="timeline-item">

                                                                <div class="timeline-body">
                                                                    <div id="dato_observacion">

                                                                        <div class="timeline-header">

                                                                            <div class="container"
                                                                                 style="margin-left:10px">

                                                                                <div class="col-lg-12">
                                                                                    <div class="col-lg-3">

                                                                                        <h4><strong>
                                                                                                <a href="#">Observaciones</a>
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </div>

                                                                                    <div class="col-lg-7">
                                                                                        <label><strong>Observaciones</strong></label>

                                                                                        {{ Form::textarea('observaciones', null, ['class' => 'form-control-t','row'=>'2','style' => 'max-height: 100px; resize: none;','placeholder' => 'Ingrese Observación',"id"=>"observacion",'maxlength'=>'200']) }}
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="container-fluid">
                                                                    <div id="dato_observacion2">

                                                                        <div class="timeline-header">

                                                                            <div class="container"
                                                                                 style="margin-left:0px">
                                                                                <div class="col-lg-12">
                                                                                    <div class="col-lg-3">

                                                                                        <h4><strong>
                                                                                                <a href="#">Datos de
                                                                                                    Asesor/Gestor</a>
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label>Asesor</label>
                                                                                        {!! Form::text('usuario',$usuario,["class"=>"form-control " ,"placeholder"=>"usuario","disabled","name"=>"usuario",'id'=>'usuario']) !!}
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <label>Gestor</label>

                                                                                        {!! Form::select('gestor', $gestores, null,['class' => 'form-control select2','placeholder'=>'Seleccione un Gestor',"style"=>"width:100%","name"=>"gestor"]) !!}

                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-footer">
                                                                            &nbsp;
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li id="forma_pago">
                                                            <!-- timeline icon -->
                                                            <i class="fa bg-blue"><b>5</b></i>
                                                            <div class="timeline-item">

                                                                <div class="timeline-body">

                                                                    <div class="timeline-header"
                                                                         style="padding:25px 25px 30px 25px">

                                                                        <div class="container" style="margin-left:10px">

                                                                            <div class="col-lg-12">
                                                                                <div class="col-lg-3"><a href="#"
                                                                                                         style="">Datos
                                                                                        de
                                                                                        Forma de pago</a>
                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    {!! Form::select('forma_pago', ['DEBITO_BANCARIO'=>'DEBITO BANCARIO','TARJETA_CREDITO'=>'TARJETA DE CREDITO','CONTRAFACTURA'=>'CONTRAFACTURA'], null,["style"=>"width:25%",'class' => 'form-control select2','placeholder'=>'FORMA DE PAGO',"style"=>"width:100%","name"=>"forma_pago", "onchange"=>"obtienedatos()"]) !!}

                                                                                </div>

                                                                                <div id="contrafactura"
                                                                                     class="col-lg-5">

                                                                                    <div class="col-lg-5">
                                                                                        <label>Deposito/Garantia</label>
                                                                                        <input type="checkbox" value="0"
                                                                                               name="deposito_garantia"
                                                                                               id="deposito_garantia">

                                                                                        <input type="hidden" value="0"
                                                                                               name="depositocheck"
                                                                                               id="depositocheck">
                                                                                    </div>


                                                                                    <div class="col-lg-3">
                                                                                        <label>Valor/Garantia</label>
                                                                                    </div>
                                                                                    <div class="col-lg-2">
                                                                                        {!! Form::text('valor_garantia', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Valor de Garantía","id"=>"valor_garantia","onkeyup"=>"solonumero('valor_garantia',0)"]) !!}
                                                                                    </div>

                                                                                </div>
                                                                                <br/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="container-fluid">
                                                                        <div id="debito">
                                                                            <div class="col-lg-12 form-group">

                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Banco</strong></label>

                                                                                    {!! Form::select('banco', $banco, null,['class' => 'form-control select2','placeholder'=>'BANCO',"style"=>"width:100%","name"=>"banco"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Tipo de
                                                                                            Cuenta</strong></label>

                                                                                    {!! Form::select('cuenta', ['AHORRO'=>'AHORRO','CORRIENTE'=>'CORRIENTE'], null,['class' => 'form-control select2','placeholder'=>'TIPO DE CUENTA',"style"=>"width:100%","name"=>"tipo_cuenta_banco"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <label><strong>Número de
                                                                                            Cuenta</strong></label>

                                                                                    {!! Form::text('n_cuenta', null,["required"=>"required","class"=>"form-control" ,"id"=>"n_cuenta","placeholder"=>"NUMERO DE CUENTA","onkeyup"=>"solonumero('n_cuenta',0)","maxlength"=>"15","name"=>"n_cuenta_banco"]) !!}

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div id="tarjeta">
                                                                            <div class="col-lg-12 form-group"
                                                                                 id="tarjeta">

                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Tarjeta</strong></label>

                                                                                    {!! Form::text('tarjeta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombre de la tarjeta","name"=>"tarjeta"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Número de
                                                                                            Tarjeta</strong></label>

                                                                                    {!! Form::text('n_tarjeta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Numero de la tarjeta","name"=>"n_tarjeta","id"=>"n_tarjeta","maxlength"=>"15","onkeyup"=>"solonumero('n_tarjeta',0)"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Código de Seguridad
                                                                                            de Tarjeta</strong></label>

                                                                                    {!! Form::text('codigo_tarjeta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Codigo de Seguridad de la tarjeta","maxlength"=>"15","name"=>"codigo_tarjeta","id"=>"codigo_tarjeta","onkeyup"=>"solonumero('codigo_tarjeta',0)"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <label><strong>Fecha de
                                                                                            Caducidad</strong></label>

                                                                                    {!! Form::text('fecha_caducidad','',['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Fecha de Caducidad',"name"=>"fecha_caducidad_tarjeta"]) !!}

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        &nbsp;
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>
                                                        <li id="lineas">
                                                            <!-- timeline icon -->
                                                            <i class="fa bg-blue"><b>6</b></i>
                                                            <div class="timeline-item">

                                                                <div class="timeline-body">

                                                                    <div class="timeline-header"
                                                                         style="padding:25px 25px 15px 25px">

                                                                        <div class="container" style="margin-left:10px">

                                                                            <div class="col-lg-12">
                                                                                <div class="col-lg-2"><a href="#"
                                                                                                         style="">Datos
                                                                                        de
                                                                                        Solicitud</a>
                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>N° Solicitud</label>
                                                                                    {!! Form::text('n_solicitud', null,["class"=>"form-control" ,"placeholder"=>"N° Solicitud","disabled","name"=>"n_solicitud","id"=>"n_solicitud"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>Total de Lineas</label>

                                                                                    {!! Form::text('tlineas', 0,["class"=>"form-control" ,"placeholder"=>"lineas","disabled","name"=>"tlineas","id"=>"tlineas"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>Total de Obsequios</label>

                                                                                    {!! Form::text('tobsequios', 0,["class"=>"form-control " ,"placeholder"=>"obsequios","disabled","name"=>"tobsequios","id"=>"tobsequios"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2" style="display:none">
                                                                                    <label>Total de Chip
                                                                                        Obsequio</label>

                                                                                    {!! Form::number('tchip', 0,["class"=>"form-control " ,"id"=>"tchip","placeholder"=>"Chip a Obsequiar","name"=>"tchip",'maxlength'=>'2','min'=>"0",'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                                                                                </div>
                                                                                <div class="col-lg-1" id="agregaitem">

                                                                                    <a href="#"
                                                                                       onclick="Add();">
                                                                                        <i class="fa fa-plus">&nbsp; </i>
                                                                                    </a>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-header"
                                                                         style="">

                                                                        <div class="container" style="margin-left:10px">

                                                                            <div class="col-lg-12" id="axis"
                                                                                 style="display: none;">

                                                                                <div class="col-lg-2">
                                                                                    <label>Solicitud/Axis</label>
                                                                                    {!! Form::text('solicitud_axis_s', null,["class"=>"form-control" ,"placeholder"=>"Solicitud Axis","disabled","name"=>"solicitud_axis_s","id"=>"solicitud_axis_s"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-1">
                                                                                    <label>Lote</label>
                                                                                    {!! Form::text('lote_s', null,["class"=>"form-control" ,"placeholder"=>"Lote","disabled","name"=>"lote_s","id"=>"lote_s"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>Fecha / Lote</label>

                                                                                    {!! Form::text('fecha_lote_s', null,["class"=>"form-control" ,"placeholder"=>"Fecha Lote","disabled","name"=>"fecha_lote_s","id"=>"fecha_lote_s"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>Fecha / Activación</label>

                                                                                    {!! Form::text('fecha_activa_s', null,["class"=>"form-control" ,"placeholder"=>"Fecha Activación","disabled","name"=>"fecha_activa_s","id"=>"fecha_activa_s"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-1">
                                                                                    <label>Ciclo</label>

                                                                                    {!! Form::text('ciclo_factura_s', 0,["class"=>"form-control" ,"placeholder"=>"Ciclo Facturación","disabled","name"=>"ciclo_factura_s","id"=>"ciclo_factura_s"]) !!}

                                                                                </div>
                                                                                <div class="col-lg-2">
                                                                                    <label>Fecha / Facturación</label>

                                                                                    {!! Form::text('fecha_factura_s', null,["class"=>"form-control" ,"placeholder"=>"Fecha Facturación","disabled","name"=>"fecha_factura_s","id"=>"fecha_factura_s"]) !!}

                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <hr/>
                                                                        <div id="item">


                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        &nbsp;
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dtmenu22">
                                <div class="col-sm-12">

                                    <div class="col-sm-1">
                                        <p><h5
                                                style="color: #4985d2;"><strong>N° Solicitud:</strong></h5></p>
                                        <p><h5
                                                style="color: #4985d2;"><strong>Region:</strong></h5></p>
                                        <p><h5
                                                style="color: #4985d2;"><strong>Identificacion:</strong></h5></p>
                                        <p><h5 style="color: #4985d2;"><strong>Cliente:</strong></h5></p>
                                        <p><h5><strong style="color: #4985d2;">N° Chip: </strong></h5></p>
                                        <p><h5><strong style="color: #4985d2;">N° Lineas: </strong></h5></p>

                                    </div>
                                    <div class="col-sm-3">

                                        <h5 id="n_solicitud_sg"></h5>
                                        <h5 id="region_sg"></h5>
                                        <h5 id="identificacion_sg"></h5>
                                        <h5 id="cliente_sg"></h5>
                                        <h5 id="n_chip_sg"></h5>
                                        <h5 id="n_lineas_sg"></h5>
                                    </div>
                                    <div class="col-sm-4" id="destado_sg" style="background: #8888b11f;">
                                        <div class="col-sm-6">
                                            <h5>
                                                <strong style="color: #4985d2;">Deuda/Adendum:</strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Deuda/Castigo Cartera: </strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Deuda/Consumo: </strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Deuda/Financiamiento: </strong><span
                                                        id=""></span>
                                            </h5> <h5>
                                                <strong style="color: #4985d2;">Otros Valores: </strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Deuda Total: </strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Inicio Deuda: </strong><span
                                                        id=""></span>
                                            </h5>
                                            <h5>
                                                <strong style="color: #4985d2;">Tiempo Vencido: </strong><span
                                                        id=""></span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-3">


                                            <h5
                                                    id="adendum_sp"></h5>
                                            <h5
                                                    id="castigoc_sp"></h5>
                                            <h5
                                                    id="consumo_sp"></h5>
                                            <h5
                                                    id="financiamiento_sp"></h5>
                                            <h5
                                                    id="otros_sp"></h5>
                                            <h5
                                                    id="tcredito_sp"></h5>
                                            <h5
                                                    id="inicio_deuda_sp"></h5>
                                            <h5
                                                    id="tiempo_vencido"></h5>

                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="color: #4985d2;text-decoration: underline"><strong>Facturacion y Activación</strong></h5>
                                        <p><h5 style="color: #4985d2;"><strong>Fecha / Activación:</strong></h5></p>
                                        <p><h5 style="color: #4985d2;"><strong>Ciclo / Facturación:</strong></h5></p>
                                        <p><h5 style="color: #4985d2;"><strong>Fecha / Facturación:</strong></h5></p>
                                        <p><h5 style="color: #4985d2;"><strong>Lote: </strong></h5></p>
                                        <p><h5 style="color: #4985d2;"><strong>Fecha / Lote:</strong></h5></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <br/>
                                        <h5 id="fecha_activa_sg"></h5>
                                        <h5 id="ciclo_fact_sg"></h5>
                                        <h5 id="fecha_fact_sg"></h5>
                                        <h5 id="lote_sg"></h5>
                                        <h5 id="fecha_lote_sg"></h5>
                                    </div>


                                    <div id="cantidadObsequios"></div>

                                </div>

                                <table class="table table-bordered table-striped" id="dtmenu2" style="width:100%!important">
                                    <thead>

                                    <th>Usuario</th>
                                    <th>Observacion</th>
                                    <th>Fecha/Hora Estado</th>
                                    <th>Tiempo Transcurrido</th>
                                    <th>Estado</th>
                                    <th>Departamento</th>
                                    <th>Observación</th>
                                    </thead>
                                    <tbody id="tbobymenu2">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div style="text-align: center;">
                    {!! Form::button('Pregrabado', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                    {!! Form::button('Grabado', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardarValida")) !!}

                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-info','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <form action="/manager_socket.php" method="POST" target="_blank"id="formulario_llamada">
                                    <input type="hidden" name="Extension" id="Extension">
                                    <input type="hidden" name="Prefijo"  id="Prefijo">
                                    <input type="hidden" name="receptor"  id="receptor">
                                    <div class="col-lg-12" style="display:none"><button id="btnenviarllamada">Enviar</button></div>
    </form>
    <div class="panel-heading">
        Consulta de datos
    </div>

    <div class="panel-body">

        <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
            <thead>

            <th>Contacto</th>
            <th>Cliente</th>
            <th>Detalle/Estado</th>
            <th>Asesor</th>
            <th>N° Solicitud</th>
            <th>Total de Lineas</th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
            <tfoot>
                       <tr>
                           <th colspan="4" style="text-align:right">Total de Lineas:</th>
                           <th></th>
                       </tr>
                   </tfoot>
        </table>
    </div>
</div>


@endsection
