<?php

namespace App\Http\Controllers\Entrevistas;

use App\Core\Entities\Entrevistas\Perfil;
use App\Core\Entities\Entrevistas\Postulantes;
use App\Http\Controllers\Ajax\SelectController;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class EntrevistadorController extends Controller
{
    public function DirectorioIndex()
    {
        $objSelect = new SelectController();
        $provincia = $objSelect->getParametro('PROVINCIA', 'http');
        $lider = DB::connection('mysql_solicitudes')
            ->table('empleados AS emp')
			->join('nextcore.tb_parametro as tbp','emp.cargo_id','tbp.id')
            ->select('emp.identificacion as identificacion', DB::raw("CONCAT(emp.apellidos,' ',emp.nombres) as name"))
			->where('tbp.descripcion','Entrevistador')
            ->get()->pluck('name', 'identificacion');
        $estado = $objSelect->getParametro('ESTADOS_POSTULANTES', 'http');
        $estado['TODOS']='TODOS';
        $estados= $objSelect->getParametro('ESTADOS_POSTULANTES', 'http');
        return view("modules.Entrevistas.index",compact('provincia','estado','lider','estados'));
    }

    public function Save(request $request)
    {
        DB::beginTransaction();

        try {
            $objPostulante = Postulantes::Find($request->celular);
            if ($objPostulante == null) {
                $objPostulante = new Postulantes();
                $objPostulante->usuario_ing = Auth::user()->persona_id;
                $objPostulante->celular = $request->celular;
            } else {
                $objPostulante->usuario_mod = Auth::user()->persona_id;
            }
            $objPostulante->nombres = $request->nombres;
            $objPostulante->email = $request->email;
            $objPostulante->edad = $request->edad;
            $objPostulante->genero = $request->genero;
            $objPostulante->id = $request->identificacion;
            $objPostulante->provincia_id = $request->provincia_id;
            $objPostulante->ciudad_id = $request->ciudad_id;
            $objPostulante->estado_id = $request->modo;
            $objPostulante->usuario_valida = $request->lider;
			$objPostulante->observacion_estado=$request->observacion_estado;
            $objPostulante->save();
            $objPerfil = Perfil::where(['postulante_id' => $request->celular])->first();

            if ($objPerfil == null) {
                $objPerfil = new Perfil();
                $objPerfil->usuario_ing = Auth::user()->persona_id;
            } else {
                $objPerfil->usuario_mod = Auth::user()->persona_id;
            }
            $objPerfil->postulante_id = $request->celular;
            $objPerfil->estado_civil = $request->civil;
            $objPerfil->convencional = $request->convencional;
            $objPerfil->actividad = $request->actividad;
            $objPerfil->dias_estudio = $request->dias_estudio;
            $objPerfil->horario_estudio = $request->horario_estudio;
            $objPerfil->casa_estudio = $request->casa_estudio;
            $objPerfil->carrera = $request->carrera;
            $objPerfil->nivel = $request->nivel;
            $objPerfil->edad_hijo = $request->edad_hijo;
            $objPerfil->edad_hijo_m = $request->edad_hijo_m;

            $objPerfil->asignacion_hijo = $request->asignacion_hijo;
            $objPerfil->mantener_casa_nucleo = $request->mantener_casa_nucleo;
            $objPerfil->convive_nucleo = $request->convive_nucleo;
            $i = 0;
            $total_p = 0;
            do {
                $va1 = 'pr' . $i;
                $t = $i + 1;
                $va = 'p' . $t;
                $respuesta = 'respuesta' . $t;
                $observacion = 'observacion' . $t;
                $total_p = $request->$va1[0] + $total_p;
                $objPerfil->$va = $request->$va1[0];
                $objPerfil->$respuesta = $request->$va1[1];
                $objPerfil->$observacion = $request->$va1[2];
                $i++;
            } while ($i < 8);

            $total_et = 0;
            $i = 0;
            do {
                $va1 = 'et' . $i;
                $t = $i + 1;
                $va = 'et' . $t;
                $observacion = 'observacion' . 'et' . $t;
                $objPerfil->$va = $request->$va1[0];
                $objPerfil->$observacion = $request->$va1[1];
                $total_et = $request->$va1[0] + $total_et;

                $i++;
            } while ($i < 4);
            $objPerfil->total_p = $total_p;
            $objPerfil->total_et = $total_et;
            $objPerfil->save();

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

    public function getDatatable($dato)
    {           
         $AdminPostulaciones = Auth::user()->evaluarole(['AdminPostulaciones']);

        
		if($dato=="TODOS")
		{
			$Query=DB::connection('mysql_entrevista')
								->table('postulantes AS p')
                                ->join('nextcore.users as u','u.persona_id','p.usuario_valida')
								->join('nextcore.tb_parametro as tbp', 'p.ciudad_id', 'tbp.id')
                                ->join('nextcore.tb_parametro as tbp2', 'p.estado_id', 'tbp2.id');

                                if($AdminPostulaciones!=1)
                                {
                                    $Query=$Query->where('p.usuario_valida', Auth::user()->persona_id);
                                }
								
                                $Query=$Query->select('p.id as id',
									'p.nombres as name',
									'p.celular as celular',
									'p.email as email',
                                    'p.genero as genero',
                                    'p.created_at as created_at',
                                    'u.name as usuario_validad',
									'p.edad as edad',
									'p.provincia_id as provincia_id',
									'p.ciudad_id as ciudad_id',
									'tbp.descripcion as ciudad',
									'tbp2.descripcion as estado',
									'p.estado_id as estado_id',
									'p.estado_id as estado_id',
									'p.estado_id as estado_id',
									'p.usuario_valida as usuario_valida',
									'p.observacion_estado as observacion_estado'
								);
		}else{
			$Query=DB::connection('mysql_entrevista')
                                ->table('postulantes AS p')
                                ->join('nextcore.users as u','u.persona_id','p.usuario_valida')
								->join('nextcore.tb_parametro as tbp', 'p.ciudad_id', 'tbp.id')
								->join('nextcore.tb_parametro as tbp2', 'p.estado_id', 'tbp2.id')
                                ->where('tbp2.descripcion', $dato);
                                if($AdminPostulaciones!=1)
                                {
                                    $Query=$Query->where('p.usuario_valida', Auth::user()->persona_id);
                                }
                                $Query=$Query->select('p.id as id',
									'p.nombres as name',
									'p.celular as celular',
									'p.email as email',
                                    'p.genero as genero',
                                    'p.created_at as created_at',
                                    'u.name as usuario_validad',
									'p.edad as edad',
									'p.provincia_id as provincia_id',
									'p.ciudad_id as ciudad_id',
									'tbp.descripcion as ciudad',
									'tbp2.descripcion as estado',
									'p.estado_id as estado_id',
									'p.estado_id as estado_id',
									'p.estado_id as estado_id',
									'p.usuario_valida as usuario_valida',
									'p.observacion_estado as observacion_estado'
								);
			
		}
                     return DataTables::of($Query->get())
            ->addColumn('total_p', function ($select) {
                    $resultp = DB::connection('mysql_entrevista')
                        ->table('perfil as c')
                        ->where('c.postulante_id', $select->celular)
                        ->get()->toArray();
                    if ($resultp != []) {
                        return $resultp[0]->total_p;
                    } else {
                        return 0;
                    }

            })
            ->addColumn('total_et', function ($select) {
                $resultp = DB::connection('mysql_entrevista')
                    ->table('perfil as c')
                    ->where('c.postulante_id', $select->celular)
                    ->get()->toArray();
                if ($resultp != []) {
                    return $resultp[0]->total_et;
                } else {
                    return 0;
                }

            })
           
            ->addColumn('estados', function ($select) {

                switch ($select->estado) {
                    case 'REGISTRADOS':
                        $label = 'primary';
                        break;
                    default:
                        $label = 'success';

                        break;
                }
                $result = '<span class="label label-' . $label . '">' . $select->estado . '</span>';
                return $result;
            })
            ->addColumn('opciones', function ($select) {
				
					$prefijo =Auth::user()->prefijo;
                    $extension =Auth::user()->extension;
              
                $resultp = DB::connection('mysql_entrevista')
                    ->table('perfil as c')
                    ->where('c.postulante_id', $select->celular)
                    ->get()->toArray();
                if ($resultp != []) {
                    $resultp = $resultp[0];
                    $edit = '<a href="#" onclick="EditChanges(\'' .
                        $select->id . '\',\'' .
                        $select->name . '\',\'' .
                        $select->celular . '\',\'' .
                        $select->email . '\',\'' .
                        $select->edad . '\',\'' .
                        $select->provincia_id . '\',\'' .
                        $select->ciudad_id . '\',\'' .
                        $select->estado_id . '\',\'' .
                        $select->genero . '\',\'' .
                        $select->usuario_valida . '\',\'' .

                        $resultp->estado_civil . '\',\'' .
                        $resultp->convencional . '\',\'' .
                        $resultp->actividad . '\',\'' .
                        $resultp->dias_estudio . '\',\'' .
                        $resultp->horario_estudio . '\',\'' .
                        $resultp->casa_estudio . '\',\'' .
                        $resultp->carrera . '\',\'' .
                        $resultp->nivel . '\',\'' .
                        $resultp->edad_hijo . '\',\'' .
                        $resultp->edad_hijo_m . '\',\'' .
                        $resultp->asignacion_hijo . '\',\'' .
                        $resultp->mantener_casa_nucleo . '\',\'' .
                        $resultp->convive_nucleo . '\',\'' .
                        $resultp->p1 . '\',\'' .
                        $resultp->respuesta1 . '\',\'' .
                        $resultp->observacion1 . '\',\'' .
                        $resultp->p2 . '\',\'' .
                        $resultp->respuesta2 . '\',\'' .
                        $resultp->observacion2 . '\',\'' .
                        $resultp->p3 . '\',\'' .
                        $resultp->respuesta3 . '\',\'' .
                        $resultp->observacion3 . '\',\'' .
                        $resultp->p4 . '\',\'' .
                        $resultp->respuesta4 . '\',\'' .
                        $resultp->observacion4 . '\',\'' .
                        $resultp->p5 . '\',\'' .
                        $resultp->respuesta5 . '\',\'' .
                        $resultp->observacion5 . '\',\'' .
                        $resultp->p6 . '\',\'' .
                        $resultp->respuesta6 . '\',\'' .
                        $resultp->observacion6 . '\',\'' .
                        $resultp->p7 . '\',\'' .
                        $resultp->respuesta7 . '\',\'' .
                        $resultp->observacion7 . '\',\'' .
                        $resultp->p8 . '\',\'' .
                        $resultp->respuesta8 . '\',\'' .
                        $resultp->observacion8 . '\',\'' .
                        $resultp->et1 . '\',\'' .
                        $resultp->observacionet1 . '\',\'' .
                        $resultp->et2 . '\',\'' .
                        $resultp->observacionet2 . '\',\'' .
                        $resultp->et3 . '\',\'' .
                        $resultp->observacionet3 . '\',\'' .
                        $resultp->et4 . '\',\'' .
                        $resultp->observacionet4 . '\',\''.
                        $extension . '\',\''.
                        $prefijo . '\',\''.
						$select->observacion_estado. '\',\''.
						$select->estado . '\',
                )"
                               data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"
                               class="label label-primary">
                        <span class="glyphicon glyphicon-edit"></span></a></small>';
                } else {
                    $vacio='';
                    $edit = '<a href="#" onclick="EditChanges(\'' .
                        $select->id . '\',\'' .
                        $select->name . '\',\'' .
                        $select->celular . '\',\'' .
                        $select->email . '\',\'' .
                        $select->edad . '\',\'' .
                        $select->provincia_id . '\',\'' .
                        $select->ciudad_id . '\',\'' .
                        $select->estado_id . '\',\'' .
                        $select->genero . '\',\'' .
                        $select->usuario_valida . '\',\'' .

                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $vacio . '\',\'' .
                        $extension . '\',\'' .
                        $prefijo . '\',\''.
						$select->observacion_estado. '\',\''.
						$select->estado . '\',
)"
                               data-hover="tooltip" data-placement="top" 
                               data-target="#Modalagregar" data-toggle="modal" id="modal"
                               class="label label-primary">
                        <span class="glyphicon glyphicon-edit"></span></a></small>';
                }


                return $edit.'
                
                        <a href="#" onclick="PedirConfirmacion(\'' . $select->celular . '\',\'' . 'delete' . '\')"
                               class="label label-danger">
                        <span class="glyphicon glyphicon-trash"></span></a></small>
                       
                        ';
            })
            ->make(true);
    }

    public function Descartar(request $request)
    {

        DB::beginTransaction();
        try {

            $objEmpleado = Postulantes::Find($request->id);
            $objEmpleado->estado_id = '131';
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
