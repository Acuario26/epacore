<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class SolicitudAsignacion extends Model
{
    public $timestamps = false;
    protected $table = 'solicitudAsignacion';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';

}
