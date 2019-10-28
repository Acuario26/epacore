<?php
namespace App\Http\Controllers\Solicitudescj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Solicitudescj\Client;
use App\Core\Entities\Solicitudescj\Consulta;
use App\Core\Entities\Solicitudescj\Archivo;
use Yajra\Datatables\Datatables;
use App\User;
use App\Core\Entities\Solicitudescj\StudentsSteachers;
use PDF;


class CasosController extends Controller
{
	public function index(){
		
		return view('modules.Solicitudescj.casos.index');

	}

	public function getDatatable()
  	{

      $casos=Consulta::with('cliente')->where('supervisor_id',auth()->user()->id)->orderBy('estado','DESC')->orderBy('id','ASC')->get();


       //dd($casos);

      return DataTables::of($casos)->addColumn('actions', function ($select) {
        return '<p class="text-center"><a title="Gestionar Clientes" href="'.route('casos.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
          })->addColumn('estado_label', function ($select) {
              return $select->estado_label;
      })->rawColumns(['actions','estado_label'])
      ->make(true);     

  	}

  	public function show($id){

  	  $caso =Consulta::find($id);
  	  	
      $client=Client::find($caso->cliente_id);

      $students = StudentsSteachers::where('user_doc_id',auth()->user()->id)->where('tipo','SUP')->where('estado','A')->pluck('user_est_id');

     

      $practicantes=User::whereIn('id',$students)->where('estado','A')->get();

      //dd($students,$practicantes);

      if(!$client){
            return redirect()->route('casos.index')->with('danger','No se ha encontrado el period');
      }

      return view('modules.Solicitudescj.casos.show', compact('client','practicantes','caso'));
    }


    public function updateCaso(Request $request,$id)
    {

      $rules = [
        'razon' => 'required',
        'causa' => 'required_if:razon,==,Patrocinio',
        'detalle' => 'required',
        'tipo_proceso' => 'required_if:razon,==,Patrocinio',
        'unidad_judicial' => 'required_if:razon,==,Patrocinio',
        'fecha_inicio' => 'required_if:razon,==,Patrocinio',
        //'demandante' => 'required_if:razon,==,Patrocinio',
        //'demandado' => 'required_if:razon,==,Patrocinio',
        'tipo_usuario' => 'required_if:razon,==,Patrocinio',
        'practicante_id' => 'nullable',
      ];
        
      $this->validate($request, $rules);

      //dd($request->all());
      $client = Consulta::find($id);
      $client->razon = $request->razon;
      $client->causa = $request->causa;
      $client->detalle = $request->detalle;
      $client->tipo_proceso = $request->tipo_proceso;
      $client->unidad_judicial = $request->unidad_judicial;
      $client->fecha_inicio = $request->fecha_inicio;
      $client->tipo_usuario = $request->tipo_usuario;
      //$client->demandante = $request->demandante;
      //$client->demandado = $request->demandado;
      $client->practicante_id = $request->practicante_id;
      if($request->razon=='Patrocinio'){
          $client->estado = 'PI';
      }else{
          $client->estado = 'F';
      }      

      //dd($client);
 
      $client->save();

      return redirect()->route('casos.show',$client->id);

    }


    public function updateCasoAsesoria(Request $request,$id)
    {

      $rules = [
        'materia' => 'required',
        'defensoria_publica' => 'required',
        'convirtio_patrocinio' => 'required',
      ];
        
      $this->validate($request, $rules);

      //dd($request->all());
      $consulta = Consulta::find($id);
      $consulta->materia = $request->materia;
      $consulta->defensoria_publica = $request->defensoria_publica;
      $consulta->convirtio_patrocinio = $request->convirtio_patrocinio;
      $consulta->estado = 'AT';      

      //dd($client);
 
      $consulta->save();

      return redirect()->route('casos.show',$consulta->id);

    }

    public function updateCasoPatrocinio(Request $request,$id)
    {

      $rules = [
        'materia' => 'required',
        'tipo_judicatura' => 'required',
        'tipo_patrocinio' => 'required',
        'pretension_presion' => 'required|numeric|min:0',
        'nombre_juez' => 'required',
        'ultima_actividad' => 'required',
        'fecha_ultima_actividad' => 'required',
        'estado_caso' => 'required',
        'defensoria_publica' => 'required',
        'resolución_judicial' => 'nullable',
        'fecha_resolucion' => 'nullable',
      ];
        
      $this->validate($request, $rules);

      //dd($request->all());
      $consulta = Consulta::find($id);
      $consulta->materia = $request->materia;
      $consulta->tipo_judicatura = $request->tipo_judicatura;
      $consulta->tipo_patrocinio = $request->tipo_patrocinio;
      $consulta->pretension_presion = $request->pretension_presion;
      $consulta->nombre_juez = $request->nombre_juez;
      $consulta->ultima_actividad = $request->ultima_actividad;
      $consulta->fecha_ultima_actividad = $request->fecha_ultima_actividad;
      $consulta->estado_caso = $request->estado_caso;
      $consulta->defensoria_publica = $request->defensoria_publica;
      $consulta->resolucion_judicial = $request->resolucion_judicial;
      $consulta->fecha_resolucion = $request->fecha_resolucion;
      $consulta->estado = 'AT';      

      //dd($client);
 
      $consulta->save();

      return redirect()->route('casos.show',$consulta->id);

    }

    public function print($id){

      $caso = Consulta::find($id);
      $client=Client::find($caso->cliente_id);

      //return view('modules.Solicitudescj.clients.imprimir', compact('client'));

      $path1=public_path() . '/images/ug.png';
      $type1 = pathinfo($path1, PATHINFO_EXTENSION);
      $im1 = file_get_contents($path1);
      $imdata1 = base64_encode($im1);

      $path2=public_path() . '/images/juris.png';
      $type2 = pathinfo($path2, PATHINFO_EXTENSION);
      $im2 = file_get_contents($path2);
      $imdata2 = base64_encode($im2);

      $pdf = PDF::loadView('modules.Solicitudescj.casos.imprimir', [
           'client' => $client,
           'caso' => $caso,
           'logo1'=>$imdata1,
           'type_image1'=>$type1,
           'logo2'=>$imdata2,
           'type_image2'=>$type2,
       ]);

      return $pdf->stream('caso_'.$id.'.pdf');
    }

    public function printCedula($id){

      $caso = Consulta::find($id);
      $client=Client::find($caso->cliente_id);

      //return view('modules.Solicitudescj.clients.imprimir', compact('client'));

      $path1=public_path() . '/images/ug.png';
      $type1 = pathinfo($path1, PATHINFO_EXTENSION);
      $im1 = file_get_contents($path1);
      $imdata1 = base64_encode($im1);

      $path2=public_path() . '/images/juris.png';
      $type2 = pathinfo($path2, PATHINFO_EXTENSION);
      $im2 = file_get_contents($path2);
      $imdata2 = base64_encode($im2);

      $path3=public_path() . '/file/'.$client->foto_cedula;
      $type3 = pathinfo($path3, PATHINFO_EXTENSION);
      $im3 = file_get_contents($path3);
      $imdata3 = base64_encode($im3);

      
      $pdf = PDF::loadView('modules.Solicitudescj.casos.imprimirCedula', [
           'client' => $client,
           'logo1'=>$imdata1,
           'type_image1'=>$type1,
           'logo2'=>$imdata2,
           'type_image2'=>$type2,
           'logo3'=>$imdata3,
           'type_image3'=>$type3,
       ]);

      return $pdf->stream('cedula_cliente_'.$client->cedula.'.pdf');
    }

    public function search(){
      return view('modules.Solicitudescj.casos.search');
    }

    public function searchPost(Request $request){

       $rules = [
        'fecha_desde' => 'required|date',
        'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        'tipo' => 'required',
      ];
        
      $this->validate($request, $rules);

      if($request->tipo=='Asesoria'){
        return redirect()->route('casos.searchFechaAsesoria',[$request->fecha_desde,$request->fecha_hasta]);
      }elseif($request->tipo=='Patrocinio'){
        return redirect()->route('casos.searchFechaPatrocinio',[$request->fecha_desde,$request->fecha_hasta]);
      }
    
    }

    public function searchFechaAsesoria($fecha_desde,$fecha_hasta){

      return view('modules.Solicitudescj.casos.reporteAsesoria',compact('fecha_desde','fecha_hasta'));

    }

    public function searchFechaPatrocinio($fecha_desde,$fecha_hasta){

      return view('modules.Solicitudescj.casos.reportePatrocinio',compact('fecha_desde','fecha_hasta'));

    }

    public function searchDataAsesoria($fecha_desde,$fecha_hasta){
      //dd($fecha_desde,$fecha_hasta);

      $rol=auth()->user()->roles->where('abv','DIR');

      if(count($rol)>0){

        $casos=Consulta::with(['cliente','supervisor'])
        ->whereBetween('created_at', [$fecha_desde.' 00:00:00', $fecha_hasta.' 23:59:59'])
        ->where('razon','Asesoría')
        ->orderBy('estado','DESC')
        ->orderBy('id','ASC')
        ->get();

      }else{

        $casos=Consulta::with(['cliente','supervisor'])
        ->where('supervisor_id',auth()->user()->id)
        ->whereBetween('created_at', [$fecha_desde.' 00:00:00', $fecha_hasta.' 23:59:59'])
        ->where('razon','Asesoría')
        ->orderBy('estado','DESC')
        ->orderBy('id','ASC')
        ->get();

      }

      //dd($casos[0]->cliente->fecha_nacimiento_es);


      return DataTables::of($casos)->addColumn('actions', function ($select) {
        return '<p class="text-center"><a title="Gestionar Clientes" href="'.route('casos.show',$select->id).'"><span class="fa fa-cog"></span></a><p>';
          })->addColumn('estado_label', function ($select) {
              return $select->estado_label;
      })->addColumn('cjga', function ($select) {
              return $select->cjga;
      })->addColumn('mes', function ($select) {
              return $select->mes_label;
      })->addColumn('annio', function ($select) {
              return $select->annio;
      })->addColumn('provincia', function ($select) {
              return $select->provincia;
      })->addColumn('ciudad', function ($select) {
              return $select->ciudad;
      })->addColumn('created_at_es', function ($select) {
              return $select->created_at_es;
      })->addColumn('cliente_nombre', function ($select) {
              return $select->cliente_nombre;
      })->addColumn('cliente_fecha_nacimiento', function ($select) {
              return $select->cliente->fecha_nacimiento_es;
      })->addColumn('detalle', function ($select) {
              return $select->observacion;
      })->rawColumns(['actions','estado_label'])
      ->make(true); 


    }

    public function searchDataPatrocinio($fecha_desde,$fecha_hasta){
      //dd($fecha_desde,$fecha_hasta);

      $rol=auth()->user()->roles->where('abv','DIR');

      if(count($rol)>0){

        $casos=Consulta::with(['cliente','supervisor'])
        ->whereBetween('created_at', [$fecha_desde.' 00:00:00', $fecha_hasta.' 23:59:59'])
        ->where('razon','Patrocinio')
        ->orderBy('estado','DESC')
        ->orderBy('id','ASC')
        ->get();

      }else{

        $casos=Consulta::with(['cliente','supervisor'])
        ->where('supervisor_id',auth()->user()->id)
        ->whereBetween('created_at', [$fecha_desde.' 00:00:00', $fecha_hasta.' 23:59:59'])
        ->where('razon','Patrocinio')
        ->orderBy('estado','DESC')
        ->orderBy('id','ASC')
        ->get();

      }

      //dd($casos[0]->cliente->fecha_nacimiento_es);


      return DataTables::of($casos)->addColumn('cjga', function ($select) {
              return $select->cjga;
      })->addColumn('mes', function ($select) {
              return $select->mes_label;
      })->addColumn('annio', function ($select) {
              return $select->annio;
      })->addColumn('provincia', function ($select) {
              return $select->provincia;
      })->addColumn('ciudad', function ($select) {
              return $select->ciudad;
      })->addColumn('created_at_es', function ($select) {
              return $select->created_at_es;
      })->addColumn('cliente_nombre', function ($select) {
              return $select->cliente_nombre;
      })->addColumn('cliente_fecha_nacimiento', function ($select) {
              return $select->cliente->fecha_nacimiento_es;
      })->addColumn('detalle', function ($select) {
              return $select->observacion;
      })->rawColumns(['actions','estado_label'])
      ->make(true); 


    }

    public function archivo(){
    
      return view('modules.Solicitudescj.casos.archivo');

    }

    public function archivoSubir(){
    
      return view('modules.Solicitudescj.casos.subir');

    }

    public function archivoGuardar(Request $request){
        $rules = [
            'nombre' => 'required',
            'archivo_caso' => 'required|mimes:xls,xlsx',
            
        ];

        $this->validate($request, $rules);

        //dd($request->archivo_caso,$request->all);
        //

        //dd($request->file('archivo_caso'),$request->file('archivo_caso')->getMimeType());

        $archivo = new Archivo();
        $archivo->nombre =  $request->nombre;
        $archivo->archivo_caso = '';

        $archivo->save();

        if ($request->hasFile('archivo_caso')){
          $path = $request->file('archivo_caso')->storeAs('archivos'.'/'.$archivo->id,str_slug($archivo->nombre, "_").'.xlsx','file');
          $archivo->archivo_caso=$path;
        }

        $archivo->save();

        return redirect()->route('casos.archivo');
    }

    public function archivoData()
    {

      $archivos=Archivo::orderBy('created_at','DESC')->get();



       //dd($casos);

      return DataTables::of($archivos)->addColumn('actions', function ($select) {
        return '<p class="text-center"><a title="Descargar" target="_blank" href="'.asset('file/'.$select->archivo_caso).'"><span class="fa fa-download"></span></a><p>';
      })->rawColumns(['actions'])
      ->make(true);     

    }


}