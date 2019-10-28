<?php

namespace App\Core\Entities\Financiera;

use Illuminate\Database\Eloquent\Model;

class CtlTipoGasto extends Model
{
    protected $table = 'ctl_tipo_gasto';
    protected $connection = 'mysql_modulos';
}
