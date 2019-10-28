<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Liberada extends Model
{
    public $timestamps = true;
    protected $table = 'solicitud_liberacion';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';
}
