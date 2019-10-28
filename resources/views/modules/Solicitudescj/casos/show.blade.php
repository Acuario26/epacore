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
    <script type="text/javascript">
        $( ".as" ).prop( "disabled", true );
		$( ".pt" ).prop( "disabled", true );
		if($("#razon").val()=='Patrocinio'){
			$( ".pt" ).prop( "disabled", false );
        	$( ".as" ).prop( "disabled", false );
		} else if ($("#razon").val()=='Asesoría'){
			$( ".pt" ).prop( "disabled", true );
			$( ".as" ).prop( "disabled", false );
		}

    	$(document.body).on("change","#razon",function(){
		    //alert(this.value);
		    $valor=this.value;
		     if($valor=='Asesoría'){
		        $( ".as" ).prop( "disabled", false );
		        $( ".pt" ).prop( "disabled", true );
		    }else{
		        $( ".pt" ).prop( "disabled", false );
		        $( ".as" ).prop( "disabled", false );
		        //$( ".pt" ).val('');
		    }   

		});

		@if($caso->estado=='PI' || $caso->estado=='F' || $caso->estado=='AT')
		  $( "#razon").prop( "disabled", true );
		  $( ".pt" ).prop( "disabled", true );
		  $( ".as" ).prop( "disabled", true );
		  $( "#practicante_id").prop( "disabled", true );
		@endif
    </script>
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
		            <dd><p>{{$client->edad}}</p></dd>
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

			    <div class="col-sm-6 col-md-6">
			    	<dt>Foto Cedula</dt>
			    	<dd><img src="{{asset('file/'.$client->foto_cedula)}}" class="img-responsive" width="100%"></dd>
			    </div>

			    <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
	        		<h4 style="padding-left: 10px;" >Información del caso</h4>
	          	</div>

	          	<div class="col-md-12" style="margin-top: 15px;">          

	          	</div>

	          	{!! Form::model($caso,['method' => 'POST', 'route' => ['casos.updateCaso',$caso->id]]) !!}

	          		{{ method_field('PUT') }}
	          	
		          	<div class="col-xs-6 form-group">
	                    {!! Form::label('razon', 'Razón acude al consultorio', ['class' => 'control-label']) !!}
	                    {!! Form::select('razon',['Asesoría'=>'Asesoría','Patrocinio'=>'Patrocinio'], Null, ['class' => 'form-control razon', 'placeholder' => '', 'required' => '','id'=>'razon']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('causa', 'Causa', ['class' => 'control-label']) !!}
	                    {!! Form::text('causa', null, ['class' => 'form-control pt', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-12 form-group">
	                    {!! Form::label('detalle', 'Detalle', ['class' => 'control-label']) !!}
	                    {!! Form::textarea('detalle', null, ['class' => 'form-control as', 'placeholder' => '', 'maxlength'=>'255', 'rows'=>'3','style'=>'height:auto !important']) !!}                           
	                </div>
	                
	                <div class="col-xs-6 form-group">
	                    {!! Form::label('tipo_usuario', 'Tipo Usuario', ['class' => 'control-label']) !!}
	                    {!! Form::select('tipo_usuario',['Demandante'=>'Demandante','Demandado'=>'Demanandado'], Null, ['class' => 'form-control as', 'placeholder' => '']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('tipo_proceso', 'Tipo Proceso', ['class' => 'control-label']) !!}
	                    {!! Form::text('tipo_proceso', null, ['class' => 'form-control pt', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('unidad_judicial', 'Unidad Judicial', ['class' => 'control-label']) !!}
	                    {!! Form::text('unidad_judicial', null, ['class' => 'form-control pt', 'placeholder' => '']) !!}                           
	                </div>


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
	                    {!! Form::text('fecha_inicio',null,['class'=>'form-control pt pickadate','id'=>'fecha_inicio','placeholder'=>'Seleccione fecha ']) !!}
	                    
	                </div>


	                <!--<div class="col-xs-6 form-group">
	                    {!! Form::label('demandante', 'Demandante', ['class' => 'control-label']) !!}
	                    {!! Form::text('demandante', null, ['class' => 'form-control pt', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('demandado', 'Demandado', ['class' => 'control-label']) !!}
	                    {!! Form::text('demandado', null, ['class' => 'form-control pt', 'placeholder' => '']) !!}                           
	                </div>-->


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('practicante_id', 'Practicante', ['class' => 'control-label']) !!}
	                    {!! Form::select('practicante_id',$practicantes->pluck('name','id'), Null, ['class' => 'form-control', 'placeholder' => '','practicante_id']) !!}                             
	                </div>

					<div class="col-xs-12">
	                	<br><br>
	                </div>
	                @if($caso->estado=='P')
	                <div class="pull-right">
	                    {!! Form::button(trans('global.app_save'), ['type'=>'submit','class' => 'btn btn-primary']) !!}

	                    &nbsp;
	                </div>
	                @elseif($caso->estado=='PI' || $caso->estado=='F' || $caso->estado=='AT')
	                    <div class="pull-right">
	                		<a class="btn btn-warning" target="_blank" href="{{route('casos.print',$caso->id)}}">Imprimir Planilla</a> <a class="btn btn-info" target="_blank" href="{{route('casos.printCedula',$caso->id)}}">Imprimir Cedula</a>
	                	</div>
	                @endif

                {!! Form::close() !!}


                <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
	        		<h4 style="padding-left: 10px;" >Información Adicional de {{$caso->razon}}</h4>
	          	</div>

	          	<div class="col-md-12" style="margin-top: 15px;">          

	          	</div>

	          	@if($caso->razon=='Asesoría')

	          		{!! Form::model($caso,['method' => 'POST', 'route' => ['casos.updateCasoAsesoria',$caso->id]]) !!}

	          		{{ method_field('PUT') }}

	          		<div class="col-xs-6 form-group">
	                    {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
	                    {!! Form::select('materia',['Civil'=>'Civil','Familia, Mujer, Niñez y Adolescencia'=>'Familia, Mujer, Niñez y Adolescencia','Civil'=>'Civil',
	                    'Garantías Jurisdiccionales'=>'Garantías Jurisdiccionales' ,'Inquilinato'=>'Inquilinato', 'Laboral'=>'Laboral', 'Movilidad Humana'=>'Movilidad Humana',
	                    'Penal (exclusivamente patrocinio a víctimas)'=>'Penal (exclusivamente patrocinio a víctimas)','Tierras'=>'Tierras','Trámites administrativos'=>'Trámites administrativos'
	                    ,'Varios'=>'Varios','Violencia Intrafamiliar'=>'Violencia Intrafamiliar' ,'Ejecución de la pena'=>'Ejecución de la pena'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '','id'=>'materia']) !!}                             
	                </div>


	                <div class="col-xs-6 form-group">
	                    {!! Form::label('defensoria_publica', 'Derivado por la Defensoría Pública', ['class' => 'control-label']) !!}
	                    {!! Form::select('defensoria_publica',['Si'=>'Si','No'=>'No'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('convirtio_patrocinio', 'Se Convirtio en Patrocinio', ['class' => 'control-label']) !!}
	                    {!! Form::select('convirtio_patrocinio',['Si'=>'Si','No'=>'No'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                </div>

	                <div class="col-md-12">
	                	<br>
	                	<div class="pull-right">
	                    	{!! Form::button(trans('global.app_save'), ['type'=>'submit','class' => 'btn btn-primary']) !!}

	                    	&nbsp;
	                	</div>
	                </div>

	                {!! Form::close() !!}



	          	@elseif($caso->razon=='Patrocinio')

	          		{!! Form::model($caso,['method' => 'POST', 'route' => ['casos.updateCasoPatrocinio',$caso->id]]) !!}

	          		{{ method_field('PUT') }}

	          		<div class="col-xs-6 form-group">
	                    {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
	                    {!! Form::select('materia',['Civil'=>'Civil','Familia, Mujer, Niñez y Adolescencia'=>'Familia, Mujer, Niñez y Adolescencia','Civil'=>'Civil',
	                    'Garantías Jurisdiccionales'=>'Garantías Jurisdiccionales' ,'Inquilinato'=>'Inquilinato', 'Laboral'=>'Laboral', 'Movilidad Humana'=>'Movilidad Humana',
	                    'Penal (exclusivamente patrocinio a víctimas)'=>'Penal (exclusivamente patrocinio a víctimas)','Tierras'=>'Tierras','Trámites administrativos'=>'Trámites administrativos'
	                    ,'Varios'=>'Varios','Violencia Intrafamiliar'=>'Violencia Intrafamiliar' ,'Ejecución de la pena'=>'Ejecución de la pena'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '','id'=>'materia']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('tipo_judicatura', 'Tipo de Judicatura', ['class' => 'control-label']) !!}
	                    {!! Form::select('tipo_judicatura',['Juzgado'=>'Juzgado','Tribunal'=>'Tribunal','Sala de la Corte'=>'Sala de la Corte','Unidad judicial'=>'Unidad judicial', 'Inspectoría'=>'Inspectoría'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '','id'=>'materia']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('tipo_patrocinio', 'Tipo patrocinio', ['class' => 'control-label']) !!}
	                    {!! Form::select('tipo_patrocinio',['Nuevo'=>'Nuevo','Seguimiento'=>'Seguimiento'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '','id'=>'materia']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('defensoria_publica', 'Derivado por la Defensoría Pública', ['class' => 'control-label']) !!}
	                    {!! Form::select('defensoria_publica',['Si'=>'Si','No'=>'No'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                             
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('pretension_presion', 'Pretesión de Presión', ['class' => 'control-label']) !!}
	                    {!! Form::number('pretension_presion', null, ['class' => 'form-control']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('nombre_juez', 'Nombre del Juez', ['class' => 'control-label']) !!}
	                    {!! Form::text('nombre_juez', null, ['class' => 'form-control', 'placeholder' => '','required' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('ultima_actividad', 'Última actividad', ['class' => 'control-label']) !!}
	                    {!! Form::text('ultima_actividad', null, ['class' => 'form-control', 'placeholder' => '','required' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('fecha_ultima_actividad', 'Fecha Ultima Actividad', ['class' => 'control-label']) !!}
	                    {!! Form::text('fecha_ultima_actividad',null,['class'=>'form-control pickadate','id'=>'fecha_ultima_actividad','placeholder'=>'Seleccione fecha ','required' => '']) !!}
	                    
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('estado_caso', 'Estado del Caso', ['class' => 'control-label']) !!}
	                    {!! Form::select('estado_caso',['Activo'=>'Activo','Resuelto'=>'Resuelto' ,'Inactivo'=>'Inactivo'], Null, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('resolucion_judicial', 'Resolución Judicial', ['class' => 'control-label']) !!}
	                    {!! Form::text('resolucion_judicial', null, ['class' => 'form-control', 'placeholder' => '']) !!}                           
	                </div>

	                <div class="col-xs-6 form-group">
	                    {!! Form::label('fecha_resolucion', 'Fecha Resolución', ['class' => 'control-label']) !!}
	                    {!! Form::text('fecha_resolucion',null,['class'=>'form-control pickadate','id'=>'fecha_resolucion','placeholder'=>'Seleccione fecha ']) !!}
	                    
	                </div>

	                <div class="col-md-12">
	                	<br>
	                	<div class="pull-right">
	                    	{!! Form::button(trans('global.app_save'), ['type'=>'submit','class' => 'btn btn-primary']) !!}

	                    	&nbsp;
	                	</div>
	                </div>


	                {!! Form::close() !!}
	            

	          	@endif




		        
		      
          </div>
      </div>
<br><br><br><br><br><br><br><br>
@endsection