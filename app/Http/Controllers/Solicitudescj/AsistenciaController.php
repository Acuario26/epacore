<?php
namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Yajra\Datatables\Datatables;
use App\Core\Entities\Solicitudescj\StudentTeacher;
use App\Core\Entities\Solicitudescj\semanaObservaciones;
use App\Core\Entities\Solicitudescj\evaluaciontutor;
use App\Core\Entities\Solicitudescj\evaluacionSup;
use App\Core\Entities\Solicitudescj\StudentsSteachers;
use App\User;
use App\Core\Entities\Solicitudescj\Postulant;

use App\Core\Entities\Solicitudescj\AsistenciaMonitor;
use Datetime;

class AsistenciaController extends Controller
{
	public function index(){

		$lugar = auth()->user()->lugarasignado_id;

		$practicante=StudentsSteachers::where('lugar_id',$lugar)
		->where('estado','A')->get()->pluck('user_est_id');

        $postulants= Postulant::where('estado','I')->get()->pluck('identificacion');

		$objD= User::whereIn('id',$practicante)
        ->whereNotIn('persona_id',$postulants)
		->where('estado','A')
		->select('id', 'name')
		->get()->pluck('name','id');



        /*$objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id','25')
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
   
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->get()->pluck('apellidos','id');*/

        //dd($objD);
     
        $sup= Auth::user()->evaluarole(['Monitor']);

        return view('modules.Solicitudescj.asistencias.index',compact('objD','sup'));
    }

    public function asistenciaSave(request $request)   
    {
        $lugar = auth()->user()->lugarasignado_id;

		$practicante=StudentsSteachers::where('lugar_id',$lugar)
		->where('estado','A')->get()->pluck('user_est_id');

		$objD= User::whereIn('id',$practicante)
		->where('estado','A')
		->select('id', 'name')
		->get()->pluck('name','id');


        $semana='Semana '.$request->semana;
        $sup= Auth::user()->evaluarole(['Monitor']);

        //dd($request->estudianteid);
       
        foreach($request->estudianteid as $id)
        {
            
            $objAsistencia=AsistenciaMonitor::where(['user_id'=>$id,
            'fecha'=>$request->fecha_registro])->count();

            $objAsistencia2=AsistenciaMonitor::where(['user_id'=>$id,
            'semana'=>$semana])->count();

            if($objAsistencia>0)
            {

                //dd($id);

                if(isset($request->hora_inicio[$id])){
                    $monitor_id=Auth::user()->id;
                    $objAsistenciaUpdate= AsistenciaMonitor::where(['user_id'=>$id,
            'fecha'=>$request->fecha_registro])->first();
                    $objAsistenciaUpdate->user_id=$id;
                    $objAsistenciaUpdate->monitor_id=$monitor_id;
                    $objAsistenciaUpdate->fecha=$request->fecha_registro;
                    $objAsistenciaUpdate->hora_inicio=$request->hora_inicio[$id];
                    $objAsistenciaUpdate->hora_fin=$request->hf[$id];
                    if($request->cant_horas[$id]==0)
                    {
                        $objAsistenciaUpdate->estado='A';
            
                    }
                    $objAsistenciaUpdate->horas=$request->cant_horas[$id];
                    $objAsistenciaUpdate->semana=' ';
                   
                    $objAsistenciaUpdate->save();
                }
                //$m="Ya existe este registro";
                //return redirect()->route('monitor.asistencia');
    
            }else{

                if(isset($request->hora_inicio[$id])){
                    $monitor_id=Auth::user()->id;
                    $objAsistenciaStore=new AsistenciaMonitor();
                    $objAsistenciaStore->user_id=$id;
                    $objAsistenciaStore->monitor_id=$monitor_id;
                    $objAsistenciaStore->fecha=$request->fecha_registro;
                    $objAsistenciaStore->hora_inicio=$request->hora_inicio[$id];
                    $objAsistenciaStore->hora_fin=$request->hf[$id];
                    if($request->cant_horas[$id]==0)
                    {
                        $objAsistenciaStore->estado='A';
            
                    }
                    $objAsistenciaStore->horas=$request->cant_horas[$id];
                    $objAsistenciaStore->semana=' ';
                   
                    $objAsistenciaStore->save();
                  
                     $m="Registro Grabado Exitosamente";
                 }

            }
            
                /*if($objAsistencia2>4)
                {
                    $m="Ya tiene la asistencia completa de la semana";
                    return redirect()->route('monitor.asistencia');
      
                }*/
               
                
        }
        /*foreach($request->estudianteid as $id)
        {
                
                    
        }*/
        return redirect()->route('monitor.asistencia');

    }


    public function datatableAsistencia(){
    	$id = auth()->user()->id;

    	$asistencias = AsistenciaMonitor::with(['estudiante'])
    	->where('monitor_id',$id)->get();

    	//dd($asistencias);

    	return DataTables::of($asistencias)
    	->addColumn('estado_label', function ($select) {
    		if(!$select->horas){
    			return '<span class="label label-warning" >No hay Asistencia</span>';
    		}else{
    			return '<span class="label label-success" >Asistente</span>';
    		}    		
    	})->addColumn('firma', function ($select) {
            return '';   
        })->rawColumns(['estado_label'])
    	->make(true);
		
    }

}