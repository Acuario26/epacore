@extends('layouts.app')

@section('content')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
    .form-control{
        text-transform: none!important;
    }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/parameter.js') }}"></script>

@endsection
<div class="col-lg-2"  style="float:right">

    <a class="btn btn-primary" onclick="limpiar();">Nuevo</a>
</div>
<hr/>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Opciones del menu</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <input type="hidden" id="var" value="0"/>

                    <div class="col-lg-12 form-group">
                        {!! Form::label('father','Seleccione el parametro báse:',["class"=>"control-label"]) !!}

                    </div>
                    <div class="col-lg-12">
                        {!! Form::select('father', $father, null,['class' => 'form-control select2']) !!}
                    </div>
                    <br/>

                    <div class="col-lg-12 form-group">
                        {!! Form::label('name','Nombre del parametro:',[]) !!}
                    </div>
                    <br/>
                    <div class="col-lg-12 form-group">

                        {!! Form::text('name', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombre de la Opción",'id'=>'name']) !!}
                    </div>
                    <br/>
                    <br/>
                    <div class="col-lg-12 form-group">
                        {!! Form::label('Estado','Estado:',[]) !!}

                        {!! Form::select('optionid', $estado, null,['placeholder'=>'ESTADO','class' => 'form-control select2','id'=>'optionid']) !!}
                    </div>
                    <br/>
                    <div class="col-lg-12 form-group">

                        {!! Form::label('Verificacion','Verificacion: ',[]) !!}
                    </div>
                    <br/>
                    <div class="col-lg-12 form-group">

                        {!! Form::select('verificacion',
                         $verificacion, 0,
                        ['id'=>'verificacion','placeholder'=>'VERIFICACION','class' => 'form-control select2 col-lg-1']) !!}
                    </div>
                    <br/>

                </div>

                <br/>
                <br/>
            </div>

            <div class="modal-footer">
                <div style="text-align: center;">
                    {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                    {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger cerrarmodal','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
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

            <th>Nombre del parametro</th>
            <th>Estado</th>

            <th>Opciones</th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
</div>

@endsection
