@extends('layouts.app')


@section('contentheader_description')
    Edición de Usuarios
@endsection
@section('javascript')
<script>
descomponerCargo();
function descomponerCargo(){
    var name=$("#nombreCompleto").val();
    var tamano=name.length;
    var lugar=name.indexOf('CARGO');
    $("#cargo").val(name.substring(lugar,tamano).replace('CARGO=',''));

}
$("#cargo").on("keyup",function(){
    var data=$("#nombreCompleto").val();
    var arreglo=data.split(',');
    arreglo[1]='CARGO='+$("#cargo").val();
    $("#nombreCompleto").val(arreglo[0]+','+arreglo[1]);
});
</script>
@endsection
@section('content')
<hr/>
    {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!}
<div class="row">
			<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body" style="margin:25px">

            
           
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Usuario*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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
                    {!! Form::label('email', 'Correo de Usuario*', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('password', 'Contraseña', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '','pattern'=>'^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('cargo', 'Cargo*', ['class' => 'control-label']) !!}
                    {!! Form::text('cargo', null, ['class' => 'form-control','required' => '','id'=>'cargo']) !!}
                </div>
            </div>
            <div class="row" style="display:none">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nombreCompleto', 'Nombre Completo*', ['class' => 'control-label']) !!}
                    {!! Form::text('nombreCompleto', old('nombreCompleto'), ['class' => 'form-control','required' => '','id'=>'nombreCompleto']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('roles'))
                        <p class="help-block">
                            {{ $errors->first('nombreCompleto') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                    {!! Form::select('roles[]', $roles, old('roles') ? old('role') : $user->roles()->pluck('name', 'name'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('roles'))
                        <p class="help-block">
                            {{ $errors->first('roles') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
            <div class="col-xs-12 form-group">
                        {!! Form::label('persona_id', 'Persona Asignada*', ['class' => 'control-label']) !!}
                        {!! Form::select('persona_id', $persona_id, null, ['class' => 'form-control select2', 'required' => '']) !!}

                    </div>
            </div>
            <div class="row">
        
            <div class="col-xs-12 form-group">
               <hr/>
            {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-lg btn-primary hidden','id'=>'savebtn']) !!}
                <a href="#" class="btn btn-primary btn-sm" onclick="$('#savebtn').click()">Guardar</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-danger btn-sm">Regresar</a>

                {!! Form::close() !!}
                        </div>
            </div>

        </div>
    </div>
</div>

@stop

