@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Gestión de cliente
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/clients.js') }}"></script>
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
      <div class="col-lg-2 text-right" style="float:right">

      	
          
      </div>
<hr/>

    

      <div class="panel panel-default">
          <div class="panel-heading">
              Datos del cliente
          </div>

          <div class="panel-body">
            
              <br>
              <div class="col-sm-4 col-md-3">
		            <dt>Identificación</dt>
		            <dd><p>{{$client->cedula}}</p></dd>
		        </div>

	            <div class="col-sm-4 col-md-3">
		            <dt>Nombre</dt>
		            <dd><p>{{$client->nombres}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Apellidos</dt>
		            <dd><p>{{$client->apellidos}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Fecha Nacimiento</dt>
		            <dd><p>{{$client->fecha_nacimiento}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Edad</dt>
		            <dd><p>12</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Nacionalidad</dt>
		            <dd><p>{{$client->nacionalidad}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Etnia</dt>
		            <dd><p>{{$client->etnia}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Celular</dt>
		            <dd><p>{{$client->celular}}</p></dd>
		        </div>

		       

		        <div class="col-sm-4 col-md-3">
		            <dt>Convencional</dt>
		            <dd><p>{{$client->convencional ? $client->convencional : '&nbsp;'}}</p></dd>
		        </div>		

		                

		        <div class="col-sm-4 col-md-3">
		            <dt>Instrucción</dt>
		            <dd><p>{{$client->instruccion}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Domicilio</dt>
		            <dd><p>{{$client->domicilio}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Estado Civil</dt>
		            <dd><p>{{$client->estado_civil}}</p></dd>
		        </div>

		         <div class="col-sm-4 col-md-3">
		            <dt>Sexo</dt>
		            <dd><p>{{$client->sexo}}</p></dd>
		        </div>

		        @if($client->sexo=='Otros')

			        <div class="col-sm-4 col-md-3">
			            <dt>Tipo Sexo</dt>
			            <dd><p>{{$client->tipo_sexo}}</p></dd>
			        </div>

		        @endif

		        <div class="col-sm-4 col-md-3">
		            <dt>Sector</dt>
		            <dd><p>{{$client->sector}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Ocupación</dt>
		            <dd><p>{{$client->ocupacion}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Afiliado al IESS</dt>
		            <dd><p>{{$client->iess}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Ingresos</dt>
		            <dd><p>{{$client->ingresos}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Bonos</dt>
		            <dd><p>{{$client->bono ?  $client->bono : '0'}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Discapacidad</dt>
		            <dd><p>{{$client->discapacidad}}</p></dd>
		        </div>

		        @if($client->discapacidad=='SI')

			        <div class="col-sm-4 col-md-3">
			            <dt>Tipo Discapacidad</dt>
			            <dd><p>{{$client->tipo_discapacidad}}</p></dd>
			        </div>

			    @endif


			    <div class="col-sm-4 col-md-3">
		            <dt>Enfermedad Catastrofica</dt>
		            <dd><p>{{$client->enfermedad}}</p></dd>
		        </div>

		        @if($client->enfermedad=='SI')

			        <div class="col-sm-4 col-md-3">
			            <dt>Tipo Enfermedad</dt>
			            <dd><p>{{$client->tipo_enfermedad}}</p></dd>
			        </div>

			    @endif

			    <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
	        		<h4 style="padding-left: 10px;" >Información del caso</h4>
	          	</div>

	          	<div class="col-md-12" style="margin-top: 15px;">          

	          	</div>

	          	{!! Form::model($client,['method' => 'POST', 'route' => ['clients.updateCaso',$client->id]]) !!}

	          		{{ method_field('PUT') }}
	          	
		          	<div class="col-xs-6 form-group">
	                    {!! Form::label('razon', 'Razón acude al consultorio', ['class' => 'control-label']) !!}
	                    {!! Form::select('razon',['Asesoría'=>'Asesoría','Patrocinio'=>'Patrocinio'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('causa', 'Causa', ['class' => 'control-label']) !!}
	                    {!! Form::text('causa', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-12 form-group">
	                    {!! Form::label('detalle', 'Detalle', ['class' => 'control-label']) !!}
	                    {!! Form::textarea('detalle', null, ['class' => 'form-control', 'placeholder' => '', 'maxlength'=>'255', 'rows'=>'3','style'=>'height:auto !important']) !!}                           
	                </div>
	                

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('tipo_proceso', 'Tipo Proceso', ['class' => 'control-label']) !!}
	                    {!! Form::text('tipo_proceso', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('unidad_judicial', 'Unidad Judicial', ['class' => 'control-label']) !!}
	                    {!! Form::text('unidad_judicial', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
	                    {!! Form::text('fecha_inicio',null,['class'=>'form-control pickadate','id'=>'fecha_inicio','placeholder'=>'Seleccione fecha ', 'required' => '']) !!}
	                    
	                </div>


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('demandante', 'Demandante', ['class' => 'control-label']) !!}
	                    {!! Form::text('demandante', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('demandado', 'Demandado', ['class' => 'control-label']) !!}
	                    {!! Form::text('demandado', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('practicante_id', 'Practicante', ['class' => 'control-label']) !!}
	                    {!! Form::select('practicante_id',$practicantes->pluck('name','id'), Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                </div>

					<div class="col-xs-12">
	                	<br><br>
	                </div>
	                <div class="pull-right">
	                    {!! Form::button(trans('global.app_save'), ['type'=>'submit','class' => 'btn btn-primary']) !!}

	                    &nbsp;

	                    <a class="btn btn-warning" href="{{route('clients.print',$client->id)}}">Imprimir</a>
	                </div>

                {!! Form::close() !!}

		        
		      
          </div>
      </div>

@endsection

