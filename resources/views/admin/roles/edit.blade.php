@extends('layouts.app')
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
    .form-control{
        text-transform: none!important;
    }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/menu_rol.js') }}"></script>
@endsection

@section('content')

    {!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->id]]) !!}
<div class="row">
			<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            Agregar Nuevos
        </div>

        <div class="panel-body" style="margin:25px">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '', 'disabled'=>'disabled']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('permission', 'Permissions', ['class' => 'control-label']) !!}
                    {!! Form::select('permission[]', $permissions, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('permission'))
                        <p class="help-block">
                            {{ $errors->first('permission') }}
                        </p>
                    @endif
                </div>
            </div>
            <div>
                <hr/>
            {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnG")) !!}
                {!! Form::close() !!}
                <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">Regresar</a>

            </div>
        </div>
    </div>
</div>
   
@stop

