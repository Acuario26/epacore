@extends('layouts.app')
@section('contentheader_title')
    Juridicore
@endsection

@section('contentheader_description')
    Gestion de periodo
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/periodis.js') }}"></script>
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

@section('content')
    <hr/>
        <div class="col-md-6 col-md-offset-3">
            {!! Form::model($period,['method' => 'POST', 'route' => ['periods.update',$period->id]]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.app_edit')
                </div>

                {{ method_field('PUT') }}


                <div class="panel-body" style="margin:25px">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                            {!! Form::text('descripcion', old('descipcion'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            
                            
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('recepcioni', 'Inicio Recepcion de Carpetas', ['class' => 'control-label']) !!}
                            {!! Form::text('recepcioni',old('recepcioni'),['class'=>'form-control pickadate','id'=>'recepcioni','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('recepcionf', 'Final Recepcion de Carpetas', ['class' => 'control-label']) !!}
                            {!! Form::text('recepcionf',old('recepcionf'),['class'=>'form-control pickadate','id'=>'recepcionf','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('notificai', 'Inicio Notificación del Consultorio o institución Asignada', ['class' => 'control-label']) !!}
                            {!! Form::text('notificai',old('notificai'),['class'=>'form-control pickadate','id'=>'recepcioni','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('notificaf', 'Final Notificación del Consultorio o institución Asignada', ['class' => 'control-label']) !!}
                            {!! Form::text('notificaf',old('notificaf'),['class'=>'form-control pickadate','id'=>'notificaf','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('fechai', 'Fecha Inicio del ciclo pasantias', ['class' => 'control-label']) !!}
                            {!! Form::text('fechai',old('fechai'),['class'=>'form-control pickadate','id'=>'fechai','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>

                    

                     <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('fechaf', 'Fecha Final del ciclo pasantias', ['class' => 'control-label']) !!}
                            {!! Form::text('fechaf',old('fechaf'),['class'=>'form-control pickadate','id'=>'fechaf','placeholder'=>'Seleccione fecha ', ""]) !!}
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                        <div class="col-md-12">
<strong>Meses de Pasantias<strong></div>
                          <div class="col-md-4"> 
                            {!! Form::select('mesi',['enero'=>'enero','febrero'=>'febrero',
                            'marzo'=>'marzo','abril'=>'abril','mayo'=>'mayo','junio'=>'junio',
                            'julio'=>'julio',
                            'agosto'=>'agosto','septiembre'=>'septiembre','octubre'=>'octubre','noviembre'=>'noviembre',
                            'diciembre'=>'diciembre'],old('mesi'),['class'=>'form-control select2','id'=>'fechai','placeholder'=>'Seleccione Mes', ""]) !!}
                            </div>
                            <div class="col-md-4"> 

                            {!! Form::select('mesf',['enero','febrero','marzo','abril','mayo','junio','julio',
                             'agosto','septiembre','octubre','noviembre','diciembre'],old('mesf'),['class'=>'form-control select2','id'=>'fechaf','placeholder'=>'Seleccione Mes ', ""]) !!}
                            </div>
                        </div>
                    </div>

                
                    <br>
                    <div class="pull-right">
                    {!! Form::button(trans('global.app_update'), ['type'=>'submit','class' => 'btn btn-primary']) !!}
                    <a href="{{route('periods.index')}}" class="btn btn-danger">Cancelar</a>
                    
                    </div>
                </div>
            </div>
        </div>
        

        {!! Form::close() !!}
        @stop
