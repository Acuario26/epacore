<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $timestamps = true;
    protected $table = 'solicitud';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'n_solicitud';

    

}
