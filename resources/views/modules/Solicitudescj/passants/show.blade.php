@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Gestión de pasante
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <script src="{{asset('js/axios.js')}}"></script>
    <script src="{{asset('js/vue.js')}}"></script>
@endsection

@section('content')
      <div class="col-lg-2 text-right" style="float:right">

      	<a class="btn btn-warning" href="{{route('passants.index')}}" >Pasantes</a>
          
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
		            <dt>Correo Eléctronico</dt>
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

		        <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
		        	<h4 style="padding-left: 10px;" >Tutor</h4>
		          </div>

		          <div class="col-md-12" style="margin-top: 15px;">          

		          </div>

		          {!! Form::open(['method' => 'POST', 'route' => ['passants.assignSteacherTutor'],'id'=>'FrmTutor']) !!}
		          		<div class="col-xs-4 form-group">
		          		 @if($supervisor)
		          		 	<b>Tutor:</b> <br><span class="label label-success">{{$supervisor->name}}</span>
		          		 	{{--<br>
		          		 	<b>Horario:</b> <br><span class="label label-info">{{$horario->descripcion}}</span>--}}
		          		 @else
		          		 	Supervisor: 
		          		 	<br>
		          		 	<span class="label label-default">No asignado</span>
		          		 @endif
		          		</div>
		          
                        <div class="col-xs-4 form-group">
                            {!! Form::label('user_doc_id', 'Tutor Asignado', ['class' => 'control-label']) !!}
                            {!! Form::select('user_doc_id', $supervisors, old('user_doc_id') , ['class' => 'form-control select2', 'required' => '']) !!}
                        </div>

                        {{--<div class="col-xs-4 form-group">
                            {!! Form::label('horario_id', 'Horario', ['class' => 'control-label']) !!}
                            {!! Form::select('horario_id', $horarios, old('horario_id') , ['class' => 'form-control select2', 'required' => '']) !!}
                        </div>--}}

                        <div class="col-xs-4 form-group text-right">
                        <input type="hidden" name="id" value="{{$student[0]->id}}" >
                        <input type="hidden" name="postulant_id" value="{{$postulant->id}}" >
                        <br>
                        <button id="btnGuardar" class="btn btn-primary " type="submit">Asignar Tutor</button>
                        @if($supervisor)
                        	<a target="_blank" href="{{route('passants.printPlanillaTutor',$postulant->id)}}" class="btn btn-warning">Imprimir Planilla</a>
                        @endif

                        </div>
                  
                  {!! Form::close() !!}


                  <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
		        	<h4 style="padding-left: 10px;" >Supervisor Elegido</h4>
		          </div>

		          <div class="col-md-12" style="margin-top: 15px;">          

		          </div>

		          <section id="mySelect">

		          {!! Form::open(['method' => 'POST', 'route' => ['passants.assignSteacherSupervisor'],'id'=>'FrmAsignarSupervisor']) !!}

		          <div class="col-xs-4 form-group" >


		          		 <div class="form-group">

							<label>Lugar:</label>

							<select class='form-control' v-model='lugar' name="lugar" @change='getSupervisores()'>

					          <option value='0' >Selecione el Lugar</option>

					          <option v-for='data in lugares' :value='data.id'>@{{ data.descripcion }}</option>

					        </select>

						</div>

					 

						<div class="form-group">

							<label>Supervisor:</label>

							<select class='form-control' v-model='supervisor' name="supervisor" >

					          <option value='0' >Selecione el Supervisor</option>

					          <option v-for='data in supervisores' :value='data.id'>@{{ data.descripcion }}</option>

					        </select>

						</div>

					 

						<div class="form-group">

							<label>Hora de Inicio:</label>

							<select class='form-control' v-model='horario' name="horario" >

					          <option value='0' >Selecione la Hora</option>

					          <option v-for='data in horarios' :value='data.id'>@{{ data.descripcion }}</option>

					        </select>

						</div>

						<div class="form-group">

							<label>Hora a trabajar:</label>

							<select class='form-control' v-model='hora' name="hora" >

					          <option value='0' >Selecione las Horas a trabajar</option>

					          <option v-for='data in horas' :value='data.id'>@{{ data.descripcion }}</option>

					        </select>

						</div>

						<div class="form-group text-right">
                        	<input type="hidden" name="id" value="{{$student[0]->id}}" >
                        	<input type="hidden" name="postulant_id" value="{{$postulant->id}}" >
                        	<br>
                        	<button id="btnAsignarHorario" class="btn btn-primary" type="submit">Asignar Horario</button>
                        </div>

		          </div>
		         {!! Form::close() !!}

		         <div class="col-xs-4 form-group mySelect">
		            {{--@if($supervisor1)
		            	@if($students_teachers1[0]->estado=='I')
	          		 		<b>Estado:</b> <br><span class="label label-warning">Inactivo</span>
	          		 	@else
	          		 		<b>Estado:</b> <br><span class="label label-success">Activo</span>
	          		 	@endif
	          		 @else
	          		 	
	          		 @endif--}}
		         	
		         </div>

		         <div class="col-xs-4 form-group ">
	                <!--<a class="btn btn-primary" href="{{url('admin/gestion/pansantes/supervisor')}}/{{$student[0]->id}}/activar">Activar Supervisor</a>-->

	                <div v-if="supervisorSelect">
	                	<div class="form-group text-left">

							
							<label>Supervisor:</label>
							<p v-text="supervisorSelect.docente.name"></p>

							<label>Lugar:</label>
							<p v-text="supervisorSelect.lugar.descripcion"></p>

							<label>Hora de inicio:</label>
							<p v-text="supervisorSelect.hora_inicio"></p>

							<label>Hora a Laborar:</label>
							<p v-text="getCantHoras"></p>

							

							<div v-if="supervisorSelect.estado=='I'" >
								<a class="btn btn-primary" href="{{url('admin/gestion/pansantes/supervisor')}}/{{$student[0]->id}}/activar">Aprobar Horario</a>
							</div>
							<div v-else >
								<label class="label label-success">Supervidor Aprobado</label>
								<br><br>
								<a target="_blank" href="{{route('passants.printPlanillaSupervisor',$postulant->id)}}" class="btn btn-warning">Imprimir Planilla</a>
							</div>

						</div>
	                </div>
	                <div v-else>
	                  <label class="label label-default">El Practicante no a elegido ningun supervisor</label>
	                </div>
	             </div>

	             </section>


	             <div class="col-md-12" style="background-color: #ccc; margin-top: 20px;">
		        	<h4 style="padding-left: 10px;" >Cambio de estado</h4>
		          </div>

		          <div class="col-md-12" style="margin-top: 15px;">          

		          </div>


		          {!! Form::open(['method' => 'POST', 'route' => ['passants.statusRejection'],'id'=>'FrmRechazo']) !!}
		          		<div class="col-xs-10 form-group">
		          			{!! Form::label('motivo', 'Motivo de rechazo', ['class' => 'control-label']) !!}
                            {!! Form::textarea('motivo', old('motivo') ? old('motivo') : $postulant->motivo, ['class' => 'form-control', 'placeholder' => '', 'required' => '','rows'=>'4','style'=>'height:auto !important']) !!}
		          		</div>
		          
                        <div class="col-xs-2 form-group text-right">
                        <input type="hidden" name="user_id" value="{{$student[0]->id}}" >
                        <input type="hidden" name="postulant_id" value="{{$postulant->id}}" >
                        <br>
                        <button id="btnRechazo" class="btn btn-danger" type="submit">Deshabilitar</button>
                        </div>
                  
                  {!! Form::close() !!}

                  @if($postulant->status_abv=='NE')

	                  {!! Form::open(['method' => 'POST', 'route' => 

	                  ['passants.statusActivar'],'id'=>'FrmActivar']) !!}
			          		
	                        <div class="col-xs-2 form-group text-right">
	                        <input type="hidden" name="user_id" value="{{$student[0]->id}}" >
	                        <input type="hidden" name="postulant_id" value="{{$postulant->id}}" >
	                        <br>
	                        <button id="btnActivar" class="btn btn-success" type="submit">Activar</button>
	                        </div>
	                  
	                  {!! Form::close() !!}

                  @endif

		        
		      
          </div>
      </div>

@endsection

@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/passants.js') }}"></script>
    

    <script type="text/javascript">
    	var app = new Vue({

		  el: '#mySelect',
		  data: {
		    lugar: '0',
		    lugares: '',
		    supervisor: '0',
		    supervisores: '',
		    horario: '0',
		    horarios:[
		    			{id:'9', descripcion:'9:00'},
		    			{id:'10', descripcion:'10:00'},
		    			{id:'11', descripcion:'11:00'},
		    			{id:'12', descripcion:'12:00'},
		    			{id:'13', descripcion:'13:00'},
		    			{id:'14', descripcion:'14:00'},
		    			{id:'15', descripcion:'15:00'}
		    		 ],
		    hora: '0',
		    horas: [
		    	{id:'2', descripcion:'2'},
		    	{id:'4', descripcion:'4'},
		    	{id:'6', descripcion:'6'},
		    ],
		    supervisorSelect: {}
		  },

		  methods: {
		    getLugares: function(){
		      console.log('Lugar');
		      axios.get('{{url("admin/gestion/pasantes/consulta/supervisor")}}', {
		        params: {
		          request: 'lugares'
		        }
		      })
		      .then(function (response) {
		         app.lugares = response.data;
		         app.supervisores = '';
		         //app.horarios = '';
		         app.supervisor = '0';
		         app.horario = '0';
		      });
		    },

		    getSupervisores: function(){
		      console.log('Supervisor');
		      axios.get('{{url("admin/gestion/pasantes/consulta/supervisor")}}', {
		         params: {
		           request: 'supervidores',
		           lugar_id: this.lugar
		         }
		      })
		      .then(function (response) {
		         app.supervisores = response.data;
		         app.supervisor = '0';
		         //app.horarios = '';
		         //app.horario = '0';
		      }); 
		    }, 

		    /*getHorarios: function(){
		    	console.log('Horario');
		        axios.get('{{url("admin/gestion/pasantes/consulta/supervisor")}}', {
		        params: {
		          request: 'horarios',
		        }
		      }) 
		      .then(function (response) {
		        app.horarios = response.data;
		        app.horario = 0;
		      }); 
		    },*/

		    getSupervisorSelect: function(){
		      console.log('SelectSupervisor','{{url("admin/gestion/pasantes/consulta/supervisor/elegido/".$student[0]->id)}}');

		      axios.get('{{url("admin/gestion/pasantes/consulta/supervisor/elegido/".$student[0]->id)}}', ) 
		      .then(function (response) {
		        app.supervisorSelect = response.data;
		      }); 
		    }


		  },

		  computed: {
		  	getCantHoras:function() {
		  		if(this.supervisorSelect){
		  			var totalCantHoras = '';
		  		    var extHoraFin = this.supervisorSelect.hora_fin.split(':');
		  		    var extHoraInicio = this.supervisorSelect.hora_inicio.split(':');

		  		    totalCantHoras=(parseInt(extHoraFin)-parseInt(extHoraInicio))

		  		    return totalCantHoras;
		  		}
		  		return '' 
		  	}
		  },

		  created: function(){
		    this.getLugares();
		    /*this.getHorarios();*/
		    this.getSupervisorSelect();
		    
		    //this.lugares=[{name:'Alejandro Garcia',id:'1'}];
		  },

		  

		});
    </script>
@endsection
