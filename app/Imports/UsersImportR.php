<?php

namespace App\Imports;
  
use App\Core\Entities\modules\Comercial\LoteRecaudacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;

class UsersImportR implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0]!='Código' && $row[0]!='Codigo')
        {
            /* FECHA EMISION Y MES */
            $valores = explode('/', $row[1]);
            $valores2 = explode('-', $row[1]);
            if(count($valores) > 2 || count($valores2)>2){
                $UNIX_DATE=$row[1];
                $UNIX_DATE=str_replace('/','-',$UNIX_DATE);
                $UNIX_DATE=date_create($UNIX_DATE);
                $unix_timestamp_seconds= date_format($UNIX_DATE, 'Y-m-d H:i:s');
                $unix_timestamp_seconds2=date_format($UNIX_DATE, 'F');
                $unix_timestamp_seconds3=date_format($UNIX_DATE, 'm');
                setlocale(LC_ALL,"es_ES@dolar","es_ES","esp");
                $fechaEspañol= $unix_timestamp_seconds3.'.'.strtoupper($unix_timestamp_seconds2);
            }else{
                $UNIX_DATE = ($row[1] - 25569) * 86400;
                $unix_timestamp_seconds= gmdate("d-m-Y H:i:s", $UNIX_DATE);
                $unix_timestamp_seconds2= gmdate("F", $UNIX_DATE);
                setlocale(LC_ALL,"es_ES@dolar","es_ES","esp");
                $fechaEspañol= strtoupper(strftime("%B",$UNIX_DATE));
                $fechaEspañol= strftime("%m",$UNIX_DATE).'.'.strtoupper(strftime("%B",$UNIX_DATE));
            }
            /* FECHA ASIGNACION*/
            $valoresA = explode('/', $row[4]);
            $valoresA2 = explode('-', $row[4]);
            if(count($valoresA) > 2 || count($valoresA2)>2){
                $UNIX_DATEA=$row[4];
                $UNIX_DATEA=str_replace('/','-',$UNIX_DATEA);
                $UNIX_DATEA=date_create($UNIX_DATEA);
                $unix_timestamp_secondsA= date_format($UNIX_DATEA, 'Y-m-d H:i:s');
                $unix_timestamp_secondsA2=date_format($UNIX_DATEA, 'F');
            }else{
                $UNIX_DATEA = ($row[4] - 25569) * 86400;
                $unix_timestamp_secondsA= gmdate("d-m-Y H:i:s", $UNIX_DATEA);
            }
             /* FECHA COBRO*/
             $valoresC = explode('/', $row[8]);
             $valoresC2 = explode('-', $row[8]);
             if(count($valoresC) > 2 || count($valoresC2)>2){
                 $UNIX_DATEC=$row[8];
                 $UNIX_DATEC=str_replace('/','-',$UNIX_DATEC);
                 $UNIX_DATEC=date_create($UNIX_DATEC);
                 $unix_timestamp_secondsC= date_format($UNIX_DATEC, 'Y-m-d H:i:s');
             }else{
                 $UNIX_DATEC = ($row[8] - 25569) * 86400;
                 $unix_timestamp_secondsC= gmdate("d-m-Y H:i:s", $UNIX_DATEC);
             }
             $codigo=$row[0];
             $fecha_emision=$unix_timestamp_seconds;
             $valorTotal=$row[2];
             $cliente=$row[3];
             $fecha_asignacion=$unix_timestamp_secondsA;
             $valor_cubierto=$row[5];
             $forma_cobro=$row[6];
             $valor_cobro=$row[7];
             $fecha_cobro=$unix_timestamp_secondsC;
             $idRecaudacion=$row[9];
             $dh=strpos($row[13], 'T')==true?'TRASVASE':$row[10];
             $cac=$row[11];
             $uso=$row[12];
             $subsuso=$row[12];
             $tipo_facturacion=$row[13];

            return new LoteRecaudacion([
                'codigo'=> $codigo
                ,'emision' => $fecha_emision
                ,'mes'=> $fechaEspañol
                ,'valor_total'=> $valorTotal
                ,'cliente'=>$cliente
                ,'fecha_asignacion'=>$fecha_asignacion
                ,'valor_cubierto'=>$valor_cubierto
                ,'forma_cobro'=>$forma_cobro
                ,'valor_cobro'=>$valor_cobro
                ,'fecha_cobro'=>$fecha_cobro
                ,'idRecaudacion'=>$idRecaudacion
                ,'dh'=> $dh
                ,'cac'=>$cac
                ,'uso'=>$uso
                ,'subsuso'=>$subsuso
                ,'tipo_facturacion'=> $tipo_facturacion
                ,'usuario_ing'=>Auth::user()->id
                ,'usuario_mod'=>Auth::user()->id
            ]);

        }
           
    }
}
