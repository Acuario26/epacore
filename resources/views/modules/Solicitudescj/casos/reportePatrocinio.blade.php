@extends('layouts.app')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Listado de Patrocinio
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
                "serverSide": false,
                "deferRender": true,
                "destroy": true,                
                "ajax": "/admin/casos/busqueda/data/patrocinio/{{$fecha_desde}}/{{$fecha_hasta}}",
                "columns":[

                	  {data: 'cjga'},
                    {data: 'mes'},
                    {data: 'annio'},
                    {data: 'provincia'},
                    {data: 'ciudad'},
                    {data: 'supervisor.name'},
                    {data: 'created_at_es'},
                    {data: 'materia'},
                    {data: 'tipo_proceso'},
                    {data: 'tipo_patrocinio'},
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
                    {data: 'pretension_presion'},
                    {data: 'tipo_judicatura'},
                    {data: 'unidad_judicial'},
                    {data: 'nombre_juez'},
                    {data: 'causa'},
                    {data: 'ultima_actividad'},
                    {data: 'fecha_ultima_actividad'},
                    {data: 'estado_caso'},
                    {data: 'resolucion_judicial'},
                    {data: 'fecha_resolucion'},
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
                      filename : 'reporte_casos_patrocinios',
                      exportOptions: {
                          modifier: {
                              page: 'current'
                          }
                      }
                  }
		            ],


            })

    
        	function minifiedAjax(data) {
        for (var i = 0, len = data.columns.length; i < len; i++) {
            if (! data.columns[i].search.value) delete data.columns[i].search;
            if (data.columns[i].searchable === true && (data.columns[i].search === undefined || data.columns[i].search === "")) delete data.columns[i].searchable;
            if (data.columns[i].orderable === false) delete data.columns[i].orderable;
            if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
        }
        delete data.search.regex;
    }
    

    
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
              <table class="table table-bordered table-striped " id="dtmenu" style="width: 6046px;" >
                  <thead>

				          <th style="width:300px !important;" >CJGA</th>
                  <th width="100">Mes Informe</th>
                  <th width="100">Año Informe</th>
                  <th width="100">Provincia</th>
                  <th width="100">Ciudad</th>
                  <th width="250">Apellidos y Nombres Abogado\a del Consultorio Juridico</th>
                  <th width="100">Fecha en que se realizo la asesoria</th>
                  <th width="150">Materia</th>
                  <th width="150">Tipo de Jucio</th> 
                  <th width="150">Tipo de Patrocininio</th>                 
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
                  <th width="150">Pretensión Presión</th>
                  <th width="150">Tipo de Judicatura</th>                  
                  <th width="150">Tipo de Judicatura</th>
                  <th width="150">No. de Juzgado / Unidad Judicial</th>
                  <th width="150">No. de Causa</th>
                  <th width="150">Última actividad o diligencia realizada por el abogado del CJGA</th>
                  <th width="150">Fecha de la última acrividad o diligencia realizada</th>
                  <th width="150">Estado</th>
                  <th width="150">Resolución Judicial \ Sentencia</th>
                  <th>Fecha Resolución Judicial \ Sentencia</th>
                  <th width="400">Observaciones</th>               
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