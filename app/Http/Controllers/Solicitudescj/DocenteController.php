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

use App\Core\Entities\Solicitudescj\Asistencia;
use Datetime;

class DocenteController extends Controller
{
    public function evaluacionSupervision()
    {
    
        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();
        
        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
        ->where('p.estado','A');
           
        $objD=$objD->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->pluck('apellidos','id');

        $sup= Auth::user()->evaluarole(['Supervisor']);

        return view('modules.Solicitudescj.docente.tutorindex',compact('objD','sup'));
    }
 
    public function index(){

        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();
        
        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
        ->where('p.estado','A')
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->get()->pluck('apellidos','id')->toArray();

       
        $sup= Auth::user()->evaluarole(['Supervisor']);

        return view('modules.Solicitudescj.docente.docenteindex',compact('objD','sup'));
    }
    public function StateActividad($id)
    {

        $objA=Asistencia::Find($id);
        $objA->estado='A';
        $objA->save();

        return redirect()->route('supervisor.asistencia');

    }
    public function semanaEstudiaante(Request $request)
	{
        $semanasNo=DB::connection('mysql_solicitudescj')->table('semanaObservaciones')
        ->where(['user_id'=>$request->valor])
        ->select('semana')
        ->get()->pluck('semana');
       
   
		$result = DB::connection('mysql_solicitudescj')
            ->table('asistencias')
            ->where('user_id', $request->valor)
            ->where('estado', 'A')
            ->whereNotIn('semana',$semanasNo)
            ->where('docente_id',Auth::user()->id)
            ->groupBy('semana')
            ->orderBy('semana', 'DSC')
            ->select('semana as id', 'semana as descripcion')->get();
           
        if (count($result) > 0) {
            //$result = $result->get('descripcion', 'id');
            //$lista['data'] = $result;
            $array_response['status'] = 200;
            $array_response['message'] = $result;
        } else {
            $array_response['status'] = 404;
            $array_response['message'] = "No hay resultados";
        }


		return response()->json($array_response, 200);
    }
    public function evaluacionSave(request $request)
    {
       
        $obc=evaluaciontutor::where('docente_id',Auth::user()->id)
        ->where('user_id',$request->estudianteo)->get()->count();
        
   
        $obc=$obc+1;
        $vfa="";
        $vfr="";
        $vf=array_sum($request->opcion);
       
        if($vf<7)
        {
            $vfr="X";
        }else
        {
            $vfa="X"; 
        }

        $objEv=new evaluaciontutor();
        $objEv->user_id=$request->estudianteo;
        $objEv->docente_id=Auth::user()->id;
        $objEv->visita=$obc;

        $objEv->e1=$request->opcion[0];
        $objEv->e2=$request->opcion[1];
        $objEv->e3=$request->opcion[2];
        $objEv->e4=$request->opcion[3];
        $objEv->e5=$request->opcion[4];
        $objEv->ec1=$request->opcion[5];
        $objEv->ec2=$request->opcion[6];
        $objEv->ec3=$request->opcion[7];
        $objEv->ec4=$request->opcion[8];
        $objEv->ec5=$request->opcion[9];

        $objEv->ob1=$request->ob1[0];
        $objEv->ob2=$request->ob1[1];
        $objEv->ob3=$request->ob1[2];
        $objEv->ob4=$request->ob1[3];
        $objEv->ob5=$request->ob1[4];
        $objEv->ob6=$request->ob1[5];
        $objEv->ob7=$request->ob1[6];
        $objEv->ob8=$request->ob1[7];
        $objEv->ob9=$request->ob1[8];
        $objEv->ob10=$request->ob1[9];

        $objEv->vfa=$vfa;
        $objEv->vfr=$vfr;
        $objEv->save();

        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
   ->where('p.estado','A')
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->pluck('apellidos','id');

        $m='Grabado Correctamente';
        $sup= Auth::user()->evaluarole(['Supervisor']);

        return view('modules.Solicitudescj.docente.tutorindex',compact('objD','m','sup'));

    }
    public function observacionSave(request $request)
    {
        $objSo=new semanaObservaciones();

        $objSo->user_id=$request->estudianteo;
        $objSo->semana=$request->se;
        $objSo->observacion=$request->observacion;
        $objSo->docente_id=Auth::user()->id;
        $objSo->save();

        return redirect()->route('supervisor.asistencia');

    }
    public function imprimirAsistencia(request $request)
    {
        switch($request->mes)
        {
            case 'ENERO':
            $mes_int=1;
            break;
            case 'FEBRERO':
            $mes_int=2;
            break;
            case 'MARZO':
            $mes_int=3;
            break;
            case 'ABRIL':
            $mes_int=4;
            break;
            case 'MAYO':
            $mes_int=5;
            break;
            case 'JUNIO':
            $mes_int=6;
            break;
            case 'JULIO':
            $mes_int=7;
            break;
            case 'AGOSTO':
            $mes_int=8;
            break;
            case 'SEPTIEMBRE':
            $mes_int=9;
            break;
            case 'OCTUBRE':
            $mes_int=10;
            break;
            case 'NOVIEMBRE':
            $mes_int=11;
            break;
            case 'DICIEMBRE':
            $mes_int=12;
            break;
            default:
            $mes_int=0;
            break;
        }

        if($request->mes!=null && $request->estudianteo!=null)
        {
            $docente=Auth::user()->name;
            $obj=DB::connection('mysql_solicitudescj')
            ->table('asistencias as a')
            ->where('user_id',$request->estudianteo)
            ->where('docente_id',Auth::user()->id)
            ->join('core.users as u','u.id','a.user_id')
            ->join('postulants as p','p.identificacion','u.persona_id')
            ->where('p.estado','A')
            ->whereMonth('a.Fecha',$mes_int)
            ->select(
                DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'),
                'a.hora_inicio as hi','a.hora_fin as hf',
                'a.fecha as fecha_registro'
            )
            ->get();
            if(!$obj->count())
            {
                return redirect()->route('supervisor.asistencia');

            }
            $objD=$obj->toArray();
            $objE=$obj->first();
            $mes=$request->mes;
            $estudiante=$objE->apellidos;
            $pdf=\PDF::loadView('modules.Solicitudescj.docente.docenteI',
            compact(
                'docente','objD',
                'estudiante','mes'
            ));
            return $pdf->stream();
        }else
        {
            return redirect()->route('supervisor.asistencia');
        }
       
    }
    public function imprimirEvaluacionSup($id)
    {
        $obj=evaluacionSup::Find($id);
        $teachers = StudentsSteachers::with(['docente','horario','lugar'])
        ->where('user_est_id',$obj->user_id)
        ->where('tipo','SUP')->first();
        
        $objU=User::Find($obj->user_id);
       
        $objPostulant=Postulant::where('identificacion',$objU->persona_id)->get()->first();
        $pdf=\PDF::loadView('modules.Solicitudescj.docente.evaluaciondoc',compact(
            'objPostulant','teachers','obj'));
        return $pdf->stream();

    }
    public function imprimirEvaluacion($id)
    {
        $obj=evaluaciontutor::Find($id);
        $teachers = StudentsSteachers::with(['docente','horario','lugar'])
        ->where('user_est_id',$obj->user_id)
        ->where('tipo','SUP')->first();
        
        $objU=User::Find($obj->user_id);
       
        $objPostulant=Postulant::where('identificacion',$objU->persona_id)->get()->first();
        $pdf=\PDF::loadView('modules.Solicitudescj.docente.evaluacion',compact(
            'objPostulant','teachers','obj'));
        return $pdf->stream();

    }

    public function asistenciaSave(request $request)   
    {
      $m='No ha selecciona registro';
      
      $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
         ->where('p.estado','A')
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->get()->pluck('apellidos','id')->toArray();
             
        
        $sup= Auth::user()->evaluarole(['Supervisor']);
     
        if(isset($request->estudianteid))
        {
            foreach($request->estudianteid as $id)
            {
                
                $objAsistencia=Asistencia::where(['user_id'=>$id,
                'fecha'=>$request->fecha_registro])->count();
    
                
                if($objAsistencia>0)
                {
                    
                    $m="Ya existe este registro";
                    
      
                     return view('modules.Solicitudescj.docente.docenteindex'
                     ,compact('objD','sup','m'));
        
                }
                $semana='Semana '.$request->semana[$id];
    
                $objAsistencia2=Asistencia::where(['user_id'=>$id,
                'semana'=>$semana])->count();
                if($objAsistencia2>4)
                {
                    $m="El estudiante, Ya tiene la asistencia completa de la semana";
                    return view('modules.Solicitudescj.docente.docenteindex'
                     ,compact('objD','sup','m'));
                }
                            
            }
            foreach($request->estudianteid as $id)
            {
                    $docent_id=Auth::user()->id;
                    $objAsistencia=new Asistencia();
                    $objAsistencia->user_id=$id;
                    $objAsistencia->docente_id=$docent_id;
                    $objAsistencia->fecha=$request->fecha_registro;
                    $objAsistencia->hora_inicio=$request->hora_inicio[$id];
                    $objAsistencia->hora_fin=$request->hf[$id];
                    if($request->cant_horas[$id]==0)
                    {
                        $objAsistencia->estado='A';
            
                    }
                    $objAsistencia->horas=$request->cant_horas[$id];
                    $objAsistencia->semana='Semana '.$request->semana[$id];
                   
                    $objAsistencia->save();
                  
                        $m="Registro Grabado Exitosamente";
                        
            }
        }
       
        return view('modules.Solicitudescj.docente.docenteindex',compact('objD','sup','m'));

      //  return redirect()->route('supervisor.asistencia')->with(['m'=>$m]);

    }
    
    public function getDatatableObservaciones()
	{
       return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('semanaobservaciones AS a')
                ->where('a.docente_id',Auth::user()->id)
                ->join('core.users as u','u.id','a.user_id')
                ->join('postulants as p','p.identificacion','u.persona_id')
                ->orderby('a.created_at', 'ASC')
                ->select(
               'a.observacion as observacion',
				
                DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
				'a.created_at as fecha_registro',
                'a.semana as semana'
               )
                ->get()

        )
          
            ->make(true);
    }
    public function datatableEvaluacionesSup()
	{
        $Directora = Auth::user()->evaluarole(['Directora']);
        $result=DB::connection('mysql_solicitudescj')
        ->table('evaluacionsupervisor AS a');
        if($Directora==0)
        {
            $result=$result->where('a.docente_id',Auth::user()->id);
        }
        $result=$result->join('core.users as u','u.id','a.user_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('p.estado','A')
        ->orderby('a.created_at', 'ASC')
        ->select(
            'a.id as id',
        'a.total as total',
        DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
        'a.created_at as fecha_registro'
        )
        ->get();
       return DataTables::of($result)->addColumn('Opciones', function ($select) {
		        return '<a href="'.route('supervisor.imprimirEvaluacionSup',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
            })
           
          
            ->make(true);
    }
    
    public function datatableEvaluacionesTutor()
	{
        $Directora = Auth::user()->evaluarole(['Directora']);

        $result=DB::connection('mysql_solicitudescj')
        ->table('evaluaciontutor AS a');
        if($Directora==0)
        {
            $result=$result->where('a.docente_id',Auth::user()->id);
        }
        $result=$result->join('core.users as u','u.id','a.user_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('p.estado','A')
        ->orderby('a.created_at', 'ASC')
        ->select(
            'a.id as id',
        'a.visita as visita',
        DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
        'a.created_at as fecha_registro'
       )
        ->get();
       return DataTables::of($result)->addColumn('Opciones', function ($select) {
		        return '<a href="'.route('tutor.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
            })
          
            ->make(true);
    }
    public function removeAsistenciaD(request $request)
    {
       // dd($request);
     
            $m='Eliminado correctamente';
            $obj=Asistencia::Find($request->id);
            $obj->delete();
       
            $objHoras=Asistencia::where('estado','A')
            ->select('user_id as user')
            ->groupBy('user')
            ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
         ->where('p.estado','A')
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->get()->pluck('apellidos','id')->toArray();
  
        $sup= Auth::user()->evaluarole(['Supervisor']);
        
        return view('modules.Solicitudescj.docente.docenteindex',compact('objD','sup','m'));

    }
    
    public function editAsistenciaD($id)
    {

        $objD=Asistencia::Find($id);
        $semana=explode('Semana ', $objD->semana);
        $semana=$semana[1];
        return view('modules.Solicitudescj.docente.docenteAsistenciaEdit',
        compact('objD','semana'));

    }
    public function saveAsistenciaD(request $request)
    {
       // dd($request);
        $objAsistencia=Asistencia::where(['user_id'=>$request->user_id,
            'fecha'=>$request->fecha_registro])->count();
            $m='Ya tiene un registro de Asistencia';
        if($objAsistencia<1)
        {
            $m='Grabado correctamente';
            $obj=Asistencia::Find($request->id);
            $obj->user_id=$request->user_id;
            $obj->docente_id=Auth::user()->id;
            $obj->fecha=$request->fecha_registro;
            $obj->semana='Semana '.$request->semana;
            foreach($request->cant_horas as $ch)
            {
                $obj->horas=$ch;
                if($ch==0)
                {
                    $obj->estado='A';
                }
                else{
                    $obj->estado='I'; 
                }
                
            }
            foreach($request->hora_inicio as $hi)
            {
                $obj->hora_inicio=$hi;
                
            }
            foreach($request->hf as $hf)
            {
                $obj->hora_fin=$hf;
            
            }
            
            $obj->save();
        }

        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
         ->where('p.estado','A')
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->get()->pluck('apellidos','id')->toArray();
     
        $sup= Auth::user()->evaluarole(['Supervisor']);
        
        return view('modules.Solicitudescj.docente.docenteindex',compact('objD','sup','m'));

    }
    
    public function datatableAsistencia()
	{   
        $Directora = Auth::user()->evaluarole(['Directora']);
        $result=DB::connection('mysql_solicitudescj')
        ->table('asistencias AS a');
        if($Directora==0)
        {
            $result= $result->where('a.docente_id',Auth::user()->id);
        }
        $result= $result->join('core.users as u','u.id','a.user_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('p.estado','A')
        ->orderby('a.estado','DESC')
        ->select(
        'a.descripcion as descripcion',
        'a.id as id',
        'a.estado as estado',
        DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
        'a.fecha as fecha',
        'a.semana as semana',
        'a.hora_inicio as hora_inicio',
        'a.hora_fin as hora_fin',
        'a.horas as horas')->get();
       return DataTables::of($result         

        )->addColumn('Estado', function ($select) {
            $linka='<a href="'.route('docente.editAsistenciaD',$select->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
            $linke='<a href="'.route('docente.removeAsistenciaD',$select->id).'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

				switch($select->estado)
				{
                    case 'A':
                    if(!$select->horas)
					{
						return '<span class="label label-success" >No hay Asistencia</span>&nbsp'.$linka.$linke;
						break;
					}
					return '<span class="label label-primary">Actividad Aprobada</span>';
					break;
					case 'I':
					
					
					return '<span class="label label-info">Asistencia</span>&nbsp;&nbsp'.$linka.$linke;
					break;
                    
                    case 'P':
                   // 
                    return '
                    <a href="'.route('docente.stateactividad',$select->id).'" id="envio'.$select->id.'"></a>

                    <a onclick="confirma(\''.$select->descripcion.'\','.$select->id.')" class="label label-warning">
                    <i class="fa fa-check"></i>&nbsp; Pendiente de Aprobar Actividad
                    </a>';

                   

					break;
				}

            })
           
            ->make(true);
    }
    public function evaluacionDesempeño()
    {
        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
   
        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->pluck('apellidos','id');

        $sup= Auth::user()->evaluarole(['Supervisor']);

        return view('modules.Solicitudescj.docente.supervisorindex',compact('objD','sup'));
    }
    public function evaluacionSupSave(request $request)
    {
        $sup= Auth::user()->evaluarole(['Supervisor']);

        $countEs=evaluacionSup::where('user_id',$request->estudianteo)->get()->count();
        $m="El estudiante ya tiene un registro";
        if($countEs<1)
        {
            $e1=$request->e1;
            $e2= $request->e2;
            $e3= $request->e3;
            $e4= $request->e4;
            $e5= $request->e5;
            $e6= $request->e6;
            $e7= $request->e7;
            $e8= $request->e8;
            $e9= $request->e9;
            $e10= $request->e10;
            $e11= $request->e11;
            //dd($e1);
          
             $i=0;
             $c1=0;
             $c2=0;
             $c3=0;
             $c4=0;
             $c5=0;
             switch($e1)
             {
                 case "1":
                 $c1=$c1+1;
     
                 break;
                 case "2":
                 $c2=$c2+1;
     
                 break;
                 case "3":
                 $c3=$c3+1;
     
                 break;
                 case "4":
                 $c4=$c4+1;
     
                 break;
                 case "5":
                 $c5=$c5+1;
                 break;
     
             }
             switch($e2)
             {
                 case "1":
                 $c1=$c1+1;
     
                 break;
                 case "2":
                 $c2=$c2+1;
     
                 break;
                 case "3":
                 $c3=$c3+1;
     
                 break;
                 case "4":
                 $c4=$c4+1;
     
                 break;
                 case "5":
                 $c5=$c5+1;
                 break;
     
             }
             
                 switch($e3)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 
                 switch($e4)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e5)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e6)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e7)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e8)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e9)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e10)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                 switch($e11)
                 {
                     case "1":
                     $c1=$c1+1;
     
                     break;
                     case "2":
                     $c2=$c2+1;
     
                     break;
                     case "3":
                     $c3=$c3+1;
     
                     break;
                     case "4":
                     $c4=$c4+1;
     
                     break;
                     case "5":
                     $c5=$c5+1;
                     break;
     
                 }
                $tt=($c5*5)+($c4*4)+($c3*3)+($c2*2)+($c1*1);
                $n=round($tt*0.18181,2);
             $obj=new evaluacionSup();
             $obj->user_id=$request->estudianteo;
             $obj->docente_id=Auth::user()->id;
             $obj->e1=$request->e1;
             $obj->e2=$request->e2;
             $obj->e3=$request->e3;
             $obj->e4=$request->e4;
             $obj->e5=$request->e5;
             $obj->e6=$request->e6;
             $obj->e7=$request->e7;
             $obj->e8=$request->e8;
             $obj->e9=$request->e9;
             $obj->e10=$request->e10;
             $obj->e11=$request->e11;
             $obj->ob1=$request->ob1;
             $obj->ob2=$request->ob2;
             $obj->ob3=$request->ob3;
     
             $obj->fr1=$c1;
             $obj->fr2=$c2;
             $obj->fr3=$c3;
             $obj->fr4=$c4;
             $obj->fr5=$c5;
     
             $obj->sum1=$c1*1;
             $obj->sum2=$c2*2;
             $obj->sum3=$c3*3;
             $obj->sum4=$c4*4;
             $obj->sum5=$c5*5;
              
             $obj->total=$tt;
            
            $obj->nota=$n;
             $obj->save();
    
             $m='Grabado Correctamente';
        }

        $objHoras=Asistencia::where('estado','A')
        ->select('user_id as user')
        ->groupBy('user')
        ->havingRaw('SUM(horas) > ?', [159])->get()->toArray();

        $objD=DB::connection('mysql_solicitudescj')
        ->table('students_teachers as et')
        ->where('et.user_doc_id',Auth::user()->id)
        ->join('core.users as u','u.id','et.user_est_id')
        ->join('postulants as p','p.identificacion','u.persona_id')
        ->where('et.estado','A')
        ->where('p.estado','A')

        ->select('u.id as id', DB::RAW('CONCAT(p.apellidos," ",p.nombres) as apellidos'))
        ->pluck('apellidos','id');

        
      
        return view('modules.Solicitudescj.docente.supervisorindex',compact('objD','m','sup'));
    }
    

}
