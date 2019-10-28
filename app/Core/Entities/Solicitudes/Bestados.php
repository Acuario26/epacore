<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Bestados extends Model
{
    public $timestamps = true;
    protected $table = 'bestados';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';

}
