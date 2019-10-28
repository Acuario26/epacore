@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado de Clientes
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/clients.js') }}"></script>
     <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">

      @if(!count($sup)>0)

        <a class="btn btn-primary" href="{{route('clients.create')}}" >Agregar</a>

      @endif
          
      </div>
<hr/>

      <div class="panel panel-default">
          <div class="panel-heading">
              @lang('global.app_list')
          </div>

          <div class="panel-body">
              <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important" >
                  <thead>

                  <th>Nombres</th>
                  <th>Apellidos</th>                  
                  <th>Cedula</th>
                  <th>Estado</th>
                  <th>Opciones</th>

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
          </div>
      </div>

@endsection