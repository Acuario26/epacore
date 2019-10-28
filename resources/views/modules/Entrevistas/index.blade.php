@extends('layouts.app')

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/pivot/') }}/pivot.css" rel="stylesheet">
    <style>
        /* The container */
        .containera {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .containera input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .containera:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .containera input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .containera input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .containera .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/entrevistas/entrevistas.js') }}"></script>
    <script src="{{ url('adminlte/plugins/pivot/') }}/pivot.js"></script>
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

<div class="col-lg-2" style="float:right">

    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-primary"
       data-target="#Modalagregar" data-toggle="modal" id="modal" onclick="limpiar();">Nuevo</a>
	   <a data-hover="tooltip" data-placement="top" class="btn btn-success"
       onClick="location.reload(false);"><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;Recargar</a>
</div>


<hr/>
<div class="col-lg-2" style="float:left;margin:5px">
{!! Form::select('bandejasA', $estado, null,['class' => 'form-control select2',"style"=>"width:100%","id"=>"bandejasA"]) !!}
</div>
<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Datos del Postulante</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form action="/manager_socket.php" method="POST" target="_blank"id="formulario_llamada">
                        <input type="hidden" name="Extension" id="Extension">
                        <input type="hidden" name="Prefijo"  id="Prefijo">
                        <input type="hidden" name="receptor"  id="receptor">
                        <div class="col-lg-12" style="display:none"><button id="btnenviarllamada">Enviar</button></div>
                    </form>
                    <div class="col-lg-12" style="margin:5px">
                        <div class="col-md-12">

                            <div class="col-md-4">
                                <strong>Identificación:</strong>
                            </div>
                            <div class="col-md-4">
                                <strong>Nombres Completos:</strong>
                            </div>

                            <div class="col-md-4">
                                <strong>Correo:</strong>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="col-md-4">
                                {!! Form::text('identificacion', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Identificación",'maxlength'=>'13','id'=>'identificacion'])!!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('nombres', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombres",'id'=>'nombres'])!!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::email('email', null, ["style"=>"resize: none",'rows'=>"3",'placeholder'=>'email',"class"=>"form-control",'id'=>'email']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin: 5px">

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <strong>Género:</strong>
                            </div>
                            <div class="col-md-4">
                                <strong>Provincia:</strong>
                            </div>
                            <div class="col-md-4">
                                <strong>Ciudad:</strong>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {!! Form::select('genero', ['0'=>'Genero','M'=>'Masculino','F'=>'Femenino'], 0,["width"=>"100%",'class' => 'form-control select2','id'=>'genero']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('provincia_id', $provincia, null,['class' => 'form-control-t select2',"width"=>"100%","placeholder"=>"Provincia",'id'=>'provincia_id']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('ciudad_id', [], null,['class' => 'form-control-t select2',"width"=>"100%","placeholder"=>"Ciudad",'id'=>'ciudad_id']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 5px">
                        <div class="col-md-4">
                            <strong>Celular:</strong>
                        </div>
                        <div class="col-md-4">
                            <strong>Convencional:</strong>
                        </div>
                        <div class="col-md-4">
                            <strong>Estado
                                Civil:</strong>
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('celular', null, ["style"=>"resize: none",'placeholder'=>'Celular','maxlength'=>'10',"class"=>"form-control",'id'=>'celular','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;','onBlur'=>'verificaCelular()']) !!}

                        </div>
                        <div class="col-md-4">
                            {!! Form::text('convencional', null, ["maxlength"=>"10","style"=>"resize: none",'placeholder'=>'Convencional',"class"=>"form-control",'id'=>'convencional','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}
                        </div>

                        <div class="col-md-4">
                            {!! Form::select('civil', ['SOLTER@'=>'SOLTER@','CASAD@'=>'CASAD@','Divorciad@'=>'DIVORCIAD@','Viud@'=>'Viud@','UNION_LIBRE'=>'UNION LIBRE'], null,['class' => 'form-control select2','placeholder'=>'ESTADO CIVIL',"style"=>"width:100%","id"=>"civil"]) !!}
                        </div>

                    </div>
                    <div class="col-md-12" style="margin: 5px">

                        <div class="col-md-4">
                            <strong>Estado:</strong>
                        </div>
                        <div class="col-md-4">
                            <strong>Asesor a Cargo:</strong>
                        </div>
                        <div class="col-md-4">
                            <strong>Edad:</strong>

                        </div>

                        <div class="col-md-4">
                            {!! Form::select('modo', $estados, 'INSCRITO',["width"=>"100%",'class' => 'form-control select2','id'=>'modo']) !!}
                
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('lider', $lider, null,["width"=>"100%",'class' => 'form-control select2','id'=>'lider']) !!}
                        </div>

                        <div class="col-md-4">
                            {!! Form::text('edad', null, ["style"=>"resize: none",'maxlength'=>'2','placeholder'=>'edad',"class"=>"form-control",'id'=>'edad','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 5px">
					       <strong>Observacion de Estado:</strong>

                            {!! Form::textarea('observacion_estado', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control-t",'onkeyup'=>"this.value = this.value.toUpperCase()",'id'=>'observacion_estado']) !!}
                        </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <strong>¿Cómo hacen para mantenerse en casa?</strong>
                            </div>
                            <div class="col-md-4">
                                <strong>¿Con quienes convive?</strong>
                            </div>
                            <div class="col-md-4">
                                <strong>¿Hace alguna actividad constantemente?</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12" style="margin: 5px">

                        <div class="col-md-4">
                            {!! Form::textarea('mantener_casa_nucleo', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control-t",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'mantener_casa_nucleo']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::textarea('convive_nucleo', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control-t",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'convive_nucleo']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::textarea('actividad', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control-t",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'actividad']) !!}
                        </div>
                    </div>

                    <div class="col-lg-12" style="margin: 5px">

                        <div class="col-md-2">
                            <strong>Tiene Hijos</strong>
                        </div>
                        <div class='col-lg-2'>
                            <label class='containera'>
                                <input type='checkbox' id='cc' onclick="checkedhijo();">
                                <span class='checkmark'></span>
                            </label>
                        </div>

                        <div id="hijos" style="display: none">
                            <div class="col-md-2">
                                <strong>Edad de su hijo menor:</strong>
                            </div>
                            <div class='col-lg-1'>
                            <strong>Años:</strong>
                            {!! Form::text('edad_hijo', null, ["style"=>"resize: none",'maxlength'=>'2',"class"=>"form-control",'id'=>'edad_hijo','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                            </div>
                            <div class='col-lg-1'>
                            <strong>Meses:</strong>
                            {!! Form::text('edad_hijo_m', null, ["style"=>"resize: none",'maxlength'=>'2',"class"=>"form-control",'id'=>'edad_hijo_m','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                            </div>
                            <div class="col-md-2">
                                <strong>¿Quien los cuida?</strong>
                            </div>
                            <div class='col-lg-2'>
                                {!! Form::text('asignacion_hijo', null, ["style"=>"resize: none","class"=>"form-control",'id'=>'asignacion_hijo']) !!}

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <hr/>
                        <div class="col-md-2">
                            <h4><strong>Estudios</strong></h4>

                        </div>
                        <div class="col-md-2">
                            <strong>Días
                            </strong>
                        </div>
                        <div class="col-md-2">
                            <strong>Horario
                            </strong>
                        </div>
                        <div class="col-md-2">
                            <strong>Insitución
                            </strong>
                        </div>
                        <div class="col-md-2">
                            <strong>Carrera
                            </strong>
                        </div>
                        <div class="col-md-2">
                            <strong>Nivel
                            </strong>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <div class="col-md-12">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-2">
                                {!! Form::select('dias_estudio', ['L-V'=>'Lunes a Viernes','S-D'=>'Sabados  y Domingos'], null,['class' => 'form-control select2','id'=>'dias_estudio']) !!}

                            </div>
                            <div class="col-md-2">
                                {!! Form::select('horario_estudio', ['MATUTINO'=>'MATUTINO','VESPERTINO'=>'VESPERTINO','NOCTURNO'=>'NOCTURNO'], null,['class' => 'form-control select2','id'=>'horario_estudio']) !!}

                            </div>
                            <div class="col-md-2">
                                {!! Form::text('casa_estudio', null, ["style"=>"resize: none","class"=>"form-control",'id'=>'casa_estudio']) !!}

                            </div>
                            <div class="col-md-2">
                                {!! Form::text('carrera', null, ["style"=>"resize: none","class"=>"form-control",'id'=>'carrera']) !!}

                            </div>
                            <div class="col-md-2">
                                {!! Form::number('nivel', null, ["style"=>"resize: none","class"=>"form-control",'id'=>'nivel','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;']) !!}

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <h4><strong>Área de Indagación
                            </strong></h4>
                        <hr/>
                        <table width="100%" border="1">
                            <tbody>
                            <tr>
                                <td style="width: 327px;">&nbsp;</td>
                                <td style="">1</td>
                                <td style="">2</td>
                                <td style="">3</td>
                                <td style="">4</td>
                                <td style="">5</td>
                                <td style="">respuestas</td>
                                <td style="">observaciones</td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">1.- &iquest;Qu&eacute; es lo que mas te interesa de este
                                    trabajo?
                                </td>
                                <td style=""><input type="radio" maxlength="1" name="1" id="p11" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="1" id="p12" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="1" id="p13" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="1" id="p14" value="4"></td>
                                <td style=""><input type="radio" maxlength="1 " name="1" id="p15" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta11', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta11']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion11', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion11']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">2.- &iquest;C&oacute;mo te defines como trabajador?</td>
                                <td style=""><input type="radio" maxlength="1" name="2" id="p21" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="2" id="p22" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="2" id="p23" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="2" id="p24" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="2" id="p25" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta12', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta12']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion12', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion12']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">3.- &iquest;C&oacute;mo fue su &uacute;ltima experiencia
                                    laboral?
                                </td>
                                <td style=""><input type="radio" maxlength="1" name="3" id="p31" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="3" id="p32" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="3" id="p33" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="3" id="p34" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="3" id="p35" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta13', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta13']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion13', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion13']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">4.- &iquest;Por qu&eacute; dej&oacute; de laborar en esa
                                    organizaci&oacute;n?
                                </td>
                                <td style=""><input type="radio" maxlength="1" name="4" id="p41" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="4" id="p42" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="4" id="p43" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="4" id="p44" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="4" id="p45" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta14', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta14']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion14', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion14']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">5.- &iquest;C&oacute;mo cree que el valoran sus compa&ntilde;eros?</td>
                                <td style=""><input type="radio" maxlength="1" name="5" id="p51" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="5" id="p52" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="5" id="p53" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="5" id="p54" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="5" id="p55" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta15', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta15']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion15', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion15']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">6.- &iquest;Qu&eacute; pueden aprender sus compa&ntilde;eros
                                    de ud?
                                </td>
                                <td style=""><input type="radio" maxlength="1" name="6" id="p61" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="6" id="p62" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="6" id="p63" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="6" id="p64" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="6" id="p65" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta16', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta16']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion16', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion16']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">7.- &iquest;C&oacute;mo ser&iacute;a su trabajo ideal?</td>
                                <td style=""><input type="radio" maxlength="1" name="7" id="p71" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="7" id="p72" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="7" id="p73" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="7" id="p74" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="7" id="p75" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta17', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta17']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion17', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion17']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">8.- &iquest;Cu&aacute;les son sus metas principales?</td>
                                <td style=""><input type="radio" maxlength="1" name="8" id="p81" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="8" id="p82" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="8" id="p83" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="8" id="p84" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="8" id="p85" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta18', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta18']) !!}
                                </td>
                                <td style="">{!! Form::textarea('observacion18', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'observacion18']) !!}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <hr/>
                        <h4><strong>Área de Valoración de Expresión Telefónica

                            </strong></h4>
                        <table width="100%" border="1">
                            <tbody>
                            <tr>
                                <td style="width: 327px;">&nbsp;</td>
                                <td style="">1</td>
                                <td style="">2</td>
                                <td style="">3</td>
                                <td style="">4</td>
                                <td style="">5</td>
                                <td style="">observaciones</td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">1.- Entonación</td>
                                <td style=""><input type="radio" maxlength="1" name="9" id="et11" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="9" id="et12" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="9" id="et13" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="9" id="et14" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="9" id="et15" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta1', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta1']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">2.- Timbre</td>
                                <td style=""><input type="radio" maxlength="1" name="10" id="et21" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="10" id="et22" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="10" id="et23" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="10" id="et24" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="10" id="et25" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta2', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta2']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">3.- Articulación</td>
                                <td style=""><input type="radio" maxlength="1" name="11" id="et31" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="11" id="et32" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="11" id="et33" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="11" id="et34" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="11" id="et35" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta3', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta3']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 327px;">4.- Ritmo</td>
                                <td style=""><input type="radio" maxlength="1" name="12" id="et41" value="1"></td>
                                <td style=""><input type="radio" maxlength="1" name="12" id="et42" value="2"></td>
                                <td style=""><input type="radio" maxlength="1" name="12" id="et43" value="3"></td>
                                <td style=""><input type="radio" maxlength="1" name="12" id="et44" value="4"></td>
                                <td style=""><input type="radio" maxlength="1" name="12" id="et45" value="5"></td>
                                <td style="">{!! Form::textarea('respuesta4', null, ["style"=>"resize: none",'rows'=>"3","class"=>"form-control",'onkeyup'=>"this.value = this.value.toUpperCase()" ,'maxlength'=>'200','id'=>'respuesta4']) !!}
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="ciudad_id_h" value="0">

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

<div class="panel panel-default">
    <div class="panel-heading">
        Consulta de datos

    </div>

    <div class="panel-body">
        <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
            <thead>
            <th>Celular</th>
            <th>Identificacion</th>
            <th>Nombres</th>
            <th>Fecha/Registro</th>
            <th>Usuario/Valida</th>
            <th>Ciudad</th>
            <th>Edad</th>
            <th>Total AI</th>
            <th>Total ET</th>

            <th>Estados</th>
            <th>Opciones</th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
</div>

@endsection
