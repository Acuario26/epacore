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
@endsection
@section('javascript')

    <script src="{{ url('js/modules/solicitudes/peticionliberacion.js') }}"></script>

@endsection

<div class="col-lg-2" style="float:left" id="destado">
    {!! Form::select('estado', ['0'=>'Todos','A'=>'Activo','I'=>'Inactivo'], 0,['class' => 'form-control select2',"style"=>"width:100%","id"=>"estado"]) !!}
</div>
<div class="col-lg-2" style="float:right">

    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-success"
       onclick="recargar()"><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;Recargar</a>
</div>
<hr/>
<input type="hidden" value="{{$controlAdmin}}" id="controlAdmin">



<div class="panel panel-default">
    <div class="panel-heading">
            Consulta de datos

    </div>

    <div class="panel-body">

        <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
            <thead>
            <th>Solicitud</th>
            <th>Observación</th>
            <th>Usuario</th>
            <th>Fecha Petición</th>
            <th>Estado</th>
            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>

    </div>
</div>


@endsection
