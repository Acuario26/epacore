@extends('layouts.app')
@section('contentheader_title')
    Juridicore
@endsection

@section('contentheader_description')
    Gestion de Empleado
@endsection

@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/employees.js') }}"></script>
@endsection

@section('content')
    <hr/>
        <div class="col-md-6 col-md-offset-3">
            {!! Form::model($employee,['method' => 'POST', 'route' => ['employees.update',$employee->id]]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.app_edit')
                </div>

                {{ method_field('PUT') }}

                <div class="panel-body" style="margin:25px">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('email', 'Correo', ['class' => 'control-label']) !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('roles', 'Rol', ['class' => 'control-label']) !!}
                            {!! Form::select('roles', $roles, old('roles') ? old('roles') : $employee->roles_type[0] , ['class' => 'form-control select2', 'required' => '','id'=>'select_tags']) !!}
                            <p class="help-block"></p>
                            
                        </div>
                    </div>
                    <div class="row">
	                    <div class="col-xs-12 form-group">
	                        {!! Form::label('persona_id', 'Cedula', ['class' => 'control-label']) !!}
	                        {!! Form::text('persona_id', null, ['class' => 'form-control', 'placeholder' => 'cedula', 'required' => '','maxlength'=>'13']) !!}
	                        
	                    </div>
	                </div>

                     <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('lugarasignado_id', 'Lugar Asignado', ['class' => 'control-label']) !!}
                            {!! Form::select('lugarasignado_id', $places, old('lugar') , ['class' => 'form-control select2', 'required' => '','id'=>'lugar']) !!}

                            {{--{!! Form::label('lugar', 'Lugar', ['class' => 'control-label']) !!}
                            {!! Form::text('lugar', null, ['class' => 'form-control', 'placeholder' => '','maxlength'=>'50','disabled'=>'disabled','id'=>'lugar']) !!}--}}
                            
                        </div>
                    </div>
                
                    <input type="hidden" name="estado" value="A"/>
                    <input type="hidden" name="id" value="{{$employee->id}}"/>
                    <br>
                    <div class="pull-right">
                    {!! Form::button(trans('global.app_update'), ['type'=>'submit','class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
        
        {!! Form::close() !!}
        @stop
