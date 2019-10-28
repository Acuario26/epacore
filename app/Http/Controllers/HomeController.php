<?php

namespace App\Http\Controllers;

use App\Core\Entities\Solicitudes\SessionAudita;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $success='data';
        return view('home',compact('success'));
    }

    public function sessionAudita()
    {
        $usuario_ing = Auth::user()->persona_id;
        $arrayA = array();
        $arrayL = array();
        $today = new \DateTime("now");
        array_push($arrayA, 'AsesorCC');
        array_push($arrayL, 'LiderCC', 'AdminCC');
        $varL = Auth::user()->evaluarole($arrayL);
        $var = Auth::user()->evaluarole($arrayA);
        if ($var != 0 && $varL==0) {
           $resultA=DB::connection('mysql_solicitudes')->table('sessionaudita')->insert(['usuario_ing'=>$usuario_ing,'created_at'=>$today]);
            $result = DB::connection('mysql')->table('users')->where('persona_id', $usuario_ing)->update(['estado' => 'I']);
            $array_response['status'] = 200;
        } else {
            $array_response['status'] = 300;
        }

        return response()->json($array_response, 200);
    }
}
