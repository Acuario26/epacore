@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Gestión de postulante
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/postulants.js') }}"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">

      	<a class="btn btn-warning" href="{{route('porstulants.index')}}" >Postulante</a>
          
      </div>
<hr/>

    

      <div class="panel panel-default">
          <div class="panel-heading">
              Datos del postulante
          </div>

          <div class="panel-body">
            
              <br>
              <div class="col-sm-4 col-md-3">
		            <dt>Identificación</dt>
		            <dd><p>{{$postulant->identificacion}}</p></dd>
		        </div>

	            <div class="col-sm-4 col-md-3">
		            <dt>Nombre</dt>
		            <dd><p>{{$postulant->nombres}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Apellidos</dt>
		            <dd><p>{{$postulant->apellidos}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Estatus de Solicitud</dt>
		            <dd>{!!$postulant->status_label!!}</dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Dirreción</dt>
		            <dd><p>{{$postulant->direccion}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Celular</dt>
		            <dd><p>{{$postulant->celular}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Convencional</dt>
		            <dd><p>{{$postulant->convencional}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Semestre</dt>
		            <dd><p>{{$postulant->semestre}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Fecha de Registro</dt>
		            <dd><p>{{$postulant->created_at_es}}</p></dd>
		        </div>		        

		        <div class="col-sm-4 col-md-3">
		            <dt>Correo Institucional</dt>
		            <dd><p>{{$postulant->correo_institucional}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Correo Personal</dt>
		            <dd><p>{{$postulant->correo_institucional}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Horario</dt>
		            <dd><p>{{$postulant->horario}}</p></dd>
		        </div>

		         <div class="col-sm-4 col-md-3">
		            <dt>Fecha de Nacimiento</dt>
		            <dd><p>{{$postulant->fecha_nacimiento}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Edad</dt>
		            <dd><p>{{$postulant->edad}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Modalidad</dt>
		            <dd><p>{{$postulant->modalidad}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Provincia</dt>
		            <dd><p>{{$postulant->provincia_id}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Ciudad</dt>
		            <dd><p>{{$postulant->ciudad_id}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Discapacidad</dt>
		            <dd><p>{{$postulant->discapacidad}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Estado Civil</dt>
		            <dd><p>{{$postulant->estado_civil}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Labora</dt>
		            <dd><p>{{$postulant->labora}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Direccion Laboral</dt>
		            <dd><p>{{$postulant->direccion_t ? $postulant->direccion_t : '&nbsp;' }}</}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Horario</dt>
		            <dd><p>{{$postulant->horario_t ? $postulant->horario_t : '&nbsp;' }}</}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Telefono</dt>
		            <dd><p>{{$postulant->telefono_t ? $postulant->telefono_t : '&nbsp;' }}</}}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Area</dt>
		            <dd><p>{{$postulant->area ? $postulant->area : '&nbsp;' }}</p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt>Carnet CONADIS</dt>
		            <dd><p>{{$postulant->carnet ? $postulant->carnet : '&nbsp;' }}</p></dd>
		        </div>


		        <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
		        	<h4 style="padding-left: 10px;" >Area de Preferencia</h4>
	            </div>

	            <div class="col-md-12" style="margin-top: 15px;">          

	            </div>

	            <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Civil</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->civil ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Penal</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->penal ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Familia</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->familia ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Laboral</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->laboral ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Violencia familiar</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->violenciaf ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Inquilinato</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->inquilinato ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Fiscalia</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->fiscalia ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Defensoria</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->defensoria ? 'checked' : ''}}></p></dd>
		        </div>

		        <div class="col-sm-4 col-md-3">
		            <dt class="text-center">Constitucional</dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->constitucional ? 'checked' : ''}}></p></dd>
		        </div>

		        <!--civil	int(11) NULL [0]	 
				penal	int(11) NULL [0]	 
				familia	int(11) NULL [0]	 
				laboral	int(11) NULL [0]	 
				violenciaf	int(11) NULL [0]	 
				inquilinato	int(11) NULL [0]	 
				fiscalia	int(11) NULL [0]	 
				defensoria	int(11) NULL [0]	 
				constitucional-->
		        



		        @if($postulant->status_request!='PENDIENTE')
		          
		          <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
		        	<h4 style="padding-left: 10px;" >Documentación</h4>
		          </div>

		          <div class="col-md-12" style="margin-top: 15px;">          

		          </div>

		          
		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">CEDULA <br>

		            	@if($postulant->cedula_archivo)
		            		<span onclick="$('#carga_image').attr('src',''); $('#carga_pdf').attr('src','{{url("storage/cedula".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif 

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->cedula_archivo ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">PAPELETA <br>

		            	@if($postulant->papeleta_archivo)
		            		<span onclick="$('#carga_image').attr('src',''); $('#carga_pdf').attr('src','{{url("storage/papeleta".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif 

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->papeleta_archivo ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">FOTO <br>

		            	@if($postulant->foto_archivo)
		            		<span onclick="$('#carga_pdf').attr('src',''); $('#carga_image').attr('src','{{url("storage/foto".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif  

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->foto_archivo ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">CURRICULUM <br>

		            	@if($postulant->curriculum_archivo)
		            		<span onclick="$('#carga_image').attr('src',''); $('#carga_pdf').attr('src','{{url("storage/curriculum".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif  

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->curriculum_archivo ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">SOLICITUD <br>

		            	@if($postulant->solicitud_sellada)
		            		<span onclick="$('#carga_image').attr('src',''); $('#carga_pdf').attr('src','{{url("storage/solicitud_sellada".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif  

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->solicitud_sellada ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">CERTIFICADO MATRICULA. <br>

		            	@if($postulant->certificado_matricula)
		            		<span onclick="$('#carga_image').attr('src','');; $('#carga_pdf').attr('src','{{url("storage/certificado_matricula".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif  

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->certificado_matricula ? 'checked' : ''}}></p></dd>
		          </div>

		          <div class="col-sm-4 col-md-3">
		            <dt class="text-center">CERTIFICADO NO ARRASTRE. <br>

		            	@if($postulant->certificado_no_arrastre)
		            		<span onclick="$('#carga_image').attr('src',''); $('#carga_pdf').attr('src','{{url("storage/certificado_arrastre".$postulant->id.".pdf")}}')" class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span>
		            	@else
		            		<span class="fa fa-file-pdf" style="color: #5fa9d4;font-size:50px;"></span> 
		            	@endif    

		            </dt>
		            <dd class="text-center"><p><input type="checkbox" disabled="disabled" {{$postulant->certificado_no_arrastre ? 'checked' : ''}}></p></dd>
		          </div>

		          
		          <div class="col-md-12 text-center" style="margin-top: 20px;">
		          	<embed id="carga_pdf" style="width: 100%;" src="" height="800"></embed>
		          	<img id="carga_image" style="width: 400px;" src="" height="auto"></img>
		          </div>

		        @endif

		        <div class="clearfix"></div>


		        <div class="col-md-12">
		            <hr>

		            {!! Form::open(['method' => 'POST', 'route' => ['porstulants.statusRequest'],'id'=>'FrmStatus']) !!}

			            <input type="hidden" name="id" value="{{$postulant->id}}" >

			            @if($postulant->status_abv=='PE')
				            <p class="text-right">
				        		<button id="btnGuardar" class="btn btn-primary" type="submit">Autorizar</button>
				        	</p>
				        	<input type="hidden" name="status" value="6" >

				        @elseif($postulant->status_abv=='AU')

				        	@if($postulant->cedula_archivo && $postulant->papeleta_archivo && $postulant->foto_archivo && $postulant->curriculum_archivo && $postulant->solicitud_sellada && $postulant->certificado_matricula && $postulant->certificado_no_arrastre && $postulant->solicitud_sellada)
					          	<p class="text-right">
					        		<button id="btnGuardar" class="btn btn-primary"  type="submit">Aprobar Postulante</button>
					        	</p>
					        	<input type="hidden" name="status" value="2" >
					        @endif
				        @endif

				    {!! Form::close() !!}



				    @if($postulant->status_abv=='AU')
				        <hr>

			          	{!! Form::open(['method' => 'POST', 'route' => ['postulants.statusIncompleto'],'id'=>'FrmIncompleto']) !!}
			          		<div class="col-xs-9 form-group">
			          			{!! Form::label('motivo', 'Motivo', ['class' => 'control-label']) !!}
	                            {!! Form::textarea('motivo', old('motivo') ? old('motivo') : $postulant->motivo, ['class' => 'form-control', 'placeholder' => '', 'required' => '','rows'=>'4','style'=>'height:auto !important']) !!}
			          		</div>
			          
	                        <div class="col-xs-3 form-group text-right">
	                        
	                        <input type="hidden" name="postulant_id" value="{{$postulant->id}}" >
	                        <br>
	                        <button id="btnIncompleto" class="btn btn-danger" type="submit">Negar Solicitud</button>
	                        </div>
	                  
	                  	{!! Form::close() !!}
	                 @endif
		        </div>

		      
          </div>
      </div>

@endsection
