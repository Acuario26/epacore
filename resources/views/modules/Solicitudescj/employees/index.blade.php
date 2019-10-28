@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado de Empleados
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/employees.js') }}"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">

        <a class="btn btn-primary" href="{{route('employees.create')}}" >Agregar</a>
          
      </div>
<hr/>

      <div class="panel panel-default">
          <div class="panel-heading">
              @lang('global.app_list')
          </div>

          <div class="panel-body">
              <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important" >
                  <thead>

                  <th>Cédula</th>
                  <th>Nombres</th>
                  <th>Rol</th>
                  <th>Correo</th>
                  <th>Estado</th>
                  <th>Opciones</th>

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
          </div>
      </div>

@endsection