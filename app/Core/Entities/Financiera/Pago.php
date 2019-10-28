<?php

namespace App\Core\Entities\Financiera;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    public $timestamps = true;
    protected $table = 'pagos';
    protected $connection = 'mysql_modulos';
}
