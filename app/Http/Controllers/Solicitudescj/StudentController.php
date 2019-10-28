<?php

namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\RequestPostulant;
use App\Core\Entities\Solicitudescj\Place;
use App\Core\Entities\Solicitudescj\StudentTeacher;
use App\Core\Entities\Solicitudescj\StudentsSteachers;

use App\Core\Entities\Solicitudescj\Horario;
use App\Core\Entities\Solicitudescj\Asistencia;
use App\Core\Entities\Solicitudescj\semanaobservaciones as semanaObservaciones;
use App\Core\Entities\Solicitudescj\evaluacionest;


use Yajra\Datatables\Datatables;
use App\Core\Entities\Solicitudescj\ProductsPhoto;


use App\User;
use DB;
use Auth;

class StudentController extends Controller
{
	public function datatableEvaluacionesTutorEst()
	{
       return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('evaluaciontutor AS a')
                ->where('a.user_id',Auth::user()->id)
                ->orderby('a.created_at', 'ASC')
                ->select(
                    'a.id as id',
                'a.visita as visita',
				'a.created_at as fecha_registro'
               )
                ->get()

        )->addColumn('Opciones', function ($select) {
		        return '<a href="'.route('tutor.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
            })
           
          
            ->make(true);
    }
    
	public function evaluacionSupervisor()
	{
		return view('modules.Solicitudescj.student.evaluacionDocente');
	}
	public function indexEvaluacion()
	{
		$objHoras=Asistencia::where('user_id',Auth::user()->id)
		->where('estado','A')
		->select(DB::RAW('sum(horas) as horas'))->get()->first();
		
		if($objHoras!=null)
		{
			$objHoras=$objHoras->horas;
		}else{
			$objHoras=0;
		}

		$obj=evaluacionest::where('user_id',Auth::user()->id)->get()->count();
		return view('modules.Solicitudescj.student.ficha')->with(['objHoras'=>$objHoras,'obj'=>$obj]);
	}
	public function evaluacionSave(request $request)
	{
		$m="Ya tiene un registro ingresado";
		$obj=evaluacionest::where('user_id',Auth::user()->id)->get()->count();
		$objHoras=Asistencia::where('user_id',Auth::user()->id)
		->where('estado','A')
		->select(DB::RAW('sum(horas) as horas'))->get()->first();
		if($obj<1)
		{
			$objEe=new evaluacionest();
			$objEe->e1=$request->e1;
			$objEe->e2=$request->e2;
			$objEe->e3=$request->e3;
			$objEe->e4=$request->e4;
			$objEe->e5=$request->e5;
			$objEe->e6=$request->e6;
			$objEe->e7=$request->e7;
			$objEe->e8=$request->e8;
			$objEe->e9=$request->e9;
			$objEe->e10=$request->e10;
			$objEe->e11=$request->e11;
			$objEe->user_id=Auth::user()->id;
			$objEe->ob1=$request->conocimiento;
			$objEe->ob2=$request->asistencia;
			$objEe->ob3=$request->apoyo;
			$objEe->ob4=$request->espacio;
			$objEe->sugerencias=$request->sugerencias;
			
			$objEe->save();
			$m="grabado exitoso";
			
		}
			
			return view('modules.Solicitudescj.student.ficha')
			->with(['m'=>$m,'obj'=>$obj,'objHoras'=>$objHoras]);

	}
	public function datatableEvaluacionesEstudiante()
	{
		return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('evaluacionestudiante AS a')
                ->where('a.user_id',Auth::user()->id)
                ->join('core.users as u','u.id','a.user_id')
                ->join('postulants as p','p.identificacion','u.persona_id')
                ->orderby('a.created_at', 'ASC')
                ->select(
                    'a.id as id',
                	'a.created_at as fecha_registro'
               )
                ->get()

        )->addColumn('Opciones', function ($select) {
		        return '<a href="'.route('student.imprimirEvaluacion',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
            })
           
          
            ->make(true);
	}
	public function imprimirEvaluacion($id){
		$objEv=evaluacionest::Find($id);
	
		$teachers = StudentsSteachers::with(['docente','horario','lugar'])
			->where('user_est_id',Auth::user()->id)
			->where('tipo','SUP')->first();
			$usuario=Auth::user()->persona_id;
			$objPostulant=Postulant::where('identificacion',$usuario)->get()->first();
	
			$pdf=\PDF::loadView('modules.Solicitudescj.student.evaluacion',compact(
				'objPostulant','teachers','objEv'));
			return $pdf->stream();
	}
	public function imprimirFicha(){
		$identificacion=Auth::user()->persona_id;
		$ob=Postulant::where(['identificacion'=>$identificacion,'estado'=>'A'])->get()->first();
	
			$pdf=\PDF::loadView('modules.Solicitudescj.student.datosficha',compact(
				'ob','identificacion'));
			return $pdf->stream();
	}
    public function estudianteperfil()
	{
		$identificacion=Auth::user()->persona_id;
		$objPostulant=Postulant::where(['identificacion'=>$identificacion,'estado'=>'A'])->get()->toArray();
		
		$idv=$objPostulant[0]['id'];
		$objPostulant=$objPostulant[0];
		
		$datos['usuario']=$objPostulant['nombres'].' '.$objPostulant['apellidos'];

		$datos['data']=$objPostulant;
		$lugares=Place::all()->where('estado','A')->pluck('descripcion','id');
		$supervisor=User::where('abv','SUP')->where('estado','A')->pluck('name','id');
		$horario=Horario::all()->pluck('descripcion','id');
		$horario_inicio='';
		$horario_fin='';
		$cant_horas=2;
		$lugar_id=null;
		$user_doc=null;
		$horario_id=1;
		
		
		$message='';
		$tipoM='';
		$objSt=StudentTeacher::where('user_est_id',Auth::user()->id)
		->where('tipo','SUP')
		->get();
		$cc=0;
		$objSt1=$objSt->where('estado','A');
	
		if(count($objSt)!=0)
		{
			$message='Su seleccion de Horario está en proceso de revisiòn';
			$tipoM='warning';
			$cc=1;
			$objSt=$objSt->first();
			$user_doc=$objSt->user_doc_id;
			$horario_id=$objSt->horario_id;
			$lugar_id=$objSt->lugar_id;
			$horario_inicio=$objSt->hora_inicio;
			$horario_fin=$objSt->hora_fin;
			$cant_horas=$objSt->cant_horas;

		}
		if(count($objSt1)!=0)
		{
			$message='Su proceso de pasantias ha iniciado ';
			$tipoM='info';
			$cc=2;
		}			
		
		return view('modules.Solicitudescj.student.index',compact(
		'datos',
		'lugares',
		'supervisor',
		'user_doc',
		'cc',
		'lugar_id',
		'horario_id',
		'horario',
		'message',
		'tipoM',
		'horario_fin',
		'horario_inicio',
		'cant_horas'));

	}
	public function Clinica()
	{
		$images=ProductsPhoto::where('user_id',Auth::user()->id)->get();
		$estudiante= Auth::user()->evaluarole(['estudiante']);

		$message='Aun no ha elegido Horario';
		$tipoM='warning';
		$objSt=StudentTeacher::where('user_est_id',Auth::user()->id)->get();
		
		$cc=0;
		$objSt1=$objSt->where('estado','A');
		if(count($objSt)!=0)
		{
			$message='Su seleccion de Horario está en proceso de revisiòn';
			$tipoM='warning';
			$cc=1;
			

		}
		if(count($objSt1)!=0)
		{
			$message='Su proceso de pasantias ha iniciado ';
			$tipoM='info';
			$cc=2;
		}

		return view('modules.Solicitudescj.student.clinica',compact('estudiante','tipoM','cc','message'))
		->with(['images'=>$images]);
	}

	public function evaluacion()
	{
		$objHoras=Asistencia::where('user_id',Auth::user()->id)
		->where('estado','A')
		->select(DB::RAW('sum(horas) as horas'))->get()->first();
		$cc=0;
		if($objHoras->horas>"159")
		{
			$teachers = StudentsSteachers::with(['docente','horario','lugar'])
			->where('user_est_id',Auth::user()->id)
			->where('tipo','SUP')->first();
			$usuario=Auth::user()->persona_id;
			$objPostulant=Postulant::where('identificacion',$usuario)->get()->first();
	
			$pdf=\PDF::loadView('modules.Solicitudescj.student.evaluacion',compact(
				'objPostulant','teachers'));
			return $pdf->stream();
		}
			$m="Aun no ha completado las 160 horas para realizar la evaluacion, Porfavor revise la cantidad de sus horas";
			//$cc=2;
		
		
		return view('modules.Solicitudescj.student.actividades')->with(['m'=>$m,'cc'=>$cc]);
	}
	public function getDatatablesemanas()
	{
		return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('asistencias AS a')
				->where(['a.user_id'=>Auth::user()->id,
						'a.estado'=>'A']
						)
                ->groupBy('a.semana')
                ->select(DB::RAW('count(a.id) as cc'),
				DB::RAW('sum(a.horas) as horas'),
				'a.semana as semana')
                ->get()

        )->addColumn('Opciones', function ($select) {
			if($select->cc==5)
			{
				return '<a href="'.route('student.semanaImprime',$select->semana).'" class="btn btn-info btn-xs" target="_blank">Imprimir</a>';
			}else
			{
				return '<span><strong>--</strong></span>';
			}
			
            })
           
            ->make(true);
	}
	public function semanaImprime($semana)
	{
		
		$observaciones=semanaObservaciones::where([
			'user_id'=>Auth::user()->id,
			'semana'=>$semana
		])->get()->toArray();
		
		if(count($observaciones)>0)
		{
			$observaciones=$observaciones[0]['observacion'];

		}else{
			$observaciones='';
		}
	
		$usuario=Auth::user()->persona_id;
		
		$idsupervisor=StudentTeacher::where(
		[
		'user_est_id'=>Auth::user()->id,
		'estado'=>'A',
		'tipo'=>'SUP'
		
		])->get()->first();
		$supervisor=User::find($idsupervisor->user_doc_id);
		$supervisor=$supervisor->name;
		$objPostulant=Postulant::where('identificacion',$usuario)->get()->first();
		$objAsistencia=Asistencia::
		where('user_id',Auth::user()->id)
		->where('estado','A')
		->where('semana',$semana)
		->select(
		'fecha','horas','descripcion')
		->get()->toArray();

		$pdf=\PDF::setOptions(['isRemoteEnabled' => true])
		->loadView('frontend/datosImprimirSemana',compact(
			'objPostulant','semana','supervisor','objAsistencia','observaciones'));
		return $pdf->stream();

		/*	return view('frontend/datosImprimirSemana',compact(
			'objPostulant','semana','supervisor','objAsistencia','observaciones'));
*/
	}
	public function getDatatableAsistencia()
	{
       return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('asistencias AS a')
				->where('a.user_id',Auth::user()->id)
                ->orderby('a.created_at', 'ASC')
                ->select(
				'a.id as id',
				'a.estado as estado',
				'a.fecha as fecha',

				'a.descripcion as descripcion',
				'a.semana as semana',
				'a.horas as horas')
                ->get()

        )->addColumn('Estado', function ($select) {
				switch($select->estado)
				{
					case 'A':
					return '<span class="label label-primary">Aprobada</span>';
					break;
					case 'I':
					if(!$select->horas)
					{
						return '<span class="label label-success">No hay Asistencia</span>';
							break;
					}
					
					$link='<a href="'.route('student.agregaActividad',$select->id).'" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></a>';
					return '<span class="label label-danger">Pendiente</span>&nbsp;'.$link;
					break;
					case 'P':
					$link='<a href="'.route('student.agregaActividad',$select->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
					return '<span class="label label-warning">Pendiente de Aprobar</span>&nbsp;'.$link;

					break;
				}

            })
           
            ->make(true);
    }
	public function agregaActividad($id)
	{
		$obj=Asistencia::Find($id);
		$fecha=$obj->fecha;
			return view('modules.Solicitudescj.student.actividadesagrega',
			compact('id','fecha'));

	}
	public function estudianteasigna(Request $request){
		if($request->cant_horas==null || $request->cant_horas=='')
		{
			$request->cant_horas=2;
		}
		$objSt=new StudentTeacher();
		$objSt->user_est_id=Auth::user()->id;
		$objSt->user_doc_id=$request->supervisor;
		$objSt->horario_id=$request->horario;
		$objSt->lugar_id=$request->lugar;
		$objSt->hora_inicio=$request->horario_inicio;
		$objSt->hora_fin=$request->idhf;
		$objSt->cant_horas=$request->cant_horas;
		$objSt->tipo='SUP';
		$objSt->estado='I';
		$objSt->save();
			return redirect()->route('admin.estudianteperfil');

	}
	public function actividadSave(Request $request)
	{
		
		$obj=Asistencia::Find($request->id);
		$obj->descripcion=$request->descripcion;
		$obj->estado='P';
		$obj->save();
		$message='Grabado Exitoso';
		return redirect()->route('estudiante.actividadesEstudiante');
	}
	public function actividadesEstudiante()
	{
		$message='Aun no ha elegido Horario';
		$tipoM='warning';
		$objSt=StudentTeacher::where('user_est_id',Auth::user()->id)->get();
		
		$cc=0;
		$objSt1=$objSt->where('estado','A');
		if(count($objSt)!=0)
		{
			$message='Su seleccion de Horario está en proceso de revisiòn';
			$tipoM='warning';
			$cc=1;
			

		}
		if(count($objSt1)!=0)
		{
			$message='Su proceso de pasantias ha iniciado ';
			$tipoM='info';
			$cc=2;
		}
				return view('modules.Solicitudescj.student.actividades',compact('cc','message','tipoM'));

	}

	public function supervisor(Request $request)
	{
		$result = DB::connection('mysql')
            ->table('users AS C')
            ->where('C.lugarasignado_id', $request->valor)
            ->where('C.estado', 'A')
            ->groupBy('C.name', 'C.id')
            ->orderBy('C.name', 'DSC')
            ->select('C.id as id', 'C.name as descripcion')->get();

           // dd($result);

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
	public function datatableEvaluacionesSup()
	{
       return DataTables::of(
            DB::connection('mysql_solicitudescj')
                ->table('evaluacionsupervisor AS a')
                ->where('a.user_id',Auth::user()->id)
                ->join('core.users as u','u.id','a.user_id')
                ->join('postulants as p','p.identificacion','u.persona_id')
                ->orderby('a.created_at', 'ASC')
                ->select(
                    'a.id as id',
                'a.total as total',
                DB::RAW('CONCAT(p.apellidos," ",p.nombres) as estudiante'),
				'a.created_at as fecha_registro'
               )
                ->get()

        )->addColumn('Opciones', function ($select) {
		        return '<a href="'.route('supervisor.imprimirEvaluacionSup',$select->id).'" target="_blank" class="btn btn-primary btn-sm">Imprimir</a>';
            })
           
          
            ->make(true);
    }
}
