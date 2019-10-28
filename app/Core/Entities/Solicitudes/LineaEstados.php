<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class LineaEstados extends Model
{
    public $timestamps = true;
    protected $table = 'lineaestados';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';
}
