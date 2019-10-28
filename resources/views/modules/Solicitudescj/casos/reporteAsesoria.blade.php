@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado de Asesorias
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
                "ajax": "/admin/casos/busqueda/data/asesoria/{{$fecha_desde}}/{{$fecha_hasta}}",
                "columns":[

                	  {data: 'cjga'},
                    {data: 'mes'},
                    {data: 'annio'},
                    {data: 'provincia'},
                    {data: 'ciudad'},
                    {data: 'supervisor.name'},
                    {data: 'created_at_es'},
                    {data: 'materia'},
                    {data: 'cliente_nombre'},
                    {data: 'cliente.cedula'},
                    {data: 'cliente_fecha_nacimiento'},
                    {data: 'cliente.celular'},
                    {data: 'cliente.domicilio'},
                    {data: 'cliente.sexo'}, 
                    {data: 'cliente.etnia'},
                    {data: 'cliente.nacionalidad'},
                    {data: 'cliente.instruccion'},
                    {data: 'cliente.ocupacion'},
                    {data: 'cliente.estado_civil'},
                    {data: 'cliente.ingresos'},  
                    {data: 'cliente.bono'},
                    {data: 'cliente.discapacidad'},
                    {data: 'cliente.sector'},
                    {data: 'tipo_usuario'},
                    {data: 'defensoria_publica'},
                    {data: 'convirtio_patrocinio'},
                    {data: 'detalle'},                   
                    /*{data: 'created_at'},
                    {data: 'estado_label'},
                    {
                        data: 'actions',
                        "width": "10%",
                        "bSortable": false,
                        "searchable": false,
                        "targets": 0,
                        
                    }*/
                ],
                dom: 'lBfrtip',
                buttons: [
		              {
                      extend: 'excel',
                      text: 'Excel',
                      filename : 'reporte_casos_asesorias',
                      exportOptions: {
                          modifier: {
                              page: 'current'
                          }
                      }
                  }
		            ]

            }).ajax.reload();

    

    

    
    </script>

     <script src="{{ url('adminlte/plugins/datepicker/') }}/bootstrap-datepicker.js"></script>
@endsection
@section('content')
      <div class="col-lg-2 text-right" style="float:right">
          <a class="btn btn-warning" href="{{route('casos.search')}}" >Buscar</a>
      </div>
<hr/>

      <div class="panel panel-default">
          <div class="panel-heading">
              @lang('global.app_list')
          </div>

          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped " id="dtmenu" style="width: 4046px;" >
                  <thead>

				          <th style="width:300px !important;" >CJGA</th>
                  <th width="100">Mes Informe</th>
                  <th width="100">Año Informe</th>
                  <th width="100">Provincia</th>
                  <th width="100">Ciudad</th>
                  <th width="250">Apellidos y Nombres Abogado\a del Consultorio Juridico</th>
                  <th width="100">Fecha en que se realizo la asesoria</th>
                  <th width="150">Materia</th>                  
                  <th width="150">Nombres y Apellidos del Usuario-a</th>
                  <th>No. Cedula o Pasaporte</th>                  
                  <th>Fecha de Nacimiento</th> 
                  <th>Numero de Teléfono del Usuario</th> 
                  <th width="200">Dirección</th> 
                  <th>Genero</th>
                  <th>Etnia</th>
                  <th>Pais de Origen</th>
                  <th>Instrucción</th> 
                  <th width="150">Ocupación</th>
                  <th width="150">Estado Civil</th>
                  <th width="150">Nivel de Ingreso</th> 
                  <th width="150">Recibe Bono</th>
                  <th width="150">Discapacidad</th>
                  <th width="150">En que zona vive?</th>
                  <th width="150">Tipo de usuario</th>
                  <th width="150">Derivado por la Defensoría Públicad</th>
                  <th width="150">Se Convirtio en Patrocinio</th>
                  <th width="150">Observaciones</th>               
                  <!--<th>Fecha</th>
                  <th>Estado</th>
                  <th>Opciones</th>-->

                  </thead>
                  <tbody id="tbobymenu">

                  </tbody>
              </table>
            </div>
          </div>
      </div>

@endsection