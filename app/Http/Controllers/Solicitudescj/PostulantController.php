<?php

namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Postulant;
use App\Core\Entities\Solicitudescj\RequestPostulant;
use App\User;
use Spatie\Permission\Models\Role;
use App\Mail\CreateUserStudent as CreateUserStudent;
use Yajra\Datatables\Datatables;
use Mail;
use App\Http\Controllers\Ajax\SelectController;
use App\Mail\NegadaPostulant as NegadaPostulant;
use App\Core\Entities\Solicitudescj\State as State;

class PostulantController extends Controller
{
	public function index(){

        //dd(1);

        /*$postulants=Postulant::with(['career'])->with(['request' => function ($query) {
            $query->with(['state' => function ($query) {
            
            }]);
        }])->get();*/

        //$postulants=Postulant::with(['career','request','request.state'])->get();

        //dd($postulants);
		
		return view('modules.Solicitudescj.postulants.index');

    }
    

	public function getDatatable()
    {


    	$postulants=Postulant::with(['request','request.state'])->get();

    	//dd($postulants);

        return DataTables::of($postulants)->addColumn('actions', function ($select) {

            return '<p class="text-center"><a title="Gestionar Postulante" href="'.route('porstulants.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
        })->addColumn('status_label', function ($select) {
            return $select->status_label;
        })->rawColumns(['actions','status_label'])
        ->make(true);


    }


    public function show($id){
        $postulant = Postulant::with(['request','request.state'])->find($id);

        //dd($postulant);

        if(!$postulant){
            return redirect()->route('postulant.index')->with('danger','No se ha encontrado el postulante');
        }  

        //dd($postulant);

        return view('modules.Solicitudescj.postulants.show', compact('postulant'));
    }


    public function statusRequest(Request $request){

        $postulantRequest = RequestPostulant::where('postulant_id',$request->id)->first(); 

		$postulant = Postulant::find($request->id); 
        //dd($postulantRequest,$request->id);      
        $postulantRequest->state_id=$request->status;
        $postulantRequest->save();

        

        if($request->status==2){
            $password=str_random(8);


          /*  $verifiqueUser = User::where('persona_id',$postulant->identificacion)
            ->where('estado','A')
            ->get();
*/
           // if(count($verifiqueUser)<1){

                $user = new User();
                $user->name = $postulant->nombres.' '.$postulant->apellidos;
                $user->email = $postulant->correo_institucional;
                $user->password = bcrypt($password); 
                $user->persona_id = $postulant->identificacion;
                $user->estado = 'A';
                $user->save();

                $user->assignRole([4]);

                Mail::to($user->email)->send(new CreateUserStudent($user, $password));

            //}
            /*else{

                $verifiqueUser[0]->estado = 'A';
                $verifiqueUser[0]->save();
            }*/
        }



        return redirect()
                ->route('porstulants.index')
                ->with('success', 'Se ha Modificado el Estatus de la Solucitud Satifactoramente');

    }

    public function statusIncompleto(Request $request)
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

        $status=State::where('abv','AUI')->first();

        $motivo= $request->motivo;
        $postulant = Postulant::find($request->postulant_id); 
        $postulant->motivo=$motivo;
        $postulant->save();        

        //dd($postulantRequest,$status,$postulant);
        //dd($postulantRequest,$request->id);      
        $postulantRequest->state_id=$status->id;
        $postulantRequest->save();

        Mail::to($postulant->correo_institucional)->send(new NegadaPostulant($postulant, $motivo));

        return redirect()->route('porstulants.index');
        //->with('message','El participante ha sido rechazado exitosamente');
    }

}
