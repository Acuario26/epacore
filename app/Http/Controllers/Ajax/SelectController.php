<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class SelectController extends Controller
{
    private function transform($result, $response)
    {
        if (count($result) > 0) {
            if ($response == 'json') {
                return response()->json(['data' => $result], 200);
            } else {
                return $result;
            }
        } else {
            if ($response == 'json') {
                return response()->json(['No hay registros'], 404);
            } else {
                return response()->view('errors.503', [], 503);

                //abort(401);
            }
        }
    }

    public function dontBandeja($bandeja, $solicitud, $si, $verifica = 0)
    {

        $estadoVerificacion = DB::connection('mysql_solicitudes')
            ->table('bestados as be')
            ->join('nextcore.tb_parametro as tbp', 'tbp.id', 'be.departamento_id')
            ->join('nextcore.tb_parametro as tbp2', 'tbp2.id', 'be.estado_linea_id')
            ->join('nextcore.tb_parametro as tbp3', 'tbp3.id', 'tbp2.parametro_id')
            ->where(['be.estado' => 'A'])
            ->where('be.solicitud_id', $solicitud)
            ->select('tbp.descripcion as descripcion', 'be.estado_linea_id as estado', 'tbp2.verificacion as verificaEstado', 'tbp3.verificacion as verificabandeja')
            ->get()->toArray();
     //   dd($estadoVerificacion);
        if ($estadoVerificacion[0]->verificaEstado > $estadoVerificacion[0]->verificabandeja && $bandeja[0] == 'BANDEJA_VALIDACION') {

            return $this->transform(0, 'http');

        }elseif ($estadoVerificacion[0]->descripcion == $bandeja[0]) {
            return $this->transform(1, 'http');
        } else {
            $objBandeja = DB::connection('mysql')
                ->table('tb_parametro')
                ->whereIn('descripcion', $bandeja)
                ->select('id', 'descripcion')->get()->toArray();

            $arrayBandeja = array();
            foreach ($objBandeja as $item) {
                array_push($arrayBandeja, $item->id);
            }


            if ($si) {
                $verifica = DB::connection('mysql_solicitudes')
                    ->table('bestados as a')
                    ->join('nextcore.tb_parametro as tp', 'tp.id', 'a.estado_linea_id')
                    ->join('solicitud as s', 'n_solicitud', 'a.solicitud_id')
                    ->where(['a.estado' => 'A'])
                    ->where('s.estado', 'A')
                    ->where('tp.descripcion', 'SOLICITUD INGRESADA')
                    ->where('a.solicitud_id', $solicitud)
                    ->count();
                $var1 = 0;
                $var2 = 1;
            } else {
                $verifica = DB::connection('mysql_solicitudes')
                    ->table('bestados')
                    ->where(['estado' => 'A'])
                    ->where('solicitud_id', $solicitud)
                    ->whereIn('departamento_id', $arrayBandeja)
                    ->count();
                $var1 = 1;
                $var2 = 0;
            }

            if ($verifica > 0) {
                return $this->transform($var2, 'http');

            } else {
                return $this->transform($var1, 'http');
            }
        }

    }

    public function searchCiudad($parametro, $type = 'json')
    { 
        $result = DB::connection('mysql')
            ->table('tb_parametro AS C')
            ->where('C.parametro_id', $parametro)
            ->where('C.estado', 'A')
            ->groupBy('C.descripcion', 'C.id')
            ->orderBy('C.descripcion', 'DSC')
            ->select('C.id as id', 'C.descripcion as descripcion')->get();

            //dd($result);

        if (count($result) > 0) {
            //$result = $result->get('descripcion', 'id');
            //$lista['data'] = $result;
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";
        }

        

        return $array_response;


    }

    public function getPermission($id, $type = 'json')
    {
        $result = DB::connection('mysql')
            ->table('menus AS f')
            ->join('role_has_permission as h', 'h.permission_id', 'f.id')
            ->where('h.role_id', '=', $id)
            ->groupBy('f.id', 'f.name')
            ->orderBy('f.name', 'DSC')
            ->select('f.id as id', 'f.name as name');
        if ($type == 'json') {
            $result = $result->get('id');
            $lista['data'] = $result;
            return response()->json($lista, 200);
        } else {
            $result = $result->pluck('id')->toArray();
            return $result;
        }

    }

    public function getParametro($parametro, $type = 'json', $v = 0)
    {
        $result1 = DB::connection('mysql')
            ->table('tb_parametro AS C')
            ->where('C.descripcion', $parametro)
            ->where('C.estado', 'A')
            ->select('C.id as id')->first();
        if($result1!=null)
        {
            $result = DB::connection('mysql')
            ->table('tb_parametro AS C')
            ->where('C.parametro_id', $result1->id)
            ->where('C.estado', 'A');
                if ($v == 1) {
                    $result = $result->whereNotIn('C.descripcion', ['SOLICITUD INGRESADA', 'SOLICITUD PREGRABADA','SOLICITUD CORREGIDA']);
                }
                $result = $result->groupBy('C.descripcion', 'C.id')
                    ->orderBy('C.descripcion', 'DSC')
                    ->select('C.id as id', 'C.descripcion as descripcion');

                if ($type == 'json') {
                    $result = $result->get('descripcion', 'id');
                    $lista['data'] = $result;
                    return response()->json($lista, 200);
                } else {
                    if ($v == 3) {
                        $result = $result->pluck('id', 'descripcion')->toArray();
                    } else {
                        $result = $result->pluck('descripcion', 'id')->toArray();

                    }
                    return $result;
                }
        }else
                return [];
     
    }

    public function getParameterFathera($parameter, $type = 'json')
    {
        $result = DB::connection('mysql')
            ->table('tb_parametro AS C')
            ->where('nivel', $parameter - 1)
            ->where('C.estado', 'A')
            ->groupBy('C.id', 'C.descripcion')
            ->orderBy('C.descripcion', 'DSC')
            ->select('C.id as id', 'C.descripcion as descripcion');
        if ($type == 'json') {
            $result = $result->get('descripcion', 'id');
            $lista['data'] = $result;
            return response()->json($lista, 200);
        } else {
            $result = $result->pluck('descripcion', 'id')->toArray();
            return $result;
        }
    }

    public function getfatherparameter($response = 'http')
    {
        $result = DB::connection('mysql')
            ->table('tb_parametro AS F')
            ->where('F.estado', 'A')
            ->select('F.id AS id', 'F.descripcion as descripcion')
            ->orderBy('descripcion', 'DSC')->pluck('descripcion', 'id')->toArray();

        return $this->transform($result, $response);
    }

    public function getGestores($role, $response = 'http')
    {
        $result = DB::connection('mysql')
            ->table('model_has_roles as r')
            ->join('users as u', 'r.model_id', 'u.id')
            ->join('solicitudes.empleados as emp', 'u.persona_id', 'emp.identificacion')
            ->where('r.role_id', $role)
            ->select('emp.identificacion as id', DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))
            ->pluck('name', 'id')->toArray();
        return $this->transform($result, $response);
    }

    public function getFather($response = 'http')
    {
        $result = DB::connection('mysql')
            ->table('menus AS F')
            ->where('F.parent', '0')
            ->where('F.enabled', '1')
            ->select('F.id AS id', DB::raw('RTRIM(F.name) AS name'))
            ->orderBy('name', 'DSC')->pluck('name', 'id')->toArray();

        return $this->transform($result, $response);
    }

}
