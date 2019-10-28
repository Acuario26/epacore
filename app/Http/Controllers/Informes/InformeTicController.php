<?php

namespace App\Http\Controllers\Informes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Yajra\Datatables\Datatables;
use App\Core\Entities\modules\Informes\CtlInformes;
use App\Core\Entities\modules\Informes\InformesTecnico;
use App\Core\Entities\modules\Glpi\GlpiUsers;
use App\Core\Entities\modules\Informes\ProblemasEquipo;
use Response;
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;

class InformeTicController extends Controller
{
    public function uploadFiles(request $request) {
            return Response::json('success', 200);


        }
    public function informespendientesR()
    {
        $pantalla='pendientesR';
        return view('modules.Informes.informeTICS',compact('pantalla'));
    }
    public function informespendientesA()
    {
        $pantalla='pendientesA';
        return view('modules.Informes.informeTICS',compact('pantalla'));
    }
    public function InformeTICS()
    {
        $pantalla='crea';
        return view('modules.Informes.informeTICS',compact('pantalla'));
    }
    public function InformeTICSFRAME()
    {
        return view('modules.Informes.InformeTICSFRAME');
    }
    public function getDatatableFecha(Request $request)
    {
        $user=Auth::user()->name;
        $fi='';
        $ff='';
        if($request->fecha!=null){
            $datafecha=explode("/",$request->fecha);
            $fi=$datafecha[0];
            $ff=$datafecha[1];
            $fi = trim($fi);
            $ff = trim($ff);
        }
        // dd($fi,$ff,strpos($fi,'/'));   
        if(strpos($fi,'/')||strpos($ff,'/'))
        {
            return response()->json("Periodo Invalido: 2019-01-01 hasta 2019-01-31", 400);
        }
 
        $fi=$fi." 00:00:01";
        $ff=$ff." 23:59:59";
        
        $consulta=InformesTecnico::where('estado','ACT');
        $consulta=$consulta->whereBetween('created_at',[$fi,$ff]);
        if($request->pantalla=='crea')
        {
            $consulta=$consulta->orwhere('usuariorevisado',$user);
            $consulta=$consulta->orwhere('usuarioaprobado',$user);
            $consulta=$consulta->orwhere('usuarioelaborado',$user);
        }
        if($request->pantalla=='pendientesR'){
            $consulta=$consulta->where('revisado','NO');
            $consulta=$consulta->where('usuariorevisado',$user);
        }
        
        if($request->pantalla=='pendientesA'){
            $consulta=$consulta->where('aprobado','NO');
            $consulta=$consulta->where('revisado','SI');
            $consulta=$consulta->where('usuarioaprobado',$user);
        }
        $consulta=$consulta->get();
     /*   $consulta=DB::connection('mysql_modulos')
         ->select('call SPEPA_INFORMES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                                       ?,?,?,?,?,?,?,?,?,?,?,?,?,?
                                       )',
                    [
                        $tipo,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $user,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $fi,
                        $ff
                    ]);
       **/ 
        $array_response['status'] = 200;
        $array_response['datos'] = $consulta;

        return response()->json($array_response, 200);
   }



    public function saveInforme(request $request){

           $tipo="crea";
           if($request->id!=0)
           {
              $tipo="actualiza";
           }
                
            $consulta=DB::connection('mysql_modulos')
            ->select('call SPEPA_INFORMES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                                          ?,?,?,?,?,?,?,?,?,?,?,?,?,?
                                          )',
                        [
                        $tipo,
                        $request->id,
                        $request->asunto,
                        $request->antecedentes,
                        $request->objetivos,
                        $request->conclusiones,
                        $request->recomendaciones,
                        $request->usuarioInforme,
                        $request->UsuarioEncargado,
                        $request->checklist,
                        $request->tablaEquipos,
                        $request->problemas,
                        $request->tablaProblemas,
                        $request->usuarioelaborado,
                        $request->usuariorevisado,
                        $request->usuariorecibido,
                        $request->usuarioaprobado,
                        $request->usuarioelaboradocargo,
                        $request->usuariorevisadocargo,
                        $request->usuariorecibidocargo,
                        $request->usuarioaprobadocargo,
                        $request->tablaPiePaginas,
                        $request->categoriasProblemas,
                        $request->acciones,
                        $request->anexos,
                        $request->arregloanexos,
                        $request->anexosCarga,
                        null,
                        null
                    ]);
            
            $consulta=$consulta[0];
            $array_response['status'] = $consulta->status;
            $array_response['message'] = $consulta->message;
            return response()->json($array_response, 200);

    }
    public function getInformes()
    {
        $consulta=CtlInformes::all();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function aprobarInforme(request $request)
    {
        $consulta=InformesTecnico::Find($request->id);
        if($consulta->revisado!='SI')
        $consulta->revisado='SI';
        else
        $consulta->aprobado='SI';
        $consulta->save();
        $array_response['status'] = '200';
        $array_response['message'] = 'El informe Ha sido aprobado';
        return response()->json($array_response, 200);
    }
    
    public function getUserGlpi()
    {
            $computador="select 
                    u.id as idUsuario,
                    u.name as nameauth,
                    concat(u.realname,' ',u.firstname) as name,
                    c.name as Equipo,
                    c.serial as Serial,
                    c.otherserial as OtroSerial,
                    cm.name as Modelo,
                    ct.name as Tipo,
                    c.id as idEquipo,
                    'cardComputador' as card
                    from glpi_users as u
                    inner join glpi_computers c on u.id=c.users_id
                    left join glpi_computermodels cm on cm.id = c.computermodels_id
                    left join glpi_computertypes ct on ct.id = c.computertypes_id
                    where u.is_active=1
                    and c.name is not null
                    and u.user_dn is not null";
            $monitor="select 
                u.id as idUsuario,
                u.name as nameauth,
                concat(u.realname,' ',u.firstname) as name,
                m.name as Equipo,
                m.serial as Serial,
                m.otherserial as OtroSerial,
                mcm.name as Modelo,
                mct.name as Tipo,
                m.id as idEquipo,
                'cardMonitor' as card

                from glpi_users as u
                inner join glpi_monitors m on m.users_id=u.id
                left join glpi_monitormodels mcm on mcm.id = m.monitormodels_id
                left join glpi_monitortypes mct on mct.id = m.monitortypes_id
                where u.is_active=1
                and m.name is not null
                and u.user_dn is not null";
            $perifericos="select 
                    u.id as idUsuario,
                    u.name as nameauth,
                    concat(u.realname,' ',u.firstname) as name,
                    p.name as Equipo,
                    p.serial as Serial,
                    p.otherserial as OtroSerial,
                    mpm.name as Modelo,
                    mpt.name as Tipo,
                    p.id as idEquipo,
                    'cardPeriferico' as card

                    from glpi_users as u
                    inner join glpi_peripherals p on p.users_id=u.id
                    left join glpi_peripheralmodels mpm on mpm.id = p.peripheralmodels_id
                    left join glpi_peripheraltypes mpt on mpt.id = p.peripheraltypes_id
                    where u.is_active=1
                    and p.name is not null
                    and u.user_dn is not null";

            $impresoras="select 
                    u.id as idUsuario,
                    u.name as nameauth,
                    concat(u.realname,' ',u.firstname) as name,
                    pr.name as Equipo,
                    pr.serial as Serial,
                    pr.otherserial as OtroSerial,
                    mprm.name as Modelo,
                    mprt.name as Tipo,
                    pr.id as idEquipo,
                    'cardImpresora' as card

                    from glpi_users as u
                    inner join glpi_printers pr on pr.users_id=u.id
                    left join glpi_printermodels mprm on mprm.id = pr.printermodels_id
                    left join glpi_printertypes mprt on mprt.id = pr.printertypes_id
                    where u.is_active=1
                    and pr.name is not null
                    and u.user_dn is not null";

            $list1 = DB::connection('mysql_GLPI')
                    ->select(DB::raw($computador.
                    " UNION ALL ".
                    $monitor.
                    " UNION ALL ".
                    $perifericos.
                    " UNION ALL ".
                    $impresoras 
                    ));
        /*
            $tipo="consulta";
            $consulta=DB::connection('mysql_GLPI')
            ->select('call SPEPA_GLPI(?)',
                        [
                        $tipo
                        ]);
            $array_response['status'] = 200;
            $array_response['message'] = $consulta;
            $tipo='elimina';
            $elimina=DB::connection('mysql_GLPI')
            ->select('call SPEPA_GLPI(?)',
                    [
                        $tipo
                    ]);
        */
        $array_response['status'] = 200;
        $array_response['message'] = $list1;
        return response()->json($array_response, 200);
    }

    public function getCargarProblemasEquipos()
    {
        $consulta=ProblemasEquipo::where('estado','ACT')->get();
        $array_response['status'] = 200;
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function agregaProblemas(request $request){
            $objBeneficiario=new ProblemasEquipo();
            $objBeneficiario->tipoDispositivo=$request->tipoDispositivo;
            $objBeneficiario->descripcion=$request->descripcion;
            $objBeneficiario->save();
            $array_response['status'] = '200';
            $array_response['message'] = "Grabado";
        
        return response()->json($array_response, 200);
    }
    public function borrarProblemas(request $request)
    {
 
            $objBeneficiario=ProblemasEquipo::Find($request->id);
            $objBeneficiario->estado='INA';
            $objBeneficiario->save();
            $array_response['status'] = 200;
            $array_response['message'] = "Registro borrado con exito";
       
        return response()->json($array_response, 200);
    }
    public function eliminardata(request $request)
    {
            $objBeneficiario=InformesTecnico::Find($request->id);
            $objBeneficiario->estado='INA';
            $objBeneficiario->save();
            $array_response['status'] = 200;
            $array_response['message'] = "Registro borrado con exito";
       
        return response()->json($array_response, 200);
    }
    
    
}
