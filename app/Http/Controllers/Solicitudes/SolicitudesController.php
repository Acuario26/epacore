<?php

namespace App\Http\Controllers\Solicitudes;

use App\Core\Entities\Solicitudes\Bestados;
use App\Core\Entities\Solicitudes\CambioGestor;
use App\Core\Entities\Solicitudes\LineaEstados;
use App\Core\Entities\Solicitudes\Solicitud_Liberada;
use App\Core\Entities\Solicitudes\SolicitudAsignacion;
use App\Core\Entities\Solicitudes\Asignaciones;
use App\Core\Entities\Admin\tb_parametro;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Monolog\Handler\ElasticSearchHandler;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Ajax\SelectController;
use App\Core\Entities\Solicitudes\Solicitud;
use App\Core\Entities\Solicitudes\Cliente;
use App\Core\Entities\Solicitudes\Lineas;


class SolicitudesController extends Controller
{
    private $asrray = array();
    private $solicitudesIngresadas = 0;

    public function index()
    {
        $name = 'AsesorCC';
        DB::beginTransaction();
        try {
            $codigo = 0;
            $int = Solicitud::select('n_solicitud')->count();
            $identificacion = Auth::user();
            //dd($identificacion->persona_id);
            $usuario = DB::connection('mysql_solicitudes')
                ->table('empleados AS emp')
                ->where('emp.identificacion', $identificacion->persona_id)
                ->groupBy('emp.nombres', 'emp.apellidos')
                ->select(DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))->first();

            $objRole = DB::connection('mysql')->table('roles')->where(['name' => $name])->first();
            $objSelect = new SelectController();
            $objgestores = $objSelect->getGestores($objRole->id);
            // $ciudad = $objSelect->getParametro('CIUDAD', 'http');
            $provincia = $objSelect->getParametro('PROVINCIA', 'http');
            $banco = $objSelect->getParametro('BANCO', 'http');


            $objUserRole = DB::connection('mysql')
                ->table('model_has_roles as mr')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->where(['mr.model_id' => $identificacion->id])
                ->select('r.name')
                ->get()->toArray();

            $bandejavalid = $objSelect->getParametro('BANDEJA_VALIDACION', 'http', 1);

            $bandejaSolicitudes = ['1' => 'Entrantes', '2' => 'Salientes', '3' => 'Todos','4'=>'Facturado Act'];

            $array = array();
            array_push($array, 'LiderCC', 'AdminCC');
            $var = Auth::user()->evaluarole($array);
            if ($var != 0) {
                $bandejaSolicitudes = ['0' => 'Pendiente de Estado', '1' => 'Pendiente de Asesor', '2' => 'Salientes', '3' => 'Todos','4'=>'Facturado Act'];
            }
            DB::commit();

            return view('modules.Solicitudes.index')->with([
                'usuario' => $usuario->name,
                'gestores' => $objgestores,
                'provincia' => $provincia,
                'banco' => $banco,
                'bandejaSolicitudes' => $bandejaSolicitudes,
                'bandejavalid' => $bandejavalid,
                'var' => $var]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function SaveSolicitud(request $request)
    {
        $band = 0;
        $errores = array();
        $success = 0;

        $objBandeja = DB::connection('mysql')
            ->table('tb_parametro')
            ->where(['descripcion' => 'SOLICITUD PREGRABADA'])->select('id', 'parametro_id')->first();

        //datos de solicitud

        $direccion_entrega = $request->dato_entrega[0];
        $celular_entrega = $request->dato_entrega[1];
        $region = $request->dato_entrega[2];
        $provincia_entrega = $request->dato_entrega[3];
        $ciudad_entrega = $request->dato_entrega[4];

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

        //datos de lineas
        $lineas = $request->lineas;


        if ($lineas != null) {
            DB::beginTransaction();
            try {
                foreach ($lineas as $item) {
                    $objBusqueda = Lineas::where(['celular' => $item[2], 'estado' => 'A'])
                                    ->whereNotIn('solicitud_id',[$request->solicitud])
                                    ->get()->toArray();
                    if ($objBusqueda == [] || $item[2] == null || $item[2] == '') {
                        $intCod = Lineas::where('solicitud_id', $request->solicitud)->delete();
                        $objLinea = new Lineas();
                                 $objLinea->tipo_solicitud = $item[1];
                    $objLinea->celular = $item[2];
                    $objLinea->operadora = $item[3] != 0 || $item[3] != null ? $item[3] : 0;
                    $objLinea->tipo_linea = $item[4] != 0 || $item[4] != null ? $item[4] : 0;
                    $objLinea->solicitud_id = $request->solicitud;
                    $objLinea->estado = 'A';
                    $objLinea->cliente_id = $request->identificacion;
                    $objLinea->usuario_ing = $usuario_ing;
                    $objLinea->equipo = $item[6] != 0 || $item[6] != null ? $item[6] : 0;
                    $objLinea->marca = $item[8];
                    $objLinea->modelo = $item[9];

                    $objLinea->bp_id = $item[11] != 0 || $item[11] != null ? $item[11] : 0;
                    $objLinea->plan = $item[13];
                    $objLinea->tarifa_basica = $item[14] != 0 || $item[14] != null ? $item[14] : 0;
                    $objLinea->cuota = $item[15];
                    $objLinea->obsequio1 = $item[16] != 0 || $item[16] != null ? $item[16] : 0;
                    $objLinea->obsequio2 = $item[17] != 0 || $item[17] != null ? $item[17] : 0;

                    $objLinea->cedula_donante = $item[21];
                    $objLinea->nombre_donante = $item[22];
                    $objLinea->direccion_donante = $item[23];
                    $objLinea->celular_donante = $item[24];
                    $objLinea->n_cuenta_donante = $item[25];
                    $objLinea->cedula_RL = $item[26];
                    $objLinea->nombre_RL = $item[27];
                    $objLinea->cargo_RL = $item[28];
                    $objLinea->save();
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

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
            
            // $objCliente ->estado='I';
            //dd($request->forma_pago,$request->pago,$request->pago1,$request->valor);
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
                            $objCliente->vencimiento_tarjeta = $request->pago[3];
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
            $success = 1;
        } catch (\Exception $e) {
            DB::rollback();
            array_push($errores, 'usuario,');
            throw $e;
        }
        //solicitud

        DB::beginTransaction();
        try {
            $intCod = Lineas::where(['solicitud_id'=>$request->solicitud,'estado'=>'A'])->count();
            $objSolicitud_escape = Solicitud::Find($request->solicitud_escape);
            if ($objSolicitud_escape != null) {
                $objSolicitud_escape->estado = 'E';
                $objSolicitud_escape->save();

            }
            $objSolicitud = Solicitud::Find($request->solicitud);
            if ($objSolicitud == null) {
                $objSolicitud = new Solicitud();
                $band = 1;
            }

            $objSolicitud->n_solicitud = $request->solicitud;
            $objSolicitud->entrega_ciudad_id = $ciudad_entrega;
            $objSolicitud->direccion_entrega = $direccion_entrega;
            $objSolicitud->provincia_id = $provincia_entrega;
            $objSolicitud->region = $region;
            $objSolicitud->celular_entrega = $celular_entrega;
            $objSolicitud->empleado_id = Auth::user()->persona_id;
            $objSolicitud->gestor_id = $request->gestor;
            $objSolicitud->usuario_ing = $usuario_ing;
            $objSolicitud->observacion = $request->observacion;
            $objSolicitud->tlineas = $intCod;
            $objSolicitud->tobsequios = $request->tobsequios;
            $objSolicitud->tchip = $request->tchip;
            $objSolicitud->cliente_id = $request->identificacion;
            $objSolicitud->estado = 'I';
            $objSolicitud->save();
            DB::commit();
            $success = 1;
        } catch (\Exception $e) {
            DB::rollback();
            array_push($errores, 'solicitud,');
            throw $e;
        }
        // PREGRABAR 1 SOLA VEZ  if ($band!=0) {
        $tiempo = Bestados::where(['solicitud_id' => $request->solicitud, 'estado' => 'A'])
            ->select('created_at')->get()->toArray();


        if (count($tiempo) > 0) {
            $anteriorFecha = ($tiempo[0]['created_at']);
            $anteriorFecha = new \DateTime($anteriorFecha);
            $today = new \DateTime("now");
            $diff = $anteriorFecha->diff($today);
            $tiempoDiferencial = $diff->format('%d días %h:%i:%s');
        } else {
            $tiempoDiferencial = '0 días 00:00:00';

        }
        $estadoVerificacion = DB::connection('mysql_solicitudes')
            ->table('bestados as be')
            ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.departamento_id')
            ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'be.estado_linea_id')
            ->join('nextcore.tb_parametro as tbp3', 'tbp3.id', 'tbp2.parametro_id')
            ->where(['be.estado' => 'A'])
            ->where('be.solicitud_id', $request->solicitud)
            ->select('tbp.descripcion as descripcion', 'tbp2.descripcion as estado')
            ->get()->toArray();


        if ($estadoVerificacion == []) {
            Bestados::where(['solicitud_id' => $request->solicitud, 'estado' => 'A'])->update(['estado' => 'I']);

            //seguimiento de estados
            DB::beginTransaction();
            try {

                $objBestados = new Bestados();
                $objBestados->departamento_id = $objBandeja->parametro_id;
                $objBestados->estado_linea_id = $objBandeja->id;
                $objBestados->estado = 'A';
                $objBestados->usuario_ing = $usuario_ing;
                $objBestados->tiempo = $tiempoDiferencial;
                $objBestados->solicitud_id = $request->solicitud;
                $objBestados->save();
                DB::commit();
                $success = 1;
            } catch (\Exception $e) {
                DB::rollback();
                array_push($errores, 'lineas,');
                throw $e;
            }

        }

        //  }
        //lineas


        if ($success != 0) {
            $array_response['status'] = 200;
            $array_response['message'] = "Registro fue grabado exitosamente";

        } else {
            $array_response['status'] = 404;
            $array_response['message'] = $errores;
        }


        return response()->json($array_response, 200);
    }

    public function NSolicitud()
    {
        DB::beginTransaction();
        try {
            $codigo = 0;
            $int = Solicitud::select('n_solicitud')->count();
            $codigo = $int + 1;
            $codigoSecuencial = Auth::user()->id . '0000' . $codigo;
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = $codigoSecuencial;

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Ups,Algo Ocurrio";
        }

        return response()->json($array_response, 200);

    }

    public function verificaNumero(request $request)
    {

        $objNumero = DB::connection('mysql_solicitudes')
            ->table('lineas as l')
            ->join('bestados as be', 'be.solicitud_id', 'l.solicitud_id')
            ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.estado_linea_id')
            ->join('solicitud as s', 's.n_solicitud', 'l.solicitud_id')
            ->join('empleados as e', 'e.identificacion', 's.empleado_id')
            ->where('l.estado', 'A')
            ->orderby('be.created_at','DSC');
        if ($request->admin == null) {
            $objNumero = $objNumero->whereNotIn('l.solicitud_id', [$request->solicitud])
                ->where('l.celular', $request->celular)
                ->select('l.celular as celular', 'l.solicitud_id as solicitud_id',
                    'l.chargeback as chargeback', 'tbp.descripcion as estado',
                    DB::raw("CONCAT(e.apellidos,' ',e.nombres) as empleado")
                )
                ->get()->toArray();
        } else {
            $objNumero = $objNumero->where('l.celular', $request->celular)
                ->select('l.celular as celular', 'l.solicitud_id as solicitud_id',
                    'l.chargeback as chargeback', 'tbp.descripcion as estado',
                    DB::raw("CONCAT(e.apellidos,' ',e.nombres) as empleado")
                )
                ->get()->toArray();
        }

        DB::beginTransaction();
        try {

            DB::commit();
            if (count($objNumero) > 0) {
                if ($objNumero[0]->chargeback == null || $objNumero[0]->chargeback == '') {
                    $objNumero[0]->chargeback = "-----";
                } else {
                    $objNumero[0]->chargeback = $objNumero[0]->chargeback;
                    $objLineaEstado = LineaEstados::where('id', $objNumero[0]->chargeback)->select('estado_linea')->first();
                    $objNumero[0]->chargeback = $objLineaEstado->estado_linea;
                }


                $array_response['status'] = 200;
                $array_response['message'] = "Numero de Celular:" . $objNumero[0]->celular . "\nEstado: " . $objNumero[0]->chargeback . "\nSolicitud N°:" . $objNumero[0]->solicitud_id . ",\nEstado:" . $objNumero[0]->estado . "\nAsesor:" . $objNumero[0]->empleado . ".";
            } else {
                $array_response['status'] = 404;
            }


        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;

        }

        return response()->json($array_response, 200);

    }

    public function ConfiguracionPlan2(request $request)
    {
        $result = DB::connection('mysql')
            ->table('tb_parametro AS tbp')
            ->where('tbp.estado', 'A')
            ->where('tbp.parametro_id', $request->dato1)
            ->groupBy('tbp.id', 'tbp.descripcion')
            ->orderBy('tbp.descripcion', 'ASC')
            ->select('tbp.id as id', 'tbp.descripcion as descripcion')->get()->toArray();
        if (count($result) > 0) {
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";

        }

        return response()->json($array_response, 200);
    }

    public function ConfiguracionPlan(request $request)
    {
        $result = DB::connection('mysql')
            ->table('tb_parametro AS tbp')
            ->where('tbp.estado', 'A')
            ->where('tbp.parametro_id', $request->dato)
            ->groupBy('tbp.id', 'tbp.descripcion')
            ->orderBy('tbp.descripcion', 'ASC')
            ->select('tbp.id as id', 'tbp.descripcion as descripcion')->get()->toArray();

        if (count($result) > 0) {
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";

        }

        return response()->json($array_response, 200);
    }

    public function ConfiguracionBP(request $request)
    {
        $result1 = DB::connection('mysql')
            ->table('tb_parametro AS tbp')
            ->where('tbp.estado', 'A')
            ->where('tbp.nivel', '2')
            ->where('tbp.descripcion', $request->parametro)
            ->select('tbp.id as id')->first();
        $result = DB::connection('mysql')
            ->table('tb_parametro AS tbp')
            ->where('tbp.estado', 'A')
            ->where('tbp.parametro_id', $result1->id)
            ->groupBy('tbp.id', 'tbp.descripcion')
            ->orderBy('tbp.descripcion', 'ASC')
            ->select('tbp.id as id', 'tbp.descripcion as descripcion')->get()->toArray();

        if (count($result) > 0) {
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";

        }
        //  $array_response['status'] = 200;
        //$array_response['message'] = "No hay resultados";

        return response()->json($array_response, 200);
    }

    public function EstadosBandeja(request $request)
    {
        //dd($request->inicio_deuda);
      //  dd($request->lineas);
        $asrray1 = array();
        $result = DB::connection('mysql')
        ->table('tb_parametro AS C')
        ->where('C.id', $request->estado)
        ->where('C.estado', 'A')
        ->get()->toArray();

        $pestados = DB::connection('mysql')
            ->table('tb_parametro AS l')
            ->join('tb_parametro as I', 'I.id', 'l.parametro_id')
            ->where('l.id', $request->estado)
            ->select('I.parametro_id as Departamento','I.descripcion as Dep','l.descripcion as EstadoI','I.verificacion as verificacion_bandeja', 'l.verificacion as verificacion_estado')
            ->whereNotIn('l.verificacion', [0, 1])
            ->get()->toArray();
        if ($pestados != []){
        
            if (($pestados[0]->verificacion_bandeja < $pestados[0]->verificacion_estado)) {
               
                if(($pestados[0]->verificacion_bandeja==$pestados[0]->verificacion_estado-1)||($pestados[0]->EstadoI=='REINGRESO APROBADO'))
                {
                    $departamento_id=tb_parametro::where(['verificacion'=>$pestados[0]->verificacion_estado,
                                    'parametro_id'=>$pestados[0]->Departamento])->get()->first();
                    $Usuarios=Asignaciones::where('departamento_id',$departamento_id->id)
                                    ->select('id','usuario','verificacion')->orderby('id','asc')->get();
                                    
                    if(count($Usuarios)>0){
                        $busquedaVerifica=$Usuarios->where('verificacion',1)->first();
                        if(!count($busquedaVerifica))
                        {
                            $Usuarios[0]->verificacion=1;
                            $Usuarios[0]->save();
                        }else{
                            
                            $siguiente=Asignaciones::where('id', '>', $busquedaVerifica->id)
                            ->where('departamento_id',$departamento_id)
                            ->orderBy('id', 'asc')->select('id')->first(); 
    //dd($siguiente);
                            if(count($siguiente))
                            {
                                $siguiente->verificacion=1;
                                $siguiente->save();
                                $busquedaVerifica->verificacion=0;
                                $busquedaVerifica->save();
                            }else{
                                $Usuarios=Asignaciones::where('departamento_id',$departamento_id->id)
                                ->select('id','usuario','verificacion')->orderby('id','asc')->where('verificacion',0)->first();
                               // dd($Usuarios);
                               if(count($Usuarios))
                               {
                                $Usuarios->verificacion=1;
                                $Usuarios->save();
                                $busquedaVerifica->verificacion=0;
                                $busquedaVerifica->save();
                               }
                                
                            }
                        }
                        $Usuarios=Asignaciones::where('departamento_id',$departamento_id->id)
                        ->select('id','usuario','verificacion')->orderby('id','asc')->where('verificacion',1)->first();
                        $ObjAsignaBandeja=SolicitudAsignacion::where(['solicitud_id'=>$request->solicitud_id,'usuario'=>$Usuarios->usuario])->get();
                        
                        if(!count($ObjAsignaBandeja))
                        {
                            $ObjAsignaBandeja = new SolicitudAsignacion();
                            $ObjAsignaBandeja->solicitud_id=$request->solicitud_id;
                            $ObjAsignaBandeja->usuario=$Usuarios->usuario;
                            $ObjAsignaBandeja->save();
                        }
                       
                    }
                }
                if($request->lineas != null) {
                    foreach ($request->lineas as $item) {
                        $axis = $item[1];
                        $axisestado = $item[2];
                        $tipo_linea = $item[3];
                        $celular = $item[4] != null ? $item[4] : '__________';
                        $equipo = $item[8];
                        $simcard = $item[9];
                        $marca = $item[10];
                        $modelo = $item[11];
                        $imei = $item[12];
                        $cobsequio1 = $item[20];
                        $cobsequio2 = $item[21];

                        switch ($request->band) {
                            case 1:
                                if ($tipo_linea == 'Linea_Nueva') {
                                    if (strlen($celular) < 10 || substr($celular, 0, 2) != '09') {
                                        array_push($asrray1, "\n" . 'Error al definir número:' . $celular);
                                    }
                                }
                                if ((strlen($axis) < 1 || $axis == null) && ($request->solicitud_axis == null || $request->solicitud_axis == 0)) {
                                    array_push($asrray1, "\n" . 'Falta ingresar la solicitud del Axis del celular:' . $celular);
                                }

                                if ($equipo == 0) {
                                    if (strlen($imei) < 1 || $imei == null) {
                                        array_push($asrray1, "\n" . 'Imei' . ',de la Linea: ' . $celular);
                                    }
                                }

                                break;
                            case 2:
                                if (strlen($simcard) < 1 || $simcard == null || $simcard == 0) {
                                    array_push($asrray1, "\n" . 'Simcard' . ',de la Linea: ' . $celular);
                                }
                                break;
                            case 3:
                                if (strlen($cobsequio1) < 1 || $cobsequio1 == null || $cobsequio1 == 0) {
                                    array_push($asrray1, "\n" . 'Codigo de Obsequio 1' . ',de la Linea: ' . $celular);
                                }
                                if (strlen($cobsequio2) < 1 || $cobsequio2 == null || $cobsequio2 == 0) {
                                    array_push($asrray1, "\n" . 'Codigo de Obsequio 2 ' . ',de la Linea: ' . $celular);
                                }
                                break;
                        }
                    }
                }
            }
        }
      
        //continua a la siguiente bandeja
        if ($asrray1 != null) {
            $array_response['status'] = 404;
            $array_response['message'] = $asrray1;
            DB::rollback();
        } else {

            $si = 0;

             DB::beginTransaction();
             try {
                 
            if ($request->bandeja == 'BANDEJA_VALIDACION') {
                $si = 1;
            }
            $objSelect = new SelectController();

            $verificac = $objSelect->dontBandeja([$request->bandeja], $request->solicitud_id, $si);
            if ($verificac != 0) {

                $tiempo = Bestados::where(['solicitud_id' => $request->solicitud_id, 'estado' => 'A'])
                    ->select('created_at')->get()->toArray();
                $anteriorFecha = ($tiempo[0]['created_at']);
                $anteriorFecha = new \DateTime($anteriorFecha);
                $today = new \DateTime("now");
                $diff = $anteriorFecha->diff($today);

                if (count($result) > 0) {

                    Bestados::where(['solicitud_id' => $request->solicitud_id, 'estado' => 'A'])
                        ->update(['estado' => 'I']);

                    $objBestado = new Bestados();
                    $objBestado->solicitud_id = $request->solicitud_id;
                    $objBestado->observacion = $request->observacion;
                    $objBestado->departamento_id = $result[0]->parametro_id;
                    $objBestado->estado_linea_id = $request->estado;
                    $objBestado->usuario_ing = Auth::user()->id;
                    $objBestado->tiempo = $diff->format('%d días %h:%i:%s');
                    $objBestado->estado = 'A';

                    $objBestado->consumo_cdc = $request->consumo_cdc;
                    $objBestado->castigo_cartera_cdc = $request->castigo_cartera_cdc;
                    $objBestado->financimiento_cdc = $request->financimiento_cdc;
                    $objBestado->adendum_cdc = $request->adendum_cdc;
                    $objBestado->otros_cdc = $request->otros_cdc;
                    $objBestado->total_cdc = $request->total_cdc;
                    if ($request->inicio_deuda != 0) {

                        $objBestado->inicio_deuda = $request->inicio_deuda;
                    } else {
                        $objBestado->inicio_deuda = null;

                    }
                    $objBestado->save();

                    $objSolicitud = Solicitud::Find($request->solicitud_id);

                    if ($objSolicitud != null) {
                        switch ($result[0]->verificacion) {
                            case 1:
                                $objSolicitud->estado = 'I';
                                $objSolicitud->save();
                                break;
                            case 0:
                                $objSolicitud->estado = 'E';
                                $objSolicitud->save();
                                break;
                        }

                    } else {
                        DB::rollback();
                        $array_response['status'] = 404;
                        $array_response['message'] = "Ups,Algo Ocurrio";
                    }
                    DB::commit();
                    $array_response['status'] = 200;
                    $array_response['message'] = "Grabado Exitosamente";
                } else {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = "Ups,Algo Ocurrio";
                }


            } else {
                DB::rollback();
                $array_response['status'] = 404;
                $array_response['message'] = "La solicitud ya se encuentra fuera de la bandeja";
            }


            if ($request->band > 0 && $request->band < 7) {
                DB::beginTransaction();
                try {

                    //Solicitud
                    $objSolicitudEdit = Solicitud::Find($request->solicitud_id);
                    switch ($request->band) {
                        //credito
                        case 1:

                            $objSolicitudEdit->n_solicitud_axis = $request->solicitud_axis;
                            $objSolicitudEdit->region = $request->region;
                            break;
                        //calidad
                        case 2:
                            $objSolicitudEdit->direccion_entrega = $request->direccion_entrega;
                            $objSolicitudEdit->entrega_ciudad_id = $request->ciudad_entrega;
                            $objSolicitudEdit->provincia_id = $request->provincia_entrega;
                            break;
                        //recepcion
                        case 3:
                            $objSolicitudEdit->entrega_ciudad_id = $request->ciudad_entrega;
                            $objSolicitudEdit->provincia_id = $request->provincia_entrega;

                            break;
                        //facturado
                        case 4:
                            $objSolicitudEdit->fecha_activacion = $request->fecha_activacion;
                            $objSolicitudEdit->ciclo_facturacion = $request->ciclo_facturacion;
                            $objSolicitudEdit->fecha_facturacion = $request->fecha_facturacion;
                            break;
                        //regularizado
                        case 5:
                            $objSolicitudEdit->lote = $request->lote;
                            $objSolicitudEdit->fecha_lote = $request->fecha_lote;
                            break;

                    }

                    $objSolicitudEdit->save();
                    
                    DB::beginTransaction();
                        try {
                            $objS = DB::connection('mysql_solicitudes')
                                        ->table('solicitud')
                                        ->where('n_solicitud', $request->solicitud_id)->get()->toArray();
                            if($request->lineas!=0)
                            {
                                foreach ($request->lineas as $item) {
                                    $objBusqueda = Lineas::where(['celular' => $item[4], 'estado' => 'A'])
                                    ->whereNotIn('solicitud_id',[$request->solicitud_id])
                                    ->get()->toArray();
                                    
                                    if ($request->band == 1) {
        
                                                if ($objBusqueda != []) {
        
                                                    throw new \Exception ("Ya se encuentra registrado el numero:" . $item[4]);
                                                }
                                                if($item[4]!=''&&$item[4]!=null)
                                                {
                                                    if (strlen($item[4]) < 10 || substr($item[4], 0, 2) != '09') {
                                                        throw new \Exception ("\n" . 'Formato no adecuado de Celular,' . $item[4]);
                                                    }
            
                                                }    
                                              
                                                $objLinea = new Lineas();
                                                $objS = DB::connection('mysql_solicitudes')
                                                ->table('solicitud')
                                                ->where('n_solicitud', $request->solicitud_id)->get()->toArray();
        
                                                $intCod = Lineas::where('solicitud_id', $request->solicitud_id)->delete(); 
        
                                      }else{
                                             $objLinea = Lineas::where(['celular' => $item[4], 'estado' => 'A'])->first();
                                       }
        
                                            $objLinea->solicitud_id = $request->solicitud_id;
                                            $objLinea->estado = 'A';
                                            $objLinea->cliente_id = $objS[0]->cliente_id;
                                            $objLinea->usuario_ing = $objS[0]->usuario_ing;
        
        
                                            if ($request->solicitud_axis != "0" && $request->solicitud_axis != null) {
                                                $objLinea->s_axis = $request->solicitud_axis;
                                            } else {
                                                $objLinea->s_axis = $item[1];
        
                                            }
                                            $objLinea->axisestado = $item[2];
                                            $objLinea->tipo_solicitud = $item[3];
                                            $objLinea->celular = $item[4];
                                            $objLinea->operadora = $item[5] != 0 || $item[5] != null ? $item[5] : 0;
                                            $objLinea->tipo_linea = $item[6] != 0 || $item[6] != null ? $item[6] : 0;
                                            $objLinea->simcard = $item[9];
                                            $objLinea->equipo = $item[8] != 0 || $item[8] != null ? $item[8] : 0;
                                            $objLinea->marca = $item[10];
                                            $objLinea->modelo = $item[11];
                                            $objLinea->imei = $item[12];
                                            $objLinea->bp_id = $item[13] != 0 || $item[13] != null ? $item[13] : 0;
                                            $objLinea->plan = $item[15];
                                            $objLinea->tarifa_basica = $item[16] != 0 || $item[16] != null ? $item[16] : 0;
                                            $objLinea->cuota = $item[17] != 0 || $item[17] != null ? $item[17] : 0;
                                            $objLinea->obsequio1 = $item[18] != 0 || $item[18] != null ? $item[18] : 0;
                                            $objLinea->obsequio2 = $item[19] != 0 || $item[19] != null ? $item[19] : 0;
                                            $objLinea->cobsequio1 = $item[20];
                                            $objLinea->cobsequio2 = $item[21];
                                            $objLinea->cedula_donante = $item[23];
                                            $objLinea->nombre_donante = $item[24];
                                            $objLinea->direccion_donante = $item[25];
                                            $objLinea->celular_donante = $item[26];
                                            $objLinea->n_cuenta_donante = $item[27];
                                            $objLinea->cedula_RL = $item[28];
                                            $objLinea->nombre_RL = $item[29];
                                            $objLinea->cargo_RL = $item[30];
                                            $objLinea->save();
        
                                    }
                                    DB::commit();
                                    $success = 1;
                            }
                            
                        
                       } catch (\Exception $e) {
                            DB::rollback();
                          $array_response['status'] = 404;
                           $array_response['message'] = $e->getMessage();
                       }

                } catch (\Exception $e) {
                    DB::rollback();
                    $array_response['status'] = 404;
                    $array_response['message'] = $e->getMessage();
                }

            }
              } catch (\Exception $e) {DB::rollback();
                $array_response['status'] = 404;
                $array_response['message'] =$e->getMessage();
              }
        }

        return response()->json($array_response, 200);
    }

    public function provinciaCiudad(request $request)
    {
        // dd($request->valor);
        $objSelect = new SelectController();
        $ciudad = $objSelect->searchCiudad($request->valor);

        return response()->json($ciudad, 200);
    }

    public function searchCedula(request $request)
    {

        if ($request->solicitud_id != 0) {

            $array_response['status'] = 300;
            $solicitud = DB::connection('mysql_solicitudes')
                ->table('solicitud as s')
                ->join('nextcore.users as u', 'u.id', 's.usuario_ing')
                ->join('empleados as emp', 'emp.identificacion', 'u.persona_id')
                ->where('s.n_solicitud', $request->solicitud_id)
                ->select('s.n_solicitud',
                    's.entrega_ciudad_id',
                    's.direccion_entrega',
                    's.provincia_id',
                    's.region',
                    's.celular_entrega',
                    's.estado',
                    's.empleado_id',
                    's.gestor_id',
                    's.cliente_id',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"),
                    's.usuario_mod',
                    's.created_at',
                    's.updated_at',
                    's.observacion',
                    's.tchip',
                    's.tobsequios',
                    's.tlineas',
                    's.n_solicitud_axis',
                    's.lote',
                    's.fecha_lote',
                    's.fecha_activacion',
                    's.ciclo_facturacion',
                    's.fecha_facturacion'
                )
                ->get()->toArray();
            $cliente = DB::connection('mysql_solicitudes')
                ->table('cliente AS C')
                ->where('C.identificacion', $solicitud[0]->cliente_id)->get()->toArray();
            $lineas = DB::connection('mysql_solicitudes')
                ->table('lineas AS l')
                ->where('l.solicitud_id', $request->solicitud_id)->get()->toArray();

            if (count($solicitud) > 0) {
                $array_response['solicitud'] = $solicitud;
            } else {
                $array_response['solicitud'] = 0;
            }

            if (count($cliente) > 0) {
                $array_response['cliente'] = $cliente;
            } else {
                $array_response['cliente'] = 0;
            }
            if (count($lineas) > 0) {
                $array_response['lineas'] = $lineas;
            } else {
                $array_response['lineas'] = 0;
            }
            if ((count($lineas) == 0) && (count($cliente) == 0) && (count($solicitud) == 0)) {
                $result = 0;
            } else {
                $result = 1;
            }
        } else {

            $result = DB::connection('mysql_solicitudes')
                ->table('cliente AS C')
                ->where('C.identificacion', $request->dato)->get()->toArray();
            if (count($result) > 0) {
                $array_response['status'] = 200;
                $array_response['message'] = $result;
            } else {
                $result = 0;
            }

        }
        if ($result == 0) {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";
        }

        return response()->json($array_response, 200);
    }

    public function SolicitudActiva(request $request)
    {

        $tiposolicitudG = 0;
        DB::beginTransaction();
        $array_response['status'] = 200;
        $array_response['message'] = "Grabado Exitosamente";
        try {
            $estadoVerificacion = DB::connection('mysql_solicitudes')
                ->table('bestados as be')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.departamento_id')
                ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'be.estado_linea_id')
                ->join('nextcore.tb_parametro as tbp3', 'tbp3.id', 'tbp2.parametro_id')
                ->where(['be.estado' => 'A'])
                ->where('be.solicitud_id', $request->id)
                ->select('tbp.descripcion as descripcion', 'tbp2.descripcion as estado')
                ->get()->toArray();
            if ($estadoVerificacion[0]->descripcion != 'BANDEJA_VALIDACION') {
                // dd(1);

                $objCambioGestor = DB::connection('mysql_solicitudes')->table('cambiogestor')->where(['solicitud_id' => $request->id, 'estado' => 'A'])->count();

                if ($objCambioGestor > 0) {
                    $objBandeja = DB::connection('mysql')
                        ->table('tb_parametro')
                        ->where(['descripcion' => 'SOLICITUD INGRESADA'])->select('id', 'parametro_id')->first();
                    $objCambioGestor = DB::connection('mysql_solicitudes')->table('cambiogestor')->where(['solicitud_id' => $request->id, 'estado' => 'A'])->update(['estado' => 'I']);

                    $today = new \DateTime("now");
                    $objSolicitud = Solicitud::where(['n_solicitud' => $request->id])->update(['created_at' => $today]);

                } else {
                    $objBandeja = DB::connection('mysql')
                        ->table('tb_parametro')
                        ->where(['descripcion' => 'SOLICITUD CORREGIDA'])->select('id', 'parametro_id')->first();
                }

            } else {


                if ($estadoVerificacion[0]->estado != 'SOLICITUD PREGRABADA') {
                    // dd($request->id);
                    $objCambioGestor = DB::connection('mysql_solicitudes')->table('cambiogestor')->where(['solicitud_id' => $request->id, 'estado' => 'A'])->count();

                    if ($objCambioGestor > 0) {
                        $objBandeja = DB::connection('mysql')
                            ->table('tb_parametro')
                            ->where(['descripcion' => 'SOLICITUD INGRESADA'])->select('id', 'parametro_id')->first();
                        $objCambioGestor = DB::connection('mysql_solicitudes')->table('cambiogestor')->where(['solicitud_id' => $request->id, 'estado' => 'A'])->update(['estado' => 'I']);

                        $today = new \DateTime("now");
                        $objSolicitud = Solicitud::where(['n_solicitud' => $request->id])->update(['created_at' => $today]);
                    } else {
                        $objBandeja = DB::connection('mysql')
                            ->table('tb_parametro')
                            ->where(['descripcion' => 'SOLICITUD CORREGIDA'])->select('id', 'parametro_id')->first();
                    }

                } else {
                    $objBandeja = DB::connection('mysql')
                        ->table('tb_parametro')
                        ->where(['descripcion' => 'SOLICITUD INGRESADA'])->select('id', 'parametro_id')->first();
                }

            }

            $objs = Solicitud::find($request->id);


            if ($objs != null && count($objs) > 0) {

                //Lineas
                $objLineas = DB::connection('mysql_solicitudes')
                    ->table('lineas')
                    ->where('solicitud_id', $request->id)->get()->toArray();

                $cl = count($objLineas);
                if ($cl > 0) {

                    $asrray1 = array();
                    $i = 0;
                    foreach ($objLineas as $item) {

                        $item->celular != '' || $item->celular != null ? $item->celular : $item->celular = 'No asignado';
                        if ($item->tipo_solicitud == 'Migracion') {
                            $tiposolicitudG = 1;
                        }

                        if (strlen($item->operadora) < 1 || $item->operadora == null || $item->operadora == '0') {

                            array_push($asrray1, "\n" . 'Operadora' . ',de la Linea: ' . $item->celular);
                        }

                        if (strlen($item->tipo_linea) < 1 || $item->tipo_linea == null || $item->tipo_linea == '0') {
                            array_push($asrray1, "\n" . 'Tipo de Linea' . ',de la Linea: ' . $item->celular);
                        }

                        if ($item->tipo_solicitud != 'Linea_Nueva') {
                            if (strlen($item->celular) < 10 || substr($item->celular, 0, 2) != '09') {
                                array_push($asrray1, "\n" . 'Formato no adecuado de Celular,' . $item->celular);
                            }
                        }
                        if ($item->bp_id == 0 || $item->bp_id == null) {
                            array_push($asrray1, "\n" . 'Codigo de BP' . ',de la Linea: ' . $item->celular);
                        }
                        if ($item->equipo == 0) {
                            if (strlen($item->marca) < 1 || $item->marca == null) {
                                array_push($asrray1, "\n" . 'marca' . ',de la Linea: ' . $item->celular);
                            }
                            if (strlen($item->modelo) < 1 || $item->modelo == null) {
                                array_push($asrray1, "\n" . 'modelo' . ',de la Linea: ' . $item->celular);
                            }
                        }
                        if (strlen($item->plan) == 0 || $item->plan == null) {
                            array_push($asrray1, "\n" . 'Plan' . ',de la Linea: ' . $item->celular);
                        }
                        if ($item->tarifa_basica == 0 || $item->tarifa_basica == null) {
                            array_push($asrray1, "\n" . 'Tárifa Básica' . ',de la Linea: ' . $item->celular);
                        }
                        if (strlen($item->tipo_solicitud) < 1 || $item->tipo_solicitud == null || $item->tipo_solicitud == '0') {
                            array_push($asrray1, "\n" . 'Tipo de Solicitud' . ',de la Linea: ' . $item->celular);
                        }
                        if ($item->tipo_solicitud == 'Transferencia_Beneficiario') {
                            if (strlen($item->n_cuenta_donante) < 1 || $item->n_cuenta_donante == null) {
                                array_push($asrray1, "\n" . 'N° de cuenta donante' . ',de la Linea: ' . $item->celular);
                            }
                            if (strlen($item->cedula_donante) < 1 || $item->cedula_donante == null) {
                                array_push($asrray1, "\n" . 'cedula_donante' . ',de la Linea: ' . $item->celular);
                            }
                            if (strlen($item->nombre_donante) < 1 || $item->nombre_donante == null) {
                                array_push($asrray1, "\n" . 'nombre_donante' . ',de la Linea: ' . $item->celular);
                            }
                            if (strlen($item->celular_donante) < 10 || $item->celular_donante == null || substr($item->celular_donante, 0, 2) != '09') {
                                array_push($asrray1, "\n" . 'Celular donante' . ',de la Linea: ' . $item->celular);
                            }
                            if (strlen($item->direccion_donante) < 0 || $item->direccion_donante == null) {
                                array_push($asrray1, "\n" . 'direccion_donante' . ',de la Linea: ' . $item->celular);
                            }
                            if($item->cedula_RL!='' || $item->nombre_RL!='' || $item->cargo_RL='')
                            {
                                if (strlen($item->cedula_RL) < 1 || $item->cedula_RL == null) {
                                    array_push($asrray1, "\n" . 'cedula Representante Legal' . ',de la Linea: ' . $item->celular);
                                }
                                if (strlen($item->nombre_RL) < 1 || $item->nombre_RL == null) {
                                    array_push($asrray1, "\n" . 'Nombre Representante Legal' . ',de la Linea: ' . $item->celular);
                                }
                                if (strlen($item->cargo_RL) < 1 || $item->cargo_RL == null) {
                                    array_push($asrray1, "\n" . 'Cargo Representante Legal' . ',de la Linea: ' . $item->celular);
                                }
                            }
                        }


                    }

                    if ($asrray1 != null) {
                        $array_response['status'] = 404;
                        $array_response['message'] = $asrray1;
                        throw new \Exception ("" . $array_response);
                    }
                } else {
                    $array_response['status'] = 404;
                    $array_response['message'] = "No posee Lineas Ingresadas";
                    //     throw new \Exception ("" . $array_response);
                }

                //SOLICITUD
                $obSolicitud = DB::connection('mysql_solicitudes')
                    ->table('solicitud')
                    ->where('n_solicitud', $request->id)->get()->toArray();

                $cl = count($obSolicitud);

                if ($cl > 0) {

                    $asrrays = array();
                    $i = 0;
                    foreach ($obSolicitud as $item) {
                        $observacion = $item->observacion;
                        if ($item->entrega_ciudad_id == 0 || $item->entrega_ciudad_id == null) {
                            array_push($asrrays, "\n" . 'Ciudad de Entrega' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if ($item->provincia_id == 0 || $item->provincia_id == null) {
                            array_push($asrrays, "\n" . 'Provincia de Entrega' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if (strlen($item->direccion_entrega) < 1 || $item->direccion_entrega == null) {
                            array_push($asrrays, "\n" . 'Dirección de Entrega' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if (strlen($item->observacion) < 1 || $item->observacion == null) {
                            array_push($asrrays, "\n" . 'Observación de la Solicitud' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if (strlen($item->region) < 1 || $item->region == null) {
                            array_push($asrrays, "\n" . 'Region de Entrega' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if (strlen($item->celular_entrega) < 10 || substr($item->celular_entrega, 0, 2) != '09') {
                            array_push($asrrays, "\n" . 'Celular de Entrega' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                        if (strlen($item->gestor_id) < 1 || $item->gestor_id == null || $item->gestor_id == 0) {
                            array_push($asrrays, "\n" . 'Elija un Gestor' . ',de la Solicitud: ' . $item->n_solicitud);
                        }
                    }
                    if ($asrrays != null) {
                        $array_response['status'] = 404;
                        $array_response['message'] = $asrrays;
                        throw new \Exception ("" . $array_response);
                    }
                } else {
                    $array_response['status'] = 404;
                    $array_response['message'] = "No se pudo encontrar Solicitud";
                    throw new \Exception ("" . $array_response);
                }

                //CLIENTE
                $objCliente = DB::connection('mysql_solicitudes')
                    ->table('cliente')
                    ->where('identificacion', $objs->cliente_id)->get()->toArray();

                $cl = count($objCliente);

                if ($cl > 0) {
                    $asrrayc = array();
                    $i = 0;
                    foreach ($objCliente as $item) {

                        if (strlen($item->nombres) < 1 || $item->nombres == null) {
                            array_push($asrrayc, "\n" . 'Nombres' . ',del Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->correo) < 1 || $item->correo == null) {
                            array_push($asrrayc, "\n" . 'Correo Válido' . ',del Cliente: ' . $item->identificacion);
                        }
                        if (filter_var($item->correo, FILTER_VALIDATE_EMAIL) == false) {
                            array_push($asrrayc, "\n" . 'No es un Correo Valido ' . ',del Cliente: ' . $item->identificacion);
                        }
                        if ($item->tipo_persona != 'JURIDICO') {
                            if (strlen($item->direccion_domicilio) < 1 || $item->direccion_domicilio == null) {
                                array_push($asrrayc, "\n" . 'Direccion del domicilio' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->referencia_domicilio) < 1 || $item->referencia_domicilio == null) {
                                array_push($asrrayc, "\n" . 'Referencia del domicilio' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->convencional) < 1 || $item->convencional == null) {
                                array_push($asrrayc, "\n" . 'Convencional' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->convencional_perteneciente) < 1 || $item->convencional_perteneciente == null) {
                                array_push($asrrayc, "\n" . 'Perteneciente del Convencional' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->movil) < 10 || $item->movil == null || substr($item->movil, 0, 2) != '09') {
                                array_push($asrrayc, "\n" . 'Error en formato del celular' . ',del Cliente: ' . $item->identificacion);
                            }
                            if ($item->ciudad_domicilio_id == 0 || $item->ciudad_domicilio_id == null) {
                                array_push($asrrayc, "\n" . 'Ciudad del domicilio' . ',del Cliente: ' . $item->identificacion);
                            }
                            if ($item->provincia_domicilio_id == 0 || $item->provincia_domicilio_id == null) {
                                array_push($asrrayc, "\n" . 'Provincia del domicilio' . ',del Cliente: ' . $item->identificacion);
                            }

                            if (strlen($item->fecha_nacimiento) < 1 || $item->fecha_nacimiento == null) {
                                array_push($asrrayc, "\n" . 'Fecha de Nacimiento' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->estado_civil) < 1 || $item->estado_civil == null) {
                                array_push($asrrayc, "\n" . 'Estado Civil' . ',del Cliente: ' . $item->identificacion);
                            }
                        } else {
                            if (strlen($item->cedula_RL) < 1 || $item->cedula_RL == null) {
                                array_push($asrrayc, "\n" . 'Cedula RL' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->nombre_RL) < 1 || $item->nombre_RL == null) {
                                array_push($asrrayc, "\n" . 'Nombre RL' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->fecha_vence_emp) < 1 || $item->fecha_vence_emp == null) {
                                array_push($asrrayc, "\n" . 'Fecha Vence Nombramiento RL' . ',del Cliente: ' . $item->identificacion);
                            }
                            if (strlen($item->cargo_RL) < 1 || $item->cargo_RL == null) {
                                array_push($asrrayc, "\n" . 'Correo' . ',del Cliente: ' . $item->identificacion);
                            }
                        }

                        //DATOS LABORALES

                        if (strlen($item->empresa) < 1 || $item->empresa == null) {
                            array_push($asrrayc, "\n" . 'Emrpesa donde labora' . ',el Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->direccion_laboral) < 1 || $item->direccion_laboral == null) {
                            array_push($asrrayc, "\n" . 'Dirección Laboral' . ',del Cliente: ' . $item->identificacion);
                        }
                        if ($item->ciudad_laboral_id == 0 || $item->ciudad_laboral_id == null) {
                            array_push($asrrayc, "\n" . 'Ciudad donde labora' . ',el Cliente: ' . $item->identificacion);
                        }
                        if ($item->provincia_laboral_id == 0 || $item->provincia_laboral_id == null) {
                            array_push($asrrayc, "\n" . 'Provincia donde labora' . ',el Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->convencional_laboral) < 1 || $item->convencional_laboral == null) {
                            array_push($asrrayc, "\n" . 'Convencional donde labora' . ',el Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->cargo) < 1 || $item->cargo == null) {
                            array_push($asrrayc, "\n" . 'Cargo donde labora' . ',el Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->tiempo_laboral) < 1 || $item->tiempo_laboral == null) {
                            array_push($asrrayc, "\n" . 'Tiempo que labora en la empresa' . ',del Cliente: ' . $item->identificacion);
                        }
                        if (strlen($item->ingresos_laboral) < 1 || $item->ingresos_laboral == null) {
                            array_push($asrrayc, "\n" . 'Ingresos en la empresa' . ',del Cliente: ' . $item->identificacion);
                        }
                        switch ($item->forma_pago) {
                            case 'DEBITO_BANCARIO':
                                if ($item->banco_id == 0 || $item->banco_id == null) {
                                    array_push($asrrayc, "\n" . 'Forma de pago Banco' . ',del Cliente: ' . $item->identificacion);
                                }
                                if ((strlen($item->cta_ahorro) < 1 || $item->cta_ahorro == null) && (strlen($item->cta_corriente) < 1 || $item->cta_corriente == null)) {
                                    array_push($asrrayc, "\n" . 'Cuenta del Banco' . ',del Cliente: ' . $item->identificacion);
                                }
                                break;
                            case 'TARJETA_CREDITO':
                                if (strlen($item->nombre_tarjeta) < 1 || $item->nombre_tarjeta == null) {
                                    array_push($asrrayc, "\n" . 'Nombre de la tarjeta' . ',del Cliente: ' . $item->identificacion);
                                }
                                if (strlen($item->numero_tarjeta) < 1 || $item->numero_tarjeta == null) {
                                    array_push($asrrayc, "\n" . 'Numero de la tarjeta' . ',del Cliente: ' . $item->identificacion);
                                }
                                if (strlen($item->codigo_seguridad_tarjeta) < 1 || $item->codigo_seguridad_tarjeta == null) {
                                    array_push($asrrayc, "\n" . 'Codigo de Seguridad de la tarjeta' . ',del Cliente: ' . $item->identificacion);
                                }

                                if ($item->vencimiento_tarjeta == '' || $item->vencimiento_tarjeta == null) {
                                    array_push($asrrayc, "\n" . 'Vencimiento de la tarjeta' . ',del Cliente: ' . $item->identificacion);
                                }

                                break;
                            case 'CONTRAFACTURA':

                                if ($tiposolicitudG != 0) {
                                    if ($item->valor_garantia == 0 || $item->valor_garantia == null) {
                                        array_push($asrrayc, "\n" . 'Valor de Garantía' . ',del Cliente: ' . $item->identificacion);
                                    }
                                } else {
                                    if (($item->banco_id == 0 || $item->banco_id == null) && (strlen($item->nombre_tarjeta) < 1 || $item->nombre_tarjeta == null)) {
                                        array_push($asrrayc, "\n" . 'Forma de pago Vacia' . ',del Cliente: ' . $item->identificacion);
                                    }
                                }
                                break;
                            default:
                                break;
                        }
                    }
                    if ($asrrayc != null) {
                        $array_response['status'] = 404;
                        $array_response['message'] = $asrrayc;
                        throw new \Exception ("" . $array_response);
                    }
                } else {
                    $array_response['status'] = 404;
                    $array_response['message'] = "No existe cliente relacion, contactese con Administrador";
                    throw new \Exception ("" . $array_response);
                }

                //FIN DE VALIDACIONES
            } else {
                $array_response['status'] = 404;
                $array_response['message'] = "No existen datos de Cliente";
                throw new \Exception ("" . $array_response);
            }


            if ($success = 1) {
                $objs->estado = 'A';
                $objs->save();

                $tiempo = Bestados::where(['solicitud_id' => $request->id, 'estado' => 'A'])
                    ->select('created_at')->get()->toArray();
                if (count($tiempo) > 0) {
                    $anteriorFecha = ($tiempo[0]['created_at']);
                    $anteriorFecha = new \DateTime($anteriorFecha);
                    $today = new \DateTime("now");
                    $diff = $anteriorFecha->diff($today);
                    $tiempoDiferencial = $diff->format('%d días %h:%i:%s');
                } else {
                    $tiempoDiferencial = '0 días 00:00:00';

                }


                $v = Bestados::where(['solicitud_id' => $request->id, 'estado' => 'A'])
                    ->update(['estado' => 'I']);


                $objBestados = new Bestados();
                $objBestados->departamento_id = $objBandeja->parametro_id;
                $objBestados->estado_linea_id = $objBandeja->id;
                $objBestados->estado = 'A';
                $objBestados->usuario_ing = Auth::user()->id;
                $objBestados->tiempo = $tiempoDiferencial;
                $objBestados->solicitud_id = $request->id;
                $objBestados->observacion = $observacion;
                $objBestados->save();
                DB::commit();
                $array_response['status'] = 200;
                $array_response['message'] = "Grabado Exitosamente";

            }


        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json($array_response, 200);
    }

    public function SolicitudEliminada(request $request)
    {

        DB::beginTransaction();
        try {
            $objBestado = Bestados::find($request->id);

            $objBestado->estado = 'E';
            $objBestado->save();
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

    public function SolicitudLiberada(request $request)
    {

        DB::beginTransaction();
        try {
            $objSolicitudLiberada = Solicitud_Liberada::where(['solicitud_id' => $request->id, 'estado' => 'A'])->get()->toArray();
            if ($objSolicitudLiberada != []) {
                $array_response['status'] = 404;
                $array_response['message'] = "Ya existe una solicitud Ingresada";
            } else {
                $objSolicitudLiberada = new Solicitud_Liberada();
                $objSolicitudLiberada->solicitud_id = $request->id;
                $objSolicitudLiberada->usuario_ingreso = Auth::user()->persona_id;
                $objSolicitudLiberada->observacion = $request->inputValue;


                if ($request->lider != 0) {
                    $objSolicitud = Solicitud::find($request->id);
                    $objSolicitud->estado = 'I';
                    $objSolicitud->save();
                    $objSolicitudLiberada->estado = 'I';
                } else {
                    $today = new \DateTime("now");
                    $momento = date_format($today, "Y/m/d H:i:s");
                    $objSolicitudLiberada->estado = 'A';
                    $txt = 'La solicitud:' . $request->id;
                    $txt .= "\n";
                    $txt .= "\nSe encuentra en peticion por el Asesor para re gestionar";
                    $txt .= "\n";
                    $txt .= 'Enviado: ' . $momento;
                    $txt .= "\n";
                    $txt .= "\n";
                    $subject = "Alerta - Peticion de Liberaracion de Solicitud";
                    $headers = "From: " . env('MAIL_ADMIN') . "\r\n" . "CC: " . env('COPIA_SISTEMA');
                    $to = $request->correo;
                    mail($to, $subject, $txt, $headers);


                }
                $objSolicitudLiberada->save();
                DB::commit();
                $array_response['status'] = 200;
                $array_response['message'] = "Grabado Exitosamente";
            }


        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Error al Grabar";
        }

        return response()->json($array_response, 200);
    }

    public function peticionLiberacionIndex()
    {
        $array = array();
        array_push($array, 'AdminCC');
        $var = Auth::user()->evaluarole($array);
        return view("modules.Solicitudes.peticionLiberacion")->with(['controlAdmin' => $var]);
    }

    public function SolicitudInactiva(request $request)
    {
        $objSolicitudLiberada = Solicitud_Liberada::where(['solicitud_id' => $request->id, 'estado' => 'A'])->update(['estado' => 'I']);
        $objSolicitud = Solicitud::find($request->id);
        $objSolicitud->estado = 'I';
        $objSolicitud->save();

        DB::beginTransaction();
        try {
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

    public function datatableSolicitudInactiva($dato)
    {
        $user = Auth::user();
        $array = array();
        array_push($array, 'AdminCC');
        $var = Auth::user()->evaluarole($array);

        $datatable1 = DB::connection('mysql_solicitudes')
            ->table('solicitud_liberacion as s')
            ->join('empleados as emp', 's.usuario_ingreso', 'emp.identificacion');
        if ($var == 0) {
            $datatable1 = $datatable1->where('s.estado', 'A');
            $datatable1 = $datatable1->where('emp.lider_empleado_id', $user->persona_id);
        }
        switch ($dato) {
            case 'A':
                $datatable1 = $datatable1->where('s.estado', 'A');
                break;
            case 'I':
                $datatable1 = $datatable1->where('s.estado', 'I');
                break;
        }
        $datatable1 = $datatable1->orderby('s.created_at', 'DSC')
            ->groupby(
                's.solicitud_id',
                's.observacion',
                'emp.apellidos',
                'emp.nombres',
                's.created_at',
                's.estado'
            )
            ->select(
                's.solicitud_id as Solicitud',
                's.observacion as Observacion',
                DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Usuario"),
                's.created_at as Fecha',
                's.estado as Estado'
            )->get();


        return DataTables::of($datatable1)
            ->addColumn('estado', function ($select) {
                switch ($select->Estado) {
                    case 'I':
                        return '<span class="label label-danger">Inactivo</span>';
                        break;
                    case 'A':
                        $result = DB::connection('mysql_solicitudes')->table('solicitud_liberacion')
                            ->where('solicitud_id', $select->Solicitud)->orderby('created_at', 'DSC')->take(1)->get()->toArray();
                        if ($result[0]->estado == 'I') {
                            return '<span class="label label-success">Activo</span>';

                        } else {
                            return '<span class="label label-success">Activo</span>&nbsp;<a href="#" onclick="PedirConfirmacion(\''
                                . $select->Solicitud . '\')" class="btn btn-xs btn-warning"><span class="fa fa-check"></span> </a>
                                ';
                        }

                        break;
                }


            })
            ->make(true);

    }

    function array_fill_keys($keyArray, $valueArray)
    {
        if (is_array($keyArray)) {
            foreach ($keyArray as $key => $value) {
                $filledArray[$value] = $valueArray[$key];
            }
        }
        return $filledArray;
    }

    public function concatenaObservaciones(request $request)
    {

        DB::beginTransaction();
        try {

            $asrray = array();
            $resultObservaciones = DB::connection('mysql_solicitudes')
                ->table('bestados as b')
                ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'b.departamento_id')
                ->where('b.solicitud_id', $request->solicitud_id)
                ->select('b.observacion as observacion', 'tbp.descripcion as bandeja')
                ->get()->toArray();


            foreach ($resultObservaciones as $observacione) {
                $asrray[$observacione->observacion] = $observacione->bandeja;

            }

            $bandejaHabilitadas = array_count_values($asrray);
            $keyHabilitadas = array_keys($bandejaHabilitadas);
            foreach ($keyHabilitadas as $key) {
                $Habilitadas[$key] = array_keys($asrray, $key);

            }

            if (count($resultObservaciones) > 0) {
                DB::commit();
                $array_response['status'] = 200;
                $array_response['message'] = $Habilitadas;
            } else {
                $array_response['status'] = 404;
                $array_response['message'] = "Error al Consultar datos";
            }

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Error al Consultar datos";
        }

        return response()->json($array_response, 200);
    }

    public function CantidadObsequio(request $request)
    {

        $asrray = array();
        DB::beginTransaction();
        try {
            $resultLineas = DB::connection('mysql_solicitudes')
                ->table('lineas as l')
                ->where('l.solicitud_id', $request->solicitud_id)
                ->select('l.obsequio1 as obsequio1', 'l.obsequio2 as obsequio2')
                ->get()->toArray();

            foreach ($resultLineas as $obsequios) {
                if ($obsequios->obsequio2 != "0" && $obsequios->obsequio2 != "" && $obsequios->obsequio2 != null) {
                    array_push($asrray, $obsequios->obsequio2);
                }
                if ($obsequios->obsequio1 != "0" && $obsequios->obsequio1 != "" && $obsequios->obsequio1 != null) {
                    array_push($asrray, $obsequios->obsequio1);

                }
            }
            $valoresObsequio = array_count_values($asrray);
            if (count($valoresObsequio) > 0) {
                DB::commit();
                $array_response['status'] = 200;
                $array_response['message'] = $valoresObsequio;
            } else {
                $array_response['status'] = 404;
                $array_response['message'] = "Error al Consultar datos";
            }

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = "Error al Consultar datos";
        }

        return response()->json($array_response, 200);
    }

    public function CambioEstados(request $request)
    {
        $objSelect = new SelectController();


        $verificac = $objSelect->dontBandeja([$request->bandeja], $request->solicitud, $request->valida);
        if ($verificac != 0) {
            $array_response['status'] = 200;

        } else {
            $array_response['status'] = 404;
        }

        return response()->json($array_response, 200);
    }
    public function  VentaNotificada(request $request)
    {
        $objSolicitud= Solicitud::find($request->solicitud);
        $objSolicitud->estado_venta=$request->venta;
        $objSolicitud->save();
        
        $array_response['status'] = 200;
        $array_response['message'] = "Grabado Correctamente";
        
        return response()->json($array_response, 200);
    }
    public function getDatatable($dato)
    {
        $user = Auth::user();

        $array = array();
        $array2 = array();
        $array3 = array();

        array_push($array, 'LiderCC');
        array_push($array2, ['AsesorCC', 'AsesorCredito', 'AsesorCalidad', 'AsesorRecepcion', 'AsesorRegularizacion']);
        array_push($array3, 'AdminCC');
        $var = Auth::user()->evaluarole($array);
        $var1 = Auth::user()->evaluarole($array2);
        $var2 = Auth::user()->evaluarole($array3);

        $datatable1 = DB::connection('mysql_solicitudes')
            ->table('solicitud as s')
            ->join('empleados as emp', 's.empleado_id', 'emp.identificacion')
            ->join('empleados as emp2', 'emp.lider_empleado_id', 'emp2.identificacion')
            ->join('cliente as cl', 's.cliente_id', 'cl.identificacion')
            ->join('bestados as be', 'be.solicitud_id', 's.n_solicitud')
            ->join('nextcore.tb_parametro as tbp1', 'tbp1.id', 'be.estado_linea_id')
            ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'be.departamento_id')
            ->where('be.estado', 'A');
        switch ($dato) {
            case 0:
                $datatable1 = $datatable1->whereIn('tbp1.descripcion', ['SOLICITUD INGRESADA', 'SOLICITUD CORREGIDA']);
                break;
            case 1:
                $datatable1 = $datatable1->where('s.estado', 'I');

                break;
            case 2:
                if ($var != 0 || $var2 != 0) {
                    $datatable1 = $datatable1->whereNotIn('tbp1.descripcion', ['SOLICITUD INGRESADA', 'SOLICITUD PREGRABADA', 'SOLICITUD CORREGIDA']);
                } elseif ($var1 != 0) {
                    $datatable1 = $datatable1->whereNotIn('s.estado', ['I']);

                }
                break;
            case 4:
                 $datatable1 = $datatable1->where(['tbp1.descripcion'=>'FACTURADO ACT']);
                 $datatable1 = $datatable1->whereNotIn('s.estado_venta', ['VENTA_NOTIFICADA']);

                break;
            default:
                break;

        }
        if ($var != 0 && $var2 == 0) {
            $datatable1 = $datatable1->where('emp.lider_empleado_id', $user->persona_id);

        } elseif ($var1 != 0 && $var2 == 0) {
            $datatable1 = $datatable1->where('emp.identificacion', $user->persona_id);

        }
        $datatable1 = $datatable1->orderby('s.created_at', 'DSC')
            ->groupby(
                's.celular_entrega',
                'cl.nombres',
                's.n_solicitud',
                'emp.apellidos',
                'emp.nombres',
                's.created_at',
                's.estado',
                's.tlineas',
                'tbp1.descripcion',
                'tbp2.descripcion',
                'emp2.correo_institucional',
                'cl.identificacion',
                's.fecha_activacion',
                's.estado_venta'
            )
            ->select(
                's.celular_entrega AS Contacto',
                'cl.nombres as Cliente',
                's.n_solicitud as Solicitud',
                DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Asesor"),
                's.created_at as Fecha_c',
                's.estado as estado',
                's.tlineas as total_l',
                'tbp1.descripcion as estado_linea',
                'tbp2.descripcion as departamento',
                'emp2.correo_institucional as clider',
                'cl.identificacion as identificacion',
                's.fecha_activacion as Fecha_activacion',
                's.estado_venta as estado_venta'

            )->get();

       // if ($var2 != 0) {
            return DataTables::of($datatable1)
            ->addColumn('DetalleEstado',function($select)
            {
                $detalle='<table class="tablacorta">
                <tr>
                <td><strong>Departamento:</strong></td>
                <td>'.$select->departamento.'</td>
                </tr>
                <tr>
                <td><strong>Ultimo Estado:</strong></td>
                <td>'.$select->estado_linea.'</td>
                </tr>
                <tr>
                <td><strong>Fecha de Estado:</strong></td>
                <td>'.$select->Fecha_c.'</td>
                </tr>';
                if($select->estado_linea=='FACTURADO ACT')
                {
                    $detalle.='<tr>
                    <td><strong style="color:#004eff">Fecha de Activacion:</strong></td>
                    <td>'.$select->Fecha_activacion.'</td>
                    </tr>';
                }
                
                $detalle.='</table>';
                    return $detalle;
            })
            ->addColumn('total_lineas', function ($select)use($var2,$var){

                $tipo = 'linea';
                $idcelular = 0;

                $lineas = DB::connection('mysql_solicitudes')
                    ->table('lineas')
                    ->where('solicitud_id', $select->Solicitud)
                    ->get()->toArray();

                $lineaHtml = '';
                $cont = 0;
                $celular=0;
                $tipo='Solicitud';
                foreach ($lineas as $item) {
                    $idcelular = $item->id;
                    $tipo='linea';
                  $editaropcion='<a href="#" onclick="changeDatatablemenuLi(\''. $tipo . '\',\''. $select->Solicitud . '\',\''. $item->celular . '\')" data-hover="tooltip" data-placement="top"
                  data-target="#ModalLinea" data-toggle="modal" id="modal" class="" style="color:"#ccc,font-size:12px">'.$item->celular.'</a>';
                  $cont++; 
                  if ($item->celular != null && $item->celular != '') {
                        if($item->estado!='A')
                        {
                            $label='<span class="dot" style="background-color: #33ffff!important"></span>';
                        }else{
                            $label='<span class="dot" style="background-color: #33ffff!important"></span>';

                        }
                        
                        $lineaHtml .= '<li><p>'.$label.' '.$editaropcion.'<span style="float:right"></span></p></li>';
                        
                    } else {
                        $lineaHtml .= '<li><p>Linea No definida<span style="float:right"></span></p></li>';

                    }
                    if($cont==$select->total_l)
                    {
                        $celular=0;
                        $tipo='Solicitud';
                        $editaropcion='<a href="#" onclick="changeDatatablemenuLi(\''. $tipo . '\',\''. $select->Solicitud . '\',\''. $celular . '\')" data-hover="tooltip" data-placement="top"
                        data-target="#ModalLinea" data-toggle="modal" id="modal" class="" style="color:"#ccc,font-size:12px">Todos</a>';
                        $lineaHtml=$lineaHtml.'<li><p>'.$editaropcion.'<span style="float:right"></span></p></li>';
                    }
                }
                $admin='';
               // $todos='<li><a href="#" onclick="changeDatatablemenuLi(\''. $tipo . '\',\''. $select->Solicitud . '\',\''. $celular . '\')" data-hover="tooltip" data-placement="top"
               // data-target="#ModalLinea" data-toggle="modal" id="modal" class="" style="color:"#ccc,font-size:12px">Todos</a></li>';
                if($var2!=0||$var!=0)
                {
                    $admin='href="#" rel="popover" data-trigger="focus" data-popover-content="#list-popover'.$select->Solicitud.'"';
                }
               
                return $select->Solicitud.'&nbsp<a '.$admin.'<span class="label label-warning" style="font-size:13px">'.$select->total_l.'</span></span></a>

                <div id="list-popover'.$select->Solicitud.'" class="hide">
                  <ul class="nav nav-pills nav-stacked">
                  '.$lineaHtml.'
                  </ul>
                </div>';
               // return $select->Solicitud.''.'<div class="label label-warning label-sm tooltip">'.'<a onclick="changeDatatablemenuLi(\''. $tipo . '\',\''. $select->Solicitud . '\',\''. $celular . '\')" data-placement="top"
               // data-target="#ModalLinea" data-toggle="modal" id="modal2" class="label" style="font-size:12px">'.$select->total_l.$admin.'</a></div>';

            })

                ->addColumn('Contactos', function ($select) use ($var, $user,$var1,$var2) {
                    if($var1!=0)
                    {
                        $libera = 'libera';
                    }else
                    {
                        $libera = 'libera_Lider';
                    }
                    $objSelect = new SelectController();
                    $verificac = $objSelect->dontBandeja(['BANDEJA_VALIDACION'], $select->Solicitud, 1);

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
                        ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'be.departamento_id')
                        ->where('be.estado', 'A')
                        ->where('be.solicitud_id', $select->Solicitud)
                        ->select("tbp.descripcion as uestado", "be.adendum_cdc as adendum_sp",
                            "be.castigo_cartera_cdc as castigoc_sp", "be.consumo_cdc as consumo_sp",
                            "be.financimiento_cdc as financiamiento_sp", "be.otros_cdc as otros_sp",
                            "be.total_cdc as tcredito_sp", "be.inicio_deuda as inicio_deuda","tbp2.descripcion as departamento")
                        ->get()->toArray();

                    $resultcliente = DB::connection('mysql_solicitudes')
                        ->table('cliente')
                        ->where('identificacion', $result[0]->cliente_id)
                        ->get()->toArray();

                    $data = $result[0];
                    $dataCliente = $resultcliente[0];
                    $dataUEstado = $resultUEstado[0];

                    $liberacionConsulta = $resultUEstado = DB::connection('mysql')
                        ->table('tb_parametro as tbp')
                        ->join('tb_parametro as tbp2', 'tbp2.id', 'tbp.parametro_id')
                        ->where('tbp.descripcion', 'like', $dataUEstado->uestado)
                        ->select('tbp.verificacion as v', 'tbp2.verificacion as v2')
                        ->first();

                    if (($liberacionConsulta->v == $liberacionConsulta->v2) && $verificac == 0 && $dataUEstado->departamento!='BANDEJA_REGULARIZACION') {
                        $liberacion = '&nbsp;<p><a href="#" onclick="PedirConfirmacionLibera(\''
                            . $select->Solicitud . '\',\'' . $libera . '\',\'' . $select->clider . '\')"

                                                               class="label label-danger">
                                                                <span class="fa fa-check"></span> Liberar</a></p>';
                    } else {
                        $liberacion = '';
                    }


                    if ($dataUEstado->uestado == 'CAMBIO_DE_INGRESO') {
                        $nueva = 1;
                    } else {
                        $nueva = 0;
                    }

                    if (count($result) > 0) {
                        $ruser = $result[0]->usuario_ing;
                    } else {
                        $ruser = 0;
                    }
                    $prefijo=Auth::user()->prefijo;
                    $extension=Auth::user()->extension;
                    $veditar=0;
                     if($select->estado=='I')
                     {
                        $veditar=1;
                     }
                     
                        $verificaestado = DB::connection('mysql_solicitudes')
                        ->table('bestados as a');

                         $verifica = $verificaestado->join('nextcore.tb_parametro as tp', 'tp.id', 'a.estado_linea_id')
                        ->join('solicitud as s', 's.n_solicitud', 'a.solicitud_id')
                        ->where(['a.estado' => 'A'])
                        ->where('s.estado', 'A')
                        ->whereIn('tp.descripcion', ['SOLICITUD INGRESADA', 'SOLICITUD PREGRABADA', 'SOLICITUD CORREGIDA'])
                        ->where('a.solicitud_id', $select->Solicitud)
                        ->get()->toArray();

                        $editarOpcion = '<a href="#" onclick="EditChangesPro(\''
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
                        valor_garantia . '\',\'' . $veditar . '\',\''
                        . $dataCliente->
                        deposito_garantia . '\',\''
                        . $nueva . '\',\''
                        . $var . '\',\''
                        . $extension . '\',\''
                        . $prefijo . '\'
                                                                                            )"
                                                               data-hover="tooltip" data-placement="top"
                                                               data-target="#Modalagregar" data-toggle="modal" id="modal"
                                                               class="label label-primary" title="Editar">
                                                                <span class="fa fa-edit"></span>&nbsp;'.$select->Contacto.'</a>';

                            if (count($verifica) > 0) {
                                $estado = "Pendiente de Estado";
                                $class = "warning";
                            } else {
                                $estado = "Solicitud Enviada";
                                $class = "primary";
                                if($select->estado=='A')
                                {
                                    $editarOpcion = '<span class="label label-warning">'.$select->Contacto.'</span>';
                                    if($select->estado_linea=='FACTURADO ACT'&& $select->estado_venta!=''&& 
                                        $select->estado_venta!=null&&$select->estado_venta!='VENTA_NOTIFICADA')
                                    {
                                        $select_NC='';
                                        $select_VN='';
                                        $select_VL='';

                                        switch($select->estado_venta)
                                        {
                                            case 'NO_CONTESTA':
                                            $select_NC='selected';
                                            break;
                                            case 'VENTA_NOTIFICADA':
                                            $select_VN='selected';

                                            break;
                                            case 'VOLVER_LLAMAR':
                                            $select_VL='selected';
                                            break;
                                        }
                                        $editarOpcion = '<a href="#" class="label label-warning" onclick="llamadaOb(
                                        \''
                                        . $select->Contacto . '\',
                                        \''
                                        . $extension . '\',
                                        \''
                                        . $prefijo . '\'
                                                                                                            )"">
                                           <span class="fa fa-phone"></span>&nbsp;'.$select->Contacto.'</a>';
                                           $editarOpcion.='<p><select id="venta_notificada" class="input-sm">
                                           <option value="NO_CONTESTA" '.$select_NC.'>NO CONTESTA</option>
                                           <option value="VENTA_NOTIFICADA" '.$select_VN.'>VENTA NOTIFICADA</option>
                                           <option value="VOLVER_LLAMAR" '.$select_VL.'>VOLVER A LLAMAR</option>
                                           </select>
                                           <a onclick="estadoVenta( \''
                                           . $select->Solicitud . '\')"><span class="fa fa-check-circle"></span></a>
                                           </p>';
                                    }
                                }
                            }

                  
                    
                
                    $seguimiento='<a href="#" onclick="SeguimientoChanges(\''
                    . $select->Solicitud . '\',\''
                    . $var . '\',\''
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
                                                                                   class="label label-success" title="Seguimiento">
                                                                                    <span class="fa fa-eye"></span></a>';

                    switch ($select->estado) {
                        case 'I':
                        

                            if ($user->id != $ruser&&$var1!=0&&$var2!=1) {
                                $muestra = '<p ><span class="label label-danger">Pendiente de Asesor</span></p>';
                               
                                }else{
        
                                    $activar='<a href="#" onclick="PedirConfirmacion(\'' . $select->Solicitud . '\',\'' . 'activa' . '\')"
                                                  class="label label-primary" title="Activar">
                                                <span class="fa fa-check"></span></a>';
                           
                                    $muestra = '<p ><span class="label label-danger">Pendiente de Asesor</span></p>
                                            <p>'.$editarOpcion.'<p>'.$activar.''. $seguimiento.'</p>
                                            </p>';
                                }
                        
                            return $muestra;
                            break;
                        case 'A':
                              
                            if($var2!=1&&$var!=1)
                            {
                                $editarOpcion = '<span class="label label-warning">'.$select->Contacto.'</span>';
                                $class='primary';
                                $estado='Solicitud Enviada';
                            }
                            $muestra = '<span class="label label-' . $class . '">' . $estado . '</span>
                            <p>' . $editarOpcion .  $seguimiento . $liberacion . '</p>';
                             
                            return $muestra;

                            break;

                        case 'E':
                            $numero='<span class="label label-warning">'.$select->Contacto.'</span>';
                            return '<span class="label label-success">Finalizado</span>'.'<p>'. $numero.$seguimiento.'</p>';
                            break;
                    }

                })->rawColumns(['total_lineas'])
                ->make(true);
     
    }

    public function getDatatableSeguimiento($id)
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
                    'g.observacion',
                    'g.created_at',
                    'g.Tiempo',
                    'tbp.descripcion',
                    'g.estado',
                    'tbp2.descripcion')
                ->select('g.id as id',
                    DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as Usuario"),
                    'g.observacion as Observacion',
                    'g.created_at as Fecha_e',
                    'g.tiempo as Tiempo',
                    'tbp.descripcion as estado_Solicitud',
                    'g.estado as est',
                    'tbp2.descripcion as departamento')
                ->get()

        )->addColumn('Estado_Solicitud', function ($select) use ($variable, $variable1) {

            $variable = $this->solicitudesIngresadas;
            $variable1 = $this->solicitudesIngresadas1;
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

                switch ($select->est) {
                    case 'I':
                        return '<p ><span class="label label-success">Revisado</span></p>
                               ';
                        break;
                    case 'A':
                        return '<span class="label label-warning">En Gestión</span>
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
}
