@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Archivo de Casos
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
            {!! Form::open(['method' => 'POST', 'route' => ['casos.archivoGuardar'], 'enctype'=>"multipart/form-data"]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subir archivo de casos
                </div>

                <div class="panel-body" style="margin:25px">
                    <div class="row">
                        
                            <div class="col-xs-6 form-group">
	                            {!! Form::label('nombre', 'Nombre', ['class' => 'control-label']) !!}
	                            {!! Form::text('nombre',' ',['class'=>'form-control' , 'placeholder'=>'', 'required' => '']) !!}                            
                        	</div>
                        	<div class="col-xs-4 form-group">
	                           {!! Form::label('archivo_caso', 'Achivo ( Excel )', ['class' => 'control-label']) !!}
                            	<br>
                            	{!! Form::file('archivo_caso',['required'=>'','class' => 'form-control']) !!}                              
                        	</div> 
                        	<div class="col-xs-2 form-group">
                        	<br>
                        	&nbsp;&nbsp;&nbsp;{!! Form::button('subir', ['type'=>'submit','class' => 'btn btn-primary']) !!}
                        	</div>                            
                        
                    </div>
                </div>
            </div>
        </div>
@endsection