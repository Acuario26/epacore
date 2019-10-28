@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Busqueda de Casos por fecha
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
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
        <div class="col-md-12 col-md-offset-0">
            {!! Form::open(['method' => 'POST', 'route' => ['casos.searchPost'], 'enctype'=>"multipart/form-data"]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    Busqueda por Fecha
                </div>

                <div class="panel-body" style="margin:25px">
                    <div class="row">
                        
                            <div class="col-xs-4 form-group">
	                            {!! Form::label('fecha_desde', 'Fecha Desde', ['class' => 'control-label']) !!}
	                            {!! Form::text('fecha_desde',' ',['class'=>'form-control pickadate','id'=>'fecha_desde','placeholder'=>'Seleccione fecha ', 'required' => '']) !!}                            
                        	</div>
                        	<div class="col-xs-4 form-group">
	                            {!! Form::label('fecha_hasta', 'Fecha Hasta', ['class' => 'control-label']) !!}
	                            {!! Form::text('fecha_hasta',' ',['class'=>'form-control pickadate','id'=>'fecha_hasta','placeholder'=>'Seleccione fecha ', 'required' => '']) !!}                            
                        	</div> 
                        	<div class="col-xs-4 form-group">
	                            {!! Form::label('tipo', 'Tipo', ['class' => 'control-label']) !!}
	                            {!! Form::select('tipo',['Asesoria'=>'Asesoria','Patrocinio'=>'Patrocinio'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                        </div>
                        	<div class="col-xs-4 form-group">
                        	<br>
                        	&nbsp;&nbsp;&nbsp;{!! Form::button('Buscar', ['type'=>'submit','class' => 'btn btn-primary']) !!}
                        	</div>                            
                        
                    </div>
                </div>
            </div>
        </div>
@endsection