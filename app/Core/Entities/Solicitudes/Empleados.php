<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    public $timestamps = true;
    protected $table = 'empleados';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    
}
