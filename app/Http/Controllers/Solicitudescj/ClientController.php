<?php
namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Client;
use App\Core\Entities\Solicitudescj\Consulta;
use Yajra\Datatables\Datatables;
use App\User;
use App\Core\Entities\Solicitudescj\StudentsSteachers;
use Storage;

class ClientController extends Controller
{
	public function index(){
        /*$users=User::whereHas('roles', function ($query) {
		    $query->whereIn('abv',['SUP','TUT','SEC']);
		})->get();
		dd($users);*/
		//dd($users[0]->roles_label);
		//dd(User::all());

    $sup=auth()->user()->roles->where('abv','SUP');

		return view('modules.Solicitudescj.clients.index',compact('sup'));
	}


	public function getDatatable()

  {

      
      $auth=auth()->user()->roles->where('abv','SUP');

      if(count($auth)>0){


        $clients=Client::where('supervisor_id',auth()->user()->id)->get();


        //dd($clients);

          return DataTables::of($clients)->addColumn('actions', function ($select) {
        return '<p class="text-center"><a title="Gestionar Clientes" href="'.route('clients.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
          })->addColumn('estado_label', function ($select) {
              return $select->estado_label;
          })->rawColumns(['actions','estado_label'])
          ->make(true);

      }else{

  	    $clients=Client::get();

      	//dd($clients);

          return DataTables::of($clients)->addColumn('actions', function ($select) {
  			return '<p class="text-center"><a title="Gestionar Clientes" href="'.route('clients.edit',$select->id).'"><span class="fa fa-cog"></span></a><p>';
          })->addColumn('estado_label', function ($select) {
              return $select->estado_label;
          })->rawColumns(['actions','estado_label'])
          ->make(true);
      }

  }

  public function create(){

    $supervisors=User::whereHas('roles', function ($query) {
      $query->whereIn('abv',['SUP']);
    })->pluck('name','id');
		
		return view('modules.Solicitudescj.clients.create',compact('supervisors'));
	}

	public function store(Request $request)
    {

    	
        $rules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required',
            'cedula' => 'required|digits_between:7,10|unique:mysql_solicitudescj.clientes,cedula',
            'fecha_nacimiento' => 'required',
            'nacionalidad' => 'required',
            'etnia' => 'required',
            'celular' => 'required|regex:/(09)[0-9]{8}/',
            'convencional' => 'nullable|digits_between:7,10',
            'instruccion' => 'required',
            'domicilio' => 'required',
            'estado_civil' => 'required',
            'sexo' => 'required',
            'tipo_sexo' => 'required_if:sexo,==,Otros',
            'sector' => 'required',
            'ocupacion' => 'required',
            'ingresos' => 'required',
            'bono' => 'required',
            'discapacidad' => 'required',
            'tipo_discapacidad' => 'required_if:discapacidad,==,SI',
            'enfermedad' => 'required',
            'tipo_enfermedad' => 'required_if:enfermedad,==,SI',
            'foto_cedula' => 'required|image',
            //'supervisor_id' => 'required',
        ];/*
        $messages = [
            'descripcion.required' => 'Escriba el descripcion ',
            'fechai.required' => 'Escriba la fecha inicio ',
            'fechaf.required' => 'Escriba la fecha final',
        ];*/
        
        $this->validate($request, $rules);

        //dd($request->all());
        /*

        
        $period = new Period();
        $period->descripcion=$request->descripcion;
        $period->fechai=$request->fechai;
        $period->fechaf=$request->fechaf;
        $period->maxtutoria=$request->maxtutoria;
        $period->fechai_extraordinaria=$request->fecha_extraordinaria;
        $period->fechaf_extraordinaria=$request->fechaf_extraordinaria;
        $period->estado = 'A';
        $period->save();*/

      $client = new Client();
      $client->nombres = $request->nombres;
	  $client->apellidos = $request->apellidos;
	  $client->cedula = $request->cedula;
	  $client->fecha_nacimiento = $request->fecha_nacimiento;
	  $client->nacionalidad = $request->nacionalidad;
	  $client->etnia = $request->etnia;
	  $client->celular = $request->celular;
	  $client->convencional = $request->convencional;
	  $client->instruccion = $request->instruccion;
	  $client->domicilio = $request->domicilio;
	  $client->estado_civil = $request->estado_civil;
	  $client->sexo = $request->sexo;
	  $client->tipo_sexo = $request->tipo_sexo;
	  $client->sector = $request->sector;
	  $client->ocupacion = $request->ocupacion;
	  $client->iess = $request->iess;
	  $client->ingresos = $request->ingresos;
	  $client->bono = $request->bono;
	  $client->discapacidad = $request->discapacidad;
	  $client->tipo_discapacidad = $request->tipo_discapacidad;
	  $client->enfermedad = $request->enfermedad;
	  $client->tipo_enfermedad = $request->tipo_enfermedad;
	  $client->monitor_id = auth()->user()->id;
    //$client->supervisor_id = $request->supervisor_id;
	  $client->estado = 'A';
    $client->foto_cedula = '';


    //dd($client);
	  $client->save();

    if ($request->hasFile('foto_cedula')){
      $path = $request->file('foto_cedula')->store('clientes'.'/'.$client->id,'file');
      $client->foto_cedula=$path;
    }

    $client->save();

      return redirect()->route('clients.index');
    }

    public function edit($id){
     	$client=Client::find($id);

      $lugarasignado_id=auth()->user()->lugarasignado_id;

		  if(!$client){
            return redirect()->route('client.index')->with('danger','No se ha encontrado el period');
      }

      $supervisors=User::whereHas('roles', function ($query) {
        $query->whereIn('abv',['SUP']);
      })->where('lugarasignado_id',$lugarasignado_id)->pluck('name','id');

      //dd(auth()->user());

      return view('modules.Solicitudescj.clients.edit', compact('client','supervisors'));
    }

     public function show($id){
      $client=Client::find($id);

      $students = StudentsSteachers::where('user_doc_id',auth()->user()->id)->where('tipo','SUP')->where('estado','A')->pluck('user_est_id');

     

      $practicantes=User::whereIn('id',$students)->where('estado','A')->get();

      //dd($students,$practicantes);

      if(!$client){
            return redirect()->route('client.index')->with('danger','No se ha encontrado el period');
      }

      return view('modules.Solicitudescj.clients.show', compact('client','practicantes'));
    }

    public function update(Request $request,$id)
    {

        
        $rules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required',
            'cedula' => 'required|digits_between:7,10|unique:mysql_solicitudescj.clientes,cedula,'.$id.',id',
            'fecha_nacimiento' => 'required',
            'nacionalidad' => 'required',
            'etnia' => 'required',
            'celular' => 'required|regex:/(09)[0-9]{8}/',
            'convencional' => 'nullable|digits_between:7,10',
            'instruccion' => 'required',
            'domicilio' => 'required',
            'estado_civil' => 'required',
            'sexo' => 'required',
            'tipo_sexo' => 'required_if:sexo,==,Otros',
            'sector' => 'required',
            'ocupacion' => 'required',
            'ingresos' => 'required',
            'bono' => 'required',
            'discapacidad' => 'required',
            'tipo_discapacidad' => 'required_if:discapacidad,==,SI',
            'enfermedad' => 'required',
            'tipo_enfermedad' => 'required_if:enfermedad,==,SI',
            'foto_cedula' => 'nullable|image',
            //'supervisor_id' => 'required',
        ];
        
        $this->validate($request, $rules);

        

      $client = Client::find($id);
      $client->nombres = $request->nombres;
      $client->apellidos = $request->apellidos;
      $client->cedula = $request->cedula;
      $client->fecha_nacimiento = $request->fecha_nacimiento;
      $client->nacionalidad = $request->nacionalidad;
      $client->etnia = $request->etnia;
      $client->celular = $request->celular;
      $client->convencional = $request->convencional;
      $client->instruccion = $request->instruccion;
      $client->domicilio = $request->domicilio;
      $client->estado_civil = $request->estado_civil;
      $client->sexo = $request->sexo;
      $client->tipo_sexo = $request->tipo_sexo;
      $client->sector = $request->sector;
      $client->ocupacion = $request->ocupacion;
      $client->iess = $request->iess;
      $client->ingresos = $request->ingresos;
      $client->bono = $request->bono;
      $client->discapacidad = $request->discapacidad;
      $client->tipo_discapacidad = $request->tipo_discapacidad;
      $client->enfermedad = $request->enfermedad;
      $client->tipo_enfermedad = $request->tipo_enfermedad;
      //$client->supervisor_id = $request->supervisor_id;
      
      //dd($request);
      //dd($client);
      $client->save();

      if ($request->hasFile('foto_cedula')){
        $foto = $client->foto_cedula;
        if(Storage::disk('file')->has($foto)){
          Storage::disk('file')->delete($foto);
        }
        $path = $request->file('foto_cedula')->store('clientes'.'/'.$client->id,'file');
        $client->foto_cedula=$path;
        $client->save();
      }

      return redirect()->route('clients.index');
    }


    public function updateCaso(Request $request,$id)
    {

      $rules = [
        'razon' => 'required',
        'causa' => 'required',
        'detalle' => 'required',
        'tipo_proceso' => 'required',
        'unidad_judicial' => 'required',
        'fecha_inicio' => 'required',
        'demandante' => 'required',
        'demandado' => 'required',
        'practicante_id' => 'required',
      ];
        
      $this->validate($request, $rules);

      //dd($request->all());
      $client = Client::find($id);
      $client->razon = $request->razon;
      $client->causa = $request->causa;
      $client->detalle = $request->detalle;
      $client->tipo_proceso = $request->tipo_proceso;
      $client->unidad_judicial = $request->unidad_judicial;
      $client->fecha_inicio = $request->fecha_inicio;
      $client->demandante = $request->demandante;
      $client->demandado = $request->demandado;
      $client->practicante_id = $request->practicante_id;

      //dd($client);
 
      $client->save();

      return redirect()->route('clients.index');

    }

    public function print($id){
      $client=Client::find($id);

      return view('modules.Solicitudescj.clients.imprimir', compact('client'));
    }

    public function asignarSupervisor(Request $request){

      $rules = [
        'supervisor_id' => 'required',
      ];
        
      $this->validate($request, $rules);

      $consulta= new Consulta();
      $consulta->cliente_id = $request->cliente_id;
      $consulta->supervisor_id = $request->supervisor_id;
      $consulta->estado = 'P';
      $consulta->save();

      //dd($request->all());
      return redirect()->route('clients.index');
    }

    public function getDatatableConsultaAsignacion($id){



        $consultas= Consulta::with(['supervisor'])->where('cliente_id',$id)->get();

        return DataTables::of($consultas)->addColumn('actions', function ($select) {
          return '';
        })->rawColumns(['actions'])
        ->make(true);


    } 



}