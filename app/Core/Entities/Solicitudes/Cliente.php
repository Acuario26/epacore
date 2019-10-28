<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = true;
    protected $table = 'cliente';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'identificacion';
}
