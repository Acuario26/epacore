@extends('layouts.app')


@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
    .form-control{
        text-transform: none!important;
    }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/admin.js') }}"></script>
@endsection
@section('content')
      <div class="col-lg-2" style="float:right">

          <a class="btn btn-primary"
              onclick="limpiar();">Nuevo</a>
      </div>
<hr/>

    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title" id="exampleModalLabel">Opciones del menu</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <input type="hidden" id="var" value="0"/>
                        <div class="form-group">
                            {!! Form::label('optionid','Opci&oacute;n Padre:',["class"=>"text-bold col-lg-12 control-label"]) !!}


                            <div class="col-lg-12">
                                {!! Form::select('optionid',$father, null,['class' => 'form-control select2',"style"=>"width:100%"]) !!}
                            </div>
                        </div>
                        <br/>
                        <br/>

                        <div class="form-group">
                            {!! Form::label('name','Nombre Opcion:',array("class" => "text-bold col-lg-12 control-label")) !!}

                            <div class="col-lg-12">
                                {!! Form::text('name', null,["required"=>"required","class"=>"form-control" ,"placeholder"=>"Nombre de la Opción"]) !!}
                            </div>
                        </div>
                        <br/>
                        <br/>

                        <div class="form-group">
                            {!! Form::label('prefix','Prefijo:',array("class" => "text-bold col-lg-12 control-label")) !!}
                            <div class="col-lg-12">
                                {!! Form::number('prefix', null,["required"=>"required","class"=>"form-control","min"=>"0" ]) !!}
                            </div>
                        </div>
                        <br/>
                        <br/>

                        <div class="form-group">
                            {!! Form::label('url','URL de la opci&oacute;n:',array("class" => "text-bold col-lg-12 control-label")) !!}
                            <div class="col-lg-12">
                                {!! Form::text('url', null,["class"=>"form-control","placeholder"=>"prefijo/NombredeOpcion"]) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div style="text-align: center;">
                        {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', array('type' => 'button', 'class' => 'btn btn-primary','id' => "btnGuardar")) !!}
                        {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', array('type' => 'button', 'class' => 'btn btn-danger cerrarmodal','id' => "btnCancelar", 'data-dismiss'=>"modal")) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

      <div class="panel panel-default">
          <div class="panel-heading">
              @lang('global.app_list')
          </div>

          <div class="panel-body">
              <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important" >
                  <thead>

                  <th>Nombre de la Opción</th>
                  <th>Url</th>
                  <th>Opciones</th>

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
          </div>
      </div>

@endsection

