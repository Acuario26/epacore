<?php

namespace App\Core\Entities\modules\Comercial;

use Illuminate\Database\Eloquent\Model;

class LoteRecaudacion extends Model
{
    public $timestamps = true;
    protected $table = 'lote_recaudacion';
    protected $connection = 'mysql_modulos';
    protected $fillable = [
        'id'
        ,'codigo'
        ,'emision'
        ,'mes'
        ,'valor_total'
        ,'cliente'
        ,'fecha_asignacion'
        ,'valor_cubierto'
        ,'forma_cobro'
        ,'valor_cobro'
        ,'fecha_cobro'
        ,'idRecaudacion'
        ,'dh'
        ,'cac'
        ,'uso'
        ,'subsuso'
        ,'tipo_facturacion'
        ,'estado'
        ,'usuario_ing'
        ,'usuario_mod'
        ,'created_at'
        ,'updated_at'
        
    ];

}
