<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class evaluacionest extends Model
{
    protected $connection = 'mysql_solicitudescj';
    protected $table='evaluacionestudiante';
}
