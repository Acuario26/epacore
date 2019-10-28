<?php

namespace App\Core\Entities\modules\Informes;

use Illuminate\Database\Eloquent\Model;

class ProblemasEquipo extends Model
{
    protected $table = 'ctl_problemas_equipos';
    protected $connection = 'mysql_modulos';
}
