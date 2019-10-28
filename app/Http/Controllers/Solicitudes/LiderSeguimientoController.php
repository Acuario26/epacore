<?php

namespace App\Http\Controllers\Solicitudes;

use App\Core\Entities\Solicitudes\Bestados;
use App\Core\Entities\Solicitudes\CambioGestor;
use App\Core\Entities\Solicitudes\Cliente;
use App\Core\Entities\Solicitudes\LineaEstados;
use App\Core\Entities\Solicitudes\SolicitudAsignacion;
use App\Core\Entities\Solicitudes\Lineas;
use App\Core\Entities\Solicitudes\Solicitud;
use App\Http\Controllers\Ajax\SelectController;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class LiderSeguimientoController extends Controller
{
    public function SeguimientoIndex()
    {
        $name = 'AsesorCC';
        DB::beginTransaction();
        try {
            $codigo = 0;
            //$int = Solicitud::select('n_solicitud')->count();
            $identificacion = Auth::user();
            $usuario = DB::connection('mysql_solicitudes')
                ->table('empleados AS emp')
                ->where('emp.estado', 'A')
                ->where('emp.identificacion', $identificacion->persona_id)
                ->groupBy('emp.nombres', 'emp.apellidos')
                ->select(DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))->first()->name;

            $objRole = DB::connection('mysql')->table('roles')->where(['name' => $name])->first();
            $objSelect = new SelectController();
            $gestores = $objSelect->getGestores($objRole->id);
            $ciudad = $objSelect->getParametro('CIUDAD', 'http');
            $provincia = $objSelect->getParametro('PROVINCIA', 'http');
            $banco = $objSelect->getParametro('BANCO', 'http');


            $objUserRole = DB::connection('mysql')
                ->table('model_has_roles as mr')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->where(['mr.model_id' => $identificacion->id])
                ->select('r.name')
                ->get()->toArray();

            $LiderCredito = Auth::user()->evaluarole(['LiderCredito','AsesorCredito','AsesorCRJ']);
            $LiderCalidad = Auth::user()->evaluarole(['LiderCalidad','AsesorCalidad']);
            $LiderRecepcion = Auth::user()->evaluarole(['LiderRecepcion','AsesorRecepcion']);
            $LiderRegularizacion = Auth::user()->evaluarole(['LiderRegularizacion','AsesorRegularizacion']);
            $BandejaLider=array();
            
            $BandejaLider[0]='Escoja una Opcion';

            if($LiderCredito!=0)
            {
                $BandejaLider['Credito']='Credito';
            }
            if($LiderCalidad!=0)
            {
                $BandejaLider['Calidad']='Calidad';
            }
            if($LiderRecepcion!=0)
            {
                $BandejaLider['Recepcion']='Recepcion';
            }
            if($LiderRegularizacion!=0)
            {
                $BandejaLider['Regularizacion']='Regularizacion';
            }
           
            
            $bandejacredi = $objSelect->getParametro('BANDEJA_CREDITO', 'http');
            $bandejacalid = $objSelect->getParametro('BANDEJA_CALIDAD', 'http');
            $bandejarecep = $objSelect->getParametro('BANDEJA_RECEPCION', 'http');
            $bandejaregul = $objSelect->getParametro('BANDEJA_REGULARIZACION', 'http');
            $bandejaSeguimiento = ['0' => 'Pendiente de Estado', '1' => 'Bandeja Actual', '2' => 'Salientes'];
            $formatos_imprimir = $objSelect->getParametro('FORMATOS', 'http');


            DB::commit();
            return view('modules.Solicitudes.LiderSeguimiento',compact(
                    'usuario',
                    'gestores' ,
                    'ciudad',
                    'provincia',
                    'banco',
                    'bandejacredi',
                    'bandejacalid',
                    'bandejarecep',
                    'bandejaregul',
                    'bandejaSeguimiento',
                    'BandejaLider',
                    'formatos_imprimir')
                );

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getDatatableSeguimiento($dato, $bandejasA)
    {
      
  
        $objSelect = new SelectController();
        $AsesorCreditoJ = Auth::user()->evaluarole(['AsesorCRJ']);
        $AsesorCredito = Auth::user()->evaluarole(['AsesorCredito']);
        $AsesorE = Auth::user()->evaluarole(['AsesorCRJ','AsesorCredito','AsesorCalidad','AsesorRecepcion','AsesorRegularizacion']);
        switch ($bandejasA) {
            case 'Credito':
                $bandeja = 'BANDEJA_CREDITO';
                $verificacion = 3;
                $bandejas = $objSelect->getParametro('BANDEJA_CREDITO', 'http', 3);
                $llamada=0;
                break;
            case 'Calidad':
                $bandeja = 'BANDEJA_CALIDAD';
                $verificacion = 4;
                //salida
                $bandejas = $objSelect->getParametro('BANDEJA_CALIDAD', 'http', 3);
                $llamada=1;

                break;
            case 'Recepcion':
                $bandeja = 'BANDEJA_RECEPCION';
                $verificacion = 5;
                //salida
                $bandejas = $objSelect->getParametro('BANDEJA_RECEPCION', 'http', 3);
                $llamada=0;

                break;
            case 'Regularizacion':
                $bandeja = 'BANDEJA_REGULARIZACION';
                $verificacion = 6;
                //salida
                $bandejas = $objSelect->getParametro('BANDEJA_REGULARIZACION', 'http', 3);
                $llamada=0;

                break;

        }
        $solicitudesPermitidas=SolicitudAsignacion::where(['usuario'=>Auth::user()->persona_id,'estado'=>'A'])->select('solicitud_id')->get()->pluck('solicitud_id')->toArray();
        $datatable = DB::connection('mysql_solicitudes')
            ->table('bestados AS g')
            ->join('solicitud as s', 'g.solicitud_id', 's.n_solicitud')
            ->join('empleados as emp', 's.empleado_id', 'emp.identificacion')
            ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
            ->join('cliente as cl', 's.cliente_id', 'cl.identificacion')
            ->join('nextcore.users as u','u.id','g.usuario_ing')
            ->join('empleados as emp2','u.persona_id','emp2.identificacion')
            //salida
            ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'g.departamento_id');
            if($AsesorE!=0)
            {
                $datatable = $datatable->wherein('s.n_solicitud', $solicitudesPermitidas);

                if ($AsesorCreditoJ) {
                    $datatable = $datatable->where('cl.tipo_persona', 'JURIDICO');
                }
                if ($AsesorCredito) {
                    $datatable = $datatable->wherein('cl.tipo_persona', ['CEDULA', 'PASAPORTE', 'NATURAL', 'PUBLICO']);
                }
            }
        //salida
        if ($dato == 'saliente') {
            $datatable = $datatable->whereIn('g.estado_linea_id', $bandejas)
                ->groupby('g.id',
                    's.celular_entrega',
                    'cl.nombres',
                    'g.solicitud_id',
                    'emp.apellidos',
                    'emp.nombres',
                    'emp2.apellidos',
                    'emp2.nombres',
                    's.created_at',
                    'g.created_at',
                    'tbp.descripcion',
                    's.region',
                    's.tlineas',
                    'cl.forma_pago',
                    'g.estado'

                )
                ->orderby('g.created_at', 'DSC')
                ->select('g.id as id',
                    's.celular_entrega AS Contacto',
                    'cl.nombres as Cliente',
                    'g.solicitud_id as Solicitud',
                    DB::raw("concat(SUBSTRING_INDEX(emp.nombres, ' ', 1 ),' ', SUBSTRING_INDEX(emp.apellidos, ' ', 1 )) as Asesor"),
                    DB::raw("concat(SUBSTRING_INDEX(emp2.nombres, ' ', 1 ),' ', SUBSTRING_INDEX(emp2.apellidos, ' ', 1 )) as Usuario_ing"),
                    's.created_at as Fecha_c',
                    'g.created_at as Fecha_e',
                    'tbp.descripcion as Estado_Solicitud',
                    's.region as Region',
                    'cl.forma_pago as Forma_pago',
                    's.region as Simcard',
                    's.tlineas as total_lineas',
                    'g.estado as estado')
                ->get();
        } else {
            if ($dato == 'pendiente') {
                $datatable = $datatable->whereNotIn('g.estado_linea_id', $bandejas);

            }
            if ($dato == 'actual') {
                $datatable = $datatable->whereIn('g.estado_linea_id', $bandejas);

            }
            $datatable = $datatable->where('g.estado', 'A')
                ->where('s.estado', 'A')
                ->where('tbp.verificacion', $verificacion)
                ->groupby('g.id',
                    's.celular_entrega',
                    'cl.nombres',
                    'g.solicitud_id',
                    'emp.apellidos',
                    'emp.nombres',
                    'emp2.apellidos',
                    'emp2.nombres',
                    's.created_at',
                    'g.created_at',
                    'tbp.descripcion',
                    's.region',
                    'cl.forma_pago',
                    's.tlineas',

                    'g.estado')
                ->orderby('g.created_at', 'DSC')
                ->select('g.id as id',
                    's.celular_entrega AS Contacto',
                    'cl.nombres as Cliente',
                    'g.solicitud_id as Solicitud',
                    DB::raw("concat(SUBSTRING_INDEX(emp.nombres, ' ', 1 ),' ', SUBSTRING_INDEX(emp.apellidos, ' ', 1 )) as Asesor"),
                    DB::raw("concat(SUBSTRING_INDEX(emp2.nombres, ' ', 1 ),' ', SUBSTRING_INDEX(emp2.apellidos, ' ', 1 )) as Usuario_ing"),
                    's.created_at as Fecha_c',
                    'g.created_at as Fecha_e',
                    'tbp.descripcion as Estado_Solicitud',
                    's.region as Region',
                    'cl.forma_pago as Forma_pago',
                    's.tlineas as total_lineas',
                    'g.estado as estado')
                ->get();
        }

        $result = DataTables::of($datatable);
        $result = $result->addColumn('estado', function ($select) use ($bandeja, $dato) {
            if ($dato == 'saliente') {
                $salida = 1;
            } else {
                $salida = 0;

            }

            $objSelect = new SelectController();
            $verificac = $objSelect->dontBandeja([$bandeja], $select->Solicitud, 0);
            $result = DB::connection('mysql_solicitudes')
                ->table('solicitud as s')
                ->join('nextcore.users as u', 'u.id', 's.usuario_ing')
                ->join('empleados as emp', 'emp.identificacion', 'u.persona_id')
                ->where('s.n_solicitud', $select->Solicitud)
                ->select('s.usuario_ing as usuario_ing',
                    's.n_solicitud as n_solicitud',
                    's.entrega_ciudad_id as entrega_ciudad_id',
                    's.direccion_entrega as direccion_entrega',
                    's.provincia_id as provincia_id',
                    's.region as region',
                    's.fecha_lote as fecha_lote',
                    's.lote as lote',
                    's.ciclo_facturacion as ciclo_facturacion',
                    's.fecha_activacion as fecha_activacion',
                    's.fecha_facturacion as fecha_facturacion',
                    's.celular_entrega as celular_entrega',
                    's.estado as estado',
                    's.empleado_id as empleado_id',
                    's.gestor_id as gestor_id',
                    's.cliente_id as cliente_id',
                    's.usuario_mod as usuario_mod',
                    's.created_at as created_at',
                    's.updated_at as updated_at',
                    's.observacion as observacion',
                    's.tchip as tchip',
                    's.tobsequios as tobsequios',
                    's.tlineas as tlineas',
                    's.n_solicitud_axis as n_solicitud_axis',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name")
                )
                ->get()->toArray();

            $resultUEstado = DB::connection('mysql_solicitudes')
                ->table('bestados as be')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.estado_linea_id')
                ->where('be.estado', 'A')
                ->where('be.solicitud_id', $select->Solicitud)
                ->select("tbp.descripcion as uestado", "be.adendum_cdc as adendum_sp",
                    "be.castigo_cartera_cdc as castigoc_sp", "be.consumo_cdc as consumo_sp",
                    "be.financimiento_cdc as financiamiento_sp", "be.otros_cdc as otros_sp",
                    "be.total_cdc as tcredito_sp", "be.inicio_deuda as inicio_deuda")
                ->get()->toArray();

            $resultDeudaE = DB::connection('mysql_solicitudes')
                ->table('bestados as be')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.estado_linea_id')
                ->where('be.solicitud_id', $select->Solicitud)
                ->where('tbp.descripcion', 'DEUDA CREDITO')
                ->orderBy('be.created_at', 'DSC')->take(1)
                ->get()->toArray();


            if ($resultDeudaE == []) {
                $adendum_cdc = 0;
                $castigo_cartera_cdc = 0;
                $consumo_cdc = 0;
                $financimiento_cdc = 0;
                $otros_cdc = 0;
                $total_cdc = 0;
                $inicio_deuda = '';
            } else {
                $adendum_cdc = $resultDeudaE[0]->adendum_cdc;
                $castigo_cartera_cdc = $resultDeudaE[0]->castigo_cartera_cdc;
                $consumo_cdc = $resultDeudaE[0]->consumo_cdc;
                $financimiento_cdc = $resultDeudaE[0]->financimiento_cdc;
                $otros_cdc = $resultDeudaE[0]->otros_cdc;
                $total_cdc = $resultDeudaE[0]->total_cdc;
                $inicio_deuda = $resultDeudaE[0]->inicio_deuda;

            }


            $resultcliente = DB::connection('mysql_solicitudes')
                ->table('cliente')
                ->where('identificacion', $result[0]->cliente_id)
                ->get()->toArray();
            $data = $result[0];
            $dataCliente = $resultcliente[0];
            $dataUEstado = $resultUEstado[0];

            if ($verificac != 0 && $salida != 1) {
                $estado = "Pendiente de Estado";
                $class = "warning";
                $editarOpcion = '<p><a href="#" onclick="viewChangesPro(\''
                    . $data->usuario_ing . '\',\''
                    . $data->n_solicitud . '\',\''
                    . $data->entrega_ciudad_id . '\',\''
                    . $data->direccion_entrega . '\',\''
                    . $data->provincia_id . '\',\''
                    . $data->region . '\',\''
                    . $data->fecha_lote . '\',\''
                    . $data->lote . '\',\''
                    . $data->ciclo_facturacion . '\',\''
                    . $data->fecha_activacion . '\',\''
                    . $data->fecha_facturacion . '\',\''
                    . $data->celular_entrega . '\',\''
                    . $data->estado . '\',\''
                    . $data->empleado_id . '\',\''
                    . $data->gestor_id . '\',\''
                    . $data->cliente_id . '\',\''
                    . $data->usuario_mod . '\',\''
                    . $data->created_at . '\',\''
                    . $data->updated_at . '\',\''
                    . $data->observacion . '\',\''
                    . $data->tchip . '\',\''
                    . $data->tobsequios . '\',\''
                    . $data->tlineas . '\',\''
                    . $data->n_solicitud_axis . '\',\''

                    . $data->name . '\',\''
                    . $dataCliente->identificacion . '\',\''
                    . $dataCliente->tipo_persona . '\',\''
                    . $dataCliente->nombres . '\',\''
                    . $dataCliente->
                    correo . '\',\''
                    . $dataCliente->
                    cedula_RL . '\',\''
                    . $dataCliente->
                    nombre_RL . '\',\''
                    . $dataCliente->
                    fecha_vence_emp . '\',\''
                    . $dataCliente->
                    cargo_RL . '\',\''
                    . $dataCliente->
                    direccion_domicilio . '\',\''
                    . $dataCliente->
                    referencia_domicilio . '\',\''
                    . $dataCliente->
                    convencional . '\',\''
                    . $dataCliente->
                    convencional_perteneciente . '\',\''
                    . $dataCliente->
                    movil . '\',\''
                    . $dataCliente->
                    ciudad_domicilio_id . '\',\''
                    . $dataCliente->
                    provincia_domicilio_id . '\',\''
                    . $dataCliente->
                    fecha_nacimiento . '\',\''
                    . $dataCliente->
                    created_at . '\',\''
                    . $dataCliente->
                    updated_at . '\',\''
                    . $dataCliente->
                    usuario_ing . '\',\''
                    . $dataCliente->
                    usuario_mod . '\',\''
                    . $dataCliente->
                    estado . '\',\''
                    . $dataCliente->
                    estado_civil . '\',\''
                    . $dataCliente->
                    empresa . '\',\''
                    . $dataCliente->
                    direccion_laboral . '\',\''
                    . $dataCliente->
                    ciudad_laboral_id . '\',\''
                    . $dataCliente->
                    provincia_laboral_id . '\',\''
                    . $dataCliente->
                    convencional_laboral . '\',\''
                    . $dataCliente->
                    cargo . '\',\''
                    . $dataCliente->
                    tiempo_laboral . '\',\''
                    . $dataCliente->
                    ingresos_laboral . '\',\''
                    . $dataCliente->
                    forma_pago . '\',\''
                    . $dataCliente->
                    banco_id . '\',\''
                    . $dataCliente->
                    cta_ahorro . '\',\''
                    . $dataCliente->
                    cta_corriente . '\',\''
                    . $dataCliente->
                    nombre_tarjeta . '\',\''
                    . $dataCliente->
                    numero_tarjeta . '\',\''
                    . $dataCliente->
                    codigo_seguridad_tarjeta . '\',\''
                    . $dataCliente->
                    vencimiento_tarjeta . '\',\''
                    . $dataCliente->
                    cupo . '\',\''
                    . $dataCliente->
                    deuda . '\',\''
                    . $dataCliente->
                    valor_garantia . '\',\'' . $bandeja . '\',\'' . $salida . '\',\''
                    . $dataCliente->
                    deposito_garantia . '\',\''
                    . $adendum_cdc . '\',\''
                    . $castigo_cartera_cdc . '\',\''
                    . $consumo_cdc . '\',\''
                    . $financimiento_cdc . '\',\''
                    . $otros_cdc . '\',\''
                    . $total_cdc . '\',\''
                    . $inicio_deuda . '\'
                  )"
                                 data-hover="tooltip" data-placement="top" 
                                 data-target="#Modalagregar" data-toggle="modal" id="modal"
                                 class="label label-primary">
                                  <span class="fa fa-edit"></span></a>';
                $editarfo = '</p>';

            } else {
                $estado = "Solicitud Enviada";
                $class = "primary";
                $editarOpcion = '';
                $editarfo = '';
            }
            $seguimiento = '<a href="#" onclick="SeguimientoChanges(\''
                . $select->Solicitud . '\',\''
                . $dataCliente->identificacion . '\',\''
                . $dataCliente->tipo_persona . '\',\''
                . $dataCliente->nombres . '\',\''
                . $data->fecha_lote . '\',\''
                . $data->lote . '\',\''
                . $data->ciclo_facturacion . '\',\''
                . $data->fecha_activacion . '\',\''
                . $data->fecha_facturacion . '\',\''
                . $data->tchip . '\',\''
                . $data->tobsequios . '\',\''
                . $data->tlineas . '\',\''
                . $select->Asesor . '\',\''
                . $dataUEstado->uestado . '\',\''
                . $dataUEstado->adendum_sp . '\',\''
                . $dataUEstado->castigoc_sp . '\',\''
                . $dataUEstado->consumo_sp . '\',\''
                . $dataUEstado->financiamiento_sp . '\',\''
                . $dataUEstado->tcredito_sp . '\',\''
                . $dataUEstado->otros_sp . '\',\''
                . $data->region . '\',\''
                . $dataUEstado->inicio_deuda . '\')"
                                                                 data-hover="tooltip" data-placement="top" 
                                                                 data-target="#Modalagregar" data-toggle="modal" id="modal"
                                                                 class="label label-success">
                                                                  <span class="fa fa-eye"></span></a>';

            switch ($select->estado) {
                case 'I':
                    return '<p ><span class="label label-primary">Solicitud Enviada</span>
                                  ' . $seguimiento . '</p>';
                    break;
                case 'A':
                    return '<span class="label label-' . $class . '">' . $estado . '</span>
                      ' . $editarOpcion . '.' . $seguimiento . '
                              ' . $editarfo . '
                                                                  ';
                    break;
                case 'E':
                    return '<span class="label label-success">Proceso Finalizado</span>';

                    break;
            }

        })
        ->addColumn('Contactos', function ($select) use ($bandeja, $dato,$llamada,$bandejasA) {
            if ($dato == 'saliente') {
                $salida = 1;
            } else {
                $salida = 0;

            }

            $objSelect = new SelectController();
            $verificac = $objSelect->dontBandeja([$bandeja], $select->Solicitud, 0);
            $result = DB::connection('mysql_solicitudes')
                ->table('solicitud as s')
                ->join('nextcore.users as u', 'u.id', 's.usuario_ing')
                ->join('empleados as emp', 'emp.identificacion', 'u.persona_id')
                ->where('s.n_solicitud', $select->Solicitud)
                ->select('s.usuario_ing as usuario_ing',
                    's.n_solicitud as n_solicitud',
                    's.entrega_ciudad_id as entrega_ciudad_id',
                    's.direccion_entrega as direccion_entrega',
                    's.provincia_id as provincia_id',
                    's.region as region',
                    's.fecha_lote as fecha_lote',
                    's.lote as lote',
                    's.ciclo_facturacion as ciclo_facturacion',
                    's.fecha_activacion as fecha_activacion',
                    's.fecha_facturacion as fecha_facturacion',
                    's.celular_entrega as celular_entrega',
                    's.estado as estado',
                    's.empleado_id as empleado_id',
                    's.gestor_id as gestor_id',
                    's.cliente_id as cliente_id',
                    's.usuario_mod as usuario_mod',
                    's.created_at as created_at',
                    's.updated_at as updated_at',
                    's.observacion as observacion',
                    's.tchip as tchip',
                    's.tobsequios as tobsequios',
                    's.tlineas as tlineas',
                    's.n_solicitud_axis as n_solicitud_axis',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name")
                )
                ->get()->toArray();

            $resultUEstado = DB::connection('mysql_solicitudes')
                ->table('bestados as be')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.estado_linea_id')
                ->where('be.estado', 'A')
                ->where('be.solicitud_id', $select->Solicitud)
                ->select("tbp.descripcion as uestado", "be.adendum_cdc as adendum_sp",
                    "be.castigo_cartera_cdc as castigoc_sp", "be.consumo_cdc as consumo_sp",
                    "be.financimiento_cdc as financiamiento_sp", "be.otros_cdc as otros_sp",
                    "be.total_cdc as tcredito_sp", "be.inicio_deuda as inicio_deuda")
                ->get()->toArray();

            $resultDeudaE = DB::connection('mysql_solicitudes')
                ->table('bestados as be')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.estado_linea_id')
                ->where('be.solicitud_id', $select->Solicitud)
                ->where('tbp.descripcion', 'DEUDA CREDITO')
                ->orderBy('be.created_at', 'DSC')->take(1)
                ->get()->toArray();


            if ($resultDeudaE == []) {
                $adendum_cdc = 0;
                $castigo_cartera_cdc = 0;
                $consumo_cdc = 0;
                $financimiento_cdc = 0;
                $otros_cdc = 0;
                $total_cdc = 0;
                $inicio_deuda = '';
            } else {
                $adendum_cdc = $resultDeudaE[0]->adendum_cdc;
                $castigo_cartera_cdc = $resultDeudaE[0]->castigo_cartera_cdc;
                $consumo_cdc = $resultDeudaE[0]->consumo_cdc;
                $financimiento_cdc = $resultDeudaE[0]->financimiento_cdc;
                $otros_cdc = $resultDeudaE[0]->otros_cdc;
                $total_cdc = $resultDeudaE[0]->total_cdc;
                $inicio_deuda = $resultDeudaE[0]->inicio_deuda;

            }


            $resultcliente = DB::connection('mysql_solicitudes')
                ->table('cliente')
                ->where('identificacion', $result[0]->cliente_id)
                ->get()->toArray();
            $data = $result[0];
            $dataCliente = $resultcliente[0];
            $dataUEstado = $resultUEstado[0];
            $prefijo=Auth::user()->prefijo;
            $extension=Auth::user()->extension;
            $class = "warning";
            $ico='fa fa-phone';
            $editarsolo= '<span class="label label-success"><span class="'.$ico.'">&nbsp;</span>&nbsp;'
            .$select->Contacto.'</span></p>';
            if ($verificac != 0 && $salida != 1) {
                $estado = "Pendiente de Estado";
                $class = "warning";
                $ico='fa fa-phone';
                if($bandejasA!='Calidad')
                        {
                            $ico='fa fa-edit';
                            $class = "primary";
                        }
               
                $editarOpcion = '<p><a href="#" onclick="viewChangesPro(\''
                . $data->usuario_ing . '\',\''
                . $data->n_solicitud . '\',\''
                . $data->entrega_ciudad_id . '\',\''
                . $data->direccion_entrega . '\',\''
                . $data->provincia_id . '\',\''
                . $data->region . '\',\''
                . $data->fecha_lote . '\',\''
                . $data->lote . '\',\''
                . $data->ciclo_facturacion . '\',\''
                . $data->fecha_activacion . '\',\''
                . $data->fecha_facturacion . '\',\''
                . $data->celular_entrega . '\',\''
                . $data->estado . '\',\''
                . $data->empleado_id . '\',\''
                . $data->gestor_id . '\',\''
                . $data->cliente_id . '\',\''
                . $data->usuario_mod . '\',\''
                . $data->created_at . '\',\''
                . $data->updated_at . '\',\''
                . $data->observacion . '\',\''
                . $data->tchip . '\',\''
                . $data->tobsequios . '\',\''
                . $data->tlineas . '\',\''
                . $data->n_solicitud_axis . '\',\''

                . $data->name . '\',\''
                . $dataCliente->identificacion . '\',\''
                . $dataCliente->tipo_persona . '\',\''
                . $dataCliente->nombres . '\',\''
                . $dataCliente->
                correo . '\',\''
                . $dataCliente->
                cedula_RL . '\',\''
                . $dataCliente->
                nombre_RL . '\',\''
                . $dataCliente->
                fecha_vence_emp . '\',\''
                . $dataCliente->
                cargo_RL . '\',\''
                . $dataCliente->
                direccion_domicilio . '\',\''
                . $dataCliente->
                referencia_domicilio . '\',\''
                . $dataCliente->
                convencional . '\',\''
                . $dataCliente->
                convencional_perteneciente . '\',\''
                . $dataCliente->
                movil . '\',\''
                . $dataCliente->
                ciudad_domicilio_id . '\',\''
                . $dataCliente->
                provincia_domicilio_id . '\',\''
                . $dataCliente->
                fecha_nacimiento . '\',\''
                . $dataCliente->
                created_at . '\',\''
                . $dataCliente->
                updated_at . '\',\''
                . $dataCliente->
                usuario_ing . '\',\''
                . $dataCliente->
                usuario_mod . '\',\''
                . $dataCliente->
                estado . '\',\''
                . $dataCliente->
                estado_civil . '\',\''
                . $dataCliente->
                empresa . '\',\''
                . $dataCliente->
                direccion_laboral . '\',\''
                . $dataCliente->
                ciudad_laboral_id . '\',\''
                . $dataCliente->
                provincia_laboral_id . '\',\''
                . $dataCliente->
                convencional_laboral . '\',\''
                . $dataCliente->
                cargo . '\',\''
                . $dataCliente->
                tiempo_laboral . '\',\''
                . $dataCliente->
                ingresos_laboral . '\',\''
                . $dataCliente->
                forma_pago . '\',\''
                . $dataCliente->
                banco_id . '\',\''
                . $dataCliente->
                cta_ahorro . '\',\''
                . $dataCliente->
                cta_corriente . '\',\''
                . $dataCliente->
                nombre_tarjeta . '\',\''
                . $dataCliente->
                numero_tarjeta . '\',\''
                . $dataCliente->
                codigo_seguridad_tarjeta . '\',\''
                . $dataCliente->
                vencimiento_tarjeta . '\',\''
                . $dataCliente->
                cupo . '\',\''
                . $dataCliente->
                deuda . '\',\''
                . $dataCliente->
                valor_garantia . '\',\'' . $bandeja . '\',\'' . $salida . '\',\''
                . $dataCliente->
                deposito_garantia . '\',\''
                . $adendum_cdc . '\',\''
                . $castigo_cartera_cdc . '\',\''
                . $consumo_cdc . '\',\''
                . $financimiento_cdc . '\',\''
                . $otros_cdc . '\',\''
                . $total_cdc . '\',\''
                . $inicio_deuda . '\',\''
                . $llamada . '\',\''
                . $extension . '\',\''
                . $prefijo . '\'
              )"
                             data-hover="tooltip" data-placement="top" 
                             data-target="#Modalagregar" data-toggle="modal" id="modal"
                             class="label label-success">
                              <span class="'.$ico.'">&nbsp;</span>&nbsp;'.$select->Contacto.'</a>';
                $editarfo = '</p>';
                $llamada=0;
                $editarsolo = '<p><a href="#" onclick="viewChangesPro(\''
                . $data->usuario_ing . '\',\''
                . $data->n_solicitud . '\',\''
                . $data->entrega_ciudad_id . '\',\''
                . $data->direccion_entrega . '\',\''
                . $data->provincia_id . '\',\''
                . $data->region . '\',\''
                . $data->fecha_lote . '\',\''
                . $data->lote . '\',\''
                . $data->ciclo_facturacion . '\',\''
                . $data->fecha_activacion . '\',\''
                . $data->fecha_facturacion . '\',\''
                . $data->celular_entrega . '\',\''
                . $data->estado . '\',\''
                . $data->empleado_id . '\',\''
                . $data->gestor_id . '\',\''
                . $data->cliente_id . '\',\''
                . $data->usuario_mod . '\',\''
                . $data->created_at . '\',\''
                . $data->updated_at . '\',\''
                . $data->observacion . '\',\''
                . $data->tchip . '\',\''
                . $data->tobsequios . '\',\''
                . $data->tlineas . '\',\''
                . $data->n_solicitud_axis . '\',\''

                . $data->name . '\',\''
                . $dataCliente->identificacion . '\',\''
                . $dataCliente->tipo_persona . '\',\''
                . $dataCliente->nombres . '\',\''
                . $dataCliente->
                correo . '\',\''
                . $dataCliente->
                cedula_RL . '\',\''
                . $dataCliente->
                nombre_RL . '\',\''
                . $dataCliente->
                fecha_vence_emp . '\',\''
                . $dataCliente->
                cargo_RL . '\',\''
                . $dataCliente->
                direccion_domicilio . '\',\''
                . $dataCliente->
                referencia_domicilio . '\',\''
                . $dataCliente->
                convencional . '\',\''
                . $dataCliente->
                convencional_perteneciente . '\',\''
                . $dataCliente->
                movil . '\',\''
                . $dataCliente->
                ciudad_domicilio_id . '\',\''
                . $dataCliente->
                provincia_domicilio_id . '\',\''
                . $dataCliente->
                fecha_nacimiento . '\',\''
                . $dataCliente->
                created_at . '\',\''
                . $dataCliente->
                updated_at . '\',\''
                . $dataCliente->
                usuario_ing . '\',\''
                . $dataCliente->
                usuario_mod . '\',\''
                . $dataCliente->
                estado . '\',\''
                . $dataCliente->
                estado_civil . '\',\''
                . $dataCliente->
                empresa . '\',\''
                . $dataCliente->
                direccion_laboral . '\',\''
                . $dataCliente->
                ciudad_laboral_id . '\',\''
                . $dataCliente->
                provincia_laboral_id . '\',\''
                . $dataCliente->
                convencional_laboral . '\',\''
                . $dataCliente->
                cargo . '\',\''
                . $dataCliente->
                tiempo_laboral . '\',\''
                . $dataCliente->
                ingresos_laboral . '\',\''
                . $dataCliente->
                forma_pago . '\',\''
                . $dataCliente->
                banco_id . '\',\''
                . $dataCliente->
                cta_ahorro . '\',\''
                . $dataCliente->
                cta_corriente . '\',\''
                . $dataCliente->
                nombre_tarjeta . '\',\''
                . $dataCliente->
                numero_tarjeta . '\',\''
                . $dataCliente->
                codigo_seguridad_tarjeta . '\',\''
                . $dataCliente->
                vencimiento_tarjeta . '\',\''
                . $dataCliente->
                cupo . '\',\''
                . $dataCliente->
                deuda . '\',\''
                . $dataCliente->
                valor_garantia . '\',\'' . $bandeja . '\',\'' . $salida . '\',\''
                . $dataCliente->
                deposito_garantia . '\',\''
                . $adendum_cdc . '\',\''
                . $castigo_cartera_cdc . '\',\''
                . $consumo_cdc . '\',\''
                . $financimiento_cdc . '\',\''
                . $otros_cdc . '\',\''
                . $total_cdc . '\',\''
                . $inicio_deuda . '\',\''
                . $llamada . '\',\''
                . $extension . '\',\''
                . $prefijo . '\'
              )"
                             data-hover="tooltip" data-placement="top" 
                             data-target="#Modalagregar" data-toggle="modal" id="modal"
                             class="label label-primary">
                              <span class="fa fa-edit"></span></a>';
                              $var=1;
              

            } else {
                $estado = "Solicitud Enviada";
                $class = "primary";
                $editarOpcion = '<p>';
                $editarfo = '</p>';
               
            }
            $seguimiento = '<a href="#" onclick="SeguimientoChanges(\''
                . $select->Solicitud . '\',\''
                . $dataCliente->identificacion . '\',\''
                . $dataCliente->tipo_persona . '\',\''
                . $dataCliente->nombres . '\',\''
                . $data->fecha_lote . '\',\''
                . $data->lote . '\',\''
                . $data->ciclo_facturacion . '\',\''
                . $data->fecha_activacion . '\',\''
                . $data->fecha_facturacion . '\',\''
                . $data->tchip . '\',\''
                . $data->tobsequios . '\',\''
                . $data->tlineas . '\',\''
                . $select->Asesor . '\',\''
                . $dataUEstado->uestado . '\',\''
                . $dataUEstado->adendum_sp . '\',\''
                . $dataUEstado->castigoc_sp . '\',\''
                . $dataUEstado->consumo_sp . '\',\''
                . $dataUEstado->financiamiento_sp . '\',\''
                . $dataUEstado->tcredito_sp . '\',\''
                . $dataUEstado->otros_sp . '\',\''
                . $data->region . '\',\''
                . $dataUEstado->inicio_deuda . '\')"
                                                                 data-hover="tooltip" data-placement="top" 
                                                                 data-target="#Modalagregar" data-toggle="modal" id="modal"
                                                                 class="label label-warning">
                                                                  <span class="fa fa-eye"></span></a>';

           
            switch ($select->estado) {
                case 'I':

                    return '<p ><span class="label label-primary">Solicitud Enviada</span>
                                  ' .'<p>'. $seguimiento .$editarsolo.'</p>'.'</p>';
                    break;
                case 'A':
                    if($estado!='Solicitud Enviada')
                    {
                        if($bandejasA!='Calidad')
                        {
                            $editarsolo='';
                        }
                       
                    }
                    return '<span class="label label-' . $class . '">' . $estado . '</span>' 
                    . $editarOpcion . $editarsolo . $seguimiento . $editarfo;
                    break;
                case 'E':
                    return '<span class="label label-success">Proceso Finalizado</span>';

                    break;
            }

        })
        ->addColumn('DetalleEstado',function($select)
        {
            $detalle='<table class="tablacorta">
            <tr>
            <td><strong>Estado:</strong></td>
            <td>'.$select->Estado_Solicitud.'</td>
            </tr>
            <tr>
            <td><strong>Usuario:</strong></td>
            <td>'.$select->Usuario_ing.'</td>
            </tr>
            
            <tr>
            <td><strong>Fecha de Estado:</strong></td>
            <td>'.$select->Fecha_e.'</td>
            </tr>
            </table>';
                return $detalle;
        })
            ->addColumn('Solicituds',function($select)
            {
                $detalle='<table class="tablacorta">
                <tr>
                <td><strong>Solicitud:</strong></td>
                <td>'.$select->Solicitud.'<span class="label label-warning label label" style="font-size:11px!important">'.$select->total_lineas.'</span>'.'</td>
                </tr>
                <tr>
                <td><strong>Asesor CC:</strong></td>
                <td>'.$select->Asesor.'</td>
                </tr>
                <tr>
                <td><strong>Fecha de Creación:</strong></td>
                <td>'.$select->Fecha_c.'</td>
                </tr>
                </table>';
                    return $detalle;
            })
            ->addColumn('Detalle',function($select)
            {
               $detalle='<table class="tablacorta">
            <tr>
            <td><strong>Región:</strong></td>
            <td>'.$select->Region.'</td>
            <tr>
            <td><strong>Forma/Pago:</strong></td>
            <td>'.$select->Forma_pago.'</td>

            </tr>
            </table>';
                return $detalle;
            })
            ->make(true);
        return $result;
    }

}
