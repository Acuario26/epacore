<?php

namespace App\Http\Controllers\Financieras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Entities\Financiera\Pago;
use App\Http\Controllers\Ajax\SelectController;
use DB;
use Yajra\Datatables\Datatables;
use App\Core\Entities\Financiera\Beneficiario;
use App\Core\Entities\Financiera\CtlTipoContrato;
use App\Core\Entities\Financiera\CtlArea;
use App\Core\Entities\Financiera\CtlTipoGasto; 
use App\Core\Entities\Financiera\CtlTipoRecurso;
use App\Core\Entities\Financiera\CtlIvaIr;
use Auth;

class FinancieraControlPrevioController extends Controller
{
    
    public function Index()
    {

       // $consulta=Pago::all();
        $objSelect = new SelectController();
        $beneficiario=Beneficiario::all()->pluck('descripcion','id');
        $tipoContrato=CtlTipoContrato::where('estado','ACT')->pluck('descripcion','id');
        $areas=CtlArea::all()->pluck('descripcion','id');
        $tipoGasto=CtlTipoGasto::all()->pluck('descripcion','id');
        $tipoRecurso=CtlTipoRecurso::all()->pluck('descripcion','id');

        $codRetIva=CtlIvaIr::where('tipo','IVA')->pluck('codigo','codigo');
        $codRetIR=CtlIvaIr::where('tipo','IR')->pluck('codigo','codigo');


	$porcentajeIva=env('PORCENTAJEIVA');
	$porcentajeSeguro=env('PORCENTAJEBASESEGUROS');


        return view('modules.Financieras.index',
                    compact(['beneficiario'
                            ,'tipoContrato'
                            ,'areas'
                            ,'tipoGasto'
                            ,'tipoRecurso'
                            ,'codRetIva'
                            ,'codRetIR'
			    ,'porcentajeIva'
			    ,'porcentajeSeguro'
                            ]));
    }
    public function getDatatable(Request $request)
    {

        $tipo="consulta";
        $consulta=DB::connection('mysql_modulos')
         ->select('call SPEPA_PAGOS(?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?
                                    )',
                    [
                       $tipo,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null
                        ]);
               
        $array_response['status'] = 200;
        $array_response['datos'] = $consulta;
             
      return response()->json($array_response, 200);
   }
    public function getDatatableFecha(Request $request)
    {
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
     
        $tipo="consultafecha";
        $consulta=DB::connection('mysql_modulos')
         ->select('call SPEPA_PAGOS(?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?
                                    )',
                    [
                       $tipo,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,$fi,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,$ff,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null,
                        null,null,null,null,null,null,null,null,null,null
                        ]);
               
        $array_response['status'] = 200;
        $array_response['datos'] = $consulta;
             
      return response()->json($array_response, 200);
   }
   public function savePago(Request $request)
   {    
      // dd($request->totaldescuentos);
    
    $dataUsuario=Auth::user()->nombreCompleto;
    $dataUsuarioArreglo=explode(",",$dataUsuario);
    $CN=$dataUsuarioArreglo[0];
    $CARGO=$dataUsuarioArreglo[1];
    $request->usuario= $dataUsuario;
       $tipo="crea";
       if($request->id!=0)
       {
          $tipo="actualiza";
       }else{
        $request->serieFacturaid=(Pago::all()->count())+1;
       }
            
        $consulta=DB::connection('mysql_modulos')
         ->select('call SPEPA_PAGOS(?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?
                                    )',
                                                                    
                [
                    $tipo,
                    $request->id,
                    $request->Recurso,
                    $request->fechaLiquidacion,
                    $request->beneficiario,
                    $request->tipoContrato,
                    $request->contrato,
                    $request->valorContrato,
                    $request->objetoContrato,
                    $request->observaciones,
                    $request->Area,
                    $request->NumeroPlanilla,
                    $request->Garante,
                    $request->datefilterPeriodo,
                    $request->valorPlanilla,
                    $request->anticipo,
                    $request->amortizacion,
                    $request->amortizacionAcumulada,
                    $request->actualAmortizacion,
                    $request->totalAmortizado,
                    $request->saldoAmortizar,
                    $request->valorAnticipo,
                    $request->serieFacturaid,
                    $request->amortizacionFiscal,
                    $request->datefilterFactura,
                    $request->NumeroFactura,
                    $request->baseNoGrav,
                    $request->baseCero,
                    $request->baseDoce,
                    $request->iva,
                    $request->totalIva,
                    $request->codRetIVA,
                    $request->retencionIva,
                    $request->baseseguros,
                    $request->baseImp,
                    $request->codRetIR,
                    $request->utilidadConsultoria,
                    $request->retencionIR,
                    $request->baseIR,
                    $request->serieFacturaidS,
                    $request->amortizacionExterna,
                    $request->datefilterFacturaS,
                    $request->NumeroFacturaS,
                    $request->baseNoGravS,
                    $request->baseCeroS,
                    $request->baseDoceS,
                    $request->ivaS,
                    $request->totalIvaS,
                    $request->codRetIVAS,
                    $request->retencionIvaS,
                    $request->basesegurosS,
                    $request->baseImpS,
                    $request->codRetIRS,
                    $request->utilidadConsultoriaS,
                    $request->retencionIRS,
                    $request->baseIRS,
                    $request->CreditoExterno,
                    $request->RecursosVirtuales,
                    $request->Autogestion,
                    $request->RecursosFiscales,
                    $request->totalrecursos,
                    $request->NroCertificacion,
                    $request->TipoGasto,
                    $request->Item,
                    $request->Fuente,
                    $request->PlantillaPie,
                    $request->FCreditoExterno,
                    $request->FRecursosVirtuales,
                    $request->FAutogestion,
                    $request->FRecursosFiscales,
                    $request->RecursosBID,
                    $request->Recursos998,
                    $request->FRecursosBID,
                    $request->FRecursos998,
                    $request->descNotasDebito,
                    $request->descotros,
                    $request->descart34,
                    $request->descmultas,
                    $request->totaldescuentos,
                    $request->usuario
                ]);
        
        $consulta=$consulta[0];
        $array_response['status'] = $consulta->status;
        $array_response['message'] = $consulta->message;
        return response()->json($array_response, 200);

    }

    public function eliminaPago(request $request)
    {
        $tipo="elimina";
        $id=$request->id;
        $consulta=DB::connection('mysql_modulos')
         ->select('call SPEPA_PAGOS(?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?,
                                    ?,?,?,?,?,?,?,?,?,?
                                    )',
           [
                   $tipo,$id,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null,
                    null,null,null,null,null,null,null,null,null,null
                    ]);

        $consulta=$consulta[0];
        $array_response['status'] = $consulta->status;
        $array_response['message'] = $consulta->message;
        return response()->json($array_response, 200);
    }

    public function codigosRetencion(request $request)
    {
        $consulta=CtlIvaIr::where('estado','ACT')
                           ->orderby('codigo','ASC')->get();
    
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    
    public function identificacionBeneficiarios(request $request)
    {
        $consulta=Beneficiario::where('estado','ACT')
                                ->orderby('descripcion','ASC')->get();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function tiposContratos(request $request)
    {
        $consulta=CtlTipoContrato::all();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function areaSolicitante(request $request)
    {
        $consulta=CtlArea::all();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function buscarcontratos(request $request)
    {
        $consulta=Pago::where([
                                'contrato'=>$request->contrato,
                                'estado'=>'ACT'
                                ])->orderby('fechaLiquidacion','DESC')->first();
        $array_response['status'] = '200';
        $array_response['message'] = $consulta;
        return response()->json($array_response, 200);
    }
    public function borrarBeneficiario(request $request)
    {
        $consulta=Pago::where([
            'beneficiarioId'=>$request->id,
            'estado'=>'ACT'
            ])->count();
        if($consulta==0)
        {
            $objBeneficiario=Beneficiario::Find($request->id);
            $objBeneficiario->estado='INA';
            $objBeneficiario->save();
            $array_response['status'] = 200;
            $array_response['message'] = "Registro borrado con exito";
        }else{
            $array_response['status'] = 400;
            $array_response['message'] = "El Beneficiario esta vinculado a un contrato";
     
        }
        return response()->json($array_response, 200);
    }
    
    public function agregaBeneficiarios(request $request)
    {
        $consulta=Beneficiario::where([
            'identificacion'=>$request->identificacion,
            'estado'=>'ACT'
            ])->count();
        if($consulta==0)
        {
            $objBeneficiario=new Beneficiario();
            $objBeneficiario->identificacion=$request->identificacion;
            $objBeneficiario->descripcion=$request->beneficiario;
            $objBeneficiario->save();
            $array_response['status'] = '200';
            $array_response['message'] = "Beneficiario Grabado";
        }else{
            $array_response['status'] = 400;
            $array_response['message'] = "Ya existe el Beneficiario";
        }
        return response()->json($array_response, 200);
    }



}
