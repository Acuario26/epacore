@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado Archivo Casos
@endsection
@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/plugins/datepicker/') }}/datepicker3.css" rel="stylesheet">
@endsection
@section('javascript')
         <script type="text/javascript">
        //$('#dtmenuCS').DataTable().destroy();
        //$('#tbobymenuCS').html('');

        //$('#dtmenuCS').show();
        //$.fn.dataTable.ext.errMode = 'throw';
        
 
        var dataSource = $('#dtmenu').DataTable(
            {
                responsive: true,"oLanguage":
                    {
                        "sUrl": "/js/config/datatablespanish.json"
                    },
                "lengthMenu": [[5,10,20 -1], [5,10,20, "All"]],
                "order": [[ 1, 'desc' ]],
                "searching": true,
                "info":  false,
                "ordering": false,
                "bPaginate": true,
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "destroy": true,
                "ajax": "/admin/casos/archivo/data",
                "columns":[

                    {data: 'nombre'}, 
                    {data: 'created_at'} ,                 
                    {
                        data: 'actions',
                        "width": "10%",
                        "bSortable": false,
                        "searchable": false,
                        "targets": 0,
                        
                    }
                ],

            }).ajax.reload();

    

    

    
    </script>

     <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">
          <a class="btn btn-primary" href="{{route('casos.archivoSubir')}}">Agregar</a>
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
                  <th>Fecha</th>
                  <th>Opciones</th>

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
          </div>
      </div>

@endsection