<?php

namespace App\Http\Controllers\Solicitudes;

use App\Core\Entities\Solicitudes\Bestados;
use App\Core\Entities\Solicitudes\CambioGestor;
use App\Core\Entities\Solicitudes\Cliente;
use App\Core\Entities\Solicitudes\LineaEstados;
use App\Core\Entities\Solicitudes\Lineas;
use App\Core\Entities\Solicitudes\Solicitud;
use App\Http\Controllers\Ajax\SelectController;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class SeguimientoController extends Controller
{
    private $solicitudesIngresadas = 0;

    public function SeguimientoIndex()
    {
        $name = 'AsesorCC';
        DB::beginTransaction();
        try {
            $codigo = 0;
            $int = Solicitud::select('n_solicitud')->count();
            $identificacion = Auth::user();
            $usuario = DB::connection('mysql_solicitudes')
                ->table('empleados AS emp')
                ->where('emp.estado', 'A')
                ->where('emp.identificacion', $identificacion->persona_id)
                ->groupBy('emp.nombres', 'emp.apellidos')
                ->select(DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))->first();

            $objRole = DB::connection('mysql')->table('roles')->where(['name' => $name])->first();
            $objSelect = new SelectController();
            $objgestores = $objSelect->getGestores($objRole->id);
            $ciudad = $objSelect->getParametro('CIUDAD', 'http');
            $provincia = $objSelect->getParametro('PROVINCIA', 'http');
            $banco = $objSelect->getParametro('BANCO', 'http');


            $objUserRole = DB::connection('mysql')
                ->table('model_has_roles as mr')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->where(['mr.model_id' => $identificacion->id])
                ->select('r.name')
                ->get()->toArray();
            $AsesorCreditoJ = Auth::user()->evaluarole(['AsesorCRJ']);

            $AsesorCredito = Auth::user()->evaluarole(['AsesorCredito']);

            $AsesorCalidad = Auth::user()->evaluarole(['AsesorCalidad']);

            $AsesorRecepcion = Auth::user()->evaluarole(['AsesorRecepcion']);

            $AsesorRegularizacion = Auth::user()->evaluarole(['AsesorRegularizacion']);

            $bandejacredi = ['0' => 'No Hay Elementos'];
            $bandejacalid = ['0' => 'No Hay Elementos'];
            $bandejarecep = ['0' => 'No Hay Elementos'];
            $bandejaregul = ['0' => 'No Hay Elementos'];

            if ($AsesorCreditoJ) {
                $bandejacredi = $objSelect->getParametro('BANDEJA_CREDITO', 'http');
                $bandeja = 'Credito';
            }
            if ($AsesorCredito) {
                $bandejacredi = $objSelect->getParametro('BANDEJA_CREDITO', 'http');
                $bandeja = 'Credito';
            }
            if ($AsesorCalidad) {
                $bandejacalid = $objSelect->getParametro('BANDEJA_CALIDAD', 'http');
                $bandeja = 'Calidad';
            }
            if ($AsesorRecepcion) {
                $bandejarecep = $objSelect->getParametro('BANDEJA_RECEPCION', 'http');
                $bandeja = 'Recepción';
            }
            if ($AsesorRegularizacion) {
                $bandejaregul = $objSelect->getParametro('BANDEJA_REGULARIZACION', 'http');
                $bandeja = 'Regularización';

            }
            $bandejaSeguimiento = ['0' => 'Pendiente de Estado', '1' => $bandeja, '2' => 'Salientes'];

            $formatos_imprimir = $objSelect->getParametro('FORMATOS', 'http');

            DB::commit();
            return view('modules.Solicitudes.seguimiento')->with(
                ['usuario' => $usuario->name,
                    'gestores' => $objgestores,
                    'ciudad' => $ciudad,
                    'provincia' => $provincia,
                    'banco' => $banco,
                    'bandejacredi' => $bandejacredi,
                    'bandejacalid' => $bandejacalid,
                    'bandejarecep' => $bandejarecep,
                    'bandejaregul' => $bandejaregul,
                    'bandejaSeguimiento' => $bandejaSeguimiento,
                    'formatos_imprimir'=>$formatos_imprimir
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getDatatableSeguimiento($dato)
    {
        $AsesorCredito = Auth::user()->evaluarole(['AsesorCredito']);
        $AsesorCreditoJ = Auth::user()->evaluarole(['AsesorCRJ']);
        $AsesorCalidad = Auth::user()->evaluarole(['AsesorCalidad']);
        $AsesorRecepcion = Auth::user()->evaluarole(['AsesorRecepcion']);
        $AsesorRegularizacion = Auth::user()->evaluarole(['AsesorRegularizacion']);

        $var = Auth::user()->evaluarole(['AsesorCredito', 'AsesorCRJ', 'AsesorCalidad', 'AsesorRecepcion', 'AsesorRegularizacion']);
        $objSelect = new SelectController();

        if ($AsesorCredito) {
            $bandeja = 'BANDEJA_CREDITO';
            $verificacion = 3;
            //salida
            $bandejas = $objSelect->getParametro('BANDEJA_CREDITO', 'http', 3);
        }
        if ($AsesorCreditoJ) {
            $bandeja = 'BANDEJA_CREDITO';
            $verificacion = 3;
            //salida
            $bandejas = $objSelect->getParametro('BANDEJA_CREDITO', 'http', 3);
        }
        if ($AsesorCalidad) {
            $bandeja = 'BANDEJA_CALIDAD';
            $verificacion = 4;
            //salida
            $bandejas = $objSelect->getParametro('BANDEJA_CALIDAD', 'http', 3);
        }
        if ($AsesorRecepcion) {
            $bandeja = 'BANDEJA_RECEPCION';
            $verificacion = 5;
            //salida
            $bandejas = $objSelect->getParametro('BANDEJA_RECEPCION', 'http', 3);
        }
        if ($AsesorRegularizacion) {
            $bandeja = 'BANDEJA_REGULARIZACION';
            $verificacion = 6;
            //salida
            $bandejas = $objSelect->getParametro('BANDEJA_REGULARIZACION', 'http', 3);
        }


        if ($var != 0) {
            $datatable = DB::connection('mysql_solicitudes')
                ->table('bestados AS g')
                ->join('solicitud as s', 'g.solicitud_id', 's.n_solicitud')
                ->join('empleados as emp', 's.empleado_id', 'emp.identificacion')
                ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
                ->join('cliente as cl', 's.cliente_id', 'cl.identificacion')
                //salida
                ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'g.departamento_id');

            if ($AsesorCreditoJ) {
                $datatable = $datatable->where('cl.tipo_persona', 'JURIDICO');
            }
            if ($AsesorCredito) {
                $datatable = $datatable->wherein('cl.tipo_persona', ['CEDULA', 'PASAPORTE', 'NATURAL', 'PUBLICO']);
            }
            //salida
            if ($dato == '2') {
                $datatable = $datatable->whereIn('g.estado_linea_id', $bandejas)
                    ->groupby('g.id',
                        'cl.movil',
                        'cl.nombres',
                        'g.solicitud_id',
                        'emp.apellidos',
                        'emp.nombres',
                        's.created_at',
                        'g.created_at',
                        'tbp.descripcion',
                        'g.estado'
                    )
                    ->orderby('g.created_at', 'DSC')
                    ->select('g.id as id',
                        'cl.movil AS Contacto',
                        'cl.nombres as Cliente',
                        'g.solicitud_id as Solicitud',
                        DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Asesor"),
                        's.created_at as Fecha_c',
                        'g.created_at as Fecha_e',
                        'tbp.descripcion as Estado_Solicitud',
                        'g.estado as estado')
                    ->get();
            } else {
                if ($dato == '0') {
                    $datatable = $datatable->whereNotIn('g.estado_linea_id', $bandejas);

                }
                if ($dato == '1') {
                    $datatable = $datatable->whereIn('g.estado_linea_id', $bandejas);

                }
                $datatable = $datatable->where('g.estado', 'A')
                    ->where('s.estado', 'A')
                    ->where('tbp.verificacion', $verificacion)
                    ->groupby('g.id',
                        'cl.movil',
                        'cl.nombres',
                        'g.solicitud_id',
                        'emp.apellidos',
                        'emp.nombres',
                        's.created_at',
                        'g.created_at',
                        'tbp.descripcion',
                        'g.estado')
                    ->orderby('g.created_at', 'DSC')
                    ->select('g.id as id',
                        'cl.movil AS Contacto',
                        'cl.nombres as Cliente',
                        'g.solicitud_id as Solicitud',
                        DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Asesor"),
                        's.created_at as Fecha_c',
                        'g.created_at as Fecha_e',
                        'tbp.descripcion as Estado_Solicitud',
                        'g.estado as estado')
                    ->get();
            }
        } else {
            $datatable = null;

        }
        $result = DataTables::of($datatable);
        /*   $result = $result->addColumn('estado', function ($select) use ($bandeja, $dato) {
                return "prueba";
            })->make(true);*/
        $result = $result->addColumn('estado', function ($select) use ($bandeja, $dato) {
            if ($dato == '2') {
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
                                  <span class="fa fa-edit">Editar</span></a>';
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

        })->make(true);
        return $result;
    }

    public function getDatatableSeguimientoSalida()
    {
        $AsesorCredito = Auth::user()->evaluarole(['AsesorCredito']);
        $AsesorCreditoJ = Auth::user()->evaluarole(['AsesorCRJ']);
        $AsesorCalidad = Auth::user()->evaluarole(['AsesorCalidad']);
        $AsesorRecepcion = Auth::user()->evaluarole(['AsesorRecepcion']);
        $AsesorRegularizacion = Auth::user()->evaluarole(['AsesorRegularizacion']);
        $var = Auth::user()->evaluarole(['AsesorCredito', 'AsesorCRJ', 'AsesorCalidad', 'AsesorRecepcion', 'AsesorRegularizacion']);
        $objSelect = new SelectController();
        if ($AsesorCredito) {
            $bandeja = 'BANDEJA_CREDITO';
            $bandejas = $objSelect->getParametro('BANDEJA_CREDITO', 'http', 3);
        }
        if ($AsesorCreditoJ) {
            $bandeja = 'BANDEJA_CREDITO';
            $bandejas = $objSelect->getParametro('BANDEJA_CREDITO', 'http', 3);
        }
        if ($AsesorCalidad) {
            $bandeja = 'BANDEJA_CALIDAD';
            $bandejas = $objSelect->getParametro('BANDEJA_CALIDAD', 'http', 3);


        }
        if ($AsesorRecepcion) {
            $bandeja = 'BANDEJA_RECEPCION';
            $bandejas = $objSelect->getParametro('BANDEJA_RECEPCION', 'http', 3);

        }
        if ($AsesorRegularizacion) {
            $bandeja = 'BANDEJA_REGULARIZACION';
            $bandejas = $objSelect->getParametro('BANDEJA_REGULARIZACION', 'http', 3);
        }


        if ($var) {

            $datatable = DB::connection('mysql_solicitudes')
                ->table('bestados AS g')
                ->join('solicitud as s', 'g.solicitud_id', 's.n_solicitud')
                ->join('empleados as emp', 's.empleado_id', 'emp.identificacion')
                ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
                ->join('cliente as cl', 's.cliente_id', 'cl.identificacion')
                ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'g.departamento_id');

            if ($AsesorCreditoJ) {
                $datatable = $datatable->where('cl.tipo_persona', 'JURIDICO');
            }
            if ($AsesorCredito) {
                $datatable = $datatable->whereIn('cl.tipo_persona', ['CEDULA', 'PASAPORTE', 'NATURAL', 'PUBLICO']);
            }

            $datatable = $datatable->whereIn('g.estado_linea_id', $bandejas)
                ->groupby('g.id',
                    'cl.movil',
                    'cl.nombres',
                    'g.solicitud_id',
                    'emp.apellidos',
                    'emp.nombres',
                    's.created_at',
                    'g.created_at',
                    'tbp.descripcion',
                    'g.estado',
                    'tbp2.descripcion')
                ->orderby('g.created_at', 'DSC')
                ->select('g.id as id',
                    'cl.movil AS Contacto',
                    'cl.nombres as Cliente',
                    'g.solicitud_id as Solicitud',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Asesor"),
                    's.created_at as Fecha_c',
                    'g.created_at as Fecha_e',
                    'tbp.descripcion as Estado_Solicitud',
                    'g.estado as estado')
                ->get();
        } else {
            $datatable = null;

        }


        $result = DataTables::of($datatable);
        $result = $result->addColumn('estado', function ($select) use ($bandeja) {

            $salida = 1;

            $estado = "Solicitud Enviada";
            $class = "primary";
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
            $resultcliente = DB::connection('mysql_solicitudes')
                ->table('cliente')
                ->where('identificacion', $result[0]->cliente_id)
                ->get()->toArray();
            $data = $result[0];
            $dataCliente = $resultcliente[0];
            $dataUEstado = $resultUEstado[0];

            return '<span class="label label-' . $class . '">' . $estado . '</span>
                    <p>
                                <a href="#" onclick="SeguimientoChanges(\''
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
                                                                <span class="fa fa-eye"></span></a></p>';

        })->make(true);
        return $result;
    }

    public function getDatatableSeguimientoSB($id)
    {
        $cantSI = DB::connection('mysql_solicitudes')
            ->table('bestados as g')
            ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
            ->where('g.solicitud_id', $id)
            ->where('tbp.descripcion', 'like', '%SOLICITUD CORREGIDA%')->count();
        $this->solicitudesIngresadas = $cantSI;
        $variable = 0;

        $cantSI1 = DB::connection('mysql_solicitudes')
            ->table('bestados as g')
            ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
            ->where('g.solicitud_id', $id)
            ->where('tbp.descripcion', 'like', '%SOLICITUD INGRESADA%')->count();
        $this->solicitudesIngresadas1 = $cantSI1;

        $variable1 = 0;
        return DataTables::of(
            DB::connection('mysql_solicitudes')
                ->table('bestados AS g')
                ->join('solicitud as s', 'g.solicitud_id', 's.n_solicitud')
                ->where('g.solicitud_id', $id)
                ->join('nextcore.users as u', 'u.id', 'g.usuario_ing')
                ->join('empleados as emp', 'u.persona_id', 'emp.identificacion')
                ->join('nextcore.tb_parametro as tbp', 'g.estado_linea_id', 'tbp.id')
                ->join('cliente as cl', 's.cliente_id', 'cl.identificacion')
                ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'g.departamento_id')
               // ->whereNotIn('tbp.descripcion', ['SOLICITUD PREGRABADA'])
                ->orderby('g.created_at', 'DSC')
                ->groupby('g.id',
                    'emp.apellidos',
                    'emp.nombres',
                    'g.created_at',
                    'g.observacion',
                    'tbp.descripcion',
                    'g.tiempo',
                    'g.estado', 'g.departamento_id',
                    'tbp2.descripcion',
                    's.estado')
                ->select('g.id as id',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Usuario"),
                    'g.observacion as Observacion',
                    'g.created_at as Fecha_e',
                    'g.tiempo as Tiempo',
                    's.estado as est',
                    'tbp.descripcion as estado_Solicitud',
                    'g.estado as estado', 'g.departamento_id as dpto', 'tbp2.descripcion as departamento')
                ->get()

        )->addColumn('Estado_Solicitud', function ($select) use ($variable,$variable1) {

            $variable = $this->solicitudesIngresadas;
            $variable1=$this->solicitudesIngresadas1;
            switch ($select->estado_Solicitud) {
                case 'SOLICITUD CORREGIDA':
                    $dato = $select->estado_Solicitud . "&nbsp;<span class='label label-primary label'>" . $variable . "</span>";
                    $this->solicitudesIngresadas--;
                    $variable--;
                    return $dato;
                    break;
                case 'SOLICITUD INGRESADA':
                    $dato = $select->estado_Solicitud . "&nbsp;<span class='label label-primary label'>" . $variable1 . "</span>";
                    $this->solicitudesIngresadas1--;
                    $variable1--;
                    return $dato;
                    break;
                default:
                    return $select->estado_Solicitud;
                    break;
            }

        })
            ->addColumn('estado', function ($select) {

            /*    $result1 = DB::connection('mysql_solicitudes')
                    ->table('bestados AS C')
                    ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'C.departamento_id')
                    ->where('C.departamento_id', $select->dpto)
                    ->where('tbp.verificacion', 6)->get()->toArray();*/
                if ($select->est=='E') {

                    $estado = "Proceso Finalizado";
                    $class = "warning";
                } else {

                    $estado = "En Gestión";
                    $class = "warning";
                }
                switch ($select->estado) {
                    case 'I':
                        return '<p ><span class="label label-success">Revisado</span></p>
                               ';
                        break;
                    case 'A':
                        return '<span class="label label-' . $class . '">' . $estado . '</span>
                               ';
                        break;
                    case 'E':
                        return '<span class="label label-primary">Finalizado</span>
                                ';

                        break;
                }

            })
            ->make(true);
    }

    public function indexAdminLineas()
    {
        $name = 'AsesorCC';
        DB::beginTransaction();
        try {
            $codigo = 0;
            $int = Solicitud::select('n_solicitud')->count();
            $identificacion = Auth::user();
            $usuario = DB::connection('mysql_solicitudes')
                ->table('empleados AS emp')
                ->where('emp.identificacion', $identificacion->persona_id)
                ->groupBy('emp.nombres', 'emp.apellidos')
                ->select(DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))->first();

            $objRole = DB::connection('mysql')->table('roles')->where(['name' => $name])->first();
            $objSelect = new SelectController();
            $objgestores = $objSelect->getGestores($objRole->id);
            $provincia = $objSelect->getParametro('PROVINCIA', 'http');
            $banco = $objSelect->getParametro('BANCO', 'http');


            $objUserRole = DB::connection('mysql')
                ->table('model_has_roles as mr')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->where(['mr.model_id' => $identificacion->id])
                ->select('r.name')
                ->get()->toArray();


            $array = array();
            array_push($array, 'LiderCC', 'AdminCC');
            $var = Auth::user()->evaluarole($array);

            DB::commit();
            $var = 1;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }


        $name = 'AsesorCC';
        $objSelect = new SelectController();
        $objRole = DB::connection('mysql')->table('roles')->where(['name' => $name])->first();
        $provincia = $objSelect->getParametro('PROVINCIA', 'http');
        $asesor = $objSelect->getGestores($objRole->id);

        $arrayA = array();

        $role = 0;
        $criterio = ['solicitud' => 'Solicitudes'];

        array_push($arrayA, 'AdminSolicitudes');
        $varA = Auth::user()->evaluarole($arrayA);
        if ($varA != 0) {
            $role = 1;
            $criterio = ['lineas' => 'Lineas', 'solicitud' => 'Solicitudes', 'cliente' => 'Clientes'];

        }

        $tipo_baja = ['CHARGEBACK' => 'CHARGEBACK', 'BAJA_MENOR' => 'BAJA_MENOR'];
        $tipo_estado_ch=['CARRUSEL'=>'CARRUSEL', 'BAJA'=>'BAJA'];
        $motivoCh = ['INACTIVO_CAMBIO_PREPAGO' => 'Inactivo Cambio Prepago', 'CAMBIO_COBRANZAS' => 'Inactivo Cobranzas', 'INACTIVO_ROBO' => 'Inactivo Robo', 'INACTIVO_SIN_CARGO' => 'Inactivo Sin Cargo'];
        $obsequio=['Agenda_Guayaquil'=>'Agenda Guayaquil','BMOBILE_K360'=>'BMOBILE K360','Gift_Card'=>'Gift Card','Reloj'=>'Reloj','Spinner'=>'Spinner','VR_BOX'=>'VR BOX','Tarjeta_de_Memoria'=>'Tarjeta de Memoria'];
        return view('modules.Solicitudes.indexAdministracion')
            ->with(['provincia' => $provincia,
                'asesor' => $asesor,
                'usuario' => $usuario->name,
                'gestores' => $objgestores,
                'provincia' => $provincia,
                'banco' => $banco,
                'var' => $var,
                'role' => $role,
                'criterio' => $criterio,
                'motivoCh' => $motivoCh,
                'tipo_baja' => $tipo_baja,
                'tipo_estado_ch'=>$tipo_estado_ch,
                'obsequio'=>$obsequio]);
    }

    public function editChange(request $request)
    {
        $result = DB::connection('mysql_solicitudes')
            ->table('solicitud as p')
            ->where('p.n_solicitud', $request->solicitud_id)
            ->join('bestados as b', 'b.solicitud_id', 'p.n_solicitud')
            ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'b.estado_linea_id')
            ->join('empleados as emp', 'emp.identificacion', 'p.gestor_id')
            ->whereIn('b.estado', ['A'])
            ->select('p.n_solicitud as solicitud',
                'p.entrega_ciudad_id as entrega_ciudad_id',
                'p.direccion_entrega as direccion_entrega',
                'p.provincia_id as provincia_id',
                'p.region as region',
                'p.fecha_lote as fecha_lote',
                'p.lote as lote',
                'p.ciclo_facturacion as ciclo_facturacion',
                'p.fecha_activacion as fecha_activacion',
                'p.fecha_facturacion as fecha_facturacion',
                'p.celular_entrega as celular_entrega',
                'p.estado as estado',
                'p.gestor_id as gestor_id',
                'p.created_at as created_at',
                'p.observacion as observacion',
                'p.tchip as tchip',
                'p.tobsequios as tobsequios',
                'p.tlineas as tlineas',
                'tbp.descripcion as uestado', 'p.empleado_id as empleado_id')->get()->toArray();

        if ($result != []) {
            //$result = $result[0];
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "Registro No encontrado";
        }

        return response()->json($array_response, 200);

    }

    public function getDatatableAdministracion($criterio, $parametro, $fechai, $fechaf)
    {
        // dd($criterio,$parametro);
        if ($fechai != '0') {
            $fechai = date_create($fechai);
            $fechai = $fechai->format('Y-m-d H:i:s');
        }

        if ($fechaf != '0') {
            $fechaf = date_create($fechaf);
            $fechaf = $fechaf->format('Y-m-d H:i:s');
        }

        $user = Auth::user();
        $array = array();
        array_push($array, 'AdminSolicitudes');
        $var = Auth::user()->evaluarole($array);
        $today = new \DateTime("now");

        $result = DB::connection('mysql_solicitudes')->table('bestados')
            ->orderby('created_at', 'DSC')
            ->select('created_at')
            ->take(1)
            ->get()
            ->toArray();
        if ($result != []) {
            $result = $result[0]->created_at;
            $dateinicio = date_create($result);
        } else {
            $dateinicio = $today;
        }
        $dateinicio = $dateinicio->format('Y-m-d h:m:s');
        $today = $today->format('Y-m-d h:m:s');

        $datatable1 = DB::connection('mysql_solicitudes')
            ->table('solicitud as p')
            ->join('bestados as be','be.solicitud_id','p.n_solicitud')
            ->join('nextcore.tb_parametro as tbp1','tbp1.id','be.estado_linea_id')
            ->join('cliente as c', 'c.identificacion', 'p.cliente_id')
            ->join('empleados as emp', 'p.empleado_id', 'emp.identificacion');
          //  ->whereNotIn('tbp1.descripcion',['SOLICITUD PREGRABA']);

        if ($parametro != '0') {
            if ($criterio == "cliente") {
                $datatable1 = $datatable1->where('c.nombres', 'like', '%' . $parametro . '%');

            }

            switch ($criterio) {
                case 'lineas':
                    $datatable1 = $datatable1->join('lineas as l', 'l.solicitud_id', 'p.n_solicitud')
                        ->where('l.celular', 'like', '%' . $parametro . '%');
                    break;
                case 'solicitud':
                    $datatable1 = $datatable1->where('p.n_solicitud', 'like', '%' . $parametro . '%');
                    break;
            }
        }
        if ($fechai == $fechaf && $fechai != 0 && $fechaf != 0) {
            $datatable1 = $datatable1->wheredate('p.created_at', $fechai);
        } elseif ($fechai != 0 && $fechaf != 0) {

            $datatable1 = $datatable1->whereBetween('p.created_at', [$fechai, $fechaf]);

        } elseif ($fechai != 0 && $fechaf == 0) {
            $datatable1 = $datatable1->whereBetween('p.created_at', [$fechai, $today]);

        } elseif ($fechaf != 0 && $fechai == 0) {
            $datatable1 = $datatable1->whereBetween('p.created_at', [$dateinicio, $fechaf]);
        }
        $datatable1 = $datatable1->orderby('p.created_at', 'DSC')
            ->groupby(
                'p.n_solicitud',
                'c.nombres',
                'emp.apellidos',
                'emp.nombres',
                'c.identificacion'
            )
            ->select(
                'p.n_solicitud as solicitud',
                'c.nombres as cliente',
                DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as usuario"),
                'c.identificacion as identificacion'
            )->get();

        return DataTables::of($datatable1)
		  ->addColumn('Solicitud', function ($select) {

                 $tipo = 'solicitud';
                 $result = DB::connection('mysql_solicitudes')
                     ->table('solicitud as p')
                     ->where('p.n_solicitud', $select->solicitud)
                     ->join('bestados as b', 'b.solicitud_id', 'p.n_solicitud')
                     ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'b.estado_linea_id')
                     ->join('empleados as emp', 'emp.identificacion', 'p.gestor_id')
                     ->whereIn('b.estado', ['A'])
                     ->select('p.entrega_ciudad_id as entrega_ciudad_id',
                         'p.direccion_entrega as direccion_entrega',
                         'p.provincia_id as provincia_id',
                         'p.region as region',
                         'p.fecha_lote as fecha_lote',
                         'p.lote as lote',
                         'p.ciclo_facturacion as ciclo_facturacion',
                         'p.fecha_activacion as fecha_activacion',
                         'p.fecha_facturacion as fecha_facturacion',
                         'p.celular_entrega as celular_entrega',
                         'p.estado as estado',
                         'p.gestor_id as gestor_id',
                         'p.created_at as created_at',
                         'p.observacion as observacion',
                         'p.tchip as tchip',
                         'p.tobsequios as tobsequios',
                         'p.tlineas as tlineas',
                         'tbp.descripcion as uestado', 'p.empleado_id as empleado_id')->get()->toArray();

                 $result = $result[0];

                 $editarlinea = '<a onclick="editchangeSolicitud(\'' . $select->solicitud . '\',
                                                         \'' . $result->entrega_ciudad_id . '\',
                                                         \'' . $result->direccion_entrega . '\',
                                                         \'' . $result->provincia_id . '\',
                                                         \'' . $result->region . '\',
                                                         \'' . $result->fecha_lote . '\',
                                                         \'' . $result->lote . '\',
                                                         \'' . $result->ciclo_facturacion . '\',
                                                         \'' . $result->fecha_activacion . '\',
                                                         \'' . $result->fecha_facturacion . '\',
                                                         \'' . $result->celular_entrega . '\',
                                                         \'' . $result->estado . '\',
                                                         \'' . $result->gestor_id . '\',
                                                         \'' . $result->created_at . '\',
                                                         \'' . $result->observacion . '\',
                                                         \'' . $result->tchip . '\',
                                                         \'' . $result->tobsequios . '\',
                                                         \'' . $result->tlineas . '\',
                                                         \'' . $result->uestado . '\',
                                                          \'' . $result->empleado_id . '\',
                                                         \'' . $tipo . '\')"
                                 class="label label-primary" data-hover="tooltip" data-placement="top"
                                data-target="#Modalagregar" data-toggle="modal" id="modal"><i class="fa fa-edit"></i></a>';

                 $eliminarlinea = '<a onclick="PedirConfirmacion(\'' . $select->solicitud . '\',\'' . $tipo . '\')" class="label label-danger"><i class="fa fa-trash"></i></a>';

                 return '<div class="float:left" style="float:left">' . $select->solicitud . '</div><div style="float:right">' . $editarlinea . $eliminarlinea . '</div>';

            })

         ->addColumn('Cliente', function ($select) {
                $tipo = 'cliente';

                  $result = DB::connection('mysql_solicitudes')
                      ->table('cliente')
                      ->where('identificacion', $select->identificacion)
                      ->select('identificacion',
                          'tipo_persona',
                          'nombres',
                          'correo',
                          'cedula_RL',
                          'nombre_RL',
                          'fecha_vence_emp',
                          'cargo_RL',
                          'direccion_domicilio',
                          'referencia_domicilio',
                          'convencional',
                          'convencional_perteneciente',
                          'movil',
                          'ciudad_domicilio_id',
                          'provincia_domicilio_id',
                          'fecha_nacimiento',
                          'created_at',
                          'estado',
                          'estado_civil',
                          'empresa',
                          'direccion_laboral',
                          'ciudad_laboral_id',
                          'provincia_laboral_id',
                          'convencional_laboral',
                          'cargo',
                          'tiempo_laboral',
                          'ingresos_laboral',
                          'forma_pago',
                          'banco_id',
                          'cta_ahorro',
                          'cta_corriente',
                          'nombre_tarjeta',
                          'numero_tarjeta',
                          'codigo_seguridad_tarjeta',
                          'vencimiento_tarjeta',
                          'cupo',
                          'deuda',
                          'valor_garantia',
                          'deposito_garantia')
                      ->get()->toArray();
                  $result = $result[0];

                  $editarlinea = '<a onclick="editchangeCliente(\'' . $result->identificacion . '\',
                  \'' . $result->tipo_persona . '\',
                  \'' . $result->nombres . '\',
                  \'' . $result->correo . '\',
                  \'' . $result->cedula_RL . '\',
                  \'' . $result->nombre_RL . '\',
                  \'' . $result->fecha_vence_emp . '\',
                  \'' . $result->cargo_RL . '\',
                  \'' . $result->direccion_domicilio . '\',
                  \'' . $result->referencia_domicilio . '\',
                  \'' . $result->convencional . '\',
                  \'' . $result->convencional_perteneciente . '\',
                  \'' . $result->movil . '\',
                  \'' . $result->ciudad_domicilio_id . '\',
                  \'' . $result->provincia_domicilio_id . '\',
                  \'' . $result->fecha_nacimiento . '\',
                  \'' . $result->created_at . '\',
                  \'' . $result->estado . '\',
                  \'' . $result->estado_civil . '\',
                  \'' . $result->empresa . '\',
                  \'' . $result->direccion_laboral . '\',
                  \'' . $result->ciudad_laboral_id . '\',
                  \'' . $result->provincia_laboral_id . '\',
                  \'' . $result->convencional_laboral . '\',
                  \'' . $result->cargo . '\',
                  \'' . $result->tiempo_laboral . '\',
                  \'' . $result->ingresos_laboral . '\',
                  \'' . $result->forma_pago . '\',
                  \'' . $result->banco_id . '\',
                  \'' . $result->cta_ahorro . '\',
                  \'' . $result->cta_corriente . '\',
                    \'' . $result->nombre_tarjeta . '\',
                  \'' . $result->numero_tarjeta . '\',
                  \'' . $result->codigo_seguridad_tarjeta . '\',
                  \'' . $result->vencimiento_tarjeta . '\',
                  \'' . $result->cupo . '\',
                   \'' . $result->deuda . '\',
                  \'' . $result->valor_garantia . '\',
                  \'' . $result->deposito_garantia . '\',
                  \'' . $tipo . '\')" class="label label-primary"  data-hover="tooltip" data-placement="top"
                                 data-target="#Modalagregar" data-toggle="modal" id="modal"><i class="fa fa-edit"></i></a>';
                  $eliminarlinea = '';

                  return '<div class="float:left" style="float:left">' . $select->cliente . '</div><div style="float:right">' . $editarlinea . $eliminarlinea . '</div>';

            })
         ->addColumn('Usuario', function ($select) {
                   $tipo = 'usuario';

                      $editarlinea = '';
                      $eliminarlinea = '';


                      return '<div class="float:left" style="float:left">' . $select->usuario . '</div><div style="float:right">' . $editarlinea . $eliminarlinea . '</div>';

            })
         ->addColumn('Celular', function ($select) {
			 
                $tipo = 'linea';
                $idcelular = 0;

                $resultL = DB::connection('mysql_solicitudes')
                    ->table('solicitud as p')
                    ->where('p.n_solicitud', $select->solicitud)
                    ->join('bestados as b', 'b.solicitud_id', 'p.n_solicitud')
                    ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'b.estado_linea_id')
                    ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'p.entrega_ciudad_id')
                    ->join('empleados as emp', 'emp.identificacion', 'p.empleado_id')
                    ->join('cliente as cl', 'cl.identificacion', 'p.cliente_id')
                    ->whereIn('b.estado', ['A'])
                    ->select(
                        'cl.identificacion as identificacion',
                        'cl.nombres as nombres_cliente',
                        'cl.forma_pago as forma_pago',
                        'tbp2.descripcion as entrega_ciudad',
                        'p.region as region',
                        'p.fecha_activacion as fecha_activacion',
                        'p.fecha_facturacion as fecha_facturacion',
                        'p.tlineas as tlineas',
                        'tbp.descripcion as uestado', DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as empleado"))->get()->toArray();

                if($resultL!=[])
                {
                    $resultL=$resultL[0];
					$identificacion=$resultL->identificacion;
					$nombres_cliente=$resultL->nombres_cliente;
					$forma_pago=$resultL->forma_pago;
					$entrega_ciudad=$resultL->entrega_ciudad;
					$region=$resultL->region;
					$fecha_activacion=$resultL->fecha_activacion;
					$fecha_facturacion=$resultL->fecha_facturacion;
					$tlineas=$resultL->tlineas;
					$uestado=$resultL->uestado;
					$empleado=$resultL->empleado;
                }else{
					
					$identificacion='--';
					$nombres_cliente='--';
					$forma_pago='--';
					$entrega_ciudad='--';
					$region='--';
					$fecha_activacion='--';
					$fecha_facturacion='--';
					$tlineas='--';
					$uestado='--';
					$empleado='--';
					
                }

                $sc = "$select->solicitud','$identificacion','$nombres_cliente','$forma_pago','$entrega_ciudad','$region','$fecha_activacion','$fecha_facturacion','$tlineas','$uestado','$empleado";

                $lineas = DB::connection('mysql_solicitudes')
                    ->table('lineas')
                    ->where('solicitud_id', $select->solicitud)
                    ->select('id',
                        'celular',
                        'solicitud_id',
                        's_axis',
                        'axisestado',
                        'operadora',
                        'tipo_linea',
                        'bp_id',
                        'equipo',
                        'marca',
                        'modelo',
                        'cobsequio1',
                        'obsequio1',
                        'cobsequio2',
                        'obsequio2',
                        'imei',
                        'simcard',
                        'cuota',
                        'estado',
                        'cliente_id',
                        'usuario_ing',
                        'usuario_mod',
                        'created_at',
                        'updated_at',
                        'plan',
                        'tarifa_basica',
                        'tipo_solicitud',
                        'n_cuenta_donante',
                        'cedula_donante',
                        'nombre_donante',
                        'direccion_donante',
                        'celular_donante',
                        'cedula_RL',
                        'nombre_RL',
                        'cargo_RL',
                        'chargeback')
                    ->get()->toArray();

                $agregaLinea = '<a onclick="agregarLinea(\'' . $select->identificacion . '\',\'' . $select->solicitud . '\',\'' . $tipo . '\')" class="label label-success"  data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal">
                              <i class="fa fa-plus"></i></a><hr/>';

                $lineaHtml = '';
                $cont = 0;
			
                foreach ($lineas as $item) {
                    $idcelular = $item->id;
                    $editarlinea = '<a onclick="editChangeLinea(\'' . $item->id . '\',
                        \'' . $item->celular . '\',
                        \'' . $item->solicitud_id . '\',
                        \'' . $item->s_axis . '\',
                        \'' . $item->axisestado . '\',
                        \'' . $item->operadora . '\',
                        \'' . $item->tipo_linea . '\',
                        \'' . $item->bp_id . '\',
                        \'' . $item->equipo . '\',
                        \'' . $item->marca . '\',
                        \'' . $item->modelo . '\',
                        \'' . $item->cobsequio1 . '\',
                        \'' . $item->obsequio1 . '\',
                        \'' . $item->cobsequio2 . '\',
                        \'' . $item->obsequio2 . '\',
                        \'' . $item->imei . '\',
                        \'' . $item->simcard . '\',
                        \'' . $item->cuota . '\',
                        \'' . $item->estado . '\',
                        \'' . $item->cliente_id . '\',
                        \'' . $item->plan . '\',
                        \'' . $item->tarifa_basica . '\',
                        \'' . $item->tipo_solicitud . '\',
                        \'' . $item->n_cuenta_donante . '\',
                        \'' . $item->cedula_donante . '\',
                        \'' . $item->nombre_donante . '\',
                        \'' . $item->direccion_donante . '\',
                        \'' . $item->celular_donante . '\',
                        \'' . $item->cedula_RL . '\',
                        \'' . $item->nombre_RL . '\',
                        \'' . $item->cargo_RL . '\',
                        \'' . $item->chargeback . '\',\'' . $tipo . '\')" class="label label-primary"  data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"><i class="fa fa-edit"></i></a>';
                    $eliminarlinea = '<a class="label label-danger" onclick="PedirConfirmacion(\'' . $idcelular . '\',\'' . $tipo . '\')"><i class="fa fa-trash"></i></a>';
                    if ($uestado == 'REGULARIZADO ACT') {
                        $chargeback = '<a class="label label-success" onclick="chargeback(\'' . $sc . '\',\'' . $item->celular . '\',\'' . $item->tarifa_basica . '\',\'' . $item->plan . '\',\'' . $item->tipo_linea . '\',)"class="label label-primary"  data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"><i class="fa fa-check"></i></a>';
                    } else {
                        $chargeback = '';
                    }
						
                    if ($item->celular != null && $item->celular != '') {
                        $cont++;
                        if($item->estado!='A')
                        {
                            $label='<span class="dot" style="background-color: #a60000!important"></span>';
                        }else{
                            $label='<span class="dot" style="background-color: #00a65a!important"></span>';

                        }
                        $lineaHtml .= '<p>'. $label.' '. $item->celular  .'<span style="float:right">' . $chargeback . $editarlinea . $eliminarlinea . '</span></p>';
                    } else {
                        $lineaHtml .= '<p>Linea No definida<span style="float:right">' . $editarlinea . $eliminarlinea . '</span></p>';

                    }

                }
                return $agregaLinea . $lineaHtml;

            })
           ->make(true);

    }

    public function updateChange(request $request)
    {
        switch ($request->tipo) {
            case 'linea':

                $cliente_id = $request->cliente_id;
                $id_celular = $request->id_celular;
                $s_axis = $request->s_axis;
                $tipo_solicitud = $request->tipo_solicitud;
                $celular = $request->celular;
                $operadora = $request->operadora;
                $tipo_linea = $request->tipo_linea;
                $equipo = $request->equipo;
                $marca = $request->marca;
                $modelo = $request->modelo;
                $imei = $request->imei;
                $cuota = $request->cuota;
                $plan = $request->plan;
                $simcard = $request->simcard;
                $cobsequio1 = $request->cobsequio1;
                $cobsequio2 = $request->cobsequio2;
                $tarifa_basica = $request->tarifa_basica;
                $obsequio1 = $request->obsequio1;
                $obsequio2 = $request->obsequio2;
                $bp_id = $request->bp_id;
                $axisestado = $request->axisestado;
                $n_cuenta_donante = $request->n_cuenta_donante;
                $cedula_donante = $request->cedula_donante;
                $nombre_donante = $request->nombre_donante;
                $direccion_donante = $request->direccion_donante;
                $celular_donante = $request->celular_donante;
                $cedula_RL = $request->cedula_RL;
                $nombre_RL = $request->nombre_RL;
                $cargo_RL = $request->cargo_RL;
                $solicitud_id = $request->solicitud_id;
                $estado=$request->estadolinea;

                if($estado=='A')
                {
                    $countLineasAnexas = Lineas::where('celular',$celular)->whereNotIn('id', [$id_celular])->count();
                }else
                {
                    $countLineasAnexas=0;
                }

                if($countLineasAnexas<1)
                {
                    DB::beginTransaction();
                   try {
                        if ($id_celular != 0) {
                            $result = Lineas::where('id', $id_celular)->update([
                                'celular' => $celular,
                                'solicitud_id' => $solicitud_id,
                                's_axis' => $s_axis,
                                'axisestado' => $axisestado,
                                'operadora' => $operadora,
                                'tipo_linea' => $tipo_linea,
                                'bp_id' => $bp_id,
                                'equipo' => $equipo,
                                'marca' => $marca,
                                'modelo' => $modelo,
                                'cobsequio1' => $cobsequio1,
                                'obsequio1' => $obsequio1,
                                'cobsequio2' => $cobsequio2,
                                'obsequio2' => $obsequio2,
                                'imei' => $imei,
                                'simcard' => $simcard,
                                'cuota' => $cuota,
                                'cliente_id' => $cliente_id,
                                'plan' => $plan,
                                'tarifa_basica' => $tarifa_basica,
                                'tipo_solicitud' => $tipo_solicitud,
                                'n_cuenta_donante' => $n_cuenta_donante,
                                'cedula_donante' => $cedula_donante,
                                'nombre_donante' => $nombre_donante,
                                'direccion_donante' => $direccion_donante,
                                'celular_donante' => $celular_donante,
                                'cedula_RL' => $cedula_RL,
                                'nombre_RL' => $nombre_RL,
                                'cargo_RL' => $cargo_RL,
                                'estado'=>$estado]);

                        } else {
                            $result = new Lineas();
                            $result->celular = $celular;
                            $result->solicitud_id = $solicitud_id;
                            $result->s_axis = $s_axis;
                            $result->axisestado = $axisestado;
                            $result->operadora = $operadora;
                            $result->tipo_linea = $tipo_linea;
                            $result->bp_id = $bp_id;
                            $result->equipo = $equipo;
                            $result->marca = $marca;
                            $result->modelo = $modelo;
                            $result->cliente_id = $cliente_id;
                            $result->cobsequio1 = $cobsequio1;
                            $result->obsequio1 = $obsequio1;
                            $result->cobsequio2 = $cobsequio2;
                            $result->obsequio2 = $obsequio2;
                            $result->imei = $imei;
                            $result->simcard = $simcard;
                            $result->cuota = $cuota;
                            $result->plan = $plan;
                            $result->tarifa_basica = $tarifa_basica;
                            $result->tipo_solicitud = $tipo_solicitud;
                            $result->n_cuenta_donante = $n_cuenta_donante;
                            $result->cedula_donante = $cedula_donante;
                            $result->nombre_donante = $nombre_donante;
                            $result->direccion_donante = $direccion_donante;
                            $result->celular_donante = $celular_donante;
                            $result->cedula_RL = $cedula_RL;
                            $result->nombre_RL = $nombre_RL;
                            $result->cargo_RL = $cargo_RL;
                            $result->save();
                        }
                        $intLineas=Lineas::where('solicitud_id',$solicitud_id)->get()->count();
                       // dd($intLineas);
                        Solicitud::where(['n_solicitud'=> $solicitud_id])->update(['tlineas'=>$intLineas]);

                        DB::commit();
                        $array_response['status'] = 200;
                        $array_response['message'] = "Grabado Exitosamente";
                        $success = 1;
                    } catch (\Exception $e) {
                        DB::rollback();
                        $array_response['status'] = 404;
                        $array_response['message'] = "Error al Grabar";
                        throw $e;
                    }
                }else{
                    $array_response['status'] = 404;
                    $array_response['message'] = "Error el Número de Celular ya esta activo en otra solicitud";
                }
                break;
            case 'cliente':
                //datos labores------------------------------------------------

                $razon_social = $request->dato_laborales[0];
                $direccion_laboral = $request->dato_laborales[1];
                $convencional_laboral = $request->dato_laborales[2];
                $cargo_laboral = $request->dato_laborales[3];
                $tiempo_laboral = $request->dato_laborales[4];
                $ingresos_laboral = $request->dato_laborales[5];
                $provincia_laboral_id = $request->dato_laborales[6];
                $ciudad_laboral_id = $request->dato_laborales[7];


                //seguridad---------------------------------------------
                $usuario_ing = Auth::user()->id;

                //cliente
                DB::beginTransaction();
                try {
                    $objCliente = Cliente::Find($request->identificacion);
                    if (count($objCliente) < 1) {
                        $objCliente = new Cliente();
                    }


                    if ($request->tipo_persona != 'JURIDICO') {
                        //natural---------------------------------------------
                        $nombres = $request->dato_general[0];
                        $correo = $request->dato_general[1];
                        $fecha_nacimiento = $request->dato_general[2];
                        $direccion_domicilio = $request->dato_general[3];
                        $referencia_domicilio = $request->dato_general[4];
                        $convencional = $request->dato_general[5];
                        $movil = $request->dato_general[6];
                        $estado_civil = $request->dato_general[7];
                        $convencional_perteneciente = $request->dato_general[8];
                        $provincia_domicilio_id = $request->dato_general[9];
                        $ciudad_domicilio_id = $request->dato_general[10];
                        //Envio

                        $objCliente->nombres = $nombres;
                        $objCliente->correo = $correo;
                        $objCliente->fecha_nacimiento = $fecha_nacimiento;
                        $objCliente->direccion_domicilio = $direccion_domicilio;
                        $objCliente->referencia_domicilio = $referencia_domicilio;
                        $objCliente->convencional = $convencional;
                        $objCliente->convencional_perteneciente = $convencional_perteneciente;
                        $objCliente->movil = $movil;
                        $objCliente->estado_civil = $estado_civil;
                        $objCliente->provincia_domicilio_id = $provincia_domicilio_id;
                        $objCliente->ciudad_domicilio_id = $ciudad_domicilio_id;


                    } else {
                        $nombres = $request->dato_general[0];
                        $correo = $request->dato_general[3];

                        $cedularl = $request->dato_general[1];
                        $fecha_vencimiento = $request->dato_general[2];
                        $nombrerl = $request->dato_general[4];
                        $cargorl = $request->dato_general[5];

                        //Envio
                        $objCliente->nombres = $nombres;
                        $objCliente->correo = $correo;
                        $objCliente->cedula_RL = $cedularl;
                        $objCliente->nombre_RL = $nombrerl;
                        $objCliente->fecha_vence_emp = $fecha_vencimiento;
                        $objCliente->cargo_RL = $cargorl;

                    }

                    $objCliente->identificacion = $request->identificacion;
                    $objCliente->tipo_persona = $request->tipo_persona;
                    $objCliente->empresa = $razon_social;
                    $objCliente->direccion_laboral = $direccion_laboral;
                    $objCliente->ciudad_laboral_id = $ciudad_laboral_id;
                    $objCliente->provincia_laboral_id = $provincia_laboral_id;
                    $objCliente->convencional_laboral = $convencional_laboral;
                    $objCliente->cargo = $cargo_laboral;
                    $objCliente->tiempo_laboral = $tiempo_laboral;
                    $objCliente->ingresos_laboral = $ingresos_laboral;
                    $objCliente->usuario_ing = $usuario_ing;
                    $objCliente->deposito_garantia = $request->deposito_garantia;
                    if ($request->forma_pago != null && $request->forma_pago != '') {
                        $objCliente->forma_pago = $request->forma_pago;
                        switch ($request->forma_pago) {

                            case 'DEBITO_BANCARIO':
                                if ($request->pago != null && $request->pago != '') {
                                    $objCliente->banco_id = $request->pago[0];
                                    $cuenta = $request->pago[1];
                                    if ($cuenta == 'CORRIENTE') {
                                        $objCliente->cta_corriente = $request->pago[2];
                                    } else {
                                        $objCliente->cta_ahorro = $request->pago[2];
                                    }

                                }
                                break;

                            case 'TARJETA_CREDITO':
                                if ($request->pago != null && $request->pago != '') {
                                    $objCliente->nombre_tarjeta = $request->pago[0];
                                    $objCliente->numero_tarjeta = $request->pago[1];
                                    $objCliente->codigo_seguridad_tarjeta = $request->pago[2];
                                    $objCliente->vencimiento_tarjeta = $request->pago1[3];
                                }
                                break;

                            case 'CONTRAFACTURA':
                                if ($request->pago != null && $request->pago != '') {
                                    $objCliente->banco_id = $request->pago[0];
                                    $cuenta = $request->pago[1];
                                    if ($cuenta == 'CORRIENTE') {
                                        $objCliente->cta_corriente = $request->pago[2];
                                    } else {
                                        $objCliente->cta_ahorro = $request->pago[2];
                                    }
                                }
                                if ($request->pago1 != null && $request->pago1 != '') {
                                    $objCliente->nombre_tarjeta = $request->pago1[0];
                                    $objCliente->numero_tarjeta = $request->pago1[1];
                                    $objCliente->codigo_seguridad_tarjeta = $request->pago1[2];
                                    $objCliente->vencimiento_tarjeta = $request->pago1[3];
                                }
                                if ($request->valor != null && $request->valor != '' && $request->valor != 0) {
                                    $objCliente->valor_garantia = $request->valor;
                                }
                                break;
                        }
                    }
                    $objCliente->save();

                    DB::commit();
                    $array_response['status'] = 200;
                    $array_response['message'] = "Grabado Exitosamente";
                    $success = 1;
                } catch (\Exception $e) {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = "Error al Grabar";
                   throw $e;
                }
                break;
            case 'solicitud':
                DB::beginTransaction();
                try {
                    $result = DB::connection('mysql')->table('users')->where('persona_id', $request->empleado_id)->select('id')->get()->toArray();
                    $result = $result[0]->id;
                    $Solicitud = Solicitud::where(['n_solicitud' => $request->solicitud])
                        ->update(['entrega_ciudad_id' => $request->entrega_ciudad_id,
                            'direccion_entrega' => $request->direccion_entrega,
                            'provincia_id' => $request->provincia_id,
                            'region' => $request->region,
                            'fecha_lote' => $request->fecha_lote,
                            'lote' => $request->lote,
                            'ciclo_facturacion' => $request->ciclo_facturacion,
                            'fecha_activacion' => $request->fecha_activacion,
                            'fecha_facturacion' => $request->fecha_facturacion,
                            'celular_entrega' => $request->celular_entrega,
                            'estado' => 'I',
                            'gestor_id' => $request->gestor_id,
                            'empleado_id' => $request->empleado_id,
                            'observacion' => $request->observacion,
                            'usuario_ing' => $result
                        ]);

                    $cliente_id = Solicitud::where('n_solicitud', $request->solicitud)->select('cliente_id')->get()->toArray()[0]['cliente_id'];
                    $Cliente = Cliente::where('identificacion', $cliente_id)->update(['usuario_ing' => $result]);
                    $objCambioGestorUpdate=DB::connection('mysql_solicitudes')
                        ->table('cambiogestor')->where('solicitud_id',$request->solicitud)->update(['estado'=>'I']);

                    $tipo_cambio = "CAMBIO_GESTOR";
                    $objCambioGestor = new CambioGestor();
                    $objCambioGestor->usuario_ing = Auth::user()->persona_id;
                    $objCambioGestor->tipo = $tipo_cambio;
                    $objCambioGestor->solicitud_id = $request->solicitud;
                    $objCambioGestor->asesor_anterior_id = $request->empleado_id_d;
                    $objCambioGestor->asesor_nuevo_id = $request->empleado_id;
                    $objCambioGestor->motivo = $request->motivo;
                    $objCambioGestor->save();


                    DB::commit();
                    $array_response['status'] = 200;
                    $array_response['message'] = "Grabado Exitosamente";

                } catch (\Exception $e) {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = "Error al Grabar";
                }

                break;
            case 'CARRUSEL':
                DB::beginTransaction();
                try {
                    $tipo_estado = $request->tipo_estado;
                    $motivo_ch = $request->motivo_ch;
                    $tipo = $request->tipo;
                    $dias_ch = $request->dias_ch;
                    $tipo_baja_ch = $request->tipo_baja_ch;
                    $fecha_desactivacion_ch = $request->fecha_desactivacion_ch;
                    $solicitud = $request->solicitud;
                    $cliente_id = $request->cliente_id;
                    $linea = $request->celular;

                    $objLineaEstadoDelete = LineaEstados::where('linea', $linea)->update(['estado' => 'I']);
                    $objLineaEstado = new LineaEstados();
                    $objLineaEstado->estado_linea = $tipo;
                    $objLineaEstado->solicitud_id = $solicitud;
                    $objLineaEstado->linea = $linea;
                    $objLineaEstado->cliente_id = $cliente_id;
                    $objLineaEstado->usuario_ing = Auth::user()->persona_id;
                    $objLineaEstado->save();
                    $objLineaUpdate = Lineas::where(['celular'=>$linea,'estado'=>'A'])->update(['chargeback' => $objLineaEstado->id]);

                    DB::commit();
                    $array_response['status'] = 200;
                    $array_response['message'] = "Grabado Exitosamente";

               } catch (\Exception $e) {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = "Error al Grabar";

                }
                break;
            case 'BAJA':
                DB::beginTransaction();
               try {
                    $tipo_estado = $request->tipo_estado;
                    $motivo_ch = $request->motivo_ch;
                    $tipo = $request->tipo;
                    $dias_ch = $request->dias_ch;
                    $tipo_baja_ch = $request->tipo_baja_ch;
                    $fecha_desactivacion_ch = $request->fecha_desactivacion_ch;
                    $solicitud = $request->solicitud;
                    $cliente_id = $request->cliente_id;
                    $linea = $request->celular;
                    $objLineaEstadoUpdate = LineaEstados::where('linea', $linea)->update(['estado' => 'I']);

                    $objLineaEstado = new LineaEstados();
                    $objLineaEstado->estado_linea = $tipo_baja_ch;
                    $objLineaEstado->solicitud_id = $solicitud;
                    $objLineaEstado->linea = $linea;
                    $objLineaEstado->dias = $dias_ch;
                    $objLineaEstado->cliente_id = $cliente_id;
                    $objLineaEstado->motivo = $motivo_ch;
                    $objLineaEstado->fecha_inactivo = $fecha_desactivacion_ch;
                    $objLineaEstado->usuario_ing = Auth::user()->persona_id;

                    $objLineaEstado->save();
                    $objLineaUpdate = Lineas::where(['celular'=> $linea,'estado'=>'A'])->update(['chargeback' => $objLineaEstado->id]);

                    DB::commit();
                    $array_response['status'] = 200;
                    $array_response['message'] = "Grabado Exitosamente";

               } catch (\Exception $e) {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = "Error al Grabar";

                }
                break;
        }

        return response()->json($array_response, 200);
    }

    public function deleteChange(request $request)
    {
        DB::beginTransaction();
        try {
            switch ($request->tipo) {
                case 'solicitud':
                    $Solicitud = Solicitud::where(['n_solicitud' => $request->id])->delete();
                    $Bestados = Bestados::where(['solicitud_id' => $request->id])->delete();
                    $Lineas = Lineas::where(['solicitud_id' => $request->id])->delete();
                    break;
                case 'linea':
                    $Lineas = Lineas::where(['id' => $request->id])->first();
                    $SolicitudId = $Lineas->solicitud_id;
                    $Solicitud = Solicitud::where(['n_solicitud' => $SolicitudId])->first();
                    $tlineas = ($Solicitud->tlineas) - 1;

                    if ($tlineas < 0) {
                        $tlineas = 0;
                    }
                    $Solicitud->tlineas = $tlineas;
                    $Solicitud->save();
                    $Lineas->delete();
                    break;

            }

            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = "Grabado Exitosamente";

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Error al Grabar";
        }

        return response()->json($array_response, 200);
    }

}
