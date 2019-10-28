<?php

namespace App\Core\Entities\modules\Comercial;

use Illuminate\Database\Eloquent\Model;

class LoteFacturacion extends Model
{
    public $timestamps = true;
    protected $table = 'lote_facturacion';
    protected $connection = 'mysql_modulos';
    protected $fillable = [
        'id'
        ,'dh'
        ,'cac'
        ,'tipo'
        ,'tipos_facturacion'
        ,'emision'
        ,'mes'
        ,'codigo'
        ,'valor'
        ,'saldo'
        ,'estado_factura'
        ,'identificacion'
        ,'cliente'
        ,'referencia'
        ,'uso'
        ,'subsuso'
        ,'periodo'
        ,'consumo'
        ,'created_at'
        ,'updated_at'
        ,'usuario_ing'
        ,'usuario_mod'
        ,'estado'
    ];

}
