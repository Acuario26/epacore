@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado de Periodos
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/solicitudescj/periods.js') }}"></script>
     <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">

        <a class="btn btn-primary" href="{{route('periods.create')}}" >Agregar</a>
          
      </div>
<hr/>

      <div class="panel panel-default">
          <div class="panel-heading">
              @lang('global.app_list')
          </div>

          <div class="panel-body">
              <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important" >
                  <thead>

                  <th>Descripción</th>
                  <th>Fecha Inicio</th>                  
                  <th>Fecha Final</th>
                  <th>Estado</th>
                  <th>Opciones</th>

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
          </div>
      </div>

@endsection