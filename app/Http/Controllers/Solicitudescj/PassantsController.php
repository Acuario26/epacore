<?php

namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\RequestPostulant;
use App\Core\Entities\Solicitudescj\Schedule;
use App\Core\Entities\Solicitudescj\StudentsSteachers;
use App\Core\Entities\Solicitudescj\State;
use App\Core\Entities\Solicitudescj\Place;
use App\Core\Entities\Solicitudescj\Horario;
use App\Core\Entities\Solicitudescj\Period;
use App\User;
use Spatie\Permission\Models\Role;
use App\Mail\CreateUserStudent as CreateUserStudent;
use App\Mail\RejectionUserStudent as RejectionUserStudent;
use App\Mail\AssignTeacherStudent as AssignTeacherStudent;
use Yajra\Datatables\Datatables;
use Mail;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use PDF;

class PassantsController extends Controller
{
	public function index(){

        //dd(1);

        /*$postulants=Postulant::with(['career'])->with(['request' => function ($query) {
            $query->with(['state' => function ($query) {
            
            }]);
        }])->get();*/

        //$postulants=Postulant::with(['career','request','request.state'])->get();

        //dd($postulants);

        $postulants=Postulant::with(['request','request.state'])
    	->whereHas('request.state', function ($query) {
		    $query->whereIn('abv',['AP','NE','AB']);
		})->get();

		//dd($postulants);
		
		return view('modules.Solicitudescj.passants.index');

    }
    

	public function getDatatable()
    {


    	$postulants=Postulant::with(['request','request.state'])
    	->whereHas('request.state', function ($query) {
		    $query->whereIn('abv',['AP','NE','AB']);
		})->get();

    	//dd($postulants);

        return DataTables::of($postulants)->addColumn('actions', function ($select) {

            return '<p class="text-center"><a title="Gestionar Pasante" href="'.route('passants.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
        })->addColumn('status_label', function ($select) {
            return $select->status_label;
        })->rawColumns(['actions','status_label'])
        ->make(true);


    }


    public function show($id){
        $postulant = Postulant::with(['request','request.state'])->find($id);

        //dd($postulant);

        $student=User::where('persona_id',$postulant->identificacion)->get();

        $supervisors=User::whereHas('roles', function ($query) {
            $query->whereIn('abv',['SUP']);
        })->where('estado','A')->pluck('name','id');

        $horarios = Schedule::pluck('descripcion','id');

        

        $students_teachers = StudentsSteachers::where('user_est_id',$student[0]->id)->where('tipo','TUT')->get();

        $students_teachers1 = StudentsSteachers::where('user_est_id',$student[0]->id)->where('tipo','SUP')->get();

        if(count($students_teachers)>0){
            $supervisor=User::find($students_teachers[0]->user_doc_id);
            $horario=[];
            $horario_id=0;
            //$horario=Schedule::find($students_teachers[0]->horario_id);
            $supervisor_id=$supervisor->id;
            //$horario_id=$students_teachers[0]->horario_id;
        }else{
            $supervisor=[];
            $horario=[];
            $supervisor_id=0;
            $horario_id=0;
        }

        if(count($students_teachers1)>0){
            $supervisor1=User::find($students_teachers1[0]->user_doc_id);
            $horario1=Schedule::find($students_teachers1[0]->horario_id);
        }else{
            $supervisor1=[];
            $horario1=[];
            
        }




        if(!$postulant){
            return redirect()->route('passant.index')->with('danger','No se ha encontrado el postulante');
        }  

        //dd($postulant);

        return view('modules.Solicitudescj.passants.show', compact('postulant','supervisors','supervisor','supervisor_id','horarios','horario','horario_id','supervisor1','horario1','student','students_teachers1'));
    }


    public function assignSteacherTutor(Request $request)
    {
        //dd($request->all());

        $rules = [
            'user_doc_id' => 'required',
            //'horario_id' => 'required',
        ];
        $messages = [
            'user_doc_id.required' => 'Elija el supervisor ',
            //'horario_id.required' => 'Elija el Horario',

        ];
        $this->validate($request, $rules);


        $teachers = StudentsSteachers::where('user_est_id',$request->id)->where('tipo','TUT')->get();

        if(count($teachers)>0){
           $students_teachers= StudentsSteachers::find($teachers[0]->id);
           //dd($students_teachers);
        }else{
           $students_teachers= new StudentsSteachers(); 
        }
        
        $students_teachers->user_est_id = $request->id;
        $students_teachers->user_doc_id = $request->user_doc_id;
        $students_teachers->tipo = 'TUT';
        //$students_teachers->horario_id = $request->horario_id;
        $students_teachers->estado = 'A';
        $students_teachers->save();


        $postulante=Postulant::find($request->postulant_id);
        
        $teachers = StudentsSteachers::with(['docente'])->where('user_est_id',$request->id)->where('tipo','TUT')->get();

        $practicante= User::find($request->id);

        $periodo= Period::where('estado','A')->find($postulante->periodo_id);


        $path1=public_path() . '/images/ug.png';
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $im1 = file_get_contents($path1);
        $imdata1 = base64_encode($im1);

        $path2=public_path() . '/images/juris.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $im2 = file_get_contents($path2);
        $imdata2 = base64_encode($im2);

      
        $pdf = PDF::loadView('modules.Solicitudescj.passants.imprimirPlanillaTutor', [
           'postulante' => $postulante,
           'docente' => $teachers[0]->docente,
           'logo1'=>$imdata1,
           'type_image1'=>$type1,
           'logo2'=>$imdata2,
           'type_image2'=>$type2,
           'periodo'=> $periodo,
        ]);

        //$file=public_path('/file/planillas/planilla_tutor_asignado_'.$postulante->id.'.pdf');

        //$pdf->save($file);

        Mail::to($practicante->email)->send(new AssignTeacherStudent($practicante,'Tutor', $pdf));

        //return redirect()->route('passants.index');
        return redirect()->route('passants.show',$request->postulant_id);

    }

    public function assignSteacherSupervisor(Request $request)
    {

        $rules = [
            'lugar' => 'integer|min:1',
            'supervisor' => 'integer|min:1',
            'horario' => 'integer|min:1',
            'hora' => 'integer|min:1',
            //'horario_id' => 'required',
        ];
        $messages = [
            'lugar.min' => 'Selecione el lugar',
            'supervisor.min' => 'Selecione el supervisor',
            'horario.min' => 'Selecione la hora de inicio',
            'hora.min' => 'Selecione el hora a trabajar',
            //'horario_id.required' => 'Elija el Horario',
        ];
        $this->validate($request, $rules, $messages);
        //dd($request->all());

        

        $teachers = StudentsSteachers::where('user_est_id',$request->id)->where('tipo','SUP')->get();

        $tutor = StudentsSteachers::with(['docente'])->where('user_est_id',$request->id)->where('tipo','TUT')->get();

        $practicante= User::find($request->id);

        $postulante=Postulant::find($request->postulant_id);

        $periodo= Period::where('estado','A')->find($postulante->periodo_id);

        //dd($postulante,$request->postulant_id);

        if(count($teachers)>0){
           $students_teachers= StudentsSteachers::find($teachers[0]->id);
           //dd($students_teachers);
        }else{
           $students_teachers= new StudentsSteachers(); 
        }

        $hora_final=intval($request->horario)+intval($request->hora);

        //dd(intval($request->horario)+intval($request->hora));

        $students_teachers->user_est_id = $request->id;
        $students_teachers->user_doc_id = $request->supervisor;
        $students_teachers->tipo = 'SUP';
        $students_teachers->lugar_id = $request->lugar;
        $students_teachers->hora_inicio = $request->horario.':00';
        $students_teachers->hora_fin = $hora_final.':00';
        $students_teachers->cant_horas = $request->hora;
        $students_teachers->estado = 'A';
        $students_teachers->save();

        $path1=public_path() . '/images/ug.png';
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $im1 = file_get_contents($path1);
        $imdata1 = base64_encode($im1);

        $path2=public_path() . '/images/juris.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $im2 = file_get_contents($path2);
        $imdata2 = base64_encode($im2);

        $teachers = StudentsSteachers::where('user_est_id',$request->id)->where('tipo','SUP')->get();

          
        $pdf = PDF::loadView('modules.Solicitudescj.passants.imprimirPlanillaSupervisor', [
               'postulante' => $postulante,
               'docente' => $teachers[0]->docente,
               'cant_horas' => $teachers[0]->cant_horas,
               'tutor' => $tutor[0]->docente,
               'logo1'=>$imdata1,
               'type_image1'=>$type1,
               'logo2'=>$imdata2,
               'type_image2'=>$type2,
               'periodo' => $periodo,
        ]);

        //$file=public_path('/file/planillas/planilla_supervisor_asignado_'.$postulante->id.'.pdf');

        //$pdf->save($file);

        Mail::to($practicante->email)->send(new AssignTeacherStudent($practicante,'Supervisor', $pdf));


        return redirect()->route('passants.show',$request->postulant_id);
    }

    public function activarSupervisor($id){
       

        $teachers = StudentsSteachers::where('user_est_id',$id)->where('tipo','SUP')->first();

        $tutor = StudentsSteachers::with(['docente'])->where('user_est_id',$id)->where('tipo','TUT')->get();

        $practicante= User::find($id);
        $postulantess=Postulant::where('identificacion',$practicante->persona_id)->get()->first();

        $postulante=Postulant::where('identificacion',$practicante->persona_id)->get();
  

        $periodo= Period::where('estado','A')->find($postulante[0]->periodo_id);

        //dd($postulante);

        //dd($teachers);
        $teachers->estado = 'A';
        $teachers->save();


        $path1=public_path() . '/images/ug.png';
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $im1 = file_get_contents($path1);
        $imdata1 = base64_encode($im1);

        $path2=public_path() . '/images/juris.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $im2 = file_get_contents($path2);
        $imdata2 = base64_encode($im2);

        $tutor1= count($tutor)>0 ? $tutor[0]->docente : null;
          
        $pdf = PDF::loadView('modules.Solicitudescj.passants.imprimirPlanillaSupervisor', [
               'postulante' => $postulante[0],
               'docente' => $teachers->docente,
               'cant_horas' => $teachers->cant_horas,
               'tutor' => $tutor1,
               'logo1'=>$imdata1,
               'type_image1'=>$type1,
               'logo2'=>$imdata2,
               'type_image2'=>$type2,
               'periodo'=> $periodo,
        ]);

       //$file=public_path('file/planillas/planilla_supervisor_asignado_'.$postulante[0]->id.'.pdf');
       // $file=public_path('file\planillas\planilla_supervisor_asignado_'.$postulante[0]->id.'.pdf');

        //$pdf->save($file);
        $file='';

        Mail::to($practicante->email)->send(new AssignTeacherStudent($practicante,'Supervisor', $pdf));

        return redirect()->route('passants.show',$postulante[0]->id);
    }

    public function statusRejection(Request $request)
    {
        //dd($request->all());

        $rules = [
            'motivo' => 'required|string|min:20|max:255',
            //'horario_id' => 'required',
        ];
        $messages = [
            'motivo.required' => 'El motivo del rechazo es requerido',
            //'horario_id.required' => 'Elija el Horario',

        ];
        $this->validate($request, $rules);

        $postulantRequest = RequestPostulant::where('postulant_id',$request->postulant_id)->first(); 
        $state_id_a = $postulantRequest->state_id;

        $status=State::where('abv','NE')->first();
        $motivo= $request->motivo;
        $postulant = Postulant::find($request->postulant_id); 
        $postulant->motivo=$motivo;
        $postulant->estado='I';
        $postulant->save();

        $user = User::where('persona_id',$postulant->identificacion)->first();

        $user->estado = 'I';
        $user->save();
        

        //dd($postulantRequest,$status,$postulant);
        //dd($postulantRequest,$request->id);      
        $postulantRequest->state_id=$status->id;
        $postulantRequest->state_id_a= $state_id_a;
        $postulantRequest->save();

        Mail::to($user->email)->send(new RejectionUserStudent($user, $postulant, $motivo));

        return redirect()->route('passants.index');
        //->with('message','El participante ha sido rechazado exitosamente');
    }

    public function statusActivar(Request $request)
    {
        //dd($request->all());


        $postulantRequest = RequestPostulant::where('postulant_id',$request->postulant_id)->first(); 
        $state_id_a = $postulantRequest->state_id_a;

        //dd($postulantRequest);
        
        $postulant = Postulant::find($request->postulant_id); 
        $postulant->estado='A';
        $postulant->save();

        $user = User::where('persona_id',$postulant->identificacion)->first();

        $user->estado = 'A';
        $user->save();
        

        //dd($postulantRequest,$status,$postulant);
        //dd($postulantRequest,$request->id);      
        $postulantRequest->state_id= $state_id_a;
        $postulantRequest->save();

        //Mail::to($user[0]->email)->send(new RejectionUserStudent($user[0], $postulant, $motivo));

        return redirect()->route('passants.index');
        //->with('message','El participante ha sido rechazado exitosamente');
    }

    public function consultaSupervisor(Request $request){

        if($request->query('request')=='lugares'){
            return $lugares=Place::all();
        }elseif($request->query('request')=='supervidores'){
            $lugar_id=$request->query('lugar_id');
            /*$result = DB::connection('mysql')
            ->table('users AS C')
            ->where('C.lugarasignado_id', $lugar_id)
            ->where('C.estado', 'A')
            ->groupBy('C.name', 'C.id')
            ->orderBy('C.name', 'DSC')
            ->select('C.id as id', 'C.name as descripcion')->get();*/
            $result= User::where('estado','A')
            ->where('lugarasignado_id',$lugar_id)
            ->select('id as id', 'name as descripcion')
            ->orderBy('name', 'DESC')
            ->where('estado','A')
            ->get();

            //dd($result);
            return $result;
        }elseif($request->query('request')=='horarios'){
            return $horario=Horario::all();
        }

        //dd($request->query('request'),$request->query);

    }

    public function selectSupervisor($id){
        $teachers = StudentsSteachers::with(['docente','horario','lugar'])->where('user_est_id',$id)->where('tipo','SUP')->first();

        return $teachers;
    }


    public function printPlanillaTutor($id){

    
      $postulante=Postulant::find($id);
      $practicante=User::where('persona_id',$postulante->identificacion)->get();
      //dd($practicante,$postulante);
      $teachers = StudentsSteachers::with(['docente'])->where('user_est_id',$practicante[0]->id)->where('tipo','TUT')->get();
      
      $periodo= Period::where('estado','A')->find($postulante->periodo_id);
   
      //dd($teachers);

      //return view('modules.Solicitudescj.clients.imprimir', compact('client'));

      $path1=public_path() . '/images/ug.png';
      $type1 = pathinfo($path1, PATHINFO_EXTENSION);
      $im1 = file_get_contents($path1);
      $imdata1 = base64_encode($im1);

      $path2=public_path() . '/images/juris.png';
      $type2 = pathinfo($path2, PATHINFO_EXTENSION);
      $im2 = file_get_contents($path2);
      $imdata2 = base64_encode($im2);

      
      $pdf = PDF::loadView('modules.Solicitudescj.passants.imprimirPlanillaTutor', [
           'postulante' => $postulante,
           'docente' => $teachers[0]->docente,
           'logo1'=>$imdata1,
           'type_image1'=>$type1,
           'logo2'=>$imdata2,
           'type_image2'=>$type2,
           'periodo'=>$periodo,
       ]);

      return $pdf->stream('planilla_tutor_asignado_'.$postulante->id.'.pdf');
    }

    public function printPlanillaSupervisor($id){
      $postulante=Postulant::find($id);
      $practicante=User::where('persona_id',$postulante->identificacion)->get();
      //dd($practicante,$postulante);
      $teachers = StudentsSteachers::with(['docente'])->where('user_est_id',$practicante[0]->id)->where('tipo','SUP')->get();

      $tutor = StudentsSteachers::with(['docente'])->where('user_est_id',$practicante[0]->id)->where('tipo','TUT')->get();

      $periodo= Period::where('estado','A')->find($postulante->periodo_id);

      //dd($periodo);


      //dd($teachers);

      //dd($teachers);

      //return view('modules.Solicitudescj.clients.imprimir', compact('client'));

      $path1=public_path() . '/images/ug.png';
      $type1 = pathinfo($path1, PATHINFO_EXTENSION);
      $im1 = file_get_contents($path1);
      $imdata1 = base64_encode($im1);

      $path2=public_path() . '/images/juris.png';
      $type2 = pathinfo($path2, PATHINFO_EXTENSION);
      $im2 = file_get_contents($path2);
      $imdata2 = base64_encode($im2);

      $tutor1= count($tutor)>0 ? $tutor[0]->docente : null;
      
      $pdf = PDF::loadView('modules.Solicitudescj.passants.imprimirPlanillaSupervisor', [
           'postulante' => $postulante,
           'docente' => $teachers[0]->docente,
           'cant_horas' => $teachers[0]->cant_horas,
           'tutor' => $tutor1,
           'logo1'=>$imdata1,
           'type_image1'=>$type1,
           'logo2'=>$imdata2,
           'type_image2'=>$type2,
           'periodo'=>$periodo,
       ]);

      return $pdf->stream('planilla_supervisor_asignado_'.$postulante->id.'.pdf');
    }


    

}

