<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Lineas extends Model
{
    public $timestamps = true;
    protected $table = 'lineas';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'celular';
    public function bp(){
        return $this->belongsTo('App\Core\Entities\Admin\tb_parametro','bp_id','id');
    }
}
