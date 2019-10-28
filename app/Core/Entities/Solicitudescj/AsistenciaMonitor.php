<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class AsistenciaMonitor extends Model
{
    protected $connection = 'mysql_solicitudescj';

    protected $table = 'asistencias_monitor';

    protected $append = ['firma'];

    public function estudiante()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function getFirmaAttribute(){
        return '';
    }
}