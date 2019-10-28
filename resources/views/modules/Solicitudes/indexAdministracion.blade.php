@extends('layouts.app')
@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>

        .flotante {
            display: scroll;
            position: fixed;
            bottom: 320px;
            right: 0px;
        }

    </style>
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">

@endsection
@section('javascript')

    <script src="{{ url('js/modules/solicitudes/administracion.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>

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
@endsection
<input type="hidden" value="{{$role}}" id="role">
<a href="#" style="float: right;" data-hover="tooltip" data-placement="top" class="btn btn-success"
   onclick="recargar()"><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;Recargar</a>
<br/>
<br/>
<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" id="spanText" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

            </div>
            <input type="hidden" value="0" id="dciudadi">
            <input type="hidden" value="0" id="tipo_dato">
            <input type="hidden" id="dciudadi" value="0">
            <input type="hidden" id="dlaboralesi" value="0">
            <input type="hidden" id="dentregai" value="0">
            <div class="modal-body">
                <div class="panel-body">
                    <div id="dsolicitud" style="display:none">
                        <div class="col-lg-12">
                            <div
                                    style="margin-left:10px"><h4><strong>
                                        <a href="#">Datos de Solicitud</a>
                                    </strong>
                                </h4>
                            </div>
                            <div class="col-lg-4">
                                <label>Fecha de Creación:</label>
                                {!! Form::text('created_at', null,['disabled',"style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"Fecha de Creacion","name"=>"created_at",'id'=>'created_at']) !!}
                            </div>
                            <div class="col-lg-4">
                                <label>Solicitud:</label>

                                {!! Form::text('solicitud', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"Solicitud","name"=>"solicitud",'id'=>'solicitud']) !!}
                            </div>

                            <div class="col-lg-4">
                                <label>Ultimo Estado:</label>
                                {!! Form::text('uestado', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"uestado","name"=>"uestado",'id'=>'uestado','disabled']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12" name="lineas_s">

                            <div class="col-lg-3">
                                <label>Estados:</label>

                                {!! Form::select('estado', ['A'=>'ACTIVO','I'=>'INACTIVO','E'=>'FINALIZADO'], null,['class' => 'form-control select2','placeholder'=>'Estado de Solicitud',"style"=>"width:100%","id"=>"estado"]) !!}

                            </div>
                            <div class="col-lg-3">
                                <label>Total de Lineas:</label>

                                {!! Form::text('tlineas', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"Total Lineas","name"=>"tlineas",'id'=>'tlineas','disabled']) !!}

                            </div>
                            <div class="col-lg-3">
                                <label>Total de Obsequios</label>

                                {!! Form::text('tobsequios', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"Total Obsequios","name"=>"tobsequios",'id'=>'tobsequios','disabled']) !!}

                            </div>
                            <div class="col-lg-3">
                                <label>Total de Chip</label>

                                {!! Form::text('tchip', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"Total Chip","name"=>"tchip",'id'=>'tchip','disabled']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12" name="observacion_s">
                            <label>Observación:</label>

                            {!! Form::textarea('observacion', null,['row'=>'4','style' => 'max-height: 400px; resize: none;',"class"=>"form-control-t","placeholder"=>"Observacion del Asesor","name"=>"observacion",'id'=>'observacion']) !!}

                        </div>
                        <div class="col-lg-12" name="hr_s">
                            <hr/>
                        </div>
                        <div class="col-lg-12">
                            <div
                                    style="margin-left:10px" class="col-lg-12"><h4><strong>
                                        <a href="#">Datos del Asesor</a>
                                    </strong>
                                </h4>
                            </div>
                            <div class="col-lg-12" id="asesor_asignado">
                                <label>Asesor asignado:</label>
                                {!! Form::select('empleado_id_d', $asesor, null,['class' => 'form-control select2','placeholder'=>'Asesor',"id"=>"empleado_id_d",'disabled']) !!}

                            </div>
                            <div class="col-lg-6" id="asesor_r">
                                <label>Asesor:</label>
                                {!! Form::select('empleado_id', $asesor, null,['class' => 'form-control select2','placeholder'=>'Asesor',"style"=>"width:100%","id"=>"empleado_id"]) !!}
                            </div>
                            <div class="col-lg-6" name="dgestor_s">
                                <label>Gestor:</label>

                                {!! Form::select('gestor_id', $asesor, null,['class' => 'form-control select2','placeholder'=>'Gestor',"style"=>"width:100%","id"=>"gestor_id"]) !!}
                            </div>
                            <div class="col-lg-12">
                                <label>Motivo de cambio:</label>
                                {!! Form::textarea('motivo', null,["style"=>"","class"=>"form-control-t" ,"placeholder"=>"motivo","name"=>"motivo",'id'=>'motivo']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12" name="hr_s">
                            <hr/>
                        </div>
                        <div class="col-lg-12" name="entrega_s">
                            <div
                                    style="margin-left:10px"><h4><strong>
                                        <a href="#">Datos de Entrega</a>
                                    </strong>
                                </h4>
                            </div>
                            <label>Dirección:</label>

                            {!! Form::textarea('direccion_entrega', null,['row'=>'4','style' => 'max-height: 400px; resize: none;',"class"=>"form-control-t" ,"placeholder"=>"Direccion de Entrega","name"=>"direccion_entrega",'id'=>'direccion_entrega']) !!}
                        </div>
                        <div class="col-lg-12" name="entregad_s">

                            <div class="col-lg-3">
                                <label>Región:</label>

                                {!! Form::select('region', ['R1'=>'R1','R2'=>'R2'], null,['class' => 'form-control select2','placeholder'=>'Region de Entrega',"style"=>"width:100%","id"=>"region"]) !!}
                            </div>
                            <div class="col-lg-3">
                                <label>Provincia/Entrega:</label>

                                {!! Form::select('provincia_id', $provincia, null,['class' => 'form-control select2','placeholder'=>'Provincia de Entrega',"style"=>"width:100%","id"=>"provincia_id"]) !!}
                            </div>
                            <div class="col-lg-3">
                                <label>Ciudad/Entrega:</label>

                                {!! Form::select('entrega_ciudad_id', [], null,['class' => 'form-control select2','placeholder'=>'Ciudad de entrega',"style"=>"width:100%","id"=>"entrega_ciudad_id"]) !!}
                            </div>
                            <div class="col-lg-3">
                                <label>Celular/Entrega:</label>

                                {!! Form::text('celular_entrega', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"Celular/Entrega","name"=>"celular_entrega",'id'=>'celular_entrega','maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12" name="hr_s">
                            <hr/>
                        </div>
                        <div class="col-lg-12" name="fact_s">
                            <div
                                    style="margin-left:10px"><h4><strong>
                                        <a href="#">Datos de Facturación</a>
                                    </strong>
                                </h4>
                            </div>
                            <div class="col-lg-4">
                                <label>Fecha/Facturación:</label>

                                {!! Form::text('fecha_facturacion', null,["style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"Fecha/Facturación","name"=>"fecha_facturacion",'id'=>'fecha_facturacion']) !!}

                            </div>
                            <div class="col-lg-4">
                                <label>Ciclo/Facturación:</label>

                                {!! Form::select('ciclo_facturacion', ['24-23'=>'24-23','08-07'=>'08-07','15-14'=>'15-14','02-01'=>'02-01'], null,['class' => 'form-control select2','placeholder'=>'Ciclo de Faturación',"style"=>"width:100%","id"=>"ciclo_facturacion"]) !!}

                            </div>
                            <div class="col-lg-4">
                                <label>Fecha/Activación:</label>

                                {!! Form::text('fecha_activacion', null,["style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"Fecha/Activación","name"=>"fecha_activacion",'id'=>'fecha_activacion']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12" name="lote_s">
                            <div class="col-lg-6">
                                <label>Fecha/Lote:</label>

                                {!! Form::text('fecha_lote', null,["style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"Fecha Lote","name"=>"fecha_lote",'id'=>'fecha_lote']) !!}
                            </div>
                            <div class="col-lg-6">
                                <label>Lote:</label>

                                {!! Form::text('lote', null,["style"=>"","class"=>"form-control" ,"placeholder"=>"Lote","name"=>"lote",'id'=>'lote']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr/>
                        </div>
                    </div>
                    <div id="dcliente">
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
                                                            "id"=>"identificacion","disabled"=>"disabled"]) !!}
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
                                                {!! Form::text('celular', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Celular","name"=>"celular_natural",'maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

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
                        <!-- timeline icon -->
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
                                                    {!! Form::text('valor_garantia', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Valor de Garantía",'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',"name"=>"valor_garantia"]) !!}
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

                                                {!! Form::text('n_cuenta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"NUMERO DE CUENTA",'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',"name"=>"n_cuenta_banco"]) !!}

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

                                                {!! Form::text('n_tarjeta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Numero de la tarjeta","name"=>"n_tarjeta"]) !!}

                                            </div>
                                            <div class="col-lg-3">
                                                <label><strong>Código de Seguridad
                                                        de Tarjeta</strong></label>

                                                {!! Form::text('codigo_tarjeta', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Codigo de Seguridad de la tarjeta","name"=>"codigo_tarjeta"]) !!}

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
                    </div>
                    <div id="dlinea">
                        <form id="idlinea">
                            <input type="hidden" id="id_celular" value="0">
                            <input type="hidden" id="cliente_id" value="0">
                            <div class='col-lg-2'>
                                Solicitud:
                                {!! Form::text('n_solicitud', null,["class"=>"form-control" ,"placeholder"=>"N° Solicitud","disabled","name"=>"n_solicitud",'id'=>'n_solicitud']) !!}
                            </div>

                            <div class='col-lg-2' name='ddiaxiscabecera11'>
                                <strong>Solicitud del Axis:</strong>

                                <input type='text' class="form-control" name='addaxis' placeholder='Solicitud Axis'>
                            </div>

                            <div class='col-lg-2' name='ddiaxiscabecera13'>
                                <strong>Estado del Axis:</strong>
                                {!! Form::select('addaxisestado', ['Aprobado'=>'Aprobado','Negado'=>'Negado'], null,['class' => 'form-control select2','placeholder'=>'ESTADO AXIS',"style"=>"width:100%","name"=>"addaxisestado"]) !!}

                            </div>

                            <div class='col-lg-2' name='ddiaxiscabecera13'>
                                <strong>Estado:</strong>
                                {!! Form::select('addestadolinea', ['A'=>'Activo','I'=>'Inactivo'], null,['class' => 'form-control select2','placeholder'=>'ESTADO',"style"=>"width:100%","name"=>"addestadolinea"]) !!}

                            </div>
                            <div class='col-lg-12' name='ddiaddditem'>
                                <div class='col-lg-2' name='ddicabecera14'>
                                    <br/>
                                </div>

                                <div style='margin:2px'>
                                    <div class='col-lg-12' name='ddicabecera'>
                                        <div class='col-lg-2' name='ddicabecera1'>
                                            <strong>Tipo/Solicitud:</strong>
                                        </div>
                                        <div class='col-lg-2' name='ddicabecera2'>
                                            <strong>Celular:</strong>
                                        </div>
                                        <div class='col-lg-2' name='ddicabecera3'>
                                            <strong>Operadora:</strong>
                                        </div>
                                        <div class='col-lg-1' name='ddicabecera4'>
                                            <strong>Linea:</strong>
                                        </div>

                                        <div class='col-lg-3' name='ddiespacio'>
                                        </div>
                                        <div class='col-lg-1' name='dmarca'>
                                            <strong>Marca:</strong>

                                        </div>
                                        <div class='col-lg-1' name='dmodelo'>
                                            <strong>Modelo:</strong>

                                        </div>
                                    </div>
                                    <div class='col-lg-2' name='ddiadddtipo_solicitud'>
                                    {!! Form::select('addtipo_solicitud', ['Linea_Nueva'=>'Linea Nueva','Migracion'=>'Migracion','Transferencia_Beneficiario'=>'Transferencia Beneficiario','Portabilidad'=>'Portabilidad'], null,['class' => 'form-control select2','placeholder'=>'TIPO DE SOLICITUD',"style"=>"width:100%","name"=>"addtipo_solicitud","onchange"=>"tipo_solicitud()"]) !!}
                                    </div>
                                    <div class='col-lg-2' name='ddiadddcelular'>
                                        <input class='form-control' type='text' name='addcelular'
                                               onblur='verificaNumero()' placeholder='Celular' maxlength='10'
                                               onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>
                                    </div>
                                    <div class='col-lg-2' name='ddiadddoperadora'>
                                    {!! Form::select('addoperadora', ['Claro'=>'Claro','Movistar'=>'Movistar','Cnt'=>'Cnt','Twenty'=>'Twenty'], null,['class' => 'form-control select2','placeholder'=>'OPERADORA',"style"=>"width:100%","name"=>"addoperadora"]) !!}

                                    </div>
                                    <div class='col-lg-2' name='ddiadddtipo_linea'>
                                    {!! Form::select('addtipo_linea', ['Prepago'=>'Prepago','Pospago'=>'Pospago','Migracion'=>'Migracion'], null,['class' => 'form-control select2','placeholder'=>'TIPO DE LINEA',"style"=>"width:100%","name"=>"addtipo_linea"]) !!}

                                    </div>
                                    <div class='col-lg-2' name='as1'>
                                        <label style='padding-left:5px;padding-right:5px;'
                                               name='ddiaddlabelequipo'>Equipo Propio</label>
                                        <input type='checkbox' name='addequipo'
                                               onclick='checkequipo()' checked>
                                        <input type='hidden' name='addequipoid' value='1'>

                                    </div>
                                    <div class='col-lg-1' name='ddiadddmarca'>
                                        <input class='form-control' type='text' name='addmarca'
                                               placeholder='marca'>
                                    </div>
                                    <div class='col-lg-1' name='ddiadddmodelo'>
                                        <input class='form-control' type='text' name='addmodelo'
                                               placeholder='modelo'>
                                    </div>
                                </div>
                                <div class='col-lg-12' name='ddicabecera22'>
                                    <div class='col-lg-2' name='ddicabecera12'>
                                        <strong>Bp:</strong>
                                    </div>
                                    <div class='col-lg-2' name='ddicabecera22'>
                                        <strong>Plan:</strong>
                                    </div>
                                    <div class='col-lg-2' name='ddicabecera32'>
                                        <strong>Tárifa Básica:</strong>
                                    </div>
                                    <div class='col-lg-2' name='ddicabecera42'>
                                        <strong>Cuota:</strong>
                                    </div>
                                    <div class='col-lg-2' name='imeiddicabecera52'>
                                        <strong>Imei:</strong>
                                    </div>
                                    <div class='col-lg-2' name='simcardddicabecera62'>
                                        <strong>Simcard:</strong>
                                    </div>
                                </div>
                                <div style='margin:2px'>
                                    <div class='col-lg-12' name='ddiadddselectbp'>
                                        <div class='col-lg-2' name='ddiaddselectbp'>

                                            <select class='form-control select2' style='border-radius: 10px'
                                                    name='addbp' onchange='obtienedatoselect()'>
                                            </select>
                                        </div>
                                        <div class='col-lg-2' name='ddiaddconsultabp'>
                                            <input class='form-control' type='hidden' name='addbphi'
                                                   value='0'>
                                            <input class='form-control' type='text' name='addplan'
                                                   placeholder='Plan' disabled>
                                        </div>
                                        <div class='col-lg-2' name='ddiaddconsultatb'>
                                            <input class='form-control' type='text' name='addtb'
                                                   placeholder='Tarifa' disabled>
                                        </div>
                                        <div class='col-lg-2' name='ddiaddconsultacuota'>
                                            <input class='form-control' type='text' maxlength='5'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'
                                                   name='addcuota' id='addcuota'
                                                   placeholder='Cuota'>
                                        </div>
                                        <div class='col-lg-2' name='ddiadddsimei'>
                                            <input class='form-control' type='text' name='addsimei'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'
                                                   placeholder='imei'>
                                        </div>

                                        <div class='col-lg-2' name='ddiadddsimcard'>
                                            <input class='form-control' type='text' name='addsimcard'
                                                   maxlength='18' placeholder='Simcard' onKeypress='if (event.keyCode <
                                    45 || event.keyCode > 57) event.returnValue = false;'>
                                        </div>


                                    </div>


                                </div>
                                <div class='col-lg-12' style='margin-top:15px;margin-bottom:15px'
                                     name='ddiadddcobsequios'>

                                    <div class='col-lg-3' name='ddiaddconsultaobsequio'
                                         style='padding-right:0px!important;'>
                                        <strong>Obsequio 1:</strong>
                                        {!! Form::select('addobsequio1', $obsequio, null,['class' => 'form-control select2','placeholder'=>'OBSEQUIO 1',"style"=>"width:100%","name"=>"addobsequio1"]) !!}

                                    </div>
                                    <div class='col-lg-3' name='ddiadddcobsequio2'>
                                        <strong>Codigo de Barra Obsequio 1:</strong>

                                        <input class='form-control' type='text' name='addcobsequio1'
                                               placeholder='Codigo de Barra Obsequio 1'>


                                    </div>
                                    <div class='col-lg-3' name='ddiaddconsultaobsequio'
                                         style='padding-right:0px!important;'>
                                        <strong>Obsequio 2:</strong>
                                        {!! Form::select('addobsequio2', $obsequio, null,['class' => 'form-control select2','placeholder'=>'OBSEQUIO 2',"style"=>"width:100%","name"=>"addobsequio2"]) !!}


                                    </div>
                                    <div class='col-lg-3' name='ddiadddobsequioc2'>
                                        <strong>Codigo de Barra Obsequio 2:</strong>
                                        <input class='form-control' type='text' name='addcobsequio2'
                                               placeholder='Codigo de Barra Obsequio 2'>

                                    </div>


                                </div>
                                <div style='margin:2px'>

                                    <div name='ddiaddddonante'>

                                        <div class='col-lg-3' name='ddiadddcidonante'>
                                            <input type='hidden' name='addiddonante' value='0'>
                                            <strong>Cédula Donante</strong>
                                            <input class='form-control' type='text' name='addceduladonante'
                                                   placeholder='Cedula Donante'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'
                                                   maxlength='13'>

                                        </div>


                                        <div class='col-lg-3' name='ddiadddnombredonante'>
                                            <strong>Nombre Donante</strong>
                                            <input class='form-control' type='text' name='addnombredonante'
                                                   placeholder='Nombre Donante'>

                                        </div>


                                        <div class='col-lg-4' name='ddiaddddirecciondonante'>
                                            <strong>Dirección Donante</strong>
                                            <input class='form-control' type='text' name='adddirecciondonante'
                                                   placeholder='Direccion Donante'>

                                        </div>


                                        <div class='col-lg-2' name='ddiadddcelulardonante'>
                                            <strong>Celular Donante</strong>
                                            <input class='form-control' type='text' name='addcelulardonante'
                                                   placeholder='Celular Donante' maxlength='10'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>


                                        </div>


                                    </div>


                                    <div name='ddiadddrl'>

                                        <div class='col-lg-3' name='ddiadddctarl'>
                                            <strong>Número de Cuenta</strong>
                                            <input class='form-control' type='text' name='addctarl'
                                                   placeholder='N° Cuenta'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'>

                                        </div>


                                        <div class='col-lg-3' name='ddiadddcirl'>
                                            <strong>Cédula de Representante Legal</strong>
                                            <input class='form-control' type='text' name='addcirl'
                                                   placeholder='Cedula RL'
                                                   maxlength='13'
                                                   onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'
                                                   maxlength='13'>

                                        </div>


                                        <div class='col-lg-4' name='ddiadddnombrerl'>
                                            <strong>Nombre del Representante Legal</strong>
                                            <input class='form-control' type='text' name='addnombrerl'
                                                   placeholder='Nombre RL'>

                                        </div>


                                        <div class='col-lg-2' name='ddiadddcargorl'>
                                            <strong>Cargo - R.Legal</strong>
                                            <input class='form-control' type='text' name='addcargorl'
                                                   placeholder='Cargo RL'>

                                        </div>


                                    </div>


                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="chargeback">
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                Identificacion:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('identificacion_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"identificacion_ch","name"=>"identificacion_ch",'id'=>'identificacion_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Cliente:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('cliente_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"cliente_ch","name"=>"cliente_ch",'id'=>'cliente_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Forma de Pago:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('forma_pago_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"forma_pago_ch","name"=>"forma_pago_ch",'id'=>'forma_pago_ch']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                N° de Solicitud:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('n_solicitud_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"n_solicitud_ch","name"=>"n_solicitud_ch",'id'=>'n_solicitud_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                N° de Lineas:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('n_lineas_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"n_lineas_ch","name"=>"n_lineas_ch",'id'=>'n_lineas_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Ciudad de Entrega:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('ciudad_entrega_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"ciudad_entrega_ch","name"=>"ciudad_entrega_ch",'id'=>'ciudad_entrega_ch']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                Región:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('region_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"region_ch","name"=>"region_ch",'id'=>'region_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Fecha de Activación:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('fecha_activacion_ch', null,['disabled',"style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"fecha_activacion_ch","name"=>"fecha_activacion_ch",'id'=>'fecha_activacion_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Fecha de Facturación:
                            </div>
                            <div class="col-lg-2">
                                {!! Form::text('fecha_facturacion_ch', null,['disabled',"style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"fecha_facturacion_ch","name"=>"fecha_facturacion_ch",'id'=>'fecha_facturacion_ch']) !!}

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr/>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                Celular:
                                {!! Form::text('celular_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"celular_ch","name"=>"celular_ch",'id'=>'celular_ch']) !!}

                            </div>
                            <div class="col-lg-1">
                                TB:
                                {!! Form::text('tb_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"tb_ch","name"=>"tb_ch",'id'=>'tb_ch']) !!}
                            </div>
                            <div class="col-lg-3">
                                Plan:
                                {!! Form::text('plan_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"plan_ch","name"=>"plan_ch",'id'=>'plan_ch']) !!}

                            </div>
                            <div class="col-lg-2">
                                Tipo de Linea:
                                {!! Form::text('tipo_linea_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"tipo_linea_ch","name"=>"tipo_linea_ch",'id'=>'tipo_linea_ch']) !!}
                            </div>
                            <div class="col-lg-3">
                                Asesor:
                                {!! Form::text('asesor_ch', null,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"asesor_ch","name"=>"asesor_ch",'id'=>'asesor_ch']) !!}

                            </div>
                        </div>

                        <div class="col-lg-12">

                            <div class="col-lg-2">
                                Estado:
                                {!! Form::select('tipo_estado_ch', $tipo_estado_ch , null,["style"=>"","class"=>"form-control select2" ,"name"=>"tipo_estado_ch",'id'=>'tipo_estado_ch']) !!}

                            </div>
                            <div id="baja_hide">
                                <div class="col-lg-4">
                                    Motivo:
                                    {!! Form::select('motivo_ch' , ['INACTIVO_CAMBIO_PREPAGO'=>'Inactivo Cambio Prepago','CAMBIO_COBRANZAS'=>'Inactivo Cobranzas','INACTIVO_ROBO'=> 'Inactivo Robo','INACTIVO_SIN_CARGO'=>'Inactivo Sin Cargo'] , null,["style"=>"","class"=>"form-control select2" ,"name"=>"motivo_ch",'id'=>'motivo_ch']) !!}

                                </div>
                                <div class="col-lg-3">
                                    Fecha/Desactivación:
                                    {!! Form::text('fecha_desactivacion_ch', null,["style"=>"","class"=>"form-control pickadate" ,"placeholder"=>"fecha/desactivacion","name"=>"fecha_desactivacion_ch",'id'=>'fecha_desactivacion_ch']) !!}

                                </div>
                                <div class="col-lg-1">
                                    Días:
                                    {!! Form::text('dias_ch', 0,['disabled',"style"=>"","class"=>"form-control" ,"placeholder"=>"dias_ch","name"=>"dias_ch",'id'=>'dias_ch']) !!}
                                </div>
                                <div class="col-lg-3">
                                    Tipo de Baja:
                                    {!! Form::select('tipo_baja_ch', ['CHARGEBACK'=>'CHARGEBACK', 'BAJA_MENOR'=>'BAJA_MENOR'] , null,['disabled',"style"=>"","class"=>"form-control select2" ,"name"=>"tipo_baja_ch",'id'=>'tipo_baja_ch']) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="text-align: center;">
                        {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                        {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Consulta de datos

    </div>

    <div class="panel-body">
        <div class="col-lg-12">
            <div class="col-lg-2" style="float:left">
                <label>Busqueda por:</label>

                {!! Form::select('criterio', $criterio, 0,['class' => 'form-control select2',"style"=>"width:100%","id"=>"criterio"]) !!}
            </div>
            <div class="col-lg-2" style="float:left">
                <label>Parametro:</label>
                {!! Form::text('parametro',null,['class'=>'form-control',"id"=>"parametro",'maxlength'=>'25']) !!}
            </div>
            <div id="destado">
                <div class="col-lg-2" style="float:left">

                    <label>Fecha de Inicio:</label>

                    {!! Form::text('fecha_inicio',null,['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Seleccione fecha ', ""]) !!}
                </div>
                <div class="col-lg-2" style="float:left">
                    <label>Fecha Final:</label>

                    {!! Form::text('fecha_final',null,['class'=>'form-control pickadate','id'=>'fechaf','placeholder'=>'Seleccione fecha ', ""]) !!}
                </div>
            </div>
            <div class="col-lg-2" style="float:left">
                <br>
                {!! Form::button('Enviar', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnEstado")) !!}
                {!! Form::button('Enviar', array('style'=>'display:none','data-hover'=>'tooltip','data-placement'=>'top',
                                                             'data-target'=>'#Modalagregar','data-toggle'=>'modal','type' => 'button', 'class' => 'btn btn-primary','id' => 'btnEstado1')) !!}

            </div>

        </div>
        <div class="col-lg-12">
            <hr/>
        </div>
        <div class="col-lg-12" style="display: none" id="datatableChange">
            <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
                <thead>
                <th>Solicitud</th>
                <th>Asesor</th>
                <th>Cliente</th>
                <th>Lineas</th>
                </thead>
                <tbody id="tbobymenu">

                </tbody>
            </table>

        </div>
    </div>
</div>


@endsection
