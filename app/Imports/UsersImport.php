<?php

namespace App\Imports;
  
use App\Core\Entities\modules\Comercial\LoteFacturacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0]!='DH')
        {
            $valores = explode('/', $row[5]);
            $valores2 = explode('-', $row[5]);
            if(count($valores) > 2 || count($valores2)>2){
                $UNIX_DATE=$row[5];
                $UNIX_DATE=str_replace('/','-',$UNIX_DATE);
                $UNIX_DATE=date_create($UNIX_DATE);
                $unix_timestamp_seconds= date_format($UNIX_DATE, 'Y-m-d H:i:s');
                $unix_timestamp_seconds2=date_format($UNIX_DATE, 'F');
                $unix_timestamp_seconds3=date_format($UNIX_DATE, 'm');
                setlocale(LC_ALL,"es_ES@dolar","es_ES","esp");
                $fechaEspañol= $unix_timestamp_seconds3.'.'.strtoupper($unix_timestamp_seconds2);
            }else{
                $UNIX_DATE = ($row[5] - 25569) * 86400;
                $unix_timestamp_seconds= gmdate("d-m-Y H:i:s", $UNIX_DATE);
                $unix_timestamp_seconds2= gmdate("F", $UNIX_DATE);
                $unix_timestamp_seconds3= gmdate("m", $UNIX_DATE);
                setlocale(LC_ALL,"es_ES@dolar","es_ES","esp");
               // $fechaEspañol= strtoupper(strftime("%B",$UNIX_DATE));
                $fechaEspañol= strftime("%m",$UNIX_DATE).'.'.strtoupper(strftime("%B",$UNIX_DATE));
            }

             $dh = strpos($row[3], 'T')==true?'TRASVASE':$row[0];
             $cac=$row[1];
             $tipo=$row[2];
             $tipo_facturacion=$row[3];
             $codigo=$row[4];
             $fecha_emision=$unix_timestamp_seconds;
             $valor=$row[6];
             $saldo=$row[7];
             $estado_factura=$row[8];
             $identificacion=$row[9];
             $cliente= $row[10];
             $referencia= $row[16];
             $uso=$row[17];
             $subuso=$row[18];
             $periodo=$row[19];
             $consumo=$row[20];


            return new LoteFacturacion([
                "dh" => $dh
                ,"cac" =>$cac
                ,"tipo" => $tipo
                ,"tipos_facturacion" => $tipo_facturacion
                ,"mes" => $fechaEspañol
                ,"codigo" => $codigo
                ,"emision" => $fecha_emision
                ,"valor" => $valor
                ,"saldo" => $saldo
                ,"estado_factura" => $estado_factura
                ,"identificacion" => $identificacion
                ,"cliente" =>$cliente
                ,"referencia" =>$referencia
                ,"uso" => $uso
                ,"subsuso" => $subuso
                ,"periodo" => $periodo
                ,"consumo" => $consumo
                ,'usuario_ing'=>Auth::user()->id
                ,'usuario_mod'=>Auth::user()->id
            ]);

        }
           
    }
}
