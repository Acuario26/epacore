<?php

namespace App\Core\Entities\Financiera;

use Illuminate\Database\Eloquent\Model;

class CtlTipoContrato extends Model
{
   // public $timestamps = true;
    protected $table = 'ctl_tipo_contrato';
    protected $connection = 'mysql_modulos';
}
