<?php

namespace App\Http\Controllers\Report;
use App\Http\Controllers\Ajax\SelectController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Core\Entities\modules\Comercial\LoteFacturacion;
use App\Core\Entities\modules\Comercial\LoteRecaudacion;

class ReportController extends Controller
{
    //
    
    public function indexRecaudacion()
    {
        return view("modules.Report.reporteGeneralR");
    }
    public function index()
    {
        $objSelect = new SelectController();
        $tipo = $objSelect->getParametro('TIPO_REPORTE', 'http');
    
        return view("modules.Report.reporteGeneral",compact('tipo'));
    }

    public function reporteGeneralDatos(request $request)
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
                if(strtoupper($request->tabla)!='FACTURACION')
                {
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
                }else{
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
                }
                
                
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


}
