<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Admin\CtlArea;
use App\Core\Entities\Admin\CtlCargo;
class DataController extends Controller
{
    public function getAreas()
    {
        $consulta=CtlArea::all();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function getCargos()
    {
        $consulta=CtlCargo::all();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
}
