<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Admin\tb_parametro;
use App\Core\Entities\Solicitudes\Empleados;
use App\Core\Entities\Solicitudes\Asignaciones;
use App\Core\Entities\Gestion\Pago;
use App\Core\Entities\Gestion\LLamada;

use App\Core\Entities\Gestion\Cliente;
use App\User;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Utils;
use Yajra\Datatables\Datatables;

class GestionController extends Controller
{
	public function asignacionCulmina(request $request)
	{
         
        $array_response['status'] = 200;
        $array_response['message'] = "Grabado Correctamente";      
        $str = $request->identidad;
        if($str!=[]&&$str!=""&&$str!=null)
        {
            $data=explode(",",$str);
            $usuario=$request->usuario;
            $d=$request->d;
            
            foreach ($data as $v){ 
                $select=Cliente::where('id',$v)->get()->first();
                $fecha_actual = date("d-m-Y");
                $datetime2 = date_create($fecha_actual); //fecha actual
                $datetime1 = date_create($select->fecha_vencida); //fecha de db
                $interval = date_diff($datetime1, $datetime2, false);
                $dias = intval($interval->format('%R%a'));
               // $d=date_format($datetime1,'Y-m-d');
                if($select->porcentaje_pago>29)
                {
                    $dias=$dias-30;
                    if($dias<1)
                    {
                        $dias=0;
                    }
    
                }
                $result=$dias;
                if($d=="RECAUDADOR")
                {
                        $d="recaudador_user";
        
                    $user=Empleados::Find($usuario)->identificacion;
                    Cliente::where('id',$v)->update([$d=>$user]);
                }else {
                            if($dias>0&&$dias<31){
                                {
                                    if($d=="OPERADOR")
                                    {
                                        $d="operador_user";
                                        $user=Empleados::Find($usuario)->identificacion;
                                        Cliente::where('id',$v)->update([$d=>$user]);
                                    }else {
                                        $array_response['status'] = 404;
                                        $array_response['message'] = "El operador1 no coincides con los parametros de las fechas vencidas"; 
                                     }
                                }
                            }else{
                                if($dias>32&&$dias<91)
                                {
                                        if($d=="OPERADOR2"){
                                            $d="operador_user";
                                            $user=Empleados::Find($usuario)->identificacion;
                                            Cliente::where('id',$v)->update([$d=>$user]);
                                        }else {
                                                    $array_response['status'] = 404;
                                                    $array_response['message'] = "El operador2 no coincides con los parametros de las fechas vencidas"; 
                                        }
                                }else{
                                    $array_response['status'] = 404;
                                    $array_response['message'] = "El operador no coincides con los parametros de las fechas vencidas"; 
                                }
                            }
                       
                }
            }
        }else{
            $array_response['status'] = 404;
            $array_response['message'] = "Seleccione un Cliente"; 
        }
        return response()->json($array_response, 200);
	}
	
	
    public function GestionLLamadaDatatable()
    {
        $bandeja="";
        $recaudador_user = Auth::user()->persona_id;
          //  $recaudador_user=User::get();
        $recaudador_v= Auth::user()->evaluarole(['Recaudador']);
        $operador_c= Auth::user()->evaluarole(['Operador']);
        $operador2= Auth::user()->evaluarole(['operador2']);
        $admin= Auth::user()->evaluarole(['Supervisor']);
        $consulta='';
           
                $consulta=DB::connection('mysql_recaudaciones')
                ->table('Clientes AS p')
                ->select('p.id as id',
                    'p.identificacion as identificacion',
                    'p.nombres as name',
                    'p.ciudad as ciudad',
                    'p.direccion as direccion',
                    'p.celular as celular',
                    db::raw('datediff(now(),p.fecha_vencida) as dias_mora'),
                    'p.valor_vencido as valor_vencido',
                    'p.valor_deuda as valor_deuda',
                    'p.pago_id as pago_id',
                    'p.estado as estado',
                    'p.usuario_ing as usuario_ing',
                    'p.usuario_mod as usuario_mod',
                    'p.created_at as created_at',
                    db::raw('DATE(p.updated_at) as updated_at'),
                    'p.recaudador_user as recaudador_user',
                    'p.operador_user as operador_user',
                    'p.convencional as convencional',
                    'p.celularlaboral as celularlaboral',
                    'p.celularreferencia as celularreferencia',
                    'p.nombrelaboral as nombrelaboral',
                    'p.nombrereferencia as nombrereferencia',
                    db::raw('DATE(p.fecha_vencida) as fecha_vencida'),
                    db::raw('DATE(p.fecha_acuerdo) as fecha_acuerdo'),
                    'p.acuerdo as acuerdo',
                    'p.intentos as intentos',
                    'p.cuotas as cuotas',
                    'p.valor_acuerdo as valor_acuerdo',
                    db::raw('DATE(p.fecha_acuerdo2) as fecha_acuerdo2'),
                    'p.acuerdo2 as acuerdo2',
                    'p.cuotas2 as cuotas2',
                    'p.valor_acuerdo2 as valor_acuerdo2',
                    'p.porcentaje_pago as porcentaje_pago',
                    'p.porcentaje_mora as porcentaje_mora'
                     )->get();            
            
        return DataTables::of($consulta)       
->addColumn('Inicio', function ($select) {

            $result=DB::connection('mysql_recaudaciones')
                        ->table('llamadas')
                        ->select('inicio',
                        'fin',
                        DB::RAW('CASE 
                                WHEN estado="A" THEN "LLAMANDO"
                                WHEN estado="I" THEN "FINALIZADO"
                                ELSE
                                "PENDIENTE"
                                  END as e'))
                        ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
                      
                        if($result==null)
                            {
                               return "--";
                                
                            } else{
                               return $result->inicio; 
                            }
        
     })
     ->addColumn('Fin', function ($select) {

    $result=DB::connection('mysql_recaudaciones')
                ->table('llamadas')
                ->select('inicio',
                'fin',
                DB::RAW('CASE 
                        WHEN estado="A" THEN "LLAMANDO"
                        WHEN estado="I" THEN "FINALIZADO"
                        ELSE
                        "PENDIENTE"
                          END as e'))
                ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
              
                if($result==null)
                    {
                       return "--";
                        
                    } else{
                       return $result->fin; 
                    }

})
 ->addColumn('Estadollamada', function ($select)use($operador_c,$admin,$recaudador_v) {
        //$prefijo=Auth::user()->prefijo;
        $extension='101';

        $result=DB::connection('mysql_recaudaciones')
                    ->table('llamadas')
                    ->select('inicio',
                    'fin','comentario',
                    DB::RAW('CASE 
                            WHEN estado="A" THEN "LLAMANDO"
                            WHEN estado="I" THEN "FINALIZADO"
                            ELSE
                            "PENDIENTE"
                              END as e'))
                    ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
                 
                    if($result==null)
                        {
                           $span="<span>";
                           $icono="<span class='label label-success'><i class='fa fa-phone'></i></span>";
                        } else{
                            switch($result->e)
                            {
                                case "LLAMANDO":
                                $icono="<span class='label label-danger'><i class='fa fa-phone-slash'></i></span>";
                                break;
                                default:
                                $icono="<span class='label label-success'><i class='fa fa-phone'></i></span>";

                                break;
                            }
                            $span="<span data-toggle='tooltip' title='".$result->comentario."'>";
                        }
                        return  '<a href="#" id="'
                        . $select->celular . '" onclick="llamada(\''
                        . $extension . '\',\''
                        . $select->celular . '\',\''
                        . $select->convencional . '\',\''
                        . $select->celularlaboral . '\',\''
                        . $select->celularreferencia . '\',\''
                        . $select->nombrelaboral . '\',\''
                        . $select->nombrereferencia . '\',\''
                        . $select->id . '\',\''
                        . $operador_c . '\',\''
                        . $admin . '\',\''
                        . $select->identificacion . '\',\''
                        . $select->name . '\',\''
                        . $select->dias_mora . '\',\''
                        . $select->valor_vencido . '\',\''
                        . $select->valor_deuda . '\',\''
                        . $select->fecha_acuerdo . '\',\''
                        . $select->acuerdo . '\',\''
                        . $select->cuotas . '\',\''
                        . $select->valor_acuerdo . '\',\''
                        . $select->intentos . '\',\''
                        . $select->fecha_acuerdo2 . '\',\''
                        . $select->acuerdo2 . '\',\''
                        . $select->cuotas2 . '\',\''
                        . $select->valor_acuerdo2 . '\',\''
                        . $recaudador_v . '\')"
                        data-hover="tooltip" data-placement="top" 
                                   data-target="#ModalConsultaLLamada" data-toggle="modal"
                                   
                        >'.$span.$icono.'</span>'.'&nbsp;'.$select->celular.'</a>';

    
 })
->addColumn('IDENTIDAD', function ($select)use($recaudador_v,$operador_c,$admin) {
               $vb=$select->id;
                
                        return $vb;
        })
->addColumn('actions', function ($select)use($recaudador_v,$operador_c,$admin) {
               $vb=$select->operador_user;
                
                        return $vb;
        })
		->addColumn('actions2', function ($select)use($recaudador_v,$operador_c,$admin) {
            $vb=$select->recaudador_user;
                
                        return $vb;
        })
		
		->addColumn('estados', function ($select) {

            switch ($select->estado) {
                case 'P':
                    $result = '<span class="label label-danger">DEUDA</span>';
                    break;
                case 'I':
                    $result = '<span class="label label-success">SIN DEUDA</span>';
                    break;
                default:
                    $result = '<span class="label label-success">Sin Estado</span>';

                    break;
            }
            return $result."&nbsp;".$select->valor_deuda;
        })->addColumn('dias_mora', function ($select) {
            if($select->estado!='I')
            {
                $select->fecha_vencida;

                $fecha_actual = date("d-m-Y");
                
                $datetime2 = date_create($fecha_actual); //fecha actual
                $datetime1 = date_create($select->fecha_vencida); //fecha de db
                $interval = date_diff($datetime1, $datetime2, false);
                $dias = intval($interval->format('%R%a'));
                $d=date_format($datetime1,'Y-m-d');
                if($select->porcentaje_pago>29)
                {
                    $dias=$dias-30;
                    if($dias<1)
                    {
                        $dias=0;
                    }

                }
                $result=$dias;
                if($dias>0&&$dias<31){
                    $result = ''.$dias.'<br/><span class="label label-info">MORA</span>';
                }
                if($dias>32&&$dias<91){
                    $result = ''.$dias.'<br/><span class="label label-warning">CENTRAL/RIESGO</span>';
                }
                if($dias>89){
                    $result = ''.$dias.'<br/><span class="label label-danger">JUICIO/COACTIVA</span>';
                }
                return $result;
            }
            return '<span class="label label-info"> NO ESTA EN MORA</span>';
                
            
           
        })
            ->make(true);
    }

    public function indexGestionLLamadas()
    {
	/*	1268 op2
		1260 op
		1259 re
*/

		$usuarios=DB::connection('mysql')
                ->table('Empleados AS p')
                ->select('p.id as id', DB::raw('CONCAT(p.nombres," ",p.apellidos,"-",tbp.descripcion) as name'))
				->join('tb_parametro as tbp','tbp.id','p.cargo_id')
				->wherein('cargo_id',['1268','1260','1259'])->pluck('name', 'id');;
        return view('modules.gestion.indexGestionLLamada',compact('usuarios'));
    }
public function iniciarllamadaCall(request $request)
{
    DB::beginTransaction();
    try {
        $id=0;
        switch($request->id)
        {
         
            //PROCESO DE NUEVA LLAMADA

            case 3:
            $operador_c= Auth::user()->evaluarole(['Operador']);
            $operador2= Auth::user()->evaluarole(['operador2']);
             
			 $c=Cliente::where('intentos',"<",2)
                ->where('operador_user',Auth::user()->persona_id)
                ->where('llamada',1)
                ->orderby('id')->get()->count();
			
			if($c==0)
            {
                    $id=Cliente::where('intentos',"<",2)
					    ->where('operador_user',Auth::user()->persona_id)
						->whereNotIn('estado',['I'])
						->where('llamada',0)
						->orderby('id')->get()->first();
				
					if($id!=null||$id!=0)
					{  
						Cliente::where('id',$id->id)->update(['llamada'=>1]);
						$id=$id->celular.','.$id->convencional.','.$id->celularlaboral.','.$id->celularreferencia;
					}else{
						$id=0;
					}
                
            }  else{

                $id=4;
            }
            
            break;
        } 
        DB::commit();
        $array_response['status'] = 200;
        $array_response['message'] =$id;


    } catch (\Exception $e) {
        DB::rollback();

        $array_response['status'] = 404;
        $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
    }
    return response()->json($array_response, 200);

}
public function iniciarllamada(request $request)
{
   
    DB::beginTransaction();
    $today = new \DateTime("now");
    try {
      switch($request->dato)
      {
          case 1:
          $objEmpleado = new LLamada();
          $objEmpleado->cliente_id = $request->id;
          $objEmpleado->inicio=$today;
          $objEmpleado->operador_id = Auth::user()->persona_id;
          $objEmpleado->estado = 'A';
          $objEmpleado->numero = $request->celular;
          $objEmpleado->save();
          $id=$objEmpleado->id;
          break;
          case 2:
          
          $objEmpleado = LLamada::Find($request->idLLamada);
          $objEmpleado->fin=$today;
          ///$objEmpleado->comentario=$request->comentario;
          $objEmpleado->estado = 'I';
          $objEmpleado->estadoLLamada = 'EXITOSO';
          $objEmpleado->save();
          $cliente=$objEmpleado->cliente_id;
          $operador=$objEmpleado->operador_id;
          Cliente::where('llamada',1)
                        ->where('id',$cliente)
                        ->update(['llamada'=>2]);
          $id=9;

          break;
          case 3:
          $objEmpleado = LLamada::Find($request->idLLamada);
          $objEmpleado->fin=$today;
          $objEmpleado->comentario=$request->comentario;
          $objEmpleado->estado = 'I';
          $objEmpleado->estadoLLamada = 'NO EXITOSO';
          $objEmpleado->save();
          $cliente=$objEmpleado->cliente_id;
          $operador=$objEmpleado->operador_id;
                $objs= LLamada::where('cliente_id',$cliente)
                        ->where('operador_id',$operador)->get()->count();
                $id=0;   
                if($objs==4)
                {
                    Cliente::where('llamada',1)
                        ->where('id',$cliente)
                        ->update(['llamada'=>2]);
                        $id=9;
                }
         
          break;
      }

        DB::commit();
        $array_response['status'] = 200;
        $array_response['message'] =$id;


    } catch (\Exception $e) {
        DB::rollback();

        $array_response['status'] = 404;
        $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
    }

    return response()->json($array_response, 200);
}

    public function index()
    {
        $objSelect = new SelectController();
        $estado=['DEUDORES'=>'DEUDORES','CLIENTES PAGO'=>'CLIENTES PAGO'];
        $tipo_pago = $objSelect->getParametro('TIPO_PAGO', 'http');

      
        $admin= Auth::user()->evaluarole(['Supervisor']);
        $recaudador= Auth::user()->evaluarole(['recaudador']);

        return view("modules.Gestion.index",compact(['tipo_pago','admin','estado','recaudador']));
    }

    public function historialCall()
    {
        $objSelect = new SelectController();
        $area = DB::connection('mysql')
        ->table('tb_parametro')
        ->where('descripcion','OPERADOR')
        ->get()->first();
       
        $area2 = DB::connection('mysql')
        ->table('tb_parametro')
        ->where('descripcion','OPERADOR2')
        ->get()->first();
        if($area!=null||$area!=[]||$area2!=null||$area2!=[])
        {
            $operadores=Empleados::wherein('cargo_id',[$area->id,$area2->id])
            ->where('estado','A')
            ->select('identificacion as identificacion',
            DB::RAW('CONCAT(apellidos," ",nombres) as nombres')    
            )
            ->get()->pluck('nombres','identificacion');
            if($operadores==null)
            {
                $operadores=["0"=>"NO EXISTE"];
            }
        }else{
            $operadores=["0"=>"NO EXISTEN"];
        }
       
        return view("modules.Gestion.historial",compact(['operadores']));
    }
    


    public function savellamadas(request $request)
{

    DB::beginTransaction();
    $today = new \DateTime("now");
 
    try {
      
            $objEmpleado = new LLamada();

        $objEmpleado->operador_id = Auth::user()->persona_id;
        $objEmpleado->cliente_id = $request->id;
        $objEmpleado->comentario = $request->comentario;

        if($request->band==1)
        {
            $objEmpleado->inicio=$today;
            $objEmpleado->estado = 'A';
        }else{
            $objEmpleado->inicio=$today;
            $objEmpleado->fin=$today;
            $objEmpleado->estado = 'I';
        }
        
        
        $objEmpleado->save();
        DB::commit();
        $array_response['status'] = 200;
        $array_response['message'] = 'Se ha Grabado Exitosamente ';


    } catch (\Exception $e) {
        DB::rollback();

        $array_response['status'] = 404;
        $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
    }

    return response()->json($array_response, 200);
}

    public function SaveAcuerdo(request $request)
    {
       
       DB::beginTransaction();
     
        try {
            $objEmpleado = Cliente::Find($request->id);

            if($objEmpleado->intentos==0)
            {
                $objEmpleado->fecha_acuerdo=$request->fecha_acuerdo;
                $objEmpleado->cuotas=$request->cuota_acuerdo;
                $objEmpleado->valor_acuerdo=$request->valor_acuerdo;
                $objEmpleado->acuerdo=$request->acuerdo;
                $objEmpleado->intentos=$objEmpleado->intentos+1;
                $objEmpleado->save();
            }else{
                $objEmpleado->fecha_acuerdo2=$request->fecha_acuerdo;
                $objEmpleado->cuotas2=$request->cuota_acuerdo;
                $objEmpleado->valor_acuerdo2=$request->valor_acuerdo;
                $objEmpleado->acuerdo2=$request->acuerdo;
                $objEmpleado->intentos=$objEmpleado->intentos+1;
                $objEmpleado->save();
            }
         
         

            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Grabado Exitosamente ';
    
    
        } catch (\Exception $e) {
            DB::rollback();
    
            $array_response['status'] = 404;
            $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
        }
        return response()->json($array_response, 200);

    }
   public function Save(request $request)
    {
        DB::beginTransaction();

        try {
            if($request->id!=0)
            {
                $objEmpleado = Empleados::Find($request->id);
            }else
            {
                $objEmpleado = new Empleados();

            }
            $objEmpleado->identificacion = $request->identificacion;
            $objEmpleado->nombres = $request->nombres;
            $objEmpleado->apellidos = $request->apellidos;
            $objEmpleado->ciudad_id = $request->ciudad_id;
            $objEmpleado->convencional = $request->convencional;
            $objEmpleado->celular = $request->celular;
            $objEmpleado->ing_empresa = $request->ing_empresa;
            $objEmpleado->direccion = $request->direccion;
            $objEmpleado->cargo_id = $request->cargo;
            $objEmpleado->email = $request->email;
            $objEmpleado->usuario_ing = Auth::user()->id;
            $objEmpleado->usuario_mod = Auth::user()->id;
            $objEmpleado->estado = 'A';
            $objEmpleado->save();
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Grabado Exitosamente ';


        } catch (\Exception $e) {
            DB::rollback();

            $array_response['status'] = 404;
            $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
        }

        return response()->json($array_response, 200);
    }


    public function savecliente(request $request)
    {
        
        DB::beginTransaction();

      //  try {
            if($request->id!=0)
            {
                $objEmpleado = Cliente::Find($request->id);
            }else
            {
                $objEmpleado = new Cliente();

            }

           $objAsignaR = Empleados::where('cargo_id',1259)->get();
           $objAsignaO = Empleados::where('cargo_id',1260)->get();
           $CountobjAsignaO=$objAsignaO->where('asigna',1)->count();
           $CountobjAsignaR=$objAsignaR->where('asigna',1)->count();

           if($CountobjAsignaO<1){
            $obj=Empleados::Find($objAsignaO->first()->id);
            $obj->asigna=1;
            $obj->save();
        
            }else{
               
              $previous = Empleados::where('id', '<', $objAsignaO->where('asigna',1)->first()->id)
                ->where('cargo_id',1260)
                ->max('id');
                
                $next = Empleados::where('id', '>', $objAsignaO->where('asigna',1)->first()->id)
                ->where('cargo_id',1260)
                ->min('id');
                
                if(count($next)>0)
                {
                    $obj=Empleados::Find($next);
                    $obj->asigna=1;
                    $obj->save();   

                    $obj=Empleados::Find($objAsignaO->where('asigna',1)->first()->id);
                    $obj->asigna=0;
                    $obj->save(); 

                }else{
                   
                    $obj=Empleados::where('cargo_id',1260)->update(['asigna'=>0]);
                    $obj=Empleados::Find(Empleados::where('cargo_id',1260)->get()->first()->id);
                    $obj->asigna=1;
                    $obj->save();
                }
            }
          
           if(count($objAsignaR->where('asigna',1))<1){
            $obj=Empleados::Find($objAsignaR->first()->id);
            $obj->asigna=1;
            $obj->save();
            //dd(1);
            }else{
              //  dd(2);
              $previous = Empleados::where('id', '<', $objAsignaR->where('asigna',1)->first()->id)
                ->where('cargo_id',1259)
                ->max('id');
                
               
               
                $next = Empleados::where('id', '>', $objAsignaR->where('asigna',1)->first()->id)
                ->where('cargo_id',1259)
                ->min('id');

            
                if(count($next)>0)
                {

                    $obj=Empleados::Find($next);
                    $obj->asigna=1;
                    $obj->save();   

                    $obj=Empleados::Find($objAsignaR->where('asigna',1)->first()->id);
                    $obj->asigna=0;
                    $obj->save(); 

                }else{
                   
                    $obj=Empleados::where('cargo_id',1259)->update(['asigna'=>0]);
                   
                    $obj=Empleados::Find(Empleados::where('cargo_id',1259)->get()->first()->id);
                    $obj->asigna=1;
                    $obj->save();
                }
            }
           


            $objEmpleado->identificacion = $request->identificacion;
            $objEmpleado->nombres = $request->nombres;
            $objEmpleado->ciudad = $request->ciudad;
            $objEmpleado->convencional = $request->convencional;
            $objEmpleado->celular = $request->celular;
            $objEmpleado->direccion = $request->direccion;
            $objEmpleado->celularlaboral = $request->celularlaboral;
            $objEmpleado->celularreferencia = $request->celularreferencia;
            $objEmpleado->nombrelaboral = $request->nombrelaboral;
            $objEmpleado->nombrereferencia = $request->nombrereferencia;
            $objEmpleado->fecha_vencida = $request->fecha_vencida;
            $objEmpleado->valor_vencido = $request->valor_vencido;
            
          
            $objEmpleado->usuario_ing = Auth::user()->id;
            $objEmpleado->usuario_mod = Auth::user()->id;
            $objEmpleado->estado = 'P';
            $objEmpleado->recaudador_user=Empleados::where('cargo_id',1259)->where('asigna',1)->get()->first()->identificacion;
            $objEmpleado->operador_user=Empleados::where('cargo_id',1260)->where('asigna',1)->get()->first()->identificacion;
           
            $objEmpleado->save();
            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Grabado Exitosamente ';


      /*  } catch (\Exception $e) {
            DB::rollback();

            $array_response['status'] = 404;
            $array_response['message'] = 'Error al grabar los datos' . $e->getMessage();
        }
*/
        return response()->json($array_response, 200);


    }
    
    public function getDatatable($bandeja)
    {
        $recaudador_user = Auth::user()->persona_id;
          //  $recaudador_user=User::get();
        $recaudador_v= Auth::user()->evaluarole(['Recaudador']);
        $operador_c= Auth::user()->evaluarole(['Operador']);
        $operador2= Auth::user()->evaluarole(['operador2']);
        $admin= Auth::user()->evaluarole(['Supervisor']);
        $consulta='';
            if($recaudador_v>0||$operador_c>0||$admin>0||$operador2>0)
            {
                $consulta=DB::connection('mysql_recaudaciones')
                ->table('Clientes AS p')
                ->select('p.id as id',
                    'p.identificacion as identificacion',
                    'p.nombres as name',
                    'p.ciudad as ciudad',
                    'p.direccion as direccion',
                    'p.celular as celular',
                    db::raw('datediff(now(),p.fecha_vencida) as dias_mora'),
                    'p.valor_vencido as valor_vencido',
                    'p.valor_deuda as valor_deuda',
                    'p.pago_id as pago_id',
                    'p.estado as estado',
                    'p.usuario_ing as usuario_ing',
                    'p.usuario_mod as usuario_mod',
                    'p.created_at as created_at',
                    db::raw('DATE(p.updated_at) as updated_at'),
                    'p.recaudador_user as recaudador_user',
                    'p.operador_user as operador_user',
                    'p.convencional as convencional',
                    'p.celularlaboral as celularlaboral',
                    'p.celularreferencia as celularreferencia',
                    'p.nombrelaboral as nombrelaboral',
                    'p.nombrereferencia as nombrereferencia',
                    db::raw('DATE(p.fecha_vencida) as fecha_vencida'),
                    db::raw('DATE(p.fecha_acuerdo) as fecha_acuerdo'),
                    'p.acuerdo as acuerdo',
                    'p.intentos as intentos',
                    'p.cuotas as cuotas',
                    'p.valor_acuerdo as valor_acuerdo',
                    db::raw('DATE(p.fecha_acuerdo2) as fecha_acuerdo2'),
                    'p.acuerdo2 as acuerdo2',
                    'p.cuotas2 as cuotas2',
                    'p.valor_acuerdo2 as valor_acuerdo2',
                    'p.porcentaje_pago as porcentaje_pago',
                    'p.porcentaje_mora as porcentaje_mora'
                     );
                if($recaudador_v>0)
                {
                    $consulta=$consulta
                    ->where('recaudador_user',$recaudador_user)
                    ->whereraw("DATEDIFF(now(),p.fecha_vencida)< '31'")
                    ->whereNotIn('estado',['I'])
                    ->whereNotIn('p.intentos',['2'])
                    ->get();

                }
                if($operador_c>0&&$operador2==0)
                {
                    
                    $consulta=$consulta
                    ->where('operador_user',$recaudador_user)
                    ->whereraw("DATEDIFF(now(),p.fecha_vencida)< '31'")
                    ->whereNotIn('estado',['I'])
                    ->whereNotIn('p.intentos',['2'])
                    ->get();

                }
                if($operador2>0)
                {
                    $consulta=$consulta
                    ->where('operador_user',$recaudador_user)
                    ->whereNotIn('estado',['I'])
                    ->get();
                }
                if($admin>0)
                { 
                    if($bandeja!='DEUDORES')
                    {
                        $consulta=$consulta->where("estado",'I')->get();
                    }else{
                        $consulta=$consulta
                        ->whereraw("DATEDIFF(now(),p.fecha_vencida)> '60'")
                        ->orwhere('p.intentos',2)
                        ->whereNotIn("estado",["I"])->get();
                    }
                    
                    
                }
                

                
            }
        return DataTables::of($consulta)       
->addColumn('Inicio', function ($select) {

            $result=DB::connection('mysql_recaudaciones')
                        ->table('llamadas')
                        ->select('inicio',
                        'fin',
                        DB::RAW('CASE 
                                WHEN estado="A" THEN "LLAMANDO"
                                WHEN estado="I" THEN "FINALIZADO"
                                ELSE
                                "PENDIENTE"
                                  END as e'))
                        ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
                      
                        if($result==null)
                            {
                               return "--";
                                
                            } else{
                               return $result->inicio; 
                            }
        
     })
     ->addColumn('Fin', function ($select) {

    $result=DB::connection('mysql_recaudaciones')
                ->table('llamadas')
                ->select('inicio',
                'fin',
                DB::RAW('CASE 
                        WHEN estado="A" THEN "LLAMANDO"
                        WHEN estado="I" THEN "FINALIZADO"
                        ELSE
                        "PENDIENTE"
                          END as e'))
                ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
              
                if($result==null)
                    {
                       return "--";
                        
                    } else{
                       return $result->fin; 
                    }

})
 ->addColumn('Estadollamada', function ($select)use($operador_c,$admin,$recaudador_v) {
        //$prefijo=Auth::user()->prefijo;
        $extension='101';

        $result=DB::connection('mysql_recaudaciones')
                    ->table('llamadas')
                    ->select('inicio',
                    'fin','comentario',
                    DB::RAW('CASE 
                            WHEN estado="A" THEN "LLAMANDO"
                            WHEN estado="I" THEN "FINALIZADO"
                            ELSE
                            "PENDIENTE"
                              END as e'))
                    ->where('cliente_id',$select->id)->orderby('inicio','DSC')->GET()->FIRST();
                 
                    if($result==null)
                        {
                           $span="<span>";
                           $icono="<span class='label label-success'><i class='fa fa-phone'></i></span>";
                        } else{
                            switch($result->e)
                            {
                                case "LLAMANDO":
                                $icono="<span class='label label-danger'><i class='fa fa-phone-slash'></i></span>";
                                break;
                                default:
                                $icono="<span class='label label-success'><i class='fa fa-phone'></i></span>";

                                break;
                            }
                            $span="<span data-toggle='tooltip' title='".$result->comentario."'>";
                        }
                        return  '<a href="#" id="'
                        . $select->celular . '" onclick="llamada(\''
                        . $extension . '\',\''
                        . $select->celular . '\',\''
                        . $select->convencional . '\',\''
                        . $select->celularlaboral . '\',\''
                        . $select->celularreferencia . '\',\''
                        . $select->nombrelaboral . '\',\''
                        . $select->nombrereferencia . '\',\''
                        . $select->id . '\',\''
                        . $operador_c . '\',\''
                        . $admin . '\',\''
                        . $select->identificacion . '\',\''
                        . $select->name . '\',\''
                        . $select->dias_mora . '\',\''
                        . $select->valor_vencido . '\',\''
                        . $select->valor_deuda . '\',\''
                        . $select->fecha_acuerdo . '\',\''
                        . $select->acuerdo . '\',\''
                        . $select->cuotas . '\',\''
                        . $select->valor_acuerdo . '\',\''
                        . $select->intentos . '\',\''
                        . $select->fecha_acuerdo2 . '\',\''
                        . $select->acuerdo2 . '\',\''
                        . $select->cuotas2 . '\',\''
                        . $select->valor_acuerdo2 . '\',\''
                        . $recaudador_v . '\')"
                        data-hover="tooltip" data-placement="top" 
                                   data-target="#ModalConsultaLLamada" data-toggle="modal"
                                   
                        >'.$span.$icono.'</span>'.'&nbsp;'.$select->celular.'</a>';

    
 })

->addColumn('actions', function ($select)use($recaudador_v,$operador_c,$admin) {
               $vb='';
                   $vb='<a href="#" onclick="PagosChanges(\'' .
                    $select->id . '\')"
                                   data-hover="tooltip" data-placement="top" 
                                   data-target="#ModalConsulta" data-toggle="modal" id="modal"
                                   class="label label-primary">
                            <span class="glyphicon glyphicon-eye-open">&nbsp;PAGOS&nbsp;</span></a></small> ';
                      
                  /*  if($operador_c>0||$admin>0)
                    {
                        $vb.='<a href="#" onclick="Finllamada(\'' .
                        $select->id . '\')"
                                       class="label label-warning">
                                <span class="glyphicon glyphicon-remove-circle"></span></a></small>
                        ';
                    } */
                    if($recaudador_v>0){

                        if($select->estado!='I')
                        {
                          $vb.='<a href="#" onclick="RecaudoChanges(\'' .
                          $select->id . '\')"
                                         data-hover="tooltip" data-placement="top" 
                                         data-target="#Modalagregar" data-toggle="modal" id="modal"
                                         class="label label-warning">
                                  <span class="glyphicon glyphicon-plus">&nbsp;RECAUDAR&nbsp;</span></a></small>
                          ';
                        }   
                    }
                      
                        return $vb;
        })->addColumn('estados', function ($select) {

            switch ($select->estado) {
                case 'P':
                    $result = '<span class="label label-danger">DEUDA</span>';
                    break;
                case 'I':
                    $result = '<span class="label label-success">SIN DEUDA</span>';
                    break;
                default:
                    $result = '<span class="label label-success">Sin Estado</span>';

                    break;
            }
            return $result."&nbsp;".$select->valor_deuda;
        })->addColumn('dias_mora', function ($select) {
            if($select->estado!='I')
            {
                $select->fecha_vencida;

                $fecha_actual = date("d-m-Y");
                
                $datetime2 = date_create($fecha_actual); //fecha actual
                $datetime1 = date_create($select->fecha_vencida); //fecha de db
                $interval = date_diff($datetime1, $datetime2, false);
                $dias = intval($interval->format('%R%a'));
                $d=date_format($datetime1,'Y-m-d');
                if($select->porcentaje_pago>29)
                {
                    $dias=$dias-30;
                    if($dias<1)
                    {
                        $dias=0;
                    }

                }
                $result=$dias;
                if($dias>0&&$dias<31){
                    $result = ''.$dias.'<br/><span class="label label-info">MORA</span>';
                }
                if($dias>32&&$dias<91){
                    $result = ''.$dias.'<br/><span class="label label-warning">CENTRAL/RIESGO</span>';
                }
                if($dias>89){
                    $result = ''.$dias.'<br/><span class="label label-danger">JUICIO/COACTIVA</span>';
                }
                return $result;
            }
            return '<span class="label label-info"> NO ESTA EN MORA</span>';
                
            
           
        })
            ->make(true);
    }

    public function getDatatablePagos($id)
    {
  
        return DataTables::of(
            DB::connection('mysql_recaudaciones')
                ->table('Pagos AS p')
                ->join('core.tb_parametro as tbp', 'p.tipo_pago', 'tbp.id')
                ->join('core.empleados as emp','emp.identificacion','p.recaudador_user')
                ->select('p.id as id',
                    'p.valor as valor',
                    'p.comprobante as comprobante',
                    'tbp.descripcion as tipo_pago',
                    DB::RAW('CONCAT(emp.apellidos," ",emp.nombres) as recaudador_user'),    
                    'p.estado as estado',
                    'p.created_at as created_at',
                    'p.filename as filename'
                )
                ->where('p.cliente_id',$id)
                ->get()

        )->addColumn('estados', function ($select) {
                $link='<a href="/storage/'.$select->filename.'" target="_blank" 
                class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
            switch ($select->estado) {
                case 'A':
                    $result = '<span class="label label-primary">Activo</span>'.$link;
                    break;
                case 'I':
                    $result = '<span class="label label-danger">Inactivo</span>'.$link;
                    break;
                default:
                    $result = '<span class="label label-success">Sin Estado</span>';

                    break;
            }
            return $result;
        })
            ->make(true);
    }
    public function Eliminar(request $request)
    {

        DB::beginTransaction();

        try {
            $objEmpleado = Empleados::Find($request->id);

            if ($request->band != 0) {
                $objEmpleado->estado = 'I';
                $objUser = User::where('persona_id', $request->id)->update(['estado' => 'I']);

            } else {
                $objEmpleado->estado = 'A';
                $objUser = User::where('persona_id', $request->id)->update(['estado' => 'A']);

            }

            $objEmpleado->save();

            DB::commit();
            $array_response['status'] = 200;
            $array_response['message'] = 'Se ha Realizado la acción Exitosamente ';


        } catch (\Exception $e) {
            DB::rollback();

            $array_response['status'] = 404;
            $array_response['message'] = 'Error al intentar realizar la acción' . $e->getMessage();
        }
        return response()->json($array_response, 200);
    }

    public function uploadFinal(request $request)
    {
        
        $objCliente=Cliente::Find($request->id);
       
        $total=($objCliente->valor_vencido)-($request->valor);
        $p100=($objCliente->valor*100)/$objCliente->valor_vencido;
        $c=Pago::where('comprobante',$request->comprobante)
        ->where('cliente_id',$request->id)->get()->count();
        if($total<0 || $c>0)
        {
            $objSelect = new SelectController();
            $estado=['DEUDORES'=>'DEUDORES','CLIENTES PAGO'=>'CLIENTES PAGO'];
            $tipo_pago = $objSelect->getParametro('TIPO_PAGO', 'http');
    
          
            $admin= Auth::user()->evaluarole(['Supervisor']);
            $recaudador= Auth::user()->evaluarole(['recaudador']);
                $m='Ya se encuentra registrado comprobante';
            return view("modules.Gestion.index",compact(['tipo_pago','admin','estado','recaudador','m']));
        }
        $id=Auth::user()->persona_id;
            if($request->file('archivo')){
                $cedula = $request->file('archivo');
                    \Storage::delete($request->comprobante.'RC'.$request->id.'.jpg');
                    \Storage::disk('local')->put($request->comprobante.'RC'.$request->id.'.jpg',  \File::get($cedula));
              }

                $obj=new Pago();
                $obj->recaudador_user =$id;

                $obj->valor =$request->valor;
                $obj->comprobante =$request->comprobante;
                $obj->entidad =$request->entidad;

                $obj->cliente_id =$request->id;
                $obj->tipo_pago =$request->tipo_pago;
                $obj->estado ='A';
                $obj->filename = $request->comprobante.'RC'.$request->id.'.jpg';
                $obj->save();
             
                $objCliente->valor_deuda=$total;
                $objCliente->porcentaje_pago=$p100;
                if($total==0)
                {
                    $objCliente->estado='I';
                }
                $objCliente->save();
        
 
           return redirect()->route('clientes.gestionIndex');
    }




public function getDatatableH($bandeja)
{
  
             $consulta=DB::connection('mysql_recaudaciones')
            ->table('llamadas as l')
            ->join('Clientes AS p','p.id','l.cliente_id')
            ->select('p.id as id',
                'p.identificacion as identificacion',
                'p.nombres as name',
                'p.direccion as direccion',
                'p.celular as celular',
                db::raw('datediff(now(),p.fecha_vencida) as dias_mora'),
                'p.valor_vencido as valor_vencido',
                'p.valor_deuda as valor_deuda',
                'p.pago_id as pago_id',
                'p.estado as estado',
                'p.usuario_ing as usuario_ing',
                'p.usuario_mod as usuario_mod',
                'p.created_at as created_at',
                'p.updated_at as updated_at',
                'p.recaudador_user as recaudador_user',
                'p.operador_user as operador_user',
                'p.convencional as convencional',
                'p.celularlaboral as celularlaboral',
                'p.celularreferencia as celularreferencia',
                'p.nombrelaboral as nombrelaboral',
                'p.nombrereferencia as nombrereferencia',
                'p.fecha_vencida as fecha_vencida',
                'p.fecha_acuerdo as fecha_acuerdo',
                'p.acuerdo as acuerdo',
                'p.intentos as intentos',
                'p.cuotas as cuotas',
                'p.valor_acuerdo as valor_acuerdo',
                'p.fecha_acuerdo2 as fecha_acuerdo2',
                'p.acuerdo2 as acuerdo2',
                'p.cuotas2 as cuotas2',
                'p.valor_acuerdo2 as valor_acuerdo2',
                'p.porcentaje_pago as porcentaje_pago',
                'p.porcentaje_mora as porcentaje_mora',
                'l.inicio as inicio',
                'l.fin as fin',
                'l.estadoLLamada as estados',
                'l.numero as numero'
);
if($bandeja!=0&&$bandeja!=''&&$bandeja!=null)
{
    $consulta=$consulta->where('operador_id',$bandeja);
}
$consulta=$consulta->get();
                 return DataTables::of($consulta)       
                 ->addColumn('Estadollamada', function ($select) {
                                    $span="<span>";
                                    $icono="<span class='label label-success'><i class='fa fa-phone'></i></span>";
                                
                                 return  '<a href="#" onclick="llamada(\''
                                 . $select->celular . '\',\''
                                 . $select->convencional . '\',\''
                                 . $select->celularlaboral . '\',\''
                                 . $select->celularreferencia . '\',\''
                                 . $select->nombrelaboral . '\',\''
                                 . $select->nombrereferencia . '\',\''
                                 . $select->id . '\',\''
                                 . $select->identificacion . '\',\''
                                 . $select->name . '\',\''
                                 . $select->dias_mora . '\',\''
                                 . $select->valor_vencido . '\',\''
                                 . $select->valor_deuda . '\',\''
                                 . $select->fecha_acuerdo . '\',\''
                                 . $select->acuerdo . '\',\''
                                 . $select->cuotas . '\',\''
                                 . $select->valor_acuerdo . '\',\''
                                 . $select->intentos . '\',\''
                                 . $select->fecha_acuerdo2 . '\',\''
                                 . $select->acuerdo2 . '\',\''
                                 . $select->cuotas2 . '\',\''
                                 . $select->valor_acuerdo2 . '\')"
                                 data-hover="tooltip" data-placement="top" 
                                            data-target="#ModalConsultaLLamada" data-toggle="modal" id="modal"
                                            
                                 >'.$span.$icono.'</span>'.'&nbsp;'.$select->numero.'</a>';
             }) ->make(true);
   } 
 }


