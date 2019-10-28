<?php


namespace App\Http\Controllers\Comercial;

use App\Core\Entities\modules\Comercial\LoteFacturacion;
use App\Core\Entities\modules\Comercial\LoteRecaudacion;
use App\Imports\UsersImport;
use App\Imports\UsersImportR;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;
use App\Http\Controllers\Ajax\SelectController;

class ComercialController extends Controller
{
        public function import(request $request) 
        {
           
            $countantes=LoteFacturacion::all()->count();
            Excel::import(new UsersImport,$request->excel);
            $countdespues=LoteFacturacion::all()->count();
            $registro=$countdespues-$countantes;
            $array_response['status'] = 200;
            $array_response['message'] = 'Se han registrado,'.$registro.' registros';
            return response()->json($array_response, 200);
        }
        public function importR(request $request) 
        {
           
            $countantes=LoteRecaudacion::all()->count();
            Excel::import(new UsersImportR,$request->excel);
            $countdespues=LoteRecaudacion::all()->count();
            $registro=$countdespues-$countantes;
            $array_response['status'] = 200;
            $array_response['message'] = 'Se han registrado,'.$registro.' registros';
            return response()->json($array_response, 200);
        }
        public function batchSize(): int
        {
            return 1000;
        }
         public function chunkSize(): int
        {
            return 1000;
        }

        public function getLote(request $request){

            if ($request->fechai == null || $request->fechaf == null) {
                $array_response['status'] = 404;
                $array_response['message'] = "No pueden estar vacio los intervalos de fechas";
            } else {
                $datetime1 = date_create($request->fechaf); //fecha actual
                $datetime2 = date_create($request->fechai); //fecha de db
                $interval = date_diff($datetime1, $datetime2, false);
                $dias = intval($interval->format('%R%a'));
                if (($dias < 0) || ($dias == 0)) {
                 if($request->fechai!=$request->fechaf)
                            {
                                $result = LoteFacturacion::whereBetween('created_at', [$request->fechai, $request->fechaf])
                                ->where('estado','PRO')
                                ->get()->toArray();
                            }else{
                                $result = LoteFacturacion::where('created_at', 'like','%'.$request->fechai.'%')
                                ->where('estado','PRO')
                                ->get()->toArray();
                            }
                    if (count($result) > 0) {
                        $array_response['status'] = 200;
                        $array_response['message'] = $result;
                    } else {
                        $array_response['status'] = 404;
                        $array_response['message'] = "No hay resultado en su consulta.";
    
                    }
                } else if ($dias > 0) {
                    $array_response['status'] = 404;
                    $array_response['message'] = "La Fecha es menor a la fecha Inicial";
                }
            }

              return response()->json($array_response, 200);
        }
        public function getLoteR(request $request){
            if ($request->fechai == null || $request->fechaf == null) {
                $array_response['status'] = 404;
                $array_response['message'] = "No pueden estar vacio los intervalos de fechas";
            } else {
                $datetime1 = date_create($request->fechaf); //fecha actual
                $datetime2 = date_create($request->fechai); //fecha de db
                $interval = date_diff($datetime1, $datetime2, false);

                $dias = intval($interval->format('%R%a'));
                if (($dias < 0) || ($dias == 0)) {
                 if($request->fechai!=$request->fechaf)
                            {
                                $result = LoteRecaudacion::whereBetween('created_at', [$request->fechai, $request->fechaf])
                                ->where('estado','PRO')
                                ->get()->toArray();
                            }else{
                                $result = LoteRecaudacion::where('created_at', 'like','%'.$request->fechai.'%')
                                ->where('estado','PRO')
                                ->get()->toArray();
                            }
                    if (count($result) > 0) {
                        $array_response['status'] = 200;
                        $array_response['message'] = $result;
                    } else {
                        $array_response['status'] = 404;
                        $array_response['message'] = "No hay resultado en su consulta.";
    
                    }
                } else if ($dias > 0) {
                    $array_response['status'] = 404;
                    $array_response['message'] = "La Fecha es menor a la fecha Inicial";
                }
            }
                
              return response()->json($array_response, 200);
        }
        public function eliminaFile(request $request){
            DB::beginTransaction();
            try{
                $data=explode(",",$request->Arreglochecklist);
                foreach ($data as $k) {
                    $consulta=LoteFacturacion::Find($k);
                    $consulta->estado='INA';
                    $consulta->save();  
                }
                DB::commit();

                $array_response['status'] = 200;
                $array_response['message'] = 'Los datos han sido eliminados Exitosamente';
            }catch(\Exception $e)
            {
                 DB::rollback();

                $array_response['status'] = 300;
                $array_response['message'] = 'ha existido un error al eliminar los archivos de Facturacion, contactese con el Administrador';
    
            }
              return response()->json($array_response, 200);
        }
        public function eliminaFileR(request $request){
            DB::beginTransaction();
            try{
                $data=explode(",",$request->Arreglochecklist);
                foreach ($data as $k) {
                    $consulta=LoteRecaudacion::Find($k);
                    $consulta->estado='INA';
                    $consulta->save();  
                }
                DB::commit();

                $array_response['status'] = 200;
                $array_response['message'] = 'Los datos han sido eliminados Exitosamente';
            }catch(\Exception $e)
            {
                 DB::rollback();

                $array_response['status'] = 200;
                $array_response['message'] = 'ha existido un error al eliminar los archivos de Recaudacion, contactese con el Administrador';
    
            }
          
              return response()->json($array_response, 200);
        }
        public function Index(){
            $objSelect = new SelectController();
            $tabla = $objSelect->getParametro('TABLA_LOTES', 'http');
            return view('modules.Comercial.index',compact('tabla'));
        }
        
}
