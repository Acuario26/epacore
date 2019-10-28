<?php

namespace App\Http\Controllers\Report;

use App\Core\Entities\Admin\tb_parametro;
use App\Core\Entities\Solicitudes\Empleados;
use App\Core\Entities\Solicitudes\Asignaciones;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class UathController extends Controller
{
    //Reporteria
    public function index()
    {
        return view("modules.Report.aindex");
    }

    public function prueba(request $request)
    {

        if ($request->fechai == null || $request->fechaf == null) {
            $array_response['status'] = 404;
            $array_response['message'] = "No pueden estar vacio los intervalos de fechas";
        } else {
            $datetime1 = date_create($request->fechaf); //fecha actual
            $datetime2 = date_create($request->fechai); //fecha de db
            $interval = date_diff($datetime1, $datetime2, false);
            $dias = intval($interval->format('%R%a'));
            if (($dias < 0) || ($dias == 0)) {
                $result = DB::connection('mysql_prueba')
                    ->table('bestados as be')
                    ->join('bases as b', 'be.base_id', 'b.id')
                    ->whereBetween('b.fecha_ing', [$request->fechai, $request->fechaf])
                    ->select('b.tipo_linea as tipo_linea',
                        'b.operadora as operadora',
                        'be.estado as estado',
                        'b.region as region',
                        'b.tipo_solicitud as tipo_solicitud')->get()->toArray();

                if (count($result) > 0) {
                    $array_response['status'] = 200;
                    $array_response['message'] = $result;
                } else {
                    $array_response['status'] = 404;
                    $array_response['message'] = "No hay resultado en su reporte. Recuerde Utilizar la ultima columna para la reporteria detallada";

                }
            } else if ($dias > 0) {
                $array_response['status'] = 404;
                $array_response['message'] = "La Fecha es menor a la fecha Inicial";
            }
        }

        return response()->json($array_response, 200);
    }

    public function prueba2(request $request)
    {
        $result = DB::connection('mysql_prueba')
            ->table('bestados as be')
            ->join('bases as b', 'be.base_id', 'b.id')
            ->where('b.' . $request->r, $request->id)
            ->select('b.fecha_ing as fecha_ing',
                'b.estado as estado',
                'b.identificacion as identificacion',
                'b.nombre as nombre',
                'b.provincia as provincia',
                'b.n_solicitud as n_solicitud',
                'b.celular as celular',
                'b.operadora as operadora',
                'b.tipo_solicitud as tipo_solicitud',
                'b.tipo_linea as tipo_linea'
            )->get()->toArray();
        if (count($result) > 0) {
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "Recuerde Utilizar la ultima columna para la reporteria detallada solamente en la vista principal";

        }


        return response()->json($array_response, 200);
    }

    //Empleados
    public function DirectorioIndex()
    {
        $objSelect = new SelectController();
        $ciudad = $objSelect->getParametro('CIUDADES', 'http');
        $cargo = $objSelect->getParametro('AREA', 'http');
        $departamentos = $objSelect->getParametro('DEPARTAMENTOS', 'http');

        return view("modules.Uath.index",compact(['ciudad', 'cargo','departamentos']));
    }

    public function EditarPerfil()
    {
        $objSelect = new SelectController();
        $provincia = $objSelect->getParametro('PROVINCIA', 'http');
        //$ciudad = $objSelect->getParametro('CIUDAD', 'http');

        $cargo = $objSelect->getParametro('CARGO', 'http');
        $lider = DB::connection('mysql_solicitudes')
            ->table('empleados AS emp')
            ->select('emp.identificacion as identificacion', DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))
            ->get()->pluck('name', 'identificacion');
        $user = Auth::user();
        $result = DB::connection('mysql_solicitudes')
            ->table('empleados')
            ->where('identificacion', $user->persona_id)->get()->toArray();
        $ciudad = DB::connection('mysql')
            ->table('tb_parametro')
            ->where('parametro_id', $result[0]->provincia_id)
            ->select('id', 'descripcion')
            ->get()->pluck('descripcion', 'id');

        return view('admin.users.editarPerfil')->with(['provincia' => $provincia, 'user' => $user, 'ciudad' => $ciudad, 'cargo' => $cargo, 'lider' => $lider, 'result' => $result[0]]);
    }
    public function DirectorioBandejasUser(request $request)
    {

        DB::beginTransaction();

        try {
            $arrayUsuario=Asignaciones::where('usuario',$request->identificacion)
                            ->select("departamento_id")->get()->pluck("departamento_id");
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] =  $arrayUsuario;

        } catch (\Exception $e) {
            DB::rollback();
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
        }

        return response()->json($array_response, 200);
    }

    
    public function SaveDirectorio(request $request)
    {
        DB::beginTransaction();
        
        try {
            if($request->id!=0)
            {
                $objEmpleado = Empleados::Find($request->id);
            }else
            {
                $objEmpleado = new Empleados();

            }
            $objEmpleado->identificacion = $request->identificacion;
            $objEmpleado->nombres = $request->nombres;
            $objEmpleado->apellidos = $request->apellidos;
            $objEmpleado->ciudad_id = $request->ciudad_id;
            $objEmpleado->convencional = $request->convencional;
            $objEmpleado->celular = $request->celular;
            $objEmpleado->ing_empresa = $request->ing_empresa;
            $objEmpleado->direccion = $request->direccion;
            $objEmpleado->cargo_id = $request->cargo;
            $objEmpleado->email = $request->email;
            $objEmpleado->usuario_ing = Auth::user()->id;
            $objEmpleado->usuario_mod = Auth::user()->id;
            $objEmpleado->estado = 'A';
            $objEmpleado->save();
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Grabado Exitosamente ';


        } catch (\Exception $e) {
            DB::rollback();

            $array_response['status'] = 404;
            $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
        }

        return response()->json($array_response, 200);


    }

    public function getDatatable()
    {

        return DataTables::of(
            DB::connection('mysql')
                ->table('empleados AS p')
                ->join('core.tb_parametro as tbp', 'p.ciudad_id', 'tbp.id')
                ->select('p.id as id',
                    'p.identificacion as identificacion',
                    DB::raw("CONCAT(p.apellidos,' ',p.nombres) as name"),
                    'p.apellidos as apellidos',
                    'p.nombres as nombres',
                    'p.ciudad_id as ciudad_id',
                    'p.direccion as direccion',
                    'tbp.descripcion as ciudad',
                    'p.convencional as convencional',
                    'p.celular as celular',
                    'p.ing_empresa as ing_empresa',
                    'p.email as email',
                    'p.estado as estado',
                    'p.usuario_ing as usuario_ing',
                    'p.usuario_mod as usuario_mod',
                    'p.created_at as created_at',
                    'p.updated_at as updated_at',
                    'p.cargo_id as cargo_id'
                )
                ->get()

        )->addColumn('actions', function ($select) {

            $var= '<a href="#" onclick="EditChanges(\'' .
                $select->id . '\',\'' .
                $select->identificacion . '\',\'' .
                $select->apellidos . '\',\'' .
                $select->nombres . '\',\'' .
                $select->ciudad_id . '\',\'' .
                $select->direccion . '\',\'' .
                $select->convencional . '\',\'' .
                $select->celular . '\',\'' .
                $select->ing_empresa . '\',\'' .
                $select->email . '\',\'' .
                $select->estado . '\',\'' .
                $select->cargo_id . '\')"
                               data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"
                               class="label label-primary">
                        <span class="glyphicon glyphicon-edit"></span></a></small>';
                if($select->estado!='I')
                {
                    $var.='<a href="#" onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . 'delete' . '\')"
                    class="label label-danger">
             <span class="glyphicon glyphicon-trash"></span></a></small>';
                }else {
                    $var.='<a href="#" onclick="PedirConfirmacion(\'' . $select->id . '\',\'' . 'activar' . '\')"
                               class="label label-success">
                        <span class="glyphicon glyphicon-check"></span></a></small>
                        ';
                }
                        return $var;
        })->addColumn('estados', function ($select) {

            switch ($select->estado) {
                case 'A':
                    $result = '<span class="label label-primary">Activo</span>';
                    break;
                case 'I':
                    $result = '<span class="label label-danger">Inactivo</span>';
                    break;
                default:
                    $result = '<span class="label label-success">Sin Estado</span>';

                    break;
            }
            return $result;
        })
            ->make(true);
    }

    public function DirectorioEliminar(request $request)
    {

        DB::beginTransaction();

        try {
            $objEmpleado = Empleados::Find($request->id);

            if ($request->band != 0) {
                $objEmpleado->estado = 'I';
                $objUser = User::where('persona_id', $request->id)->update(['estado' => 'I']);

            } else {
                $objEmpleado->estado = 'A';
                $objUser = User::where('persona_id', $request->id)->update(['estado' => 'A']);

            }

            $objEmpleado->save();

            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Realizado la acción Exitosamente ';


        } catch (\Exception $e) {
            DB::rollback();

            $array_response['status'] = 404;
            $array_response['message'] = 'Error al intentar realizar la acción' . $e->getMessage();
        }
        return response()->json($array_response, 200);
    }


}
