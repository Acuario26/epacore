@extends('layouts.app')
@section('javascript')
<script>
$("#persona_id").val('').change();
$("#nombreCompleto").val('CN=,CARGO=');
$("#persona_id").on("change",function(){
    var dataName=$('#persona_id option:selected').html();
    var data=$("#nombreCompleto").val();
    var arreglo=data.split(',');
    arreglo[0]='CN='+dataName;
    $("#nombreCompleto").val(arreglo[0]+','+arreglo[1]);
});
$("#cargo").on("keyup",function(){
    var data=$("#nombreCompleto").val();
    var arreglo=data.split(',');
    arreglo[1]='CARGO='+$("#cargo").val();
    $("#nombreCompleto").val(arreglo[0]+','+arreglo[1]);
});
/*
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
});*/
</script>
@endsection
@section('content')
        <div class="col-md-8 col-md-offset-2">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.users.store']]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.app_create')
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
                            {!! Form::label('password', 'Contraseña*', ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '','pattern'=>'^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$']) !!}
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
                            {!! Form::text('nombreCompleto', null, ['class' => 'form-control','required' => '','id'=>'nombreCompleto']) !!}
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                            {!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
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
                    <input type="hidden" name="estado" value="A"/>
                    <div class="col-md-12">
                        <hr/>
                    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-primary btn-sm hidden' , 'id'=>'savebtn']) !!}
                        <a href="#" class="btn btn-primary btn-sm" onclick="$('#savebtn').click()">Guardar Cambios</a>

                         <a href="{{ route('admin.users.index') }}" class="btn btn-danger btn-sm">Regresar</a>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
      
        @stop


