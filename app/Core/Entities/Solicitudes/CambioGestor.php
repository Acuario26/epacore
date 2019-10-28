<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class CambioGestor extends Model
{
    public $timestamps = true;
    protected $table = 'cambiogestor';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';
}
